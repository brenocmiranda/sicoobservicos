<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Notifications\SolicitacaoMaterialCliente;
use App\Notifications\SolicitacaoMaterialQtdMinima;
use App\Notifications\SolicitacaoMaterialAdmin;
use App\Http\Requests\CategoriasRqt;
use App\Http\Requests\MateriaisRqt;
use App\Http\Requests\DocumentosRqt;
use App\Models\Associados;
use App\Models\Atividades; 
use App\Models\Arquivos; 
use App\Models\Bens; 
use App\Models\BensImagens; 
use App\Models\Documentos;
use App\Models\Imagens;  
use App\Models\Materiais;
use App\Models\MateriaisCategorias;
use App\Models\MateriaisHistorico;
use App\Models\CogEmailsMaterial;
use PDF;

class AdministrativoCtrl extends Controller
{
    
    public function __construct(){
    	$this->email = CogEmailsMaterial::first();
		$this->middleware('auth');
	}

	#-------------------------------------------------------------------
	# Dashboard 
	#-------------------------------------------------------------------
	public function Dashboard(){
		$materiais = Materiais::all();
		$materiaisCategoria = Materiais::join('adm_materiais_categorias', 'id_categoria', 'adm_materiais_categorias.id')->select('id_categoria', 'adm_materiais_categorias.nome', \DB::raw('count(id_categoria) as quantidade'))->groupBy('id_categoria')->where('adm_materiais.status', 1)->get();
		$materiaisHistorico = MateriaisHistorico::all();
		$bens = Bens::all();
		$bensBairro = Bens::whereNotNull('bairro')->select('bairro')->groupBy('bairro')->get();
		$bensCidade = Bens::whereNotNull('cidade')->select('cidade')->groupBy('cidade')->get();
		$documentos = Documentos::all();

		return view('administrativo.dashboard')->with('bens', $bens)->with('bensBairro', $bensBairro)->with('bensCidade', $bensCidade)->with('documentos', $documentos)->with('materiais', $materiais)->with('materiaisHistorico', $materiaisHistorico)->with('materiaisCategoria', $materiaisCategoria);
	}


	#-------------------------------------------------------------------
	# Bens da cooperativa
	#-------------------------------------------------------------------
	public function ExibirBens(){
		if(Auth::user()->RelationFuncao->ver_administrativo == 1){
			$bens = Bens::orderBy('nome', 'ASC')->get();
			return view('administrativo.bens.exibir')->with('bens', $bens);
		}else{
			return redirect(route('403'));
		}
	}
	// Adicionando novos itens
	public function AdicionarBens(){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			return view('administrativo.bens.adicionar');
		}else{
			return redirect(route('403'));
		}
	}
	public function AdicionarSalvarBens(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$create = Bens::create([
				'nome' => $request->nome,
				'tipo' => $request->tipo, 
				'valor' => str_replace(',', '.', str_replace('.', '', $request->valor)), 
				'descricao' => (isset($request->descricao) ? $request->descricao : null),
				'cep' => (isset($request->cep) ? $request->cep : null),
				'rua' => (isset($request->rua) ? $request->rua : null),
				'bairro' => (isset($request->bairro) ? $request->bairro : null),
				'numero' => (isset($request->numero) ? $request->numero : null),
				'complemento' => (isset($request->complemento) ? $request->complemento : null),
				'cidade' => (isset($request->cidade) ? $request->cidade : null),
				'estado' => (isset($request->estado) ? $request->estado : null),
			]);
			// Carregando imagem principal
			if ($request->hasFile('imagem_principal')) {
				if($request->imagem_principal->isValid()){
					$name = uniqid(date('HisYmd'));
					$extension =  $request->imagem_principal->extension();
					$nameFile = "{$name}.{$extension}";
					$upload =  $request->imagem_principal->storeAs('bens', $nameFile);
				}
				$imagem = Imagens::create(['endereco' => $upload, 'tipo' => 'bens_principal']);
				Bens::find($create->id)->update(['id_imagem' => $imagem->id]);
			}
			// Cadastramento de várias imagens 
	        if ($request->imagens) {
	            foreach($request->imagens as $arq){
	                $imagem_produto = BensImagens::create([
	                    'id_bens' => $create->id,
	                    'id_imagem' => $arq                    
	                ]);
	            }
	        }
			Atividades::create([
				'nome' => 'Cadastro de novo bem',
				'descricao' => 'Você cadastrou um novo bem da cooperativa, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('detalhes.bens.administrativo', $create->id),
				'id_usuario' => Auth::id()
			]);
			return redirect()->route('detalhes.bens.administrativo', $create->id);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações
	public function EditarBens($id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$bens = Bens::find($id);
			return view('administrativo.bens.editar')->with('bens', $bens);
		}else{
			return redirect(route('403'));
		}
	}
	public function EditarSalvarBens(Request $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			Bens::find($id)->update([
				'nome' => $request->nome,
				'tipo' => $request->tipo, 
				'valor' => str_replace(',', '.', str_replace('.', '', $request->valor)), 
				'descricao' => (isset($request->descricao) ? $request->descricao : null),
				'cep' => (isset($request->cep) ? $request->cep : null),
				'rua' => (isset($request->rua) ? $request->rua : null),
				'bairro' => (isset($request->bairro) ? $request->bairro : null),
				'numero' => (isset($request->numero) ? $request->numero : null),
				'complemento' => (isset($request->complemento) ? $request->complemento : null),
				'cidade' => (isset($request->cidade) ? $request->cidade : null),
				'estado' => (isset($request->estado) ? $request->estado : null),  
			]);
			// Carregando imagem principal
			if ($request->hasFile('imagem_principal')) {
				if($request->imagem_principal->isValid()){
					$name = uniqid(date('HisYmd'));
					$extension =  $request->imagem_principal->extension();
					$nameFile = "{$name}.{$extension}";
					$upload =  $request->imagem_principal->storeAs('ativos', $nameFile);
				}
				$imagem = Imagens::create(['endereco' => $upload, 'tipo' => 'bens_principal']);
				Bens::find($id)->update(['id_imagem' => $imagem->id]);
			}
			// Cadastramento de várias imagens 
	        if ($request->imagens){
	        	BensImagens::where('id_bens', $id)->delete();
	            foreach($request->imagens as $arq){
	                $imagem_produto = BensImagens::create([
	                    'id_bens' => $id,
	                    'id_imagem' => $arq                    
	                ]);
	            }
	        }
			$create = Bens::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do bem '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('detalhes.bens.administrativo', $id),
				'id_usuario' => Auth::id()
			]);
			return redirect()->route('detalhes.bens.administrativo', $id);
		}else{
			return redirect(route('403'));
		}
	}
	// Deletando a base
	public function DeleteBens($id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$create = Bens::find($id);
			Atividades::create([
				'nome' => 'Remoção de um bem',
				'descricao' => 'Você acabou de remover o bem '.$create->nome.'.',
				'icone' => 'mdi-delete-forever',
				'url' => route('exibir.bens.administrativo'),
				'id_usuario' => Auth::id()
			]);
			BensImagens::where('id_bens', $id)->delete();
			Bens::find($id)->delete();
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do item da base
	public function DetalhesBens($id){
		$bens = Bens::find($id);
		return view('administrativo.bens.detalhes')->with('bens', $bens);
	}
	// Importando arquivos de anexo
    public function ImagensBens(Request $request){
        // Cadastramento de várias imagens do mesmo produto
        if ($request->hasFile('imagens')) {
            foreach($request->file('imagens') as $imagem){
                if($imagem->isValid()){
					$name = uniqid(date('HisYmd'));
                    $extension =  $imagem->extension();
                    $nameFile = "{$name}.{$extension}";
                    $upload =  $imagem->storeAs('bens', $nameFile);
                }
                $imagens[] = Imagens::create(['endereco' => $upload, 'tipo' => 'bens']);
            }
        }
        return response()->json($imagens);
    }
    // Removendo arquivos de anexo
    public function RemoveImagemBens($id){
        $imagens = Imagens::find($id);
        unlink(getcwd().'/storage/app/'.$imagens->endereco);
        $dados = BensImagens::where('id_imagem', $id)->get();
        if(isset($dados[0])){
        	BensImagens::where('id_imagem', $id)->delete();
        }
        Imagens::find($id)->delete();
        return response()->json(['success' => true]);
    }


    #-------------------------------------------------------------------
	# Documentos 
	#-------------------------------------------------------------------
    // Listando todos os documentos
	public function ExibirDocumentos(){
		if(Auth::user()->RelationFuncao->ver_administrativo == 1 || Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			return view('administrativo.documentos.todos.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesDocumentos(){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			return datatables()->of(Documentos::all())
	            ->editColumn('nome1', function(Documentos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('documento', function(Documentos $dados){
	                return '<a href='.asset('storage/app/'. $dados->RelationArquivo->endereco).' target="_blank"> <i class="mdi mdi-download"></i> <span> Download </span> <a>';
	            })
	            ->editColumn('arquivo', function(Documentos $dados){
	                return $dados->RelationArquivo->endereco;
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
	            })->rawColumns(['nome1', 'documento',  'arquivo', 'status1', 'acoes'])->make(true);
        }else{
        	return datatables()->of(Documentos::all())
	            ->editColumn('nome1', function(Documentos $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	            ->editColumn('documento', function(Documentos $dados){
	                return '<a href='.asset('storage/app/'. $dados->RelationArquivo->endereco).' target="_blank"> <i class="mdi mdi-download"></i> <span> Download </span> <a>';
	            })
	            ->editColumn('arquivo', function(Documentos $dados){
	                return $dados->RelationArquivo->endereco;
	            })
	            ->editColumn('status1', function(Documentos $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Documentos $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'documento',  'arquivo', 'status1', 'acoes'])->make(true);
        }
	}
	// Adicionando novo documento
	public function AdicionarDocumentos(DocumentosRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			// Importando arquivo
			if(!empty($request->id_arquivo)){
	            $nameFile = null;
	            if ($request->hasFile('id_arquivo') && $request->file('id_arquivo')->isValid()) {
					$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , $request->nome);
					$name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
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
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do documento
	public function EditarDocumentos(DocumentosRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			// Importando arquivo
			if(!empty($request->id_arquivo)){
	            $nameFile = null;
	            if ($request->hasFile('id_arquivo') && $request->file('id_arquivo')->isValid()) {
	               	$string = iconv( "UTF-8" , "ASCII//TRANSLIT//IGNORE" , $request->nome);
					$name = preg_replace( array( '/[ ]/' , '/[^A-Za-z0-9\-]/' ) , array( '' , '' ) , $string);
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
				'descricao' => 'Você modificou as informações do documento '.$arq->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.todos.documentos'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status do documento
	public function AlterarDocumentos($id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
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
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes do documento
	public function DetalhesDocumentos($id){
		$dados = Documentos::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Controle de estoque (Materiais)
	#-------------------------------------------------------------------
	// Listando materiais para configuração
	public function ExibirMateriais(){
		if(Auth::user()->RelationFuncao->ver_administrativo == 1 || Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$categorias = MateriaisCategorias::where('status', 1)->orderBy('nome', 'ASC')->get();
			return view('administrativo.controle.todos.listar')->with('categorias', $categorias);
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesMateriais(){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			return datatables()->of(Materiais::all())
	            ->editColumn('nome1', function(Materiais $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	             ->editColumn('categoria1', function(Materiais $dados){ 
	                return '<label>'.$dados->RelationCategoria->nome.'</label>';
	            })
	            ->editColumn('status1', function(Materiais $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Materiais $dados){ 
	                return ($dados->status == 1 ? '
	                	<button class="btn btn-dark btn-xs btn-rounded mx-1" id="reposicao" title="Reposição de material"><i class="mx-0 mdi mdi-plus"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da material"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a material"><i class="mx-0 mdi mdi-close"></i></button>' : '
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="reposicao" title="Reposição de material"><i class="mx-0 mdi mdi-plus"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
						<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar  material"><i class="mx-0 mdi mdi-check"></i></button>');
	            })->rawColumns(['nome1', 'status1', 'categoria1', 'acoes'])->make(true);
	    }else{
	    	return datatables()->of(Materiais::all())
	            ->editColumn('nome1', function(Materiais $dados){ 
	                return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
	            })
	             ->editColumn('categoria1', function(Materiais $dados){ 
	                return '<label>'.$dados->RelationCategoria->nome.'</label>';
	            })
	            ->editColumn('status1', function(Materiais $dados){
	                return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
	            })
	            ->editColumn('acoes', function(Materiais $dados){ 
	                return '';
	            })->rawColumns(['nome1', 'status1', 'categoria1', 'acoes'])->make(true);
	    }
	}
	// Adicionando novo material
	public function AdicionarMateriais(MateriaisRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$create = Materiais::create([
				'nome' => $request->nome, 
				'descricao' => $request->descricao, 
				'quantidade' => $request->quantidade, 
				'quantidade_min' => $request->quantidade_min, 
				'id_categoria' => $request->id_categoria, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de um novo material',
				'descricao' => 'Você cadastrou um novo material, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.todos.materiais'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações do material
	public function EditarMateriais(MateriaisRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			Materiais::find($id)->update([
				'nome' => $request->nome, 
				'descricao' => $request->descricao, 
				'quantidade' => $request->quantidade, 
				'quantidade_min' => $request->quantidade_min, 
				'id_categoria' => $request->id_categoria, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = Materiais::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações do material, '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.todos.materiais'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status
	public function AlterarMateriais($id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$materiais = Materiais::find($id);
			if($materiais->status == 1){
				Materiais::find($id)->update(['status' => 0]);
			}else{
				Materiais::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status do material '.$materiais->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.todos.materiais'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detalhes do material
	public function DetalhesMateriais($id){
		$dados = Materiais::find($id);
		return $dados;
	}
	// Reposição de materiais
	public function ReposicaoMateriais(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$create = MateriaisHistorico::create([
				'tipo' => 'e',
				'quantidade' => $request->quantidade,
				'id_material' => $request->id_material, 
				'id_usuario' => Auth::id(), 
				'status' => 1,
			]);
			Materiais::find($request->id_material)->increment('quantidade', $request->quantidade);
			Atividades::create([
				'nome' => 'Reposição de estoque do material',
				'descricao' => 'Você acabou de repor o estoque do material '.$create->RelationMaterial->nome.'.',
				'icone' => 'mdi-plus-one',
				'url' => route('exibir.todos.materiais'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}	


	#-------------------------------------------------------------------
	# Controle de estoque (Categorias)
	#-------------------------------------------------------------------
	// Listando todos as categorias
	public function ExibirCategorias(){
		if(Auth::user()->RelationFuncao->ver_administrativo == 1 || Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			return view('administrativo.controle.categorias.listar');
		}else{
			return redirect(route('403'));
		}
	}
	public function DatatablesCategorias(){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			return datatables()->of(MateriaisCategorias::all())
			->editColumn('nome1', function(MateriaisCategorias $dados){ 
				return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
			})
			->editColumn('status1', function(MateriaisCategorias $dados){
				return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
			})
			->editColumn('acoes', function(MateriaisCategorias $dados){ 
				return ($dados->status == 1 ? '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações da função"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Desativar a função"><i class="mx-0 mdi mdi-close"></i></button>' : '
					<button class="btn btn-dark btn-xs btn-rounded mx-1" id="editar" title="Editar informações do armário"><i class="mx-0 mdi mdi-settings"></i></button>
					<button class="btn btn-dark btn-xs btn-rounded" id="alterar" title="Ativar a função"><i class="mx-0 mdi mdi-check"></i></button>');
			})->rawColumns(['nome1',  'status1','acoes'])->make(true);
		}else{
			return datatables()->of(MateriaisCategorias::all())
			->editColumn('nome1', function(MateriaisCategorias $dados){ 
				return '<a href="javascript:void(0)" id="detalhes">'.$dados->nome.'</a>';
			})
			->editColumn('status1', function(MateriaisCategorias $dados){
				return '<label class="badge'.($dados->status == 1 ? " badge-success" : " badge-danger").'">'.($dados->status == 1 ? "Ativo" : "Desativado").'</label>';
			})
			->editColumn('acoes', function(MateriaisCategorias $dados){ 
				return '';
			})->rawColumns(['nome1',  'status1','acoes'])->make(true);
		}
	}
	// Adicionando nova categoria
	public function AdicionarCategorias(CategoriasRqt $request){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$create = MateriaisCategorias::create([
				'nome' => $request->nome, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			Atividades::create([
				'nome' => 'Cadastro de nova categoria',
				'descricao' => 'Você cadastrou uma nova categoria, '.$create->nome.'.',
				'icone' => 'mdi-plus',
				'url' => route('exibir.todos.materiais'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Editando informações da categoria
	public function EditarCategorias(CategoriasRqt $request, $id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			MateriaisCategorias::find($id)->update([
				'nome' => $request->nome, 
				'status' => ($request->status == "on" ? 1 : 0)
			]);
			$create = MateriaisCategorias::find($id);
			Atividades::create([
				'nome' => 'Edição de informações',
				'descricao' => 'Você modificou as informações a categoria '.$create->nome.'.',
				'icone' => 'mdi-auto-fix',
				'url' => route('exibir.todos.materiais'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Alterar o status da categoria
	public function AlterarCategorias($id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$tipos = MateriaisCategorias::find($id);
			if($tipos->status == 1){
				MateriaisCategorias::find($id)->update(['status' => 0]);
			}else{
				MateriaisCategorias::find($id)->update(['status' => 1]);
			}
			Atividades::create([
				'nome' => 'Alteração de estado',
				'descricao' => 'Você alterou o status da categoria '.$tipos->nome.'.',
				'icone' => 'mdi-rotate-3d',
				'url' => route('exibir.todos.materiais'),
				'id_usuario' => Auth::id()
			]);
			return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}
	// Detallhes da categoria
	public function DetalhesCategorias($id){
		$dados = MateriaisCategorias::find($id);
		return $dados;
	}


	#-------------------------------------------------------------------
	# Solicitações 
	#-------------------------------------------------------------------
	// Listando todas solicitações para aprovação
	public function ExibirMateriaisAdmin(){
		if(Auth::user()->RelationFuncao->ver_administrativo == 1 || Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$historico = MateriaisHistorico::where('status', 1)->orWhere('status', 2)->orderBy('created_at', 'DESC')->get();
			$pendencias = MateriaisHistorico::where('status', 0)->orderBy('created_at', 'DESC')->get();
			$categorias = MateriaisCategorias::where('status', 1)->orderBy('nome', 'ASC')->get();
			return view('administrativo.materiais.exibir')->with('pendencias', $pendencias)->with('categorias', $categorias)->with('historico', $historico);
		}else{
			return redirect(route('403'));
		}
	}
	// Aprovando solicitação de material
	public function SolicitacaoMateriaisAdminAprovar($id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$historico = MateriaisHistorico::find($id);
			if($historico->RelationMaterial->quantidade >= $historico->quantidade){
				MateriaisHistorico::find($id)->update(['status' => 1]);
				Materiais::find($historico->id_material)->decrement('quantidade', $historico->quantidade);
				$material = Materiais::find($historico->id_material);
				if($material->quantidade <= $material->quantidade_min){
					$this->email->notify(new SolicitacaoMaterialQtdMinima($historico));
				}
				$historico->RelationUsuario->notify(new SolicitacaoMaterialCliente($historico));	
				
				Atividades::create([
					'nome' => 'Aprovação de solicitação de material',
					'descricao' => 'Você acabou de aprovar a solicitação do material, '.$historico->RelationMaterial->nome.'.',
					'icone' => ' mdi-cube-send',
					'url' => route('exibir.solicitacoes.administrativo'),
					'id_usuario' => Auth::id()
				]);
				return response()->json(['success' => true]);
			}else{
				return response()->json(['success' => false]);
			}
		}else{
			return redirect(route('403'));
		}
	}
	// Desaprovando solicitação de material
	public function SolicitacaoMateriaisAdminDesaprovar(Request $request){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
				MateriaisHistorico::find($request->id)->update(['status' => 2, 'observacao' => $request->observacao]);
				$historico = MateriaisHistorico::find($request->id);
				$historico->RelationUsuario->notify(new SolicitacaoMaterialCliente($historico));
				$this->email->notify(new SolicitacaoMaterialAdmin($historico));
				Atividades::create([
					'nome' => 'Desaprovação de solicitação de material',
					'descricao' => 'Você acabou de cancelar a solicitação do material, '.$historico->RelationMaterial->nome.'.',
					'icone' => ' mdi-delete-forever',
					'url' => route('exibir.solicitacoes.administrativo'),
					'id_usuario' => Auth::id()
				]);

				return response()->json(['success' => true]);
		}else{
			return redirect(route('403'));
		}
	}


	#-------------------------------------------------------------------
	# Relatórios 
	#-------------------------------------------------------------------
	// Listando lista de relatórios
	public function Relatorios(){
	    if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1 || Auth::user()->RelationFuncao->ver_administrativo == 1){
	      return view('administrativo.relatorios.exibir');
	    }else{
	      return redirect(route('403'));
	    }
	}
	// Gerando relatório de aniversariantes
	public function RelatoriosAniversariantes(Request $request){
	    if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1 || Auth::user()->RelationFuncao->ver_administrativo == 1){
	      if($request->orientacao == 'paisagem'){
	        $result = Associados::where('funcionario', 1)->whereMonth('data_nascimento', $request->mes)->where('id', '<>', 1)->select('nome', 'data_nascimento')->orderByRaw('day(data_nascimento) asc')->get();
	        Atividades::create([
	          'nome' => 'Geração de relatório de aniversariantes',
	          'descricao' => 'Você gerou o relatório de aniversariantes do mês '.$request->mes.'.',
	          'icone' => 'mdi-file-document',
	          'url' => 'javascript:',
	          'id_usuario' => Auth::id()
	        ]);
	        $pdf = PDF::loadView('administrativo.relatorios.niver-p', compact('result'))->setPaper('a4', 'landscape');
	        return $pdf->stream();
	      }else{
	        $result = Associados::where('funcionario', 1)->whereMonth('data_nascimento', $request->mes)->where('id', '<>', 1)->select('nome', 'data_nascimento')->orderByRaw('day(data_nascimento) asc')->get();
	        Atividades::create([
	          'nome' => 'Geração de relatório de aniversariantes',
	          'descricao' => 'Você gerou o relatório de aniversariantes do mês '.$request->mes.'.',
	          'icone' => 'mdi-file-document',
	          'url' => 'javascript:',
	          'id_usuario' => Auth::id()
	        ]);
	        $pdf = PDF::loadView('administrativo.relatorios.niver-r', compact('result'))->setPaper('a4', 'portrait');
	        return $pdf->stream();

	      }
	    }else{
	      return redirect(route('403'));
	    }
	}
}
