<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\View\View;

class CertificateVerifyController extends Controller
{
    public function show(string $code): View
    {
        $certificate = Certificate::query()
            ->where('validation_code', $code)
            ->with(['participant', 'project'])
            ->first();

        return view('site.certificate-verify', [
            'certificate' => $certificate,
            'code' => $code,
        ]);
    }
}
