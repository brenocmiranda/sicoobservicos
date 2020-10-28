<?php

#---------------------------------------------------------------------
# Website
#---------------------------------------------------------------------
Route::group(['prefix' => '/'], function(){
	Route::get('', 'HomepageCtrl@Exibir')->name('homepage');
});


#---------------------------------------------------------------------
# Aplicação
#---------------------------------------------------------------------
Route::group(['prefix' => 'app'], function(){

	#---------------------------------------------------------------------
	# Funções internas
	#---------------------------------------------------------------------
	Route::group(['prefix' => ''], function(){
		Route::get('login', 'UsuariosCtrl@Login')->name('login');
		Route::post('redirect', 'UsuariosCtrl@Redirecionar')->name('redirect');
		Route::get('logout', 'UsuariosCtrl@Sair')->name('logout');
		Route::get('home', 'UsuariosCtrl@Inicio')->name('inicio')->middleware('auth');
		Route::get('atividades', 'UsuariosCtrl@Atividades')->name('atividades')->middleware('auth');

		// Primeiro acesso a plataforma
		Route::group(['prefix' => 'new'], function(){
			Route::get('', 'UsuariosCtrl@PrimeiroAcesso')->name('primeiro.acesso')->middleware('auth');
			Route::post('salvar', 'UsuariosCtrl@SalvarPrimeiroAcesso')->name('salvar.primeiro.acesso')->middleware('auth');
		});
		// Recuperação de senha
		Route::group(['prefix' => 'password'], function(){
			Route::post('solicitar', 'UsuariosCtrl@Solicitar')->name('recuperar.password');
			Route::any('redefinir/{token}', 'UsuariosCtrl@Verificar')->name('view.password');
			Route::any('trocar', 'UsuariosCtrl@Trocar')->name('redefinindo.password');
		});
		
		// Gestão do perfil
		Route::group(['prefix' => 'perfil'], function(){
			Route::get('', 'UsuariosCtrl@Perfil')->name('perfil')->middleware('auth');
			Route::post('salvar', 'UsuariosCtrl@SalvarPerfil')->name('perfil.salvar')->middleware('auth');
		});
	});

	#---------------------------------------------------------------------
	# Módulo Administrativo
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'administrativo'], function(){
		// Dashboard
		Route::group(['prefix' => ''], function(){
			Route::get('dashboard', 'DashboardCtrl@DashAdministrativo')->name('dashboard.administrativo');
		});
		// Solicitações de materiais
		Route::group(['prefix' => 'solicitacoes'], function(){
			Route::get('', 'MateriaisCtrl@ExibirSuporteAdmin')->name('exibir.solicitacoes.administrativo');
			Route::get('alterar/{id}', 'MateriaisCtrl@SolicitacaoAprovacao')->name('aprovar.solicitacoes.administrativo');
			
		});
		// Documentos
		Route::group(['prefix' => 'documentos'], function(){
			Route::get('', 'DocumentosCtrl@Exibir')->name('exibir.todos.documentos');
			Route::get('listar', 'DocumentosCtrl@Datatables')->name('listar.todos.documentos');
			Route::post('adicionar', 'DocumentosCtrl@Adicionar')->name('adicionar.todos.documentos');
			Route::post('editar/{id}', 'DocumentosCtrl@Editar')->name('editar.todos.documentos');
			Route::get('alterar/{id}', 'DocumentosCtrl@Alterar')->name('alterar.todos.documentos');
			Route::any('detalhes/{id}', 'DocumentosCtrl@Detalhes')->name('detalhes.todos.documentos');
		});

		// Aniversariantes
		Route::group(['prefix' => 'aniversariantes'], function(){
			Route::get('', 'AssociadosCtrl@ExibirAniversariantes')->name('exibir.aniversariantes.administrativo');
			Route::post('relatorio', 'AssociadosCtrl@GerarAniversariantes')->name('gerar.aniversariantes.administrativo');
		});

		// Controle de estoque
		Route::group(['prefix' => 'controle'], function(){
			// Todos
			Route::group(['prefix' => 'todos'], function(){
				Route::get('', 'MateriaisCtrl@Exibir')->name('exibir.todos.materiais');
				Route::get('listar', 'MateriaisCtrl@Datatables')->name('listar.todos.materiais');
				Route::post('adicionar', 'MateriaisCtrl@Adicionar')->name('adicionar.todos.materiais');
				Route::post('editar/{id}', 'MateriaisCtrl@Editar')->name('editar.todos.materiais');
				Route::get('alterar/{id}', 'MateriaisCtrl@Alterar')->name('alterar.todos.materiais');
				Route::any('detalhes/{id}', 'MateriaisCtrl@Detalhes')->name('detalhes.todos.materiais');
			});
			// Categorias
			Route::group(['prefix' => 'categorias'], function(){
				Route::get('', 'CategoriasCtrl@Exibir')->name('exibir.categorias.materiais');
				Route::get('listar', 'CategoriasCtrl@Datatables')->name('listar.categorias.materiais');
				Route::post('adicionar', 'CategoriasCtrl@Adicionar')->name('adicionar.categorias.materiais');
				Route::post('editar/{id}', 'CategoriasCtrl@Editar')->name('editar.categorias.materiais');
				Route::get('alterar/{id}', 'CategoriasCtrl@Alterar')->name('alterar.categorias.materiais');
				Route::any('detalhes/{id}', 'CategoriasCtrl@Detalhes')->name('detalhes.categorias.materiais');
			});
		});
	});

	#---------------------------------------------------------------------
	# Módulo de Crédito
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'credito'], function(){
		// Dashboard
		Route::group(['prefix' => ''], function(){
			Route::get('dashboard', 'DashboardCtrl@DashCredito')->name('dashboard.credito');
		});
		// Contratos
		Route::group(['prefix' => 'contratos'], function(){
			Route::group(['prefix' => ''], function(){
				Route::get('', 'CreditoCtrl@Contratos')->name('exibir.contratos.credito');
				Route::any('pesquisar', 'CreditoCtrl@Pesquisar')->name('pesquisar.contratos.credito');
				Route::post('adicionar', 'CreditoCtrl@Adicionar')->name('adicionar.contratos.credito');
				Route::post('editar/{id}', 'CreditoCtrl@Editar')->name('editar.contratos.credito');
				Route::post('alterar/{id}', 'CreditoCtrl@Alterar')->name('alterar.contratos.credito');
				Route::get('detalhes/{id}', 'CreditoCtrl@Detalhes')->name('detalhes.contratos.credito');
				Route::any('garantias/{id}', 'CreditoCtrl@Garantias')->name('garantias.contratos.credito');
			});
			// Contratos vigentes
			Route::group(['prefix' => 'vigente'], function(){
				Route::get('', 'CreditoCtrl@Exibir')->name('exibir.vigente.credito');
				Route::get('listar', 'CreditoCtrl@Datatables')->name('listar.vigente.credito');
			});
			// Contratos liquidados
			Route::group(['prefix' => 'quitado'], function(){
				Route::get('', 'CreditoCtrl@Exibir')->name('exibir.quitado.credito');
				Route::get('listar', 'CreditoCtrl@Datatables')->name('listar.quitado.credito');
			});
			// Contratos em prejuizo
			Route::group(['prefix' => 'prejuizo'], function(){
				Route::get('', 'CreditoCtrl@Exibir')->name('exibir.prejuizo.credito');
				Route::get('listar', 'CreditoCtrl@Datatables')->name('listar.prejuizo.credito');
			});
		});
		// Disposição
		Route::group(['prefix' => 'disposicao'], function(){
			Route::get('', 'CreditoCtrl@Disposicao')->name('exibir.disposicao.credito');
			Route::get('/{id}', 'CreditoCtrl@ExibirDisposicao')->name('exibir.gaveta.credito');
			Route::get('listar/{id}', 'CreditoCtrl@DatatablesDisposicao')->name('listar.gaveta.credito');
			//Route::get('imprimir', 'CreditoCtrl@Imprimir')->name('imprimir.disposicao.credito');
		});
		// Garantias
		Route::group(['prefix' => 'garantias'], function(){
			// Garantias fiduciárias
			Route::group(['prefix' => 'fiduciaria'], function(){
				Route::get('', 'GarantiasCtrl@ExibirFiduciaria')->name('exibir.garantias.fiduciaria.credito');
				Route::get('listar', 'GarantiasCtrl@DatatablesFiduciaria')->name('listar.garantias.fiduciaria.credito');
			});
			// Garantias fidejussórias
			Route::group(['prefix' => 'fidejussoria'], function(){
				Route::get('', 'GarantiasCtrl@ExibirFidejussoria')->name('exibir.garantias.fidejussoria.credito');
				Route::get('listar', 'GarantiasCtrl@DatatablesFidejussoria')->name('listar.garantias.fidejussoria.credito');
			});
			Route::post('adicionar', 'GarantiasCtrl@Adicionar')->name('adicionar.garantias.credito');
			Route::post('editar/{avalista}/{id}', 'GarantiasCtrl@Editar')->name('editar.garantias.credito');
			Route::any('detalhes/{id}', 'GarantiasCtrl@Detalhes')->name('detalhes.garantias.credito');
			Route::any('alterar/{avalista}/{id}', 'GarantiasCtrl@Alterar')->name('alterar.garantias.credito');
		});
		// Solicitações
		Route::group(['prefix' => 'solicitacoes'], function(){
			Route::get('', 'SolicitacoesCtrl@Exibir')->name('exibir.solicitacoes.credito');
			Route::post('solicitar', 'SolicitacoesCtrl@Solicitar')->name('solicitar.solicitacoes.credito');
			Route::post('alterar', 'SolicitacoesCtrl@Alterar')->name('alterar.solicitacoes.credito');
			Route::get('imprimir/{id}', 'SolicitacoesCtrl@Relatorio')->name('imprimir.solicitacoes.credito');
			Route::any('remover/{id}', 'SolicitacoesCtrl@Remover')->name('remover.solicitacoes.credito');
			
			Route::get('detalhes/{id}', 'SolicitacoesCtrl@DetalhesContrato')->name('detalhes.solicitacoes.credito');
		});
		// Associados *
		Route::group(['prefix' => 'associados'], function(){
			Route::get('', 'AssociadosCtrl@Listar')->name('listar.associado.credito');
			Route::get('detalhes/{id}', 'AssociadosCtrl@Detalhes')->name('detalhes.associado.credito');
			Route::post('adicionar', 'AssociadosCtrl@Adicionar')->name('adicionar.associado.credito');
		});
		Route::group(['prefix' => 'configuracoes'], function(){
			// Armários
			Route::group(['prefix' => 'armarios'], function(){
				Route::get('', 'ArmariosCtrl@Exibir')->name('exibir.armarios.credito');
				Route::get('listar', 'ArmariosCtrl@Datatables')->name('listar.armarios.credito');
				Route::post('adicionar', 'ArmariosCtrl@Adicionar')->name('adicionar.armarios.credito');
				Route::post('editar/{id}', 'ArmariosCtrl@Editar')->name('editar.armarios.credito');
				Route::get('alterar/{id}', 'ArmariosCtrl@Alterar')->name('alterar.armarios.credito');
				Route::any('detalhes/{id}', 'ArmariosCtrl@Detalhes')->name('detalhes.armarios.credito');
			});
			// Modalidades
			Route::group(['prefix' => 'modalidades'], function(){
				Route::get('', 'ModalidadesCtrl@Exibir')->name('exibir.modalidades.credito');
				Route::get('listar', 'ModalidadesCtrl@Datatables')->name('listar.modalidades.credito');
				Route::post('adicionar', 'ModalidadesCtrl@Adicionar')->name('adicionar.modalidades.credito');
				Route::post('editar/{id}', 'ModalidadesCtrl@Editar')->name('editar.modalidades.credito');
				Route::get('alterar/{id}', 'ModalidadesCtrl@Alterar')->name('alterar.modalidades.credito');
				Route::any('detalhes/{id}', 'ModalidadesCtrl@Detalhes')->name('detalhes.modalidades.credito');
			});
			// Finalidades
			Route::group(['prefix' => 'finalidades'], function(){
				Route::get('', 'FinalidadesCtrl@Exibir')->name('exibir.finalidades.credito');
				Route::get('listar', 'FinalidadesCtrl@Datatables')->name('listar.finalidades.credito');
				Route::post('adicionar', 'FinalidadesCtrl@Adicionar')->name('adicionar.finalidades.credito');
				Route::post('editar/{id}', 'FinalidadesCtrl@Editar')->name('editar.finalidades.credito');
				Route::get('alterar/{id}', 'FinalidadesCtrl@Alterar')->name('alterar.finalidades.credito');
				Route::any('detalhes/{id}', 'FinalidadesCtrl@Detalhes')->name('detalhes.finalidades.credito');
			});
			// Produtos
			Route::group(['prefix' => 'produtos'], function(){
				Route::get('', 'ProdutosCredCtrl@Exibir')->name('exibir.produtos.credito');
				Route::get('listar', 'ProdutosCredCtrl@Datatables')->name('listar.produtos.credito');
				Route::post('adicionar', 'ProdutosCredCtrl@Adicionar')->name('adicionar.produtos.credito');
				Route::post('editar/{id}', 'ProdutosCredCtrl@Editar')->name('editar.produtos.credito');
				Route::get('alterar/{id}', 'ProdutosCredCtrl@Alterar')->name('alterar.produtos.credito');
				Route::any('detalhes/{id}', 'ProdutosCredCtrl@Detalhes')->name('detalhes.produtos.credito');
			});
		});
	});

	#---------------------------------------------------------------------
	# Módulo Suporte
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'suporte'], function(){
		// Base de conhecimento
		Route::group(['prefix' => 'base'], function(){
			Route::get('', 'BaseCtrl@ExibirSuporte')->name('exibir.base');
			Route::get('listar/{fonte}/{tipo}', 'BaseCtrl@Listar')->name('listar.base');
			Route::get('detalhes/{id}', 'BaseCtrl@Detalhes')->name('detalhes.base');
		});
		// Chamados
		Route::group(['prefix' => 'chamados'], function(){
			Route::get('', 'ChamadosCtrl@ExibirUsuarios')->name('exibir.chamados');
			Route::get('abertura', 'ChamadosCtrl@Abertura')->name('abertura.chamados');
			Route::post('aberturaEnviar', 'ChamadosCtrl@AberturaEnviar')->name('abertura.chamados.enviar');
			Route::post('finalizar/{id}', 'ChamadosCtrl@Finalizar')->name('finalizar.chamados');
			Route::get('relatorio/{id}', 'ChamadosCtrl@Relatorio')->name('relatorio.chamados');
			Route::get('reabrir/{id}', 'ChamadosCtrl@Reabertura')->name('reabertura.chamados');
			Route::get('detalhes/{id}', 'ChamadosCtrl@Detalhes')->name('detalhes.chamados');
			Route::any('tipos/{idFonte}', 'ChamadosCtrl@ListarTipos')->name('tipos.chamados');
			Route::any('base/{idTipo}/{idFonte}', 'ChamadosCtrl@ListarBase')->name('base.chamados');
			Route::post('addArquivos', 'ChamadosCtrl@Arquivos')->name('adicionar.arquivos.chamados');
			Route::get('removeArquivo/{id}', 'ChamadosCtrl@RemoveArquivos')->name('remover.arquivos.chamados');
		});
		// Solicitações de materiais
		Route::group(['prefix' => 'materiais'], function(){
			Route::get('', 'MateriaisCtrl@ExibirSuporte')->name('exibir.solicitacoes.materiais');
			Route::post('solicitacao', 'MateriaisCtrl@Solicitacao')->name('efetuar.solicitacoes.materiais');
			Route::post('reposicao', 'MateriaisCtrl@Reposicao')->name('efetuar.reposicao.materiais');
			Route::get('categorias/{id}', 'MateriaisCtrl@ListarMateriais')->name('categorias.solicitacoes.materiais');
		});
		// Documentos para download
		Route::group(['prefix' => 'documentos'], function(){
			Route::get('', 'DocumentosCtrl@ExibirDocumentos')->name('exibir.documentos');
		});
	});

	#---------------------------------------------------------------------
	# Módulo de GTI 
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'gti'], function(){
		// Dashboard
		Route::group(['prefix' => ''], function(){
			Route::get('dashboard', 'DashboardCtrl@DashTecnologia')->name('dashboard.gti');
		});
		// Equipamentos
		Route::group(['prefix' => 'equipamentos'], function(){
			Route::get('geral', 'AtivosCtrl@Exibir')->name('exibir.geral.equipamentos');
			Route::get('usuarios', 'AtivosCtrl@ExibirUsuarios')->name('exibir.usuarios.equipamentos');
			Route::get('termo', 'AtivosCtrl@ExibirTermo')->name('exibir.termo.equipamentos');
			Route::post('gerarTermo', 'AtivosCtrl@GerarTermo')->name('gerar.termo.equipamentos');
			Route::get('listar', 'AtivosCtrl@Datatables')->name('listar.equipamentos');
			Route::get('adicionar', 'AtivosCtrl@Adicionar')->name('adicionar.equipamentos');
			Route::post('salvar', 'AtivosCtrl@AdicionarSalvar')->name('salvar.adicionar.equipamentos');
			Route::get('editar/{id}', 'AtivosCtrl@Editar')->name('editar.equipamentos');
			Route::post('salvarEditar/{id}', 'AtivosCtrl@EditarSalvar')->name('salvar.editar.equipamentos');
			Route::get('remover/{id}', 'AtivosCtrl@Delete')->name('remover.equipamentos');
			Route::any('detalhes/{id}', 'AtivosCtrl@Detalhes')->name('detalhes.equipamentos');
			Route::post('addImagens', 'AtivosCtrl@Imagens')->name('adicionar.imagens.equipamentos');
			
		});
		// Chamados
		Route::group(['prefix' => 'chamados'], function(){
			Route::get('', 'ChamadosCtrl@ExibirGTI')->name('exibir.chamados.gti');
			Route::get('detalhes/{id}', 'ChamadosCtrl@DetalhesGTI')->name('detalhes.chamados.gti');
			Route::post('finalizar/{id}', 'ChamadosCtrl@FinalizarGTI')->name('finalizar.chamados.gti');
			Route::get('atualizacao/{id_chamado}/{id_status}', 'ChamadosCtrl@MonitorarGTI')->name('monitorar.chamados.gti');
			Route::get('relatorio/{id}', 'ChamadosCtrl@RelatorioGTI')->name('relatorio.chamados.gti');
			Route::post('status/{id}', 'ChamadosCtrl@StatusGTI')->name('status.chamados.gti');
			Route::get('info/{id}', 'ChamadosCtrl@InfoGTI')->name('info.chamados.gti');
			Route::get('remove/{id}', 'ChamadosCtrl@RemoveGTI')->name('remove.chamados.gti');
			Route::post('descricao', 'ChamadosCtrl@DescricaoGTI')->name('descricao.chamados.gti');
		});
		// Homepage
		Route::group(['prefix' => 'homepage'], function(){
			Route::get('', 'HomepageCtrl@Listar')->name('exibir.homepage')->middleware('auth');
			Route::post('adicionar', 'HomepageCtrl@Adicionar')->name('adicionar.homepage')->middleware('auth');
			Route::post('editar/{id}', 'HomepageCtrl@Editar')->name('editar.homepage')->middleware('auth');
			Route::any('delete/{id}', 'HomepageCtrl@Delete')->name('delete.homepage')->middleware('auth');
			Route::any('detalhes/{id}', 'HomepageCtrl@Detalhes')->name('detalhes.homepage')->middleware('auth');
		});

		Route::group(['prefix' => 'configuracoes'], function(){
			// Aprendizagem
			Route::group(['prefix' => 'aprendizagem'], function(){		
				Route::group(['prefix' => 'base'], function(){
					Route::get('', 'BaseCtrl@Exibir')->name('exibir.base.aprendizagem');
					Route::get('adicionar', 'BaseCtrl@Adicionar')->name('adicionar.base.aprendizagem');
					Route::post('salvar', 'BaseCtrl@AdicionarSalvar')->name('salvar.adicionar.base.aprendizagem');
					Route::get('editar/{id}', 'BaseCtrl@Editar')->name('editar.base.aprendizagem');
					Route::post('salvarEditar/{id}', 'BaseCtrl@EditarSalvar')->name('salvar.editar.base.aprendizagem');
					Route::get('detele/{id}', 'BaseCtrl@Delete')->name('delete.base.aprendizagem');
					Route::post('addArquivos', 'BaseCtrl@Arquivos')->name('adicionar.arquivos.aprendizagem');
					Route::get('removeArquivo/{id}', 'BaseCtrl@RemoveArquivos')->name('remover.arquivos.aprendizagem');
					Route::any('tipos/{idFonte}', 'ChamadosCtrl@ListarTipos')->name('tipos.chamados');
					Route::any('base/{idTipo}/{idFonte}', 'ChamadosCtrl@ListarBase')->name('base.chamados');
				});
			});
			// Fontes
			Route::group(['prefix' => 'fontes'], function(){
				Route::get('', 'FontesCtrl@Exibir')->name('exibir.fontes.chamados');
				Route::get('listar', 'FontesCtrl@Datatables')->name('listar.fontes.chamados');
				Route::post('adicionar', 'FontesCtrl@Adicionar')->name('adicionar.fontes.chamados');
				Route::post('editar/{id}', 'FontesCtrl@Editar')->name('editar.fontes.chamados');
				Route::get('alterar/{id}', 'FontesCtrl@Alterar')->name('alterar.fontes.chamados');
				Route::any('detalhes/{id}', 'FontesCtrl@Detalhes')->name('detalhes.fontes.chamados');
			});		
			// Tipos
			Route::group(['prefix' => 'tipos'], function(){
				Route::get('', 'TiposCtrl@Exibir')->name('exibir.tipos.chamados');
				Route::get('listar', 'TiposCtrl@Datatables')->name('listar.tipos.chamados');
				Route::post('adicionar', 'TiposCtrl@Adicionar')->name('adicionar.tipos.chamados');
				Route::post('editar/{id}', 'TiposCtrl@Editar')->name('editar.tipos.chamados');
				Route::get('alterar/{id}', 'TiposCtrl@Alterar')->name('alterar.tipos.chamados');
				Route::any('detalhes/{id}', 'TiposCtrl@Detalhes')->name('detalhes.tipos.chamados');
			});
			// Status
			Route::group(['prefix' => 'status'], function(){
				Route::get('', 'StatusCtrl@Exibir')->name('exibir.status.chamados');
				Route::get('listar', 'StatusCtrl@Datatables')->name('listar.status.chamados');
				Route::post('adicionar', 'StatusCtrl@Adicionar')->name('adicionar.status.chamados');
				Route::post('editar/{id}', 'StatusCtrl@Editar')->name('editar.status.chamados');
				Route::get('alterar/{id}', 'StatusCtrl@Alterar')->name('alterar.status.chamados');
				Route::any('detalhes/{id}', 'StatusCtrl@Detalhes')->name('detalhes.status.chamados');
			});
		});
	});

	#---------------------------------------------------------------------
	# Módulo de Configurações 
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'gestao'], function(){
		Route::get('', 'UsuariosCtrl@Configuracoes')->name('configuracoes')->middleware('auth');
		Route::group(['prefix' => 'administrativo'], function(){
			// Funções
			Route::group(['prefix' => 'funcoes'], function(){
				Route::get('', 'FuncoesCtrl@Exibir')->name('exibir.funcoes.administrativo');
				Route::get('listar', 'FuncoesCtrl@Datatables')->name('listar.funcoes.administrativo');
				Route::post('adicionar', 'FuncoesCtrl@Adicionar')->name('adicionar.funcoes.administrativo');
				Route::post('editar/{id}', 'FuncoesCtrl@Editar')->name('editar.funcoes.administrativo');
				Route::get('alterar/{id}', 'FuncoesCtrl@Alterar')->name('alterar.funcoes.administrativo');
				Route::any('detalhes/{id}', 'FuncoesCtrl@Detalhes')->name('detalhes.funcoes.administrativo');
			});
			// Instituições
			Route::group(['prefix' => 'instituicoes'], function(){
				Route::get('', 'InstituicoesCtrl@Exibir')->name('exibir.instituicoes.administrativo');
				Route::post('adicionar', 'InstituicoesCtrl@Adicionar')->name('adicionar.instituicoes.administrativo');
				Route::post('editar/{id}', 'InstituicoesCtrl@Editar')->name('editar.instituicoes.administrativo');
				Route::get('alterar/{id}', 'InstituicoesCtrl@Alterar')->name('alterar.instituicoes.administrativo');
				Route::any('detalhes/{id}', 'InstituicoesCtrl@Detalhes')->name('detalhes.instituicoes.administrativo');
			});
			// Setores
			Route::group(['prefix' => 'setores'], function(){
				Route::get('', 'SetoresCtrl@Exibir')->name('exibir.setores.administrativo');
				Route::get('listar', 'SetoresCtrl@Datatables')->name('listar.setores.administrativo');
				Route::post('adicionar', 'SetoresCtrl@Adicionar')->name('adicionar.setores.administrativo');
				Route::post('editar/{id}', 'SetoresCtrl@Editar')->name('editar.setores.administrativo');
				Route::get('alterar/{id}', 'SetoresCtrl@Alterar')->name('alterar.setores.administrativo');
				Route::any('detalhes/{id}', 'SetoresCtrl@Detalhes')->name('detalhes.setores.administrativo');
			});
			// Unidades
			Route::group(['prefix' => 'unidades'], function(){
				Route::get('', 'UnidadesCtrl@Exibir')->name('exibir.unidades.administrativo');
				Route::post('adicionar', 'UnidadesCtrl@Adicionar')->name('adicionar.unidades.administrativo');
				Route::post('editar/{id}', 'UnidadesCtrl@Editar')->name('editar.unidades.administrativo');
				Route::get('alterar/{id}', 'UnidadesCtrl@Alterar')->name('alterar.unidades.administrativo');
				Route::any('detalhes/{id}', 'UnidadesCtrl@Detalhes')->name('detalhes.unidades.administrativo');
			});
			// Usuários
			Route::group(['prefix' => 'usuarios'], function(){
				Route::get('', 'UsuariosCtrl@Exibir')->name('exibir.usuarios.administrativo')->middleware('auth');
				Route::get('listar', 'UsuariosCtrl@Datatables')->name('listar.usuarios.administrativo')->middleware('auth');
				Route::post('adicionar', 'UsuariosCtrl@Adicionar')->name('adicionar.usuarios.administrativo')->middleware('auth');
				Route::post('editar/{id}', 'UsuariosCtrl@Editar')->name('editar.usuarios.administrativo')->middleware('auth');
				Route::post('alterar/{id}', 'UsuariosCtrl@Alterar')->name('alterar.usuarios.administrativo')->middleware('auth');
				Route::any('detalhes/{id}', 'UsuariosCtrl@Detalhes')->name('detalhes.usuarios.administrativo')->middleware('auth');
				Route::any('resetar/{id}', 'UsuariosCtrl@Resetar')->name('resetar.usuarios.administrativo')->middleware('auth');
			});
		});	
		// Emails
		Route::group(['prefix' => 'emails'], function(){
			// Ajustes
			Route::group(['prefix' => 'ajustes'], function(){
				Route::get('', 'EmailsCtrl@ExibirAjustes')->name('exibir.ajustes.emails');
				Route::post('salvar', 'EmailsCtrl@SalvarAjustes')->name('salvar.ajustes.emails');
			});
			// Menssagens
			Route::group(['prefix' => 'mensagens'], function(){
				Route::get('', 'EmailsCtrl@ExibirMensagens')->name('exibir.mensagens.emails');
				Route::post('salvar', 'EmailsCtrl@SalvarMensagens')->name('salvar.mensagens.emails');
			});
		});
		// Importações
		Route::group(['prefix' => 'importacoes'], function(){
			// Automática
			Route::group(['prefix' => 'automatica'], function(){
				Route::any('', 'ImportacoesCtrl@ImportarAutomatica')->name('importAuto.importacoes');
			});
			// Manual
			Route::group(['prefix' => 'manual'], function(){
				Route::get('', 'ImportacoesCtrl@Exibir')->name('exibir.importacoes');
				Route::any('executar', 'ImportacoesCtrl@Importar')->name('executar.importacoes');
			});
			// Logs
			Route::group(['prefix' => 'logs'], function(){
				Route::get('', 'ImportacoesCtrl@ExibirLogs')->name('exibir.logs.importacoes');
			});
			// Importação automática
			
		});
		
	});
});