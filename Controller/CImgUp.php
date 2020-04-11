<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CImgUp extends Controller
{
    public function fileCreate($nama_p)
    {
        $data['item'] = DB::selectOne("SELECT * FROM tb_produk WHERE nama_p = ?", [$nama_p]);
        $data['kategori'] = DB::selectOne("SELECT * FROM tb_kategori");
        return view('produk/produk_upload_gambar', $data);
    }

    public function fileStore(Request $request)//upload ke db + pindah file ke project
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('/assets/img/gambar_produk/'), $imageName);

        DB::insert("INSERT INTO tb_gambar_p (id_p, gambar_p) VALUES (?, ?)", [
            $request->input('id_p'),
            '/assets/img/gambar_produk/' . $imageName
        ]);
        return response()->json(['success' => $imageName]);
    }

    public function fileDestroy(Request $request)// delete daata db + hapus file project
    {
        $filename =  $request->get('filename');
        DB::delete("DELETE FROM tb_gambar_p WHERE gambar_p = ?", ['/assets/img/gambar_produk/' . $filename]);
        $path = public_path() . '/assets/img/gambar_produk/' . $filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;
    }
}
