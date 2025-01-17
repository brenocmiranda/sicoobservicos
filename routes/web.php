<?php

#---------------------------------------------------------------------
# Hotsite
#---------------------------------------------------------------------
Route::group(['prefix' => '/'], function(){
	Route::get('', 'PublicCtrl@Homepage')->name('homepage');
	Route::get('telefones', 'PublicCtrl@ExibirTelefones')->name('telefones');
	Route::group(['prefix' => 'digitalizar'], function(){
		Route::get('', 'PublicCtrl@ExibirImportacao')->name('digitalizar');
		Route::post('enviar', 'PublicCtrl@Upload')->name('digitalizar.enviar');
		Route::post('arquivo', 'PublicCtrl@ArquivoDigitalizar')->name('arquivo.digitalizar.enviar');
	});
	Route::get('universidade', 'PublicCtrl@ExibirUniversidade')->name('universidade');
});


#---------------------------------------------------------------------
# Aplicação
#---------------------------------------------------------------------
Route::group(['prefix' => 'app'], function(){

	#---------------------------------------------------------------------
	# Funções internas
	#---------------------------------------------------------------------
	Route::group(['prefix' => ''], function(){
		// Funções externas
		Route::get('login', 'PublicCtrl@Login')->name('login');
		Route::post('redirect', 'PublicCtrl@Redirecionar')->name('redirect');
		Route::group(['prefix' => 'password'], function(){
			// Recuperação de senha
			Route::post('solicitar', 'PublicCtrl@Solicitar')->name('recuperar.password');
			Route::any('redefinir/{token}', 'PublicCtrl@Verificar')->name('view.password');
			Route::any('trocar', 'PublicCtrl@Trocar')->name('redefinindo.password');
		});

		// Funções internas
		Route::get('home', 'PrivateCtrl@Inicio')->name('inicio');
		Route::get('logout', 'PrivateCtrl@Sair')->name('logout');
		Route::get('atividades', 'PrivateCtrl@Atividades')->name('atividades');
		Route::get('403', 'PrivateCtrl@Permission403')->name('403');
		Route::get('check', 'PrivateCtrl@CheckUser')->name('check');
		Route::group(['prefix' => 'new'], function(){
			// Primeiro acesso a plataforma
			Route::get('', 'PrivateCtrl@PrimeiroAcesso')->name('primeiro.acesso');
			Route::post('salvar', 'PrivateCtrl@SalvarPrimeiroAcesso')->name('salvar.primeiro.acesso');
		});
		Route::group(['prefix' => 'perfil'], function(){
			// Gestão do perfil
			Route::get('', 'PrivateCtrl@Perfil')->name('perfil');
			Route::post('salvar', 'PrivateCtrl@SalvarPerfil')->name('perfil.salvar');
		});
	});

	#---------------------------------------------------------------------
	# Módulo Administrativo
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'administrativo'], function(){
		// Dashboard
		Route::group(['prefix' => ''], function(){
			Route::get('dashboard', 'AdministrativoCtrl@Dashboard')->name('dashboard.administrativo');
		});
		// Bens 
		Route::group(['prefix' => 'bens'], function(){
			Route::get('', 'AdministrativoCtrl@ExibirBens')->name('exibir.bens.administrativo');
			Route::get('adicionar', 'AdministrativoCtrl@AdicionarBens')->name('adicionar.bens.administrativo');
			Route::post('salvar', 'AdministrativoCtrl@AdicionarSalvarBens')->name('salvar.bens.administrativo');
			Route::get('editar/{id}', 'AdministrativoCtrl@EditarBens')->name('editar.bens.administrativo');
			Route::post('editando/{id}', 'AdministrativoCtrl@EditarSalvarBens')->name('editando.bens.administrativo');
			Route::get('delete/{id}', 'AdministrativoCtrl@DeleteBens')->name('delete.bens.administrativo');
			Route::any('detalhes/{id}', 'AdministrativoCtrl@DetalhesBens')->name('detalhes.bens.administrativo');
			Route::post('addImagens', 'AdministrativoCtrl@ImagensBens')->name('adicionar.imagens.bens.administrativo');
			Route::get('removeImagem/{id}', 'AdministrativoCtrl@RemoveImagemBens')->name('remover.imagens.bens.administrativo');
			Route::any('pesquisar', 'AdministrativoCtrl@PesquisarDacao')->name('pesquisar.associado.bens.administrativo');
		});
		// Documentos
		Route::group(['prefix' => 'documentos'], function(){
			Route::get('', 'AdministrativoCtrl@ExibirDocumentos')->name('exibir.todos.documentos');
			Route::get('listar', 'AdministrativoCtrl@DatatablesDocumentos')->name('listar.todos.documentos');
			Route::post('adicionar', 'AdministrativoCtrl@AdicionarDocumentos')->name('adicionar.todos.documentos');
			Route::post('editar/{id}', 'AdministrativoCtrl@EditarDocumentos')->name('editar.todos.documentos');
			Route::get('alterar/{id}', 'AdministrativoCtrl@AlterarDocumentos')->name('alterar.todos.documentos');
			Route::any('detalhes/{id}', 'AdministrativoCtrl@DetalhesDocumentos')->name('detalhes.todos.documentos');
		});
		// Controle de estoque
		Route::group(['prefix' => 'controle'], function(){
			// Todos
			Route::group(['prefix' => 'todos'], function(){
				Route::get('', 'AdministrativoCtrl@ExibirMateriais')->name('exibir.todos.materiais');
				Route::get('listar', 'AdministrativoCtrl@DatatablesMateriais')->name('listar.todos.materiais');
				Route::post('adicionar', 'AdministrativoCtrl@AdicionarMateriais')->name('adicionar.todos.materiais');
				Route::post('editar/{id}', 'AdministrativoCtrl@EditarMateriais')->name('editar.todos.materiais');
				Route::get('alterar/{id}', 'AdministrativoCtrl@AlterarMateriais')->name('alterar.todos.materiais');
				Route::any('detalhes/{id}', 'AdministrativoCtrl@DetalhesMateriais')->name('detalhes.todos.materiais');			
				Route::post('reposicao', 'AdministrativoCtrl@ReposicaoMateriais')->name('efetuar.reposicao.materiais');
			});
			// Categorias
			Route::group(['prefix' => 'categorias'], function(){
				Route::get('', 'AdministrativoCtrl@ExibirCategorias')->name('exibir.categorias.materiais');
				Route::get('listar', 'AdministrativoCtrl@DatatablesCategorias')->name('listar.categorias.materiais');
				Route::post('adicionar', 'AdministrativoCtrl@AdicionarCategorias')->name('adicionar.categorias.materiais');
				Route::post('editar/{id}', 'AdministrativoCtrl@EditarCategorias')->name('editar.categorias.materiais');
				Route::get('alterar/{id}', 'AdministrativoCtrl@AlterarCategorias')->name('alterar.categorias.materiais');
				Route::any('detalhes/{id}', 'AdministrativoCtrl@DetalhesCategorias')->name('detalhes.categorias.materiais');
			});
		});
		// Solicitações de materiais
		Route::group(['prefix' => 'solicitacoes'], function(){
			Route::get('', 'AdministrativoCtrl@ExibirMateriaisAdmin')->name('exibir.solicitacoes.administrativo');
			Route::get('aprovar/{id}', 'AdministrativoCtrl@SolicitacaoMateriaisAdminAprovar')->name('aprovar.solicitacoes.administrativo');	
			Route::post('desaprovar/{id}', 'AdministrativoCtrl@SolicitacaoMateriaisAdminDesaprovar')->name('desaprovar.solicitacoes.administrativo');
		});
		// Relatórios
		Route::group(['prefix' => 'relatorios'], function(){
			Route::get('', 'AdministrativoCtrl@Relatorios')->name('exibir.relatorios.administrativo');
			Route::any('relatorio', 'AdministrativoCtrl@RelatoriosAniversariantes')->name('relatorio.aniversariantes.administrativo');
		});
	});

	#---------------------------------------------------------------------
	# Módulo Atendimento
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'atendimento'], function(){
		// Atividades
		Route::group(['prefix' => 'atividades'], function(){
			Route::get('', 'AtendimentoCtrl@ExibirAtividades')->name('exibir.atividades.atendimento');
			Route::get('listar', 'AtendimentoCtrl@DatatablesAtividades')->name('listar.atividades.atendimento');
			Route::any('filter', 'AtendimentoCtrl@PesquisaAtividades')->name('filtros.atividades.atendimento');
			Route::any('relatorio', 'AtendimentoCtrl@RelatorioAtividades')->name('relatorio.atividades.atendimento');
		});
		// Painel comercial
		Route::group(['prefix' => 'painel'], function(){
			Route::get('', 'AtendimentoCtrl@ExibirPainel')->name('exibir.painel.atendimento');
			Route::any('pesquisar', 'AtendimentoCtrl@PesquisarPainel')->name('pesquisar.associado.atendimento');
			Route::any('exibir', 'AtendimentoCtrl@MostrarPainel')->name('exibir.associado.atendimento');
			Route::any('exibir/{id}', 'AtendimentoCtrl@MostrarPainelID')->name('exibirID.associado.atendimento');
			Route::any('relatorio/{id}', 'AtendimentoCtrl@RelatorioPainel')->name('relatorio.associado.atendimento');
			// Atividades
			Route::group(['prefix' => 'atividades'], function(){
				Route::post('', 'AtendimentoCtrl@AtividadesPainel')->name('atividade.associado.atendimento');
				Route::get('detalhes/{id}', 'AtendimentoCtrl@DetalhesPainel')->name('detalhes.atividade.associado.atendimento');
				Route::post('editando', 'AtendimentoCtrl@EditandoPainel')->name('editando.atividade.associado.atendimento');
			});
		});
		// Cadastro *
		Route::group(['prefix' => 'cadastro'], function(){
			Route::group(['prefix' => 'novos'], function(){
				Route::get('', 'AtendimentoCtrl@ExibirAssociado')->name('exibir.cadastro.atendimento');
				Route::get('adicionar', 'AtendimentoCtrl@NovoAssociado')->name('adicionar.cadastro.atendimento');
				Route::post('salvarPF', 'AtendimentoCtrl@CadastroAssociadoPF')->name('salvarPF.cadastro.atendimento');
				Route::post('salvarPJ', 'AtendimentoCtrl@CadastroAssociadoPJ')->name('salvarPJ.cadastro.atendimento');
				Route::get('detalhes/{id}', 'AtendimentoCtrl@DetalhesCadastro')->name('detalhes.cadastro.atendimento');
				Route::get('existe/{documento}', 'AtendimentoCtrl@ExisteCadastro')->name('existe.cadastro.atendimento');
				Route::any('pesquisar', 'AtendimentoCtrl@PesquisarCadastro')->name('pesquisar.cadastro.atendimento');
			});
		});
	});

	#---------------------------------------------------------------------
	# Módulo Cadastro *
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'cadastro'], function(){
		// Dashboard
		Route::group(['prefix' => ''], function(){
			Route::get('dashboard', 'CadastroCtrl@Dashboard')->name('dashboard.cadastro');
		});
		// Solicitações
		Route::group(['prefix' => 'novos'], function(){
			Route::get('', 'CadastroCtrl@ExibirNovos')->name('exibir.solicitacoes.cadastro');
			Route::get('solicitar', 'CadastroCtrl@DetalhesNovos')->name('detalhes.solicitacoes.cadastro');
		});
	});

	#---------------------------------------------------------------------
	# Módulo de Crédito *
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'credito'], function(){
		// Dashboard
		Route::group(['prefix' => ''], function(){
			Route::get('dashboard', 'CreditoCtrl@Dashboard')->name('dashboard.credito');
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
				Route::get('', 'CreditoCtrl@ExibirFiduciaria')->name('exibir.garantias.fiduciaria.credito');
				Route::get('listar', 'CreditoCtrl@DatatablesFiduciaria')->name('listar.garantias.fiduciaria.credito');
			});
			// Garantias fidejussórias
			Route::group(['prefix' => 'fidejussoria'], function(){
				Route::get('', 'CreditoCtrl@ExibirFidejussoria')->name('exibir.garantias.fidejussoria.credito');
				Route::get('listar', 'CreditoCtrl@DatatablesFidejussoria')->name('listar.garantias.fidejussoria.credito');
			});
			Route::post('adicionar', 'CreditoCtrl@AdicionarGarantias')->name('adicionar.garantias.credito');
			Route::post('editar/{avalista}/{id}', 'CreditoCtrl@EditarGarantias')->name('editar.garantias.credito');
			Route::any('detalhes/{id}', 'CreditoCtrl@DetalhesGarantias')->name('detalhes.garantias.credito');
			Route::any('alterar/{avalista}/{id}', 'CreditoCtrl@AlterarGarantias')->name('alterar.garantias.credito');
		});
		// Solicitações
		Route::group(['prefix' => 'solicitacoes'], function(){
			Route::get('', 'CreditoCtrl@ExibirSolicitacoes')->name('exibir.solicitacoes.credito');
			Route::post('solicitar', 'CreditoCtrl@SolicitarSolicitacoes')->name('solicitar.solicitacoes.credito');
			Route::post('alterar', 'CreditoCtrl@AlterarSolicitacoes')->name('alterar.solicitacoes.credito');
			Route::get('imprimir/{id}', 'CreditoCtrl@RelatorioSolicitacoes')->name('imprimir.solicitacoes.credito');
			Route::any('remover/{id}', 'CreditoCtrl@RemoverSolicitacoes')->name('remover.solicitacoes.credito');
			Route::get('detalhes/{id}', 'CreditoCtrl@DetalhesContratoSolicitacoes')->name('detalhes.solicitacoes.credito');
		});
		// Associados *
		Route::group(['prefix' => 'associados'], function(){
			Route::get('', 'AssociadosCtrl@Listar')->name('listar.associado.credito');
		});
		// Configurações
		Route::group(['prefix' => 'configuracoes'], function(){
			// Armários
			Route::group(['prefix' => 'armarios'], function(){
				Route::get('', 'CreditoCtrl@ExibirArmarios')->name('exibir.armarios.credito');
				Route::get('listar', 'CreditoCtrl@DatatablesArmarios')->name('listar.armarios.credito');
				Route::post('adicionar', 'CreditoCtrl@AdicionarArmarios')->name('adicionar.armarios.credito');
				Route::post('editar/{id}', 'CreditoCtrl@EditarArmarios')->name('editar.armarios.credito');
				Route::get('alterar/{id}', 'CreditoCtrl@AlterarArmarios')->name('alterar.armarios.credito');
				Route::any('detalhes/{id}', 'CreditoCtrl@DetalhesArmarios')->name('detalhes.armarios.credito');
			});
			// Modalidades
			Route::group(['prefix' => 'modalidades'], function(){
				Route::get('', 'CreditoCtrl@ExibirModalidades')->name('exibir.modalidades.credito');
				Route::get('listar', 'CreditoCtrl@DatatablesModalidades')->name('listar.modalidades.credito');
				Route::post('adicionar', 'CreditoCtrl@AdicionarModalidades')->name('adicionar.modalidades.credito');
				Route::post('editar/{id}', 'CreditoCtrl@EditarModalidades')->name('editar.modalidades.credito');
				Route::get('alterar/{id}', 'CreditoCtrl@AlterarModalidades')->name('alterar.modalidades.credito');
				Route::any('detalhes/{id}', 'CreditoCtrl@DetalhesModalidades')->name('detalhes.modalidades.credito');
			});
			// Produtos
			Route::group(['prefix' => 'produtos'], function(){
				Route::get('', 'CreditoCtrl@ExibirProdutos')->name('exibir.produtos.credito');
				Route::get('listar', 'CreditoCtrl@DatatablesProdutos')->name('listar.produtos.credito');
				Route::post('adicionar', 'CreditoCtrl@AdicionarProdutos')->name('adicionar.produtos.credito');
				Route::post('editar/{id}', 'CreditoCtrl@EditarProdutos')->name('editar.produtos.credito');
				Route::get('alterar/{id}', 'CreditoCtrl@AlterarProdutos')->name('alterar.produtos.credito');
				Route::any('detalhes/{id}', 'CreditoCtrl@DetalhesProdutos')->name('detalhes.produtos.credito');
			});
		});
		// FAMPE
		Route::group(['prefix' => ''], function(){
			Route::get('fampe', 'CreditoCtrl@Fampe')->name('fampe.credito');
		});
	});
	
	#---------------------------------------------------------------------
	# Módulo Negócios *
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'negocios'], function(){
		// Dashboard
		Route::group(['prefix' => ''], function(){
			Route::get('dashboard', 'NegociosCtrl@Dashboard')->name('dashboard.negocios');
		});
		// Análise
		Route::group(['prefix' => 'analise'], function(){
			Route::get('', 'NegociosCtrl@ExibirAnalise')->name('exibir.analise.negocios');
			Route::get('listar', 'NegociosCtrl@DatatablesAnalise')->name('listar.analise.negocios');
			Route::get('executar/{id}', 'NegociosCtrl@ExecutarAnalise')->name('executar.analise.negocios');
			Route::post('finalizar/{id}', 'NegociosCtrl@SalvarAnalise')->name('finalizar.analise.negocios');
			Route::get('encaminhar/{id}', 'NegociosCtrl@EncaminharAnalise')->name('encaminhar.analise.negocios');
			Route::post('remover/{id}', 'NegociosCtrl@RemoverAnalise')->name('remover.analise.negocios');
		});
		// Carteira
		Route::group(['prefix' => 'carteira'], function(){
			Route::get('', 'NegociosCtrl@ExibirCarteira')->name('exibir.carteira.negocios');
			Route::get('listar', 'NegociosCtrl@DatatablesCarteira')->name('listar.carteira.negocios');
			Route::get('executar/{id}', 'NegociosCtrl@ExecutarCarteira')->name('executar.carteira.negocios');
			Route::post('finalizar/{id}', 'NegociosCtrl@SalvarCarteira')->name('finalizar.carteira.negocios');
			Route::get('devolver/{id}', 'NegociosCtrl@DevolverCarteira')->name('devolver.carteira.negocios');
		});
		// Acompanhamento
		Route::group(['prefix' => 'acompanhamento'], function(){
			Route::get('', 'NegociosCtrl@ExibirAcompanhamento')->name('exibir.acompanhamento.negocios');
			Route::get('listar', 'NegociosCtrl@DatatablesAcompanhamento')->name('listar.acompanhamento.negocios');
			Route::get('executar/{id}', 'NegociosCtrl@ExecutarAcompanhamento')->name('executar.acompanhamento.negocios');
			Route::any('alterar/{id}', 'NegociosCtrl@AlterarAcompanhamento')->name('alterar.acompanhamento.negocios');
			Route::get('relatorio/{id}', 'NegociosCtrl@RelatorioAcompanhamento')->name('relatorio.acompanhamento.negocios');
		});
		// Relatórios
		Route::group(['prefix' => 'relatorios'], function(){
			Route::get('', 'NegociosCtrl@ExibirRelatorios')->name('exibir.relatorios.negocios');
		});
	});

	#---------------------------------------------------------------------
	# Módulo Suporte
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'suporte'], function(){
		// Aprendizagem
		Route::group(['prefix' => 'base'], function(){
			Route::get('', 'SuporteCtrl@Aprendizagem')->name('exibir.base');
			Route::get('listar/{fonte}/{tipo}', 'SuporteCtrl@AprendizagemListar')->name('listar.base');
			Route::get('detalhes/{id}', 'SuporteCtrl@DetalhesAprendizagem')->name('detalhes.base');
			Route::get('relatorio/{id}', 'SuporteCtrl@RelatorioAprendizagem')->name('relatorio.base');
		});
		// Chamados
		Route::group(['prefix' => 'chamados'], function(){
			Route::get('', 'SuporteCtrl@Chamados')->name('exibir.chamados');
			Route::get('abertura', 'SuporteCtrl@AberturaChamados')->name('abertura.chamados');
			Route::post('aberturaEnviar', 'SuporteCtrl@AberturaEnviarChamados')->name('abertura.chamados.enviar');
			Route::post('finalizar/{id}', 'SuporteCtrl@FinalizarChamados')->name('finalizar.chamados');
			Route::get('relatorio/{id}', 'SuporteCtrl@RelatorioChamados')->name('relatorio.chamados');
			Route::post('reabrir/{id}', 'SuporteCtrl@ReaberturaChamados')->name('reabertura.chamados');
			Route::get('detalhes/{id}', 'SuporteCtrl@DetalhesChamados')->name('detalhes.chamados');
			Route::any('fontes/{idAmbiente}', 'SuporteCtrl@ListarFontesChamados')->name('fontes.chamados');
			Route::any('base/{idAmbiente}/{idFonte}', 'SuporteCtrl@ListarBaseChamados')->name('base.chamados');
			Route::post('status/{id}', 'SuporteCtrl@StatusChamados')->name('status.chamados');
			Route::post('addArquivos', 'SuporteCtrl@ArquivosChamados')->name('adicionar.arquivos.chamados');
			Route::get('removeArquivo/{id}', 'SuporteCtrl@RemoveArquivosChamados')->name('remover.arquivos.chamados');
			Route::post('addArquivosStatus', 'SuporteCtrl@ArquivosChamadosStatus')->name('adicionar.arquivos.chamados.status');
			Route::get('removeArquivoStatus/{id}', 'SuporteCtrl@RemoveArquivosChamadosStatus')->name('remover.arquivos.chamados.status');
		});
		// Solicitações de materiais
		Route::group(['prefix' => 'materiais'], function(){
			Route::get('', 'SuporteCtrl@Materiais')->name('exibir.solicitacoes.materiais');
			Route::post('solicitacao', 'SuporteCtrl@MateriaisSolicitacao')->name('efetuar.solicitacoes.materiais');
			Route::post('cancelar/{id}', 'SuporteCtrl@MateriaisSolicitacaoCancelar')->name('cancelar.solicitacoes.materiais');
			Route::get('categorias/{id}', 'SuporteCtrl@MateriaisListar')->name('categorias.solicitacoes.materiais');
		});
		// Documentos
		Route::group(['prefix' => 'documentos'], function(){
			Route::get('', 'SuporteCtrl@Documentos')->name('exibir.documentos');
		});
	});

	#---------------------------------------------------------------------
	# Módulo de Tecnologia 
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'gti'], function(){
		// Dashboard
		Route::group(['prefix' => ''], function(){
			Route::get('dashboard', 'TecnologiaCtrl@Dashboard')->name('dashboard.gti');
		});
		// Aprendizagem
		Route::group(['prefix' => 'aprendizagem'], function(){
			Route::get('', 'TecnologiaCtrl@ExibirAprendizagem')->name('exibir.base.aprendizagem');
			Route::get('adicionar', 'TecnologiaCtrl@AdicionarAprendizagem')->name('adicionar.base.aprendizagem');
			Route::post('salvar', 'TecnologiaCtrl@AdicionarSalvarAprendizagem')->name('salvar.adicionar.base.aprendizagem');
			Route::get('editar/{id}', 'TecnologiaCtrl@EditarAprendizagem')->name('editar.base.aprendizagem');
			Route::post('salvarEditar/{id}', 'TecnologiaCtrl@EditarSalvarAprendizagem')->name('salvar.editar.base.aprendizagem');
			Route::get('delete/{id}', 'TecnologiaCtrl@DeleteAprendizagem')->name('delete.base.aprendizagem');
			Route::post('addArquivos', 'TecnologiaCtrl@ArquivosAprendizagem')->name('adicionar.arquivos.aprendizagem');
			Route::get('removeArquivo/{id}', 'TecnologiaCtrl@RemoveArquivosAprendizagem')->name('remover.arquivos.aprendizagem');
			// Módulo suporte
			Route::any('fontes/{idAmbiente}', 'SuporteCtrl@ListarFontesChamados')->name('fontes.chamados');
			Route::any('base/{idFonte}/{idAmbiente}', 'SuporteCtrl@ListarBaseChamados')->name('base.chamados');
		});
		// Chamados
		Route::group(['prefix' => 'chamados'], function(){
			Route::get('', 'TecnologiaCtrl@ExibirChamados')->name('exibir.chamados.gti');
			Route::get('detalhes/{id}', 'TecnologiaCtrl@DetalhesChamados')->name('detalhes.chamados.gti');
			Route::post('finalizar/{id}', 'TecnologiaCtrl@FinalizarChamados')->name('finalizar.chamados.gti');
			Route::get('atualizacao/{id_chamado}/{id_status}', 'TecnologiaCtrl@MonitorarChamados')->name('monitorar.chamados.gti');
			Route::get('relatorio/{id}', 'TecnologiaCtrl@RelatorioChamados')->name('relatorio.chamados.gti');
			Route::post('status/{id}', 'TecnologiaCtrl@StatusChamados')->name('status.chamados.gti');
			Route::get('info/{id}', 'TecnologiaCtrl@InfoChamados')->name('info.chamados.gti');
			Route::get('remove/{id}', 'TecnologiaCtrl@RemoveChamados')->name('remove.chamados.gti');
			Route::post('descricao', 'TecnologiaCtrl@DescricaoChamados')->name('descricao.chamados.gti');
			Route::post('addArquivosStatus', 'TecnologiaCtrl@ArquivosChamadosStatus')->name('adicionar.arquivos.chamados.status.gti');
			Route::get('removeArquivoStatus/{id}', 'TecnologiaCtrl@RemoveArquivosChamadosStatus')->name('remover.arquivos.chamados.status.gti');
			// Tarefa de monitoramento
			// Route::get('atraso', 'TecnologiaCtrl@MonitorarTempoVidaStatus')->name('dados.chamados.gti');
		});
		// Configurações
		Route::group(['prefix' => 'configuracoes'], function(){
			// Equipamentos
			Route::group(['prefix' => 'equipamentos'], function(){
				Route::get('', 'TecnologiaCtrl@ExibirEquipamentos')->name('exibir.equipamentos.inventario');
				Route::get('listar', 'TecnologiaCtrl@DatatablesEquipamentos')->name('listar.equipamentos.inventario');
				Route::post('adicionar', 'TecnologiaCtrl@AdicionarEquipamentos')->name('adicionar.equipamentos.inventario');
				Route::post('editar/{id}', 'TecnologiaCtrl@EditarEquipamentos')->name('editar.equipamentos.inventario');
				Route::get('alterar/{id}', 'TecnologiaCtrl@AlterarEquipamentos')->name('alterar.equipamentos.inventario');
				Route::any('detalhes/{id}', 'TecnologiaCtrl@DetalhesEquipamentos')->name('detalhes.equipamentos.inventario');
			});
			// Ambientes
			Route::group(['prefix' => 'ambientes'], function(){
				Route::get('', 'TecnologiaCtrl@ExibirAmbientes')->name('exibir.ambientes.chamados');
				Route::get('listar', 'TecnologiaCtrl@DatatablesAmbientes')->name('listar.ambientes.chamados');
				Route::post('adicionar', 'TecnologiaCtrl@AdicionarAmbientes')->name('adicionar.ambientes.chamados');
				Route::post('editar/{id}', 'TecnologiaCtrl@EditarAmbientes')->name('editar.ambientes.chamados');
				Route::get('alterar/{id}', 'TecnologiaCtrl@AlterarAmbientes')->name('alterar.ambientes.chamados');
				Route::any('detalhes/{id}', 'TecnologiaCtrl@DetalhesAmbientes')->name('detalhes.ambientes.chamados');
			});		
			// Marcas
			Route::group(['prefix' => 'marcas'], function(){
				Route::get('', 'TecnologiaCtrl@ExibirMarcas')->name('exibir.marcas.inventario');
				Route::get('listar', 'TecnologiaCtrl@DatatablesMarcas')->name('listar.marcas.inventario');
				Route::post('adicionar', 'TecnologiaCtrl@AdicionarMarcas')->name('adicionar.marcas.inventario');
				Route::post('editar/{id}', 'TecnologiaCtrl@EditarMarcas')->name('editar.marcas.inventario');
				Route::get('alterar/{id}', 'TecnologiaCtrl@AlterarMarcas')->name('alterar.marcas.inventario');
				Route::any('detalhes/{id}', 'TecnologiaCtrl@DetalhesMarcas')->name('detalhes.marcas.inventario');
			});
			// Fontes
			Route::group(['prefix' => 'fontes'], function(){
				Route::get('', 'TecnologiaCtrl@ExibirFontes')->name('exibir.fontes.chamados');
				Route::get('listar', 'TecnologiaCtrl@DatatablesFontes')->name('listar.fontes.chamados');
				Route::post('adicionar', 'TecnologiaCtrl@AdicionarFontes')->name('adicionar.fontes.chamados');
				Route::post('editar/{id}', 'TecnologiaCtrl@EditarFontes')->name('editar.fontes.chamados');
				Route::get('alterar/{id}', 'TecnologiaCtrl@AlterarFontes')->name('alterar.fontes.chamados');
				Route::any('detalhes/{id}', 'TecnologiaCtrl@DetalhesFontes')->name('detalhes.fontes.chamados');
			});
			// Status
			Route::group(['prefix' => 'status'], function(){
				Route::get('', 'TecnologiaCtrl@ExibirStatus')->name('exibir.status.chamados');
				Route::get('listar', 'TecnologiaCtrl@DatatablesStatus')->name('listar.status.chamados');
				Route::post('adicionar', 'TecnologiaCtrl@AdicionarStatus')->name('adicionar.status.chamados');
				Route::post('editar/{id}', 'TecnologiaCtrl@EditarStatus')->name('editar.status.chamados');
				Route::get('alterar/{id}', 'TecnologiaCtrl@AlterarStatus')->name('alterar.status.chamados');
				Route::any('detalhes/{id}', 'TecnologiaCtrl@DetalhesStatus')->name('detalhes.status.chamados');
			});
		});
		// Atalhos
		Route::group(['prefix' => 'atalhos'], function(){
			Route::get('', 'TecnologiaCtrl@ExibirHomepage')->name('exibir.atalhos');
			Route::post('adicionar', 'TecnologiaCtrl@AdicionarHomepage')->name('adicionar.atalhos');
			Route::post('editar/{id}', 'TecnologiaCtrl@EditarHomepage')->name('editar.atalhos');
			Route::any('delete/{id}', 'TecnologiaCtrl@DeleteHomepage')->name('delete.atalhos');
			Route::any('detalhes/{id}', 'TecnologiaCtrl@DetalhesHomepage')->name('detalhes.atalhos');
		});
		// Inventário
		Route::group(['prefix' => 'equipamentos'], function(){
			Route::get('geral', 'TecnologiaCtrl@ExibirInventario')->name('exibir.geral.equipamentos');
			Route::get('usuarios', 'TecnologiaCtrl@ExibirUsuariosInventario')->name('exibir.usuarios.equipamentos');
			Route::get('listar', 'TecnologiaCtrl@DatatablesInventario')->name('listar.equipamentos');
			Route::get('adicionar', 'TecnologiaCtrl@AdicionarInventario')->name('adicionar.equipamentos');
			Route::post('salvar', 'TecnologiaCtrl@AdicionarSalvarInventario')->name('salvar.adicionar.equipamentos');
			Route::get('editar/{id}', 'TecnologiaCtrl@EditarInventario')->name('editar.equipamentos');
			Route::post('salvarEditar/{id}', 'TecnologiaCtrl@EditarSalvarInventario')->name('salvar.editar.equipamentos');
			Route::get('remover/{id}', 'TecnologiaCtrl@DeleteInventario')->name('remover.equipamentos');
			Route::any('detalhes/{id}', 'TecnologiaCtrl@DetalhesInventario')->name('detalhes.equipamentos');
			Route::post('addImagens', 'TecnologiaCtrl@ImagensInventario')->name('adicionar.imagens.equipamentos');
			Route::post('alterarUsuario/{id}', 'TecnologiaCtrl@AlterarUsuarioInvetario')->name('alterar.usuarios.equipamentos');
			Route::any('historico/{id}', 'TecnologiaCtrl@HistoricoInvetario')->name('historico.usuarios.equipamentos');
			Route::any('serialNumber/{dados}', 'TecnologiaCtrl@ExisteSerialNumber')->name('serialNumber.equipamentos');
			Route::any('patrimonio/{dados}', 'TecnologiaCtrl@ExistePatrimonio')->name('patrimonio.equipamentos');
		});
		
		// Relatórios
		Route::group(['prefix' => 'relatorios'], function(){
			Route::get('', 'TecnologiaCtrl@Relatorios')->name('exibir.relatorios.tecnologia');
			Route::any('atalhos', 'TecnologiaCtrl@RelatoriosAtalhos')->name('relatorio.atalhos.tecnologia');
			Route::any('chamados', 'TecnologiaCtrl@RelatoriosChamados')->name('relatorio.chamados.tecnologia');
			Route::any('equipamentos', 'TecnologiaCtrl@RelatoriosEquipamentos')->name('relatorio.equipamentos.tecnologia');
			Route::any('termoUso', 'TecnologiaCtrl@RelatoriosTermoUso')->name('relatorio.termoUso.tecnologia');
		});
	});

	#---------------------------------------------------------------------
	# Módulo de Configurações 
	#---------------------------------------------------------------------
	Route::group(['prefix' => 'configuracoes'], function(){
		Route::get('', 'ConfiguracoesCtrl@Configuracoes')->name('configuracoes');
		Route::group(['prefix' => 'administrativo'], function(){
			// Funções
			Route::group(['prefix' => 'funcoes'], function(){
				Route::get('', 'ConfiguracoesCtrl@ExibirFuncoes')->name('exibir.funcoes.administrativo');
				Route::get('listar', 'ConfiguracoesCtrl@DatatablesFuncoes')->name('listar.funcoes.administrativo');
				Route::post('adicionar', 'ConfiguracoesCtrl@AdicionarFuncoes')->name('adicionar.funcoes.administrativo');
				Route::post('editar/{id}', 'ConfiguracoesCtrl@EditarFuncoes')->name('editar.funcoes.administrativo');
				Route::get('alterar/{id}', 'ConfiguracoesCtrl@AlterarFuncoes')->name('alterar.funcoes.administrativo');
				Route::any('detalhes/{id}', 'ConfiguracoesCtrl@DetalhesFuncoes')->name('detalhes.funcoes.administrativo');
			});
			// Instituições
			Route::group(['prefix' => 'instituicoes'], function(){
				Route::get('', 'ConfiguracoesCtrl@ExibirInstituicoes')->name('exibir.instituicoes.administrativo');
				Route::post('adicionar', 'ConfiguracoesCtrl@AdicionarInstituicoes')->name('adicionar.instituicoes.administrativo');
				Route::post('editar/{id}', 'ConfiguracoesCtrl@EditarInstituicoes')->name('editar.instituicoes.administrativo');
				Route::get('alterar/{id}', 'ConfiguracoesCtrl@AlterarInstituicoes')->name('alterar.instituicoes.administrativo');
				Route::any('detalhes/{id}', 'ConfiguracoesCtrl@DetalhesInstituicoes')->name('detalhes.instituicoes.administrativo');
			});
			// Setores
			Route::group(['prefix' => 'setores'], function(){
				Route::get('', 'ConfiguracoesCtrl@ExibirSetores')->name('exibir.setores.administrativo');
				Route::get('listar', 'ConfiguracoesCtrl@DatatablesSetores')->name('listar.setores.administrativo');
				Route::post('adicionar', 'ConfiguracoesCtrl@AdicionarSetores')->name('adicionar.setores.administrativo');
				Route::post('editar/{id}', 'ConfiguracoesCtrl@EditarSetores')->name('editar.setores.administrativo');
				Route::get('alterar/{id}', 'ConfiguracoesCtrl@AlterarSetores')->name('alterar.setores.administrativo');
				Route::any('detalhes/{id}', 'ConfiguracoesCtrl@DetalhesSetores')->name('detalhes.setores.administrativo');
			});
			// Unidades
			Route::group(['prefix' => 'unidades'], function(){
				Route::get('', 'ConfiguracoesCtrl@ExibirUnidades')->name('exibir.unidades.administrativo');
				Route::post('adicionar', 'ConfiguracoesCtrl@AdicionarUnidades')->name('adicionar.unidades.administrativo');
				Route::post('editar/{id}', 'ConfiguracoesCtrl@EditarUnidades')->name('editar.unidades.administrativo');
				Route::get('alterar/{id}', 'ConfiguracoesCtrl@AlterarUnidades')->name('alterar.unidades.administrativo');
				Route::any('detalhes/{id}', 'ConfiguracoesCtrl@DetalhesUnidades')->name('detalhes.unidades.administrativo');
			});
			// Usuários
			Route::group(['prefix' => 'usuarios'], function(){
				Route::get('', 'ConfiguracoesCtrl@ExibirUsuarios')->name('exibir.usuarios.administrativo')->middleware('auth');
				Route::get('listar', 'ConfiguracoesCtrl@DatatablesUsuarios')->name('listar.usuarios.administrativo')->middleware('auth');
				Route::post('adicionar', 'ConfiguracoesCtrl@AdicionarUsuarios')->name('adicionar.usuarios.administrativo')->middleware('auth');
				Route::post('editar/{id}', 'ConfiguracoesCtrl@EditarUsuarios')->name('editar.usuarios.administrativo')->middleware('auth');
				Route::post('alterar/{id}', 'ConfiguracoesCtrl@AlterarUsuarios')->name('alterar.usuarios.administrativo')->middleware('auth');
				Route::any('detalhes/{id}', 'ConfiguracoesCtrl@DetalhesUsuarios')->name('detalhes.usuarios.administrativo')->middleware('auth');
				Route::any('resetar/{id}', 'ConfiguracoesCtrl@ResetarUsuarios')->name('resetar.usuarios.administrativo')->middleware('auth');
			});
		});	
		// Emails
		Route::group(['prefix' => 'emails'], function(){
			// Ajustes
			Route::group(['prefix' => 'ajustes'], function(){
				Route::get('', 'ConfiguracoesCtrl@ExibirAjustesEmails')->name('exibir.ajustes.emails');
				Route::post('salvar', 'ConfiguracoesCtrl@SalvarAjustesEmails')->name('salvar.ajustes.emails');
			});
			// Disparar
			Route::group(['prefix' => 'disparar'], function(){
				Route::get('', 'ConfiguracoesCtrl@ExibirDisparoEmails')->name('exibir.disparo.emails');
				Route::post('enviar', 'ConfiguracoesCtrl@EnviarDisparoEmails')->name('enviar.disparo.emails');
			});
			// Menssagens
			Route::group(['prefix' => 'mensagens'], function(){
				Route::get('', 'ConfiguracoesCtrl@ExibirMensagensEmails')->name('exibir.mensagens.emails');
				Route::post('salvar', 'ConfiguracoesCtrl@SalvarMensagensEmails')->name('salvar.mensagens.emails');
			});
		});
		// Importações
		Route::group(['prefix' => 'importacoes'], function(){
			// Importar
			Route::group(['prefix' => 'upload'], function(){
				Route::get('', 'ImportacoesCtrl@ExibirImportar')->name('exibir.importacoes');
				Route::any('manual', 'ImportacoesCtrl@ImportarManual')->name('importManual.importacoes');
				Route::any('automatico', 'ImportacoesCtrl@ImportarAutomatica')->name('importAuto.importacoes');
				Route::any('download', 'ImportacoesCtrl@DonwloadRelatorios')->name('download.importacoes');
			});
			// Data base
			Route::group(['prefix' => 'data'], function(){
				Route::get('', 'ImportacoesCtrl@ExibirData')->name('exibir.data.importacoes');
			});
			// Logs
			Route::group(['prefix' => 'logs'], function(){
				Route::get('', 'ImportacoesCtrl@ExibirLogs')->name('exibir.logs.importacoes');
			});
		});
		// Atividades
		Route::group(['prefix' => 'atividades'], function(){
			Route::get('', 'ConfiguracoesCtrl@ExibirAtividades')->name('exibir.atividades');
		});
		// Plataforma
		Route::group(['prefix' => 'plataforma'], function(){
			Route::get('', 'ConfiguracoesCtrl@ExibirPlataforma')->name('exibir.plataforma');
			Route::post('salvar', 'ConfiguracoesCtrl@SalvarPlataforma')->name('salvar.plataforma');
		});
	});
});