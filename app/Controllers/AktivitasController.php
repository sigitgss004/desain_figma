<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AktivitasModel;
use App\Models\DataAktivitasModel;
use CodeIgniter\HTTP\ResponseInterface;

class AktivitasController extends BaseController
{
    public function index()
    {
                        //  // Inisialisasi model
                        $aktivitasModel = new AktivitasModel();
        
                        //  // Ambil semua data, data akan dikembalikan sebagai object
                         $data['aktivitas'] = $aktivitasModel->first();

                        $aktivitasDataModel = new DataAktivitasModel();

                        $dataaktivitasmodel = new DataAktivitasModel();

                        $data['aktivitasdata']  = $aktivitasDataModel->FindAll();
                         

                        $lang = session()->get('lang') ?? 'id';
                        $data['lang'] = $lang;

                         // Kirim data ke view
                         return view('Aktivitas/index', $data);
    }

    public function detail($slug)
    {
       

        $lang = session()->get('lang') ?? 'id';
        $data['lang'] = $lang;

        $dataaktivitas = new DataAktivitasModel();
        // Mencari produk berdasarkan slug
  
        $aktivitas = $dataaktivitas->where('slug', $slug)->orWhere('slug_en', $slug)->first();

        // Cek apakah slug sesuai dengan bahasa yang sedang aktif
        if (($lang === 'id' && $slug !== $aktivitas->slug) || ($lang === 'en' && $slug !== $aktivitas->slug_en)) {
            // Redirect ke URL slug yang benar sesuai bahasa
            $correctSlug = $lang === 'id' ? $aktivitas->slug : $aktivitas->slug_en;
            $correctulr = $lang === 'id' ? 'aktivitas' : 'activity';

            return redirect()->to("$lang/$correctulr/$correctSlug");
        }
       
        

        

        if (!$aktivitas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Aktivitas dengan slug '{$slug}' tidak ditemukan.");
        }

        $lang = session()->get('lang') ?? 'id';
        $data['lang'] = $lang;

        $data['aktivitas'] = $aktivitas;
        return view('aktivitas/detail', $data); // Menampilkan detail produk
    }
}