<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\HomepageRqt;
use App\Models\Homepage;
use App\Models\Imagens;

class HomepageCtrl extends Controller
{
 
    // Listando todos os instituições
	public function Exibir(){
		$dados = Homepage::orderBy('titulo')->get();
		return view('tecnologia.homepage.exibir')->with('homepages', $dados);
	}

	// Listando todos os instituições
	public function Listar(){
		$dados = Homepage::orderBy('titulo')->get();
		return view('tecnologia.homepage.listar')->with('homepages', $dados);
	}

	// Adicionando nova instituições
	public function Adicionar(HomepageRqt $request){
		if(!empty($request->upload_img)){
            $nameFile = null;
            if ($request->hasFile('upload_img') && $request->file('upload_img')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->upload_img->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->upload_img->storeAs('homepage', $nameFile);
                $imagem = Imagens::create(['tipo' => 'homepage', 'endereco' => $upload]);
            }
        }else{
        	if(is_dir(getcwd().'/storage/app/homepage')){
                $nameFile = uniqid(date('HisYmd')).'.png';
                copy(getcwd().'/public/img/padrao.png', getcwd().'/storage/app/homepage/'.$nameFile);
                $caminho = 'homepage/'.$nameFile;
                $imagem = Imagens::create(['endereco' =>  $caminho, 'tipo' => 'homepage']);
            }else{
                mkdir(getcwd().'/storage/app/homepage', 0755);
                $nameFile = uniqid(date('HisYmd')).'.png';
                copy(getcwd().'/public/img/padrao.png', getcwd().'/storage/app/homepage/'.$nameFile);
                $caminho = 'homepage/'.$nameFile;
                $imagem = Imagens::create(['endereco' =>  $caminho, 'tipo' => 'homepage']);
            } 
        }

		$create = Homepage::create([
			'titulo' => $request->titulo,
			'subtitulo' => $request->subtitulo,
			'endereco' => $request->endereco, 
			'id_imagem' => $imagem->id,
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da instituição
	public function Editar(HomepageRqt $request, $id){
		if(!empty($request->upload_img)){
            $nameFile = null;
            if ($request->hasFile('upload_img') && $request->file('upload_img')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->upload_img->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->upload_img->storeAs('homepage', $nameFile);
                $imagem = Imagens::create(['tipo' => 'homepage', 'endereco' => $upload]);
            }  
        }

        $dados = Homepage::find($id);
		Homepage::find($id)->update([
			'titulo' => $request->titulo,
			'subtitulo' => $request->subtitulo,
			'endereco' => $request->endereco, 
			'id_imagem' => (isset($imagem->id) ? $imagem->id : $dados->id_imagem),
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Delete($id){
		Homepage::find($id)->delete();
		return response()->json(['success' => true]);
	}

	// Detallhes da instituição
	public function Detalhes($id){
		$dados = Homepage::find($id);
		$dados->image = $dados->RelationImagem->endereco;
		return $dados;
	}
}
