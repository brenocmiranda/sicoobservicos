<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Plataforma de auxilio a processos internos a cooperativas">
  <meta name="author" content="BCM Developers">

  <!-- Icone -->
  <link rel="shortcut icon" href="{{ asset('public/img/favicon.png') }}?<?php echo rand();?>">

  <!-- Title &#8226 -->
  <title>@yield('title') &#183 {{ env('APP_NAME') }} </title>
  
  <link href="{{ asset('public/css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/jquery-asColorPicker-master/css/asColorPicker.css') }}" rel="stylesheet">
  <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('public/css/animate.css') }}" rel="stylesheet">
  <link href="{{ asset('public/css/colors/default.css') }}" id="theme" rel="stylesheet">
  <link href="{{ asset('public/css/jquery-ui.css')  }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/morrisjs/morris.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/calendar/dist/fullcalendar.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('public/vendor/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('public/vendor/switchery/switchery.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('public/vendor/dropzone-master/dist/dropzone.css')  }}" rel="stylesheet" type="text/css">  
  <link href="{{ asset('public/vendor/Magnific-Popup-master/dist/magnific-popup.css')  }}" rel="stylesheet">
  <link href="{{ asset('public/vendor/owl.carousel/owl.carousel.min.css')  }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('public/vendor/owl.carousel/owl.theme.default.css')  }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('public/vendor/summernote/dist/summernote.css')  }}" rel="stylesheet">
  

  @yield('header-support')
</head>

<body class="fix-header">
