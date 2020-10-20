<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AtivoRqt; 
use Illuminate\Routing\Controller;
use App\Models\Atividades; 
use App\Models\Ativos;
use App\Models\AtivosImagens;
use App\Models\AtivosUsuarios;
use App\Models\Usuarios;
use App\Models\Setores;
use App\Models\Unidades;
use App\Models\Imagens;

class AtivosCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	// Listando todos os instituições
	public function Exibir(){
		$equipamentos = Ativos::all();
		return view('tecnologia.equipamentos.listar')->with('ativos', $equipamentos);
	}
	public function Datatables(){
		return datatables()->of(Ativos::all())
			->editColumn('imagem1', function(Ativos $dados){ 
                return '<img src="'.asset('storage/app/'.$dados->RelationImagemPrincipal->endereco).'" height="50" class="rounded">';
            })
            ->editColumn('setor', function(Ativos $dados){ 
                return $dados->RelationSetor->nome;
            })
            ->editColumn('usuario', function(Ativos $dados){ 
                return $dados->RelationUsuario->last()->RelationAssociado->nome;
            })
            ->editColumn('nome1', function(Ativos $dados){ 
                return '<label>'.$dados->nome.'</label><br><small>'.$dados->marca.' <b>&#183</b> '.$dados->modelo.'</small>';
            })
            ->editColumn('acoes', function(Ativos $dados){ 
                return '
                <a href="'.route('editar.equipamentos', $dados->id).'" class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do equipamento"><i class="mx-0 mdi mdi-settings"></i></a>
					<button class="btn btn-dark btn-xs btn-rounded" id="remover" title="Remover o equipamento"><i class="mx-0 mdi mdi-close"></i></button>';
            })->rawColumns(['imagem1', 'nome1', 'acoes'])->make(true);
	}

	public function ExibirUsuarios(){
		$equipamentos = Ativos::all();
		$usuarios = Usuarios::all();
		return view('tecnologia.equipamentos.usuarios')->with('ativos', $equipamentos)->with('usuarios', $usuarios);
	}

	// Adicionando novos itens
	public function Adicionar(){
		$usuarios = Usuarios::where('status', 1)->get();
		$setores = Setores::where('status', 1)->get();
		$unidades = Unidades::where('status', 1)->get();
		return view('tecnologia.equipamentos.adicionar')->with('usuarios', $usuarios)->with('setores', $setores)->with('unidades', $unidades);
	}
	public function AdicionarSalvar(AtivoRqt $request){
		$create = Ativos::create([
			'nome' => $request->nome,
			'n_patrimonio' => $request->n_patrimonio, 
			'serialNumber' => $request->serialNumber, 
			'marca' => $request->marca,
			'modelo' => $request->modelo,
			'id_setor' => $request->id_setor,
			'id_unidade' => $request->id_unidade,
			'descricao' => (isset($request->descricao) ? $request->descricao : null), 
		]);
		// Carregando imagem principal
		if ($request->hasFile('imagem_principal')) {
			if($request->imagem_principal->isValid()){
				$name = uniqid(date('HisYmd'));
				$extension =  $request->imagem_principal->extension();
				$nameFile = "{$name}.{$extension}";
				$upload =  $request->imagem_principal->storeAs('equipamentos', $nameFile);
			}
			$imagem = Imagens::create(['endereco' => $upload, 'tipo' => 'ativos_principal']);
			Ativos::find($create->id)->update(['id_imagem' => $imagem->id]);
		}
		// Cadastramento de várias imagens
		if ($request->imagens) {
			foreach($request->imagens as $img){
				$imagem_produto = AtivosImagens::create([
					'id_ativo' => $create->id,
					'id_imagem' => $img                    
				]);
			}
		}
        // Cadastrando o usuário responsável
		$usuarios = AtivosUsuarios::create([
			'gti_id_ativos' => $create->id,
			'usr_id_usuarios' => $request->usuario,
			'dataRecebimento' => now()
		]);
		Atividades::create([
			'nome' => 'Cadastro de novo equipamento de tecnologia',
			'descricao' => 'Você cadastrou um novo equipamento de tecnologia, '.$create->nome.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.equipamentos'),
			'id_usuario' => Auth::id()
		]);
		return redirect()->route('exibir.equipamentos');
	}

	// Editando informações
	public function Editar($id){
		$equipamentos = Ativos::find($id);
		$usuarios = Usuarios::where('status', 1)->get();
		$setores = Setores::where('status', 1)->get();
		$unidades = Unidades::where('status', 1)->get();
		return view('tecnologia.equipamentos.editar')->with('usuarios', $usuarios)->with('setores', $setores)->with('equipamentos', $equipamentos)->with('unidades', $unidades);
	}
	public function EditarSalvar(AtivoRqt $request, $id){
		Ativos::find($id)->update([
			'nome' => $request->nome,
			'n_patrimonio' => $request->n_patrimonio, 
			'serialNumber' => $request->serialNumber, 
			'marca' => $request->marca,
			'modelo' => $request->modelo,
			'id_setor' => $request->id_setor,
			'id_unidade' => $request->id_unidade,
			'descricao' => (isset($request->descricao) ? $request->descricao : null),  
		]);
		// Carregando imagem principal
		if ($request->hasFile('imagem_principal')) {
			if($request->imagem_principal->isValid()){
				$name = uniqid(date('HisYmd'));
				$extension =  $request->imagem_principal->extension();
				$nameFile = "{$name}.{$extension}";
				$upload =  $request->imagem_principal->storeAs('ativos', $nameFile);
			}
			$imagem = Imagens::create(['endereco' => $upload, 'tipo' => 'ativos_principal']);
			Ativos::find($id)->update(['id_imagem' => $imagem->id]);
		}
    	// Cadastramento de várias imagens
		if ($request->imagens) {
			AtivosImagens::where('id_ativo', $id)->delete();
			foreach($request->imagens as $img){
				$imagem_produto = AtivosImagens::create([
					'id_ativo' => $id,
					'id_imagem' => $img                    
				]);
			}
		}
        // Cadastrando o usuário responsável
		$equipamento = Ativos::find($id);
		if($request->usuario){
			AtivosUsuarios::find($equipamento->RelationUsuario->last()->pivot->id)->update(['dataDevolucao' => now()]);
			$usuarios = AtivosUsuarios::create([
				'gti_id_ativos' => $id,
				'usr_id_usuarios' => $request->usuario,
				'dataRecebimento' => now()
			]);
		}
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do equipamento de tecnologia '.$equipamento->nome.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.equipamentos'),
			'id_usuario' => Auth::id()
		]);
		return redirect()->route('exibir.equipamentos');
	}

	// Deletando o ativo
	public function Delete($id){
		$create = Ativos::find($id);
		Atividades::create([
			'nome' => 'Remoção de equipamento',
			'descricao' => 'Você acabou de remover o equipamento de tecnologia '.$create->nome.'.',
			'icone' => 'mdi-delete-forever',
			'url' => route('exibir.equipamentos'),
			'id_usuario' => Auth::id()
		]);
		AtivosImagens::where('id_ativo', $id)->delete();
		AtivosUsuarios::where('gti_id_ativos', $id)->delete();
		Ativos::find($id)->delete();
		return response()->json(['success' => true]);
	}

	// Detallhes do ativo
	public function Detalhes($id){
		$dados = Ativos::find($id);
		$dados->imagem = $dados->RelationImagemPrincipal;
		$dados->imagens  = $dados->RelationImagem;
		return response()->json($dados);
	}

	// Relatório do ativo
	public function Relatorio($id){
		$dados = Ativos::find($id);
		return view('tecnologia.equipamentos.relatorio')->with('dados', $dados);
	}

	// Importando fotos do chamado
	public function Imagens(Request $request){
        // Cadastramento de várias imagens do mesmo produto
		if ($request->hasFile('imagens')) {
			foreach($request->file('imagens') as $imagem){
				if($imagem->isValid()){
					$name = uniqid(date('HisYmd'));
					$extension =  $imagem->extension();
					$nameFile = "{$name}.{$extension}";
					$upload =  $imagem->storeAs('ativos', $nameFile);
				}
				$imagens[] = Imagens::create(['endereco' => $upload, 'tipo' => 'ativos']);
			}
		}
		return response()->json($imagens);
	}
}
