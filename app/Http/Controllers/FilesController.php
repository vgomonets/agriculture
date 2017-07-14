<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use App\Models\Company;
use App\Models\Contractor;
use App\Models\Files;
use App\Models\Task;
use File;
use Response;

class FilesController extends Controller
{
    
    protected $access = [
        'upload' => ['manager'],
        'filesList' => ['manager'],
        'delete' => ['manager'],
        'save' => ['manager'],
        'get' => ['?'],
        'download' => ['?'],
    ];
    

    public function upload(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        Validator::extend('maxFileSize', function($attribute, $value, $parameters, $validator) use($request) {
            return !(filesize($request->file('files')->getPathname()) > $parameters[0] * 1024 * 1024);
        });
        Validator::replacer('maxFileSize', function($message, $attribute, $rule, $parameters) use($request) {
            $file = $request->file('files')->getClientOriginalName();
            return "Размер файла {$file} не должен превышать {$parameters[0]} Мб";
        });
        $validator = Validator::make(Input::all(), [
            'files' => 'maxFileSize:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $user = Auth::user();
        if (!empty($request->file('files'))) {
            $originalName = $request->file('files')->getClientOriginalName();
            $fileName = Files::getFileNameByUserId($originalName, $user->id);
            $request->file('files')->move(Files::getFilePath(), $fileName);
            
            // Resize image
            if(in_array(mime_content_type(Files::getFilePath() . $fileName), [
                    'image/jpg', 'image/jpeg', 'image/png', 'image/gif',
                ])) {
                    Image::make(Files::getFilePath() . $fileName)
                        ->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save();
            }

            $file = new Files();
            $file->user_id = $user->id;
            $file->name = $fileName;
            $file->original_name = $originalName;
            
            switch($request->type) {
                case 'user':
                    $file->relation_type = Contractor::class;
                    $file->relation_id = !empty($request->id) ? $request->id : $user->id;
                    break;
                case 'company':
                    $file->relation_type = Company::class;
                    $file->relation_id = !empty($request->id) ? $request->id : $user->id;
                    break;
                case 'task':
                    $file->relation_type = Task::class;
                    $file->relation_id = $request->id;
                    break;
            }
            $file->save();
        }

        return  response()->json([
            'success' => true,
        ]);
    }

    public function filesList(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        $user = Auth::user();

        $relation_type = '';
        switch($request->type) {
            case 'user':
                $relation_type = Contractor::class;
                $relation_id = !empty($request->id) ? $request->id : $user->id;
                break;
            case 'company':
                $relation_type = Company::class;
                $relation_id = !empty($request->id) ? $request->id : $user->id;
                break;
            case 'task':
                $relation_type = Task::class;
                $relation_id = $request->id;
                break;
        }
        
        $files = Files::where([
            'relation_id' => $relation_id,
            'relation_type' => $relation_type,
        ])->get();
        foreach ($files as $file) {
            $file->url = Files::getHttpPath($file->id);
            $file->download = Files::getDownloadPath($file->id);
            $file->mimetype = File::mimeType(Files::getFilePath() . $file->name);
        }

        return  response()->json([
            'success' => true,
            'data' => $files,
        ]);
    }

    public function get(Request $request)
    {
        $user = Auth::user();
        if (empty($user)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $file = Files::where([
//            'user_id' => $user->id,
            'id' => $request->file_id,
        ])->first();
        if (empty($file)) {
            return  response()->json([
                'success' => false,
            ]);
        }
        $path = Files::getFilePath() . $file->name;

        if (empty($path) || !file_exists($path)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $file = File::get($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", File::mimeType($path));

        return $response;
    }

    public function download(Request $request)
    {
        $user = Auth::user();
        if (empty($user)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $file = Files::where([
//            'user_id' => $user->id,
            'id' => $request->file_id,
        ])->first();
        if (empty($file)) {
            return  response()->json([
                'success' => false,
            ]);
        }
        $path = Files::getFilePath() . $file->name;

        if (empty($path) || !file_exists($path)) {
            return  response()->json([
                'success' => false,
            ]);
        }

        $file_content = File::get($path);
        $response = Response::make($file_content, 200);
        $response->header("Content-Type", File::mimeType($path));
        $response->header("Content-Disposition", 'attachment; filename=' . $file->original_name);

        return $response;
    }

    public function delete(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        $user = Auth::user();
        if (empty($user)) {
            return response()->json([
                'success' => false,
            ]);
        }
        $files = Files::where([
            'user_id' => $user->id,
            'id' => $request->id,
        ])->delete();

        return  response()->json([
            'success' => true,
        ]);
    }

    public function save(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        $user = Auth::user();
        if (empty($user)) {
            return response()->json([
                'success' => false,
            ]);
        }
        $file = Files::where([
            'user_id' => $user->id,
            'id' => $request->id,
        ])->first();

        if ($file->exists) {
            $file->unguard();
            $file->update(Input::only(['description']));
        }

        return  response()->json([
            'success' => true,
        ]);
    }
}
