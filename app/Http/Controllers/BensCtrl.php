<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Bens; 
use App\Models\BensImagens; 
use App\Models\Atividades; 
use App\Models\Imagens; 

class BensCtrl extends Controller
{
    
    public function __construct(){
		$this->middleware('auth');
	}

	public function Exibir(){
		if(Auth::user()->RelationFuncao->ver_administrativo == 1){
			$bens = Bens::orderBy('nome', 'ASC')->get();
			return view('administrativo.bens.exibir')->with('bens', $bens);
		}else{
			return redirect(route('403'));
		}
	}
	// Adicionando novos itens
	public function Adicionar(){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			return view('administrativo.bens.adicionar');
		}else{
			return redirect(route('403'));
		}
	}
	public function AdicionarSalvar(Request $request){
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
	public function Editar($id){
		if(Auth::user()->RelationFuncao->gerenciar_administrativo == 1){
			$bens = Bens::find($id);
			return view('administrativo.bens.editar')->with('bens', $bens);
		}else{
			return redirect(route('403'));
		}
	}
	public function EditarSalvar(Request $request, $id){
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
	public function Delete($id){
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
	public function Detalhes($id){
		$bens = Bens::find($id);
		return view('administrativo.bens.detalhes')->with('bens', $bens);
	}

	// Importando arquivos de anexo
    public function Imagens(Request $request){
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
    public function RemoveImagem($id){
        $imagens = Imagens::find($id);
        unlink(getcwd().'/storage/app/'.$imagens->endereco);
        $dados = BensImagens::where('id_imagem', $id)->get();
        if(isset($dados[0])){
        	BensImagens::where('id_imagem', $id)->delete();
        }
        Imagens::find($id)->delete();
        return response()->json(['success' => true]);
    }
}
