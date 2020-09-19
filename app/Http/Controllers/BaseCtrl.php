<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\BaseRqt;
use App\Models\Atividades; 
use App\Models\Base;
use App\Models\Fontes;
use App\Models\Tipos;

class BaseCtrl extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	// -------------------------------------
	// Funções do módulo de suporte
	// -------------------------------------

	// Exibir base de conhecimento
	public function ExibirSuporte(){
		$fontes = Fontes::where('status', 1)->orderBy('nome', 'ASC')->get();
		$tipos = Tipos::where('status', 1)->orderBy('nome', 'ASC')->get();
		return view('suporte.base.exibir')->with('fontes', $fontes)->with('tipos', $tipos);
	}
	// Listar todos os itens da base
	public function Listar($fonte, $tipo){
		$todos = Base::where('gti_id_fontes', $fonte)->where('gti_id_tipos', $tipo)->get();
		$fonte = Fontes::find($fonte);
		$tipo = Tipos::find($tipo);
		return view('suporte.base.listar')->with('todos', $todos)->with('fonte', $fonte)->with('tipo', $tipo);
	}

	// -------------------------------------
	// Funções do módulo de configurações
	// -------------------------------------
	public function Exibir(){
		$topicos = Base::all();
		return view('gestao.aprendizagem.base.exibir')->with('topicos', $topicos);
	}
	// Adicionando novos itens
	public function Adicionar(){
		$fontes = Fontes::where('status', 1)->orderBy('nome', 'ASC')->get();
		$tipos = Tipos::where('status', 1)->orderBy('nome', 'ASC')->get();
		return view('gestao.aprendizagem.base.adicionar')->with('fontes', $fontes)->with('tipos', $tipos);
	}
	public function AdicionarSalvar(BaseRqt $request){
		$create = Base::create([
			'titulo' => $request->titulo,
			'subtitulo' => $request->subtitulo, 
			'descricao' => $request->descricao, 
			'gti_id_fontes' => $request->gti_id_fontes,
			'gti_id_tipos' => $request->gti_id_tipos,
		]);
		Atividades::create([
			'nome' => 'Cadastro de novo tópico',
			'descricao' => 'Você cadastrou um novo tópico, '.$create->titulo.'.',
			'icone' => 'mdi-plus',
			'url' => route('exibir.base.aprendizagem'),
			'id_usuario' => Auth::id()
		]);
		return redirect()->route('detalhes.base', $create->id);
	}
	// Editando informações
	public function Editar($id){
		$base = Base::find($id);
		$fontes = Fontes::where('status', 1)->orderBy('nome', 'ASC')->get();
		$tipos = Tipos::where('status', 1)->where('gti_id_fontes', $base->gti_id_fontes)->orderBy('nome', 'ASC')->get();
		return view('gestao.aprendizagem.base.editar')->with('base', $base)->with('fontes', $fontes)->with('tipos', $tipos);
	}
	public function EditarSalvar(BaseRqt $request, $id){
		Base::find($id)->update([
			'titulo' => $request->titulo,
			'subtitulo' => $request->subtitulo, 
			'descricao' => $request->descricao, 
			'gti_id_fontes' => $request->gti_id_fontes,
			'gti_id_tipos' => $request->gti_id_tipos,  
		]);
		$create = Base::find($id);
		Atividades::create([
			'nome' => 'Edição de informações',
			'descricao' => 'Você modificou as informações do tópico '.$create->titulo.'.',
			'icone' => 'mdi-auto-fix',
			'url' => route('exibir.base.aprendizagem'),
			'id_usuario' => Auth::id()
		]);
		return redirect()->route('detalhes.base', $id);
	}
	// Deletando a base
	public function Delete($id){
		$create = Ativos::find($id);
		Atividades::create([
			'nome' => 'Remoção de ativo',
			'descricao' => 'Você acabou de remover o ativo '.$create->titulo.'.',
			'icone' => 'mdi-rotate-3d',
			'url' => route('exibir.base.aprendizagem'),
			'id_usuario' => Auth::id()
		]);
		Base::find($id)->delete();
		return response()->json(['success' => true]);
	}
	// Detallhes do item da base
	public function Detalhes($id){
		$dados = Base::find($id);
		$topicos = Base::where('gti_id_fontes', $dados->gti_id_fontes)->where('gti_id_tipos', $dados->gti_id_tipos)->where('id', '<>', $dados->id)->limit(5)->get();
		return view('suporte.base.detalhes')->with('dados', $dados)->with('topicos', $topicos);
	}
}
