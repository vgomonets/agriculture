<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Files extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $guarded = [
        'user_id',
        'relation_id',
        'relation_type',
        'name',
        'original_name',
        'description',
    ];
    
    public function relation()
    {
        return $this->morphTo();
    }

    /**
     * Return unique image name for user
     * @param string $name
     * @param integer $user_id
     * @return string
     */
    public static function getFileNameByUserId($name, $user_id)
    {
        $ext = mb_strtolower(last(explode('.', $name)));
        $time = time();
        do {
            $time ++;
            $res = "{$user_id}_{$time}." . mb_strtolower($ext);
        } while (file_exists(static::getFilePath() . $res));
        return $res;
    }

    /**
     * Return image path
     * @return string
     */
    public static function getFilePath()
    {
        return storage_path() . '/app/public/userfiles/';
    }

    /**
     * Return image path
     * @return string
     */
    public static function getHttpPath($file)
    {
        if (preg_match('/^[0-9]+$/', $file)) {
            return "/files/get/?file_id={$file}";
        } else {
            return "/files/get/?file_name={$file}";
        }
    }

    /**
     * Return image path
     * @return string
     */
    public static function getDownloadPath($file)
    {
        if (preg_match('/^[0-9]+$/', $file)) {
            return "/files/download/?file_id={$file}";
        } else {
            return "/files/download/?file_name={$file}";
        }
    }

    /**
     * Get gallery images by user_id and file_type_id
     * @param integer $user_id
     * @return Files[]
     */
    public static function getFilesByIdUser($user_id, $user_type, $type_id = null)
    {
        $where = [
            'user_id' => $user_id,
            'user_type' => $user_type,
            'removed' => 0,
        ];
        if (!empty($type_id)) {
            $where['file_type_id'] = $type_id;
        }

        return self::where($where)
            ->get();
    }
}
