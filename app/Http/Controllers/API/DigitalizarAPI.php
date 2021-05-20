<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Usuarios;

class DigitalizarAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if ($request->hasFile('arquivos')) {
            foreach($request->file('arquivos') as $imagem){
                if($imagem->isValid()){
                    $name = 'Digitalizar_'.date('Y_m_d_H_i_s_').rand(1, 999);
                    $extension =  $imagem->extension();
                    $nameFile = "{$name}.{$extension}";
                    $upload =  $imagem->storeAs('digitalizar', $nameFile);
                }
                // Compactando a imagem
                $info = getimagesize(storage_path().'/app/digitalizar/'.$nameFile);
                if ($info['mime'] == 'image/jpeg') {
                    $image = imagecreatefromjpeg(storage_path().'/app/digitalizar/'.$nameFile);
                }elseif ($info['mime'] == 'image/gif') {
                    $image = imagecreatefromgif(storage_path().'/app/digitalizar/'.$nameFile);
                }elseif ($info['mime'] == 'image/png') {
                    $image = imagecreatefrompng(storage_path().'/app/digitalizar/'.$nameFile);
                }

                // Alterando filtros da imagem
                imagefilter($image, IMG_FILTER_BRIGHTNESS, 30);

                // Alterando a orientação da imagem
                $arq = storage_path().'/app/digitalizar/'.$nameFile;
                $exif = @exif_read_data($arq);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                    case 8:
                        $newimage = imagerotate($image,90,0);
                        break;
                    case 3:
                        $newimage = imagerotate($image,180,0);
                        break;
                    case 6:
                        $newimage = imagerotate($image,-90,0);
                        break;
                    case 1:
                        $newimage = $image;
                        break;
                    }
                }else{
                    //$newimage = imagerotate($image, -90,0);
                    $newimage = $image;
                }   
                // Gerando nova imagem
                imagejpeg($newimage, storage_path().'/app/digitalizar/'.$nameFile, 30);
                $urlImage = 'app/digitalizar/'.$nameFile;
                return $urlImage;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return false;
    }
}
