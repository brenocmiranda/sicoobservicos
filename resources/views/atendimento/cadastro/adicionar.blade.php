@section('title')
Novo associado
@endsection

@extends('layouts.index')

@section('content')
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<h4 class="page-title">Novo associado</h4> 
		</div>
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<ol class="breadcrumb">
				<li><a href="javascript:void(0)">Atendimento</a></li>
				<li><a href="{{route('exibir.cadastro.atendimento')}}">Associados</a></li>
				<li class="active">Novo associado</li>
			</ol>
		</div>
	</div>
	<div class="confim"></div>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-12 text-center mb-5">
					<p class="text-muted mb-4 ont-13"> Selecione qual o tipo de associado:</p>
					<div class="btn-group btn-group-justified select-mode mx-auto col-6">
						<div class="btn-group">
							<button class="btn btn-default btn-outline" id="PF" type="button">
								<i class="icon-user"></i>
								<br>
								<span>Pessoa física</span>
							</button>
						</div>
						<div class="btn-group">
							<button class="btn btn-default btn-outline" id="PJ" type="button">
								<i class="icon-people"></i>
								<br>
								<span>Pessoa Jurídica</span>
							</button>
						</div>
					</div>
				</div>

				<div class="row col-12 mx-auto">
					@include('atendimento.cadastro.fisica')
					@include('atendimento.cadastro.juridica')
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('suporte')
<script type="text/javascript">
	function remover(input){
		$(input).parent('div').parent('div').remove();
	}

	$(document).ready(function() {
		// Mascaras 
		$('#formPF #cpf').mask('000.000.000-00', {reverse: true});
		$('#formPJ #cnpj').mask('00.000.000/0000-00', {reverse: true});
		$('.numeroTelefone').mask('(00) 0000-0000');

		$("#smartwizardPF").on("showStep", function(e, anchorObject, stepIndex, stepDirection) {
			if(stepIndex == 3){
				$('.toolbar .sw-btn-next').fadeOut();
				$('.toolbar .sw-btn-enviar').fadeIn();
			}else{
				$('.toolbar .sw-btn-next').fadeIn();
				$('.toolbar .sw-btn-enviar').fadeOut();
			}
		});

		$("#smartwizardPJ").on("showStep", function(e, anchorObject, stepIndex, stepDirection) {
			if(stepIndex == 4){
				$('.toolbar .sw-btn-next').fadeOut();
				$('.toolbar .sw-btn-enviar').fadeIn();
			}else{
				$('.toolbar .sw-btn-next').fadeIn();
				$('.toolbar .sw-btn-enviar').fadeOut();
			}
		});

		// Inicilizando formulário de pessoa física
		$('#PF').on('click', function(){
			// Smart Wizard
			$('#smartwizardPF').smartWizard({
				selected: 0,
				theme: 'dots',
				enableURLhash: false,
				transition: {
					animation: 'slide-horizontal',
				},
				anchorSettings : {  
					removeDoneStepOnNavigateBack : true , // Enquanto navegar para trás, a etapa realizada após a etapa ativa será apagada  
					enableAnchorOnDoneStep : false // Habilita / desabilita a navegação das etapas concluídas  
				},
				keyboardSettings: {
					keyNavigation: false
				},
			});
			$('#formPJ')[0].reset();
			$('.verificarDocumentoPJ').html('');
			$('#razaoSocial').val('');
			$('#fantasia').val('');
			$('.razaoSocial').html('-');
			$('.endereco').html('-');
			$('.atividade_principal').html('-');
			$('.porte').html('-');
			$('.situacao').html('-');
			$('.data_situacao').html('-');
			$('#smartwizardPJ').smartWizard("reset");
			$('#PJ').removeClass('btn-info').addClass('btn-outline btn-default');
			$(this).removeClass('btn-outline btn-default').addClass('btn-info');
			$('#dadosPJ').fadeOut();
			$('#dadosPF').fadeIn();
		});

		// Inicilizando formulário de pessoa jurídica
		$('#PJ').on('click', function(){
			// Smart Wizard
			$('#smartwizardPJ').smartWizard({
				selected: 0,
				theme: 'dots',
				enableURLhash: false,
				transition: {
					animation: 'slide-horizontal', 
				},
				toolbarSettings: {
					toolbarPosition: 'bottom',
					toolbarButtonPosition: 'center',
				}
			});
			$('#formPF')[0].reset();
			$('.verificarDocumentoPF').html('');
			$('#smartwizardPF').smartWizard("reset");
			$('#PF').removeClass('btn-info').addClass('btn-outline btn-default');
			$(this).removeClass('btn-outline btn-default').addClass('btn-info');
			$('#dadosPF').fadeOut();
			$('#dadosPJ').fadeIn();
		});

		$('.novoTelefone').on('click', function(){
			$('.dadosTelefone').append('<div class="col-12 px-0"> <div class="col-lg-4 col-12"> <div class="form-group"> <label class="col-form-label pb-0">Tipo <span class="text-danger">*</span></label> <select class="form-control form-control-line" name="tipoTelefone" required> <option>Celular</option> <option>Residencial</option> <option>Comercial</option> <option>Recado</option> <option>Fax</option> </select> </div> </div> <div class="col-lg-5 col-11"> <div class="form-group"> <label class="col-form-label pb-0">Número <span class="text-danger">*</span></label> <input class="form-control form-control-line numeroTelefone" name="numeroTelefone" placeholder="(38) 99168-0335" required/> </div> </div> <div class="row col-lg-1 col-1 h-100"> <a href="javascript:" title="Remover arquivos" onclick="remover(this)" class="m-auto"><i class="mdi mdi-delete text-danger mdi-24px"></i></a> </div> </div>'); 
		});

		// Verifica se o CPF é válido e se não já foi cadastrado
		$('.cpf').blur( function()
		{
			var cpf = $('.cpf').val().replace(/[^0-9]/g, '').toString();
			if( cpf.length == 11 )
			{
				var v = [];
	            //Calcula o primeiro dígito de verificação.
	            v[0] = 1 * cpf[0] + 2 * cpf[1] + 3 * cpf[2];
	            v[0] += 4 * cpf[3] + 5 * cpf[4] + 6 * cpf[5];
	            v[0] += 7 * cpf[6] + 8 * cpf[7] + 9 * cpf[8];
	            v[0] = v[0] % 11;
	            v[0] = v[0] % 10;
	            //Calcula o segundo dígito de verificação.
	            v[1] = 1 * cpf[1] + 2 * cpf[2] + 3 * cpf[3];
	            v[1] += 4 * cpf[4] + 5 * cpf[5] + 6 * cpf[6];
	            v[1] += 7 * cpf[7] + 8 * cpf[8] + 9 * v[0];
	            v[1] = v[1] % 11;
	            v[1] = v[1] % 10;
	            //Retorna Verdadeiro se os dígitos de verificação são os esperados.
	            if ( (v[0] != cpf[9]) || (v[1] != cpf[10]) )
	            {
	            	$('.verificarDocumentoPF').html('<span class="text-danger"><i class="mdi mdi-close mdi-24px"></i></span>');
	            	$('.cpf').focus();
	            }else{
	            	$.ajax({
			    		url: 'existe/'+cpf,
		        		type: 'GET',
			    		beforeSend: function(){
			    			$('.verificarDocumentoPF').html('<div class="spinner-border text-primary" role="status" style="height: 25px; width: 25px;"></div>');
			    		},
			    		success: function(data){
			    			if(data.status == true){
			    				$('.verificarDocumentoPF').html('<span class="text-danger">Associado já cadastrado!</span>');
			    			}else{
			    				$('.verificarDocumentoPF').html('<span class="text-success"><i class="mdi mdi-check mdi-24px"></i></span>');
			    			}	    			
			    		}, error: function (data) {
			    			$('.verificarDocumentoPJ').html('<span class="text-danger"><i class="mdi mdi-close mdi-24px"></i></span>');
			    		}
			    	});
	            }
	        }
	        else
	        {
	        	$('.verificarDocumentoPF').html('<span class="text-danger"><i class="mdi mdi-close mdi-24px"></i></span>');
	        	$('.cpf').focus();
	        }
	    });

	    //Executa a requisição quando o campo username perder o foco
	    $('.cnpj').blur( function(e){
	    	cnpj = $('.cnpj').val().replace(/[^0-9]/g, '').toString();
	    	$.ajax({
	    		url: 'https://www.receitaws.com.br/v1/cnpj/'+cnpj,
	    		dataType: 'jsonp',
        		type: 'GET',
	    		beforeSend: function(){
	    			$('.verificarDocumentoPJ').html('<div class="spinner-border text-primary" role="status" style="height: 25px; width: 25px;"></div>');
	    		},
	    		success: function(data){
	    			if(data.status == "ERROR"){
	    				$('#razaoSocial').val('');
	    				$('#fantasia').val('');
	    				$('.razaoSocial').html('-');
	    				$('.endereco').html('-');
	    				$('.atividade_principal').html('-');
	    				$('.porte').html('-');
	    				$('.situacao').html('-');
	    				$('.data_situacao').html('-');
	 					$('.verificarDocumentoPJ').html('<span class="text-danger">'+data.message+'</span>');
	    			}else{
	    				$.ajax({
				    		url: 'existe/'+cnpj,
			        		type: 'GET',
				    		beforeSend: function(){
				    			$('.verificarDocumentoPJ').html('<div class="spinner-border text-primary" role="status" style="height: 25px; width: 25px;"></div>');
				    		},
				    		success: function(data1){
				    			if(data1.status == true){
				    				$('.verificarDocumentoPJ').html('<span class="text-danger">Associado já cadastrado!</span>');
				    			}else{
				    				$('#razaoSocial').val(data.nome);
				    				$('.razaoSocial').html(data.nome);
				    				if(data.fantasia){
				    					$('#fantasia').val(data.fantasia);
				    				}
				    				$('.endereco').html((data.logradouro ? data.logradouro+', '+data.numero+', '+data.bairro+' - '+data.municipio+'/'+data.uf : 'Não informado'));
				    				$('.atividade_principal').html('('+data.atividade_principal[0].code+') '+data.atividade_principal[0].text);
				    				$('.porte').html(data.porte);
				    				$('.situacao').html(data.situacao + (data.motivo_situacao ? ' - '+data.motivo_situacao : ''));
				    				$('.data_situacao').html(data.data_situacao);
				    				$('.verificarDocumentoPJ').html('<span class="text-success"><i class="mdi mdi-check mdi-24px"></i></span>');
				    			}	    			
				    		}, error: function (data) {
				    			$('.verificarDocumentoPJ').html('<span class="text-danger"><i class="mdi mdi-close mdi-24px"></i></span>');
				    		}
				    	});   				
	    			}	    			
	    		}, error: function (data) {
	    			$('#razaoSocial').val('');
    				$('#fantasia').val('');
    				$('.razaoSocial').html('-');
    				$('.endereco').html('-');
    				$('.atividade_principal').html('-');
    				$('.porte').html('-');
    				$('.situacao').html('-');
    				$('.data_situacao').html('-');
	    			$('.verificarDocumentoPJ').html('<span class="text-danger"><i class="mdi mdi-close mdi-24px"></i></span>');
	    		}
	    	});
	    });
	});
</script>
@endsection