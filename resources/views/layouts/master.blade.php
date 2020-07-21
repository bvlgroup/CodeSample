<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.partials.header')
<body class="hold-transition layout-top-nav layout-navbar-fixed layout-fixed">
<div class="wrapper card">
    <div class="background overlay dark">
        <div class="fas fa-2x fa-spinner fa-spin"></div>
    </div>
    <!-- Navbar -->
    @include('layouts.partials.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
{{--    @include('layouts.partials.sidebar')--}}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('layouts.partials.contentheader')
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @include ('admin.includes.notification')
                @yield('main-content')

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Control Sidebar -->
    @include('layouts.partials.sidebarcontrol')
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('layouts.partials.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('layouts.partials.scripts')
@yield('scripts')

</body>
</html>
