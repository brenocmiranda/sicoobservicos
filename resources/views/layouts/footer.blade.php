<script src="{{ asset('public/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('public/vendor/toast-master/js/jquery.toast.js')}}"></script>
<script src="{{ asset('public/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('public/vendor/waypoints/lib/jquery.waypoints.js')}}"></script>
<script src="{{ asset('public/vendor/counterup/jquery.counterup.min.js')}}"></script>
<script src="{{ asset('public/vendor/chartist-js/dist/chartist.min.js')}}"></script>
<script src="{{ asset('public/vendor/styleswitcher/jQuery.style.switcher.js')}}"></script>
<script src="{{ asset('public/vendor/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{ asset('public/vendor/sidebar-nav/dist/sidebar-nav.min.js')}}"></script>
<script src="{{ asset('public/js/custom.min.js')}}"></script>
<script src="{{ asset('public/js/style.js')}}"></script>
<script src="{{ asset('public/js/jasny-bootstrap.js')}}"></script>
<script src="{{ asset('public/js/jquery.slimscroll.js')}}"></script>
<script src="{{ asset('public/js/waves.js')}}"></script>
<script src="{{ asset('public/js/datatables.js') }}"></script>
<script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('public/js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('public/vendor/jquery-mask/dist/jquery.mask.js') }}"></script>
<script src="{{ asset('public/vendor/switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('public/vendor/styleswitcher/jQuery.style.switcher.js') }}"></script>
<script src="{{ asset('public/vendor/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('public/vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('public/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('public/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('public/vendor/multiselect/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('public/vendor/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
<script src="{{ asset('public/vendor/jquery-asColorPicker-master/libs/jquery-asColor.js') }}"></script>
<script src="{{ asset('public/vendor/jquery-asColorPicker-master/libs/jquery-asGradient.js') }}"></script>
<script src="{{ asset('public/vendor/jquery-asColorPicker-master/dist/jquery-asColorPicker.js') }}"></script>
<script src="{{ asset('public/vendor/dropzone-master/dist/dropzone.js') }}"></script>
<script src="{{ asset('public/vendor/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('public/vendor/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') }}"></script>
<script src="{{ asset('public/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('public/vendor/owl.carousel/owl.custom.js') }}"></script>
<script src="{{ asset('public/vendor/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('public/vendor/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('public/vendor/morrisjs/morris.js') }}"></script>
<script src="{{ asset('public/vendor/summernote/dist/summernote.min.js') }}"></script>
<script src="{{ asset('public/js/jquery-ui.js')}}"></script>
<script src="{{ asset('public/vendor/bootstrap-treeview-master/src/js/bootstrap-treeview.js') }}"></script>
<script src="{{ asset('public/vendor/blockUI/jquery.blockUI.js') }}"></script>
<script src="{{ asset('public/js/jquery.smartWizard.js') }}"></script>
<script src="{{ asset('public/js/fabric.js') }}"></script>
<script src="{{ asset('public/js/jcrop.js') }}"></script>
<script src="{{ asset('public/js/jspdf.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".colorpicker").asColorPicker();
		
	    (function() {
	        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
	            new CBPFWTabs(el);
	        });
	    })();

	    // Verificando status do usuário
	    @if(request()->segment(1) == 'app' && request()->segment(2) != 'login' && request()->segment(2) != 'password')
		    setInterval( function(){
		      $.ajax({
		        url: "{{route('check')}}",
		        type: 'GET',
		        success: function(data){
		        	if(data.success == true){
				        swal({
							title: "Seu usuário foi desconectado.",
							icon: "warning",
							button: "Ok",
							dangerMode: true,
						})
						.then((willDelete) => {
						    location.reload();
						});
		        	}
		        }, error: function(data){
		        	console.log(data);
		        }
		      });
		    }, 30000);
	    @endif

		// Função para logout do usuário
		$('.logout').on('click', function() {
			swal({
				title: "Tem certeza que deseja sair da plataforma?",
				icon: "warning",
				buttons: ["Cancelar", "Sair"],
				dangerMode: true,
			})
			.then((willDelete) => {
			    if (willDelete) {
			        window.document.location = "{{ route('logout') }}";
			    } else {
			        swal.close();
			    }
			});
		});

		// Função para abrir modal sobre
		$('.sobre').on('click', function() {
			$('#modal-sobre').modal('show');
		});

		// Remover enter para fechamento de modal
		$('input').keypress( function(e) {
			var code = null;
			code = (e.keyCode ? e.keyCode : e.which);                
			return (code == 13) ? false : true;
		});

		// Switchery
		var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
		$('.js-switch').each(function() {
			new Switchery($(this)[0], $(this).data());
		});

		$('.password, .confirmpassword').on('keyup', function(){
	     	$('#err').html('');
	      	// Se confere com a confirmação
	      	if($('.password').val() == $('.confirmpassword').val()){
	        	// Se possui no mínimo 6 caracteres
	        	if($('.confirmpassword').val().length >= 8){
	        		// Se possui números
	        		if($('.confirmpassword').val().match(/\d+/)){
	        			// Se possui caracteres especiais
	        			if($('.confirmpassword').val().match(/[^a-zA-Z0-9]+/)){
	        				$('#submit').removeAttr('disabled');
	          				$('#submit').addClass('btn-success');
	        			}else{
	        				$('#err').html('<div class="text-danger text-center col">Sua senha deve conter carácteres especiais.</div>');
	        			}
	        		}else{
	        			$('#err').html('<div class="text-danger text-center col">Sua senha deve conter números.</div>');
	        		}
	        	}else{
	          		$('#err').html('<div class="text-danger text-center col"> São necessários no mínimo 8 carácteres.</div>');
	        	}
	      	}else{
		        $('#err').html('<div class="text-danger text-center col">As senhas não conferem.</div>')
		        $('#submit').attr('disabled', 'disabled');
		        $('#submit').removeClass('btn-success');
	      	}
	    });
	});
</script>

@yield('suporte')
</body>
</html>