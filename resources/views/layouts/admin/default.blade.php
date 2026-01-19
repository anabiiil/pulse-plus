<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
      data-menu-styles="dark" data-toggled="close">


    @include('includes.admin.head')
{{--    <style>--}}
{{--        .table-responsive div {--}}
{{--            display: block !important;--}}
{{--        }--}}
{{--    </style>--}}

<body>

<!-- Start Switcher -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
    @include('includes.admin.switcher')

</div>
<!-- End Switcher -->

<div class="page">
    <!-- app-header -->
    <header class="app-header">

        @include('includes.admin.header')

    </header>
    <!-- /app-header -->
    <!-- Start::app-sidebar -->
    <aside class="app-sidebar sticky" id="sidebar">

        @include('includes.admin.sidebar')

    </aside>
    <!-- End::app-sidebar -->

    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">@yield('title')</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Page Header Close -->

            <!-- Start::row-1 -->
            <div class="row" id='app'>
                @yield('content')
            </div>
            <!--End::row-1 -->

        </div>
    </div>
    <!-- End::app-content -->


    <!-- Footer Start -->
    <footer class="footer mt-auto py-3 bg-white text-center">
        @include('includes.admin.footer')
    </footer>
    <!-- Footer End -->

</div>


<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
</div>
<div id="responsive-overlay"></div>

@include('includes.admin.script')

</body>

</html>
