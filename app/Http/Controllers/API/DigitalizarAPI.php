<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Usuarios;

class DigitalizarAPI extends Controller
{

    public function index()
    {
        
    }

    public function create()
    {
        return false;
    }

    public function store(Request $request)
    {   
        /*
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
                
                foreach($request->outros as $key => $arq){
                    // Criando nome do arquivo do PDF
                    if($request->nomeArquivos[$key]){
                        if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta).'/'.$request->nomeArquivos[$key].'.pdf')){
                            $namePdf = mb_strtoupper($request->nomeArquivos[$key]).'.pdf';
                        }else{
                            $namePdf = mb_strtoupper($request->nomeArquivos[$key]).date('His').'.pdf';
                        }
                    }else{
                        $namePdf = str_replace('.'.$arq->getClientOriginalExtension(), '', $request->outros[$key]).'.pdf';
                    }
                    
                    // HTML para criação do PDF
                    $usuario = Usuarios::where('login', $request->usuario)->first();
                    $html = '<div><img src="'.asset('storage/'.$request->outros[$key]).'" style="max-width: 100%; max-height: 26cm;"><div style="font-size: 1.5px !important; text-align:right; color:white; width:100%; background-color: #292828; padding-right: 1px; padding-top: 0.5px; padding-bottom: 0.5px;">Confere com o original <br> '.$usuario->RelationAssociado->nome.'</div></div>';
                    $html = preg_replace("/>s+</", "><", $html);

                    // Gerando PDF
                    if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'))){
                        if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta))){
                            $pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta).'/'.$namePdf);
                        }else{
                            mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta), 0755);
                            $pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta).'/'.$namePdf);
                        }
                    }else{
                        mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y'), 0755);
                        if(is_dir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta))){
                            $pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta).'/'.$namePdf);
                        }else{
                            mkdir("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta), 0755);
                            $pdf = PDF::loadHTML($html)->setPaper('a4', $request->orientacao)->setOptions(['dpi' => 10, 'isRemoteEnabled' => true])->save("//10.11.26.1/digitaliza_ss/".date('d-m-Y').'/'.mb_strtoupper($request->nomePasta).'/'.$namePdf);
                        }
                    }
                }
            }
        }
        */
    }

    public function show($id)
    {
        return false;
    }

    public function edit($id)
    {
        return false;
    }

    public function update(Request $request, $id)
    {
        return false;
    }

    public function destroy($id)
    {
        return false;
    }
}
