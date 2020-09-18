<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<!-- Required meta tags -->
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	  <title>{{ env('APP_NAME') }} | Imprimir disposição</title>
	  
	  <!-- endinject -->
	  <link rel="shortcut icon" href="{{ asset('public/img/favicon.png') }}?<?php echo rand();?>">

	  <!-- plugins:css -->
	  <link rel="stylesheet" href="{{ asset('public/css/jquery-ui.css')}}?<?php echo rand();?>">
	  <link rel="stylesheet" href="{{ asset('public/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}?<?php echo rand();?>">
	  <link rel="stylesheet" href="{{ asset('public/vendors/css/vendor.bundle.base.css') }}?<?php echo rand();?>">
	  <link rel="stylesheet" href="{{ asset('public/vendors/css/vendor.bundle.addons.css') }}?<?php echo rand();?>">
	  <link rel="stylesheet" href="{{ asset('public/css/bootstrap.css')}}?<?php echo rand();?>">
	  <link rel="stylesheet" href="{{ asset('public/css/datatables.css')}}?<?php echo rand();?>">
	  <link rel="stylesheet" href="{{ asset('public/css/materialize.css')}}?<?php echo rand();?>">
	  <link rel="stylesheet" href="{{ asset('public/css/style.css')}}?<?php echo rand();?>">
	  <style type="text/css" media="print">
	    @page { 
	        size: landscape;
	        margin:0;
	    }
	    body {
			margin:0;
			padding:0;
			line-height: 1.4em;
		}
		</style>
</head>

<body>
	<div class="content-wrapper bg-white vh-100 px-5 py-3">
		<div class="card shadow-none">
			<div class="card-header bg-white">
				<h3>Disposição dos armários</h3>
				<h6>Listagem com todos os armários cadastrados na plataforma.</h6>
			</div>
			<div class="card-body bg-white">
				<div class="mx-2 d-flex justify-content-left" id="disposicao">
					<?php $i=0;?>

					@for($j=0; $j < count($armarios); $j=$j+4)
					<div class="col-3 p-3 bg-secondary" style="border: 8px solid white; border-radius: 20px; font-size: 13px">
						@while($i < count($armarios))
							<a href="javascript:void(0)" class="text-dark border-bottom text-decoration-none">
								<div class="p-2 text-center bg-white rounded mb-2">
									<b>{{$armarios[$i]->referencia}}</b>
									<br>
									{{$armarios[$i]->nome}}
								</div>
							</a>
							@if($i % 3 === 0 && $i != 0)
								<?php $i++; ?>
								@break
							@else
								<?php $i++; ?>
							@endif	
						@endwhile
					</div>
					@endfor

				</div>
			</div>
		</div>
	</div>
</body>

<script type="text/javascript">
	window.print();
</script>
</html>