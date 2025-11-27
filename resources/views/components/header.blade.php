<!DOCTYPE html>
<html
  lang="{{ config('app.locale') }}" dir="{{ config('app.locale') == 'ar' ? 'rtl' : 'ltr' }}"
  class="layout-wide customizer-hide"
  data-assets-path="{{ asset('assets') }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
     <title>{{ $title ?? '' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />  
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    @if(request()->routeIs('login') || request()->routeIs('forgot_password.page'))
      <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
      <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}" />
    @endif
    <script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('assets/js/config.js')}}"></script>
    <style>* {font-family: 'cairo'; !important} </style>
    @yield('charts-css')
  </head>
  <body>