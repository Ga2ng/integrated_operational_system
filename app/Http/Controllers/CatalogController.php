<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(): View
    {
        $modules = [
            ['name' => 'Project Management System', 'description' => 'Monitoring progres proyek, timeline, dan status pekerjaan.', 'icon' => 'fa-diagram-project'],
            ['name' => 'Sales and Inventory System', 'description' => 'Pengelolaan RFQ dan inventory material sebagai dasar keputusan penawaran.', 'icon' => 'fa-warehouse'],
            ['name' => 'PTS Digital Portal (Guest View)', 'description' => 'Portal publik untuk informasi layanan dan akses akun pengguna.', 'icon' => 'fa-globe'],
            ['name' => 'Training Management System', 'description' => 'Pengelolaan sertifikasi dan histori pelatihan peserta.', 'icon' => 'fa-graduation-cap'],
        ];

        return view('site.catalog', compact('modules'));
    }
}
