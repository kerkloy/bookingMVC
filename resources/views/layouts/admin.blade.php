<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Fonts and icons -->
    <script src="../admin/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["../admin/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../admin/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../admin/css/plugins.min.css" />
    <link rel="stylesheet" href="../admin/css/kaiadmin.min.css" />
    
    
</head>
<body>
    <div class="app">
        <div class="wrapper">
            <!-- Sidebar -->
            @include('layouts.admin-side')
            <!-- End Sidebar -->
                <div class="main-panel">
                    @include('layouts.admin-nav')
                    @yield('content')
                </div>
            
            @yield('scripts')
        </div>
    </div>

    
    

    <!--   Core JS Files   -->
    <script src="../admin/js/core/jquery-3.7.1.min.js"></script>
    <script src="../admin/js/core/popper.min.js"></script>
    <script src="../admin/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="../admin/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="../admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="../admin/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../admin/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="../admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- Sweet Alert -->
    <script src="../admin/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="../admin/js/kaiadmin.min.js"></script>

    <!-- Navbar JS -->
     <script src="../admin/js/navbar.js"></script>
</body>
</html>
