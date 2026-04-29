<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CertificateVerifyController extends Controller
{
    public function index(): View
    {
        return view('site.certificate-search');
    }

    public function search(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string']
        ]);

        return redirect()->route('certificates.verify', ['code' => trim($request->code)]);
    }

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
