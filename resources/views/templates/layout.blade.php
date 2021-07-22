<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}n">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>INFOPoint in Cloud - @yield('title', 'HOME')</title>
    <link rel="icon" type="image/x-icon" href="/assets/img/favicon.ico"/>
    <link href="/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="/assets/js/loader.js"></script>
    

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset('assets/addchat/css/addchat.min.css') ?>" rel="stylesheet">
    
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @yield('page-style')
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>
<body class="dashboard-analytics">

    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->


     <!--  BEGIN NAVBAR  -->
     @component('components.menu')
     @endcomponent
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @component('components.sidebar')
        @endcomponent
        <!--  END SIDEBAR  -->
        
        <!--  BEGIN CONTENT AREA  -->
        @yield('content')
        <!-- 2. AddChat widget -->
        <div id="addchat_app" 
        data-baseurl="{{ url('') }}"
        data-csrfname="{{ 'X-CSRF-Token' }}"
        data-csrftoken="{{ csrf_token() }}"
        >
        </div>
        {{ $slot ?? '' }}
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="/bootstrap/js/popper.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="/assets/js/custom.js"></script>
    <!-- 3. AddChat JS -->
<!-- Modern browsers -->
<script type="module" src="<?php echo asset('assets/addchat/js/addchat.min.js') ?>"></script>
<!-- Fallback support for Older browsers -->
<script nomodule src="<?php echo asset('assets/addchat/js/addchat-legacy.min.js') ?>"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @yield('page-script')
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>
</html>