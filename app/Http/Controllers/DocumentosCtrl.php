<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use App\Http\Requests\DocumentosRqt;
use App\Models\Atividades; 
use App\Models\Documentos;

class DocumentosCtrl extends Controller
{
   public function __construct(){
		$this->middleware('auth');
	}
	
    // Listando todos os funções
	public function Exibir(){
		return view('gestao.documentos.todos.listar');
	}
	public function Datatables(){
		return datatables()->of(Documentos::all())
            ->editColumn('nome1', function(Documentos $dados){ 
                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
            })
            ->editColumn('documento', function(Documentos $dados){
                return '<a href='.asset('storage/app/documentos/'. $dados->RelationArquivo->endereco).'> <i class="mdi mdi-cloud-download"></i> Download<a>';
            })
            ->editColumn('status1', function(Documentos $dados){
                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
            })
            ->editColumn('acoes', function(Documentos $dados){ 
                return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do documento"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar o documento"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do documento"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar o documento"><i class="mx-0 mdi mdi-check"></i></button>');
            })->rawColumns(['nome1', 'documento', 'status1', 'acoes'])->make(true);
	}

	// Adicionando novo documento
	public function Adicionar(DocumentosRqt $request){
		// Importando arquivo
		if(!empty($request->id_arquivo)){
            $nameFile = null;
            if ($request->hasFile('id_arquivo') && $request->file('id_arquivo')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->id_arquivo->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->id_arquivo->storeAs('documentos', $nameFile);

                $arquivo = Arquivos::create(['tipo' => 'documentos', 'endereco' => $upload]);
            }  
        }
		$create = Documentos::create([
			'nome' => $request->nome, 
			'descricao' => $request->descricao,
			'status' => ($request->status == "on" ? 1 : 0),
			'id_arquivo' => $arquivo->id
		]);
		Atividades::create([
			'nome' => 'Cadastro de novo documento',
			'descricao' => 'Você cadastrou um novo documento, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.todos.documentos'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Editando informações da função
	public function Editar(DocumentosRqt $request, $id){
		// Importando arquivo
		if(!empty($request->id_arquivo)){
            $nameFile = null;
            if ($request->hasFile('id_arquivo') && $request->file('id_arquivo')->isValid()) {
                $name = uniqid(date('HisYmd'));
                $extension =  $request->id_arquivo->extension();
                $nameFile = "{$name}.{$extension}";
                $upload =  $request->id_arquivo->storeAs('documentos', $nameFile);

                $arquivo = Arquivos::create(['tipo' => 'documentos', 'endereco' => $upload]);
            }  
        }
        $arq = Documentos::find($id);
		Documentos::find($id)->update([
			'nome' => $request->nome, 
			'descricao' => $request->descricao,
			'status' => ($request->status == "on" ? 1 : 0),
			'id_arquivo' => (isset($arquivo->id) ? $arquivo->id : $arq->id)
		]);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do documento '.$create->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.todos.documentos'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Alterar o status
	public function Alterar($id){
		$documentos = Documentos::find($id);
		if($documentos->status == 1){
			Documentos::find($id)->update(['status' => 0]);
		}else{
			Documentos::find($id)->update(['status' => 1]);
		}
		Atividades::create([
			'nome' => 'Alteração de estado',
			'descricao' => 'Você alterou o status do documento' .$documentos->nome.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.funcoes.administrativo'),
			'id_usuario' => Auth::id()
		]);
		return response()->json(['success' => true]);
	}

	// Detallhes da função
	public function Detalhes($id){
		$dados = Documentos::find($id);
		return $dados;
	}
}
