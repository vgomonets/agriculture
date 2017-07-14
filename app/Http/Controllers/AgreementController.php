<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgreementController extends Controller
{

    public function getAgreement(Request $request)
    {
        if ($request->download) {
            $file= public_path(). "/documents/vol_public_offer.pdf";

            $headers = array(
                'Content-Type: application/pdf',
            );

            return response()->download($file, 'vol_public_offer.pdf', $headers);
        }

        return view('agreement.getagreement');
    }

    public function showAgreement()
    {
        $filename = 'vol_public_offer.pdf';
        $path = public_path()."/documents/vol_public_offer.pdf";

        return response()->make(
            file_get_contents($path),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"',
            ]
        );
    }
}
