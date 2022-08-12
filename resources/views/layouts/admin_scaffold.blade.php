<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
   <!-- BEGIN: Head-->
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
      <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
      <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
      <meta name="author" content="PIXINVENT">
      <title>@yield('title') @ QED Group</title>
      <link rel="apple-touch-icon" href="">
      <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets/images/logo/favicon.png')}}">
      @include('admin-portal.partials.admin.styles')
      <!-- BEGIN: Page CSS-->
      @stack('styles')
      <!-- END: Page CSS-->
   </head>
   <!-- END: Head-->
   <!-- BEGIN: Body-->
   <body class="pace-done vertical-layout navbar-floating footer-static vertical-menu-modern menu-expanded" data-open="click" data-menu="vertical-menu-modern" data-col="">
      @include('admin-portal.partials.admin.header')
      @include('admin-portal.partials.admin.sidebar')
      <!-- BEGIN: Content-->
      <div class="app-content content ">
         <div class="content-overlay"></div>
         <div class="header-navbar-shadow"></div>
         <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                  <div class="row breadcrumbs-top">
                    <div class="col-12">
                      <h2 class="content-header-title float-start mb-0">@yield('title')</h2>
                      <div class="breadcrumb-wrapper">
                        @if(@isset($breadcrumbs))
                            <ol class="breadcrumb">
                                {{-- this will load breadcrumbs dynamically from controller --}}
                                @foreach ($breadcrumbs as $breadcrumb)
                                <li class="breadcrumb-item">
                                    @if(isset($breadcrumb['link']))
                                    <a href="{{ $breadcrumb['link'] }}">
                                        @endif
                                        {{$breadcrumb['name']}}
                                        @if(isset($breadcrumb['link']))
                                    </a>
                                    @endif
                                </li>
                                @endforeach
                            </ol>
                        @endisset
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            <div class="content-body">
               <!-- Dashboard Ecommerce Starts -->
               <section id="dashboard-ecommerce">
                   @include('admin-portal.partials.admin.errors')
                   @yield('content')
               </section>
               <!-- Dashboard Ecommerce ends -->
            </div>
         </div>
      </div>
      <!-- END: Content-->
      @include('admin-portal.partials.admin.setting')
      <!-- Buynow Button-->
      </div>
      <div class="sidenav-overlay"></div>
      <div class="drag-target"></div>
      <!-- BEGIN: Footer-->
      <footer class="footer footer-static footer-light">
         <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT  &copy; 2021<a class="ms-25" href="../../../../../user/pixinvent/portfolio.html" target="_blank">Pixinvent</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span><span class="float-md-end d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span></p>
      </footer>
      <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
      <!-- END: Footer-->
      @include('admin-portal.partials.admin.scripts')
      <!-- BEGIN: Page JS-->
      @stack('scripts')
      <!-- END: Page JS-->
      <script>
         $(window).on('load',  function(){
           if (feather) {
             feather.replace({ width: 14, height: 14 });
           }
         })



          @if (Session::has('success'))
             $.notify('{{Session::get("success")}}','success');
          @endif
          @if (Session::has('error'))
            $.notify('{{Session::get("error")}}','error');
          @endif
          @if (Session::has('warning'))
            $.notify('{{Session::get("warning")}}','warning');
          @endif

      </script>
   </body>
   <!-- END: Body-->
</html>
