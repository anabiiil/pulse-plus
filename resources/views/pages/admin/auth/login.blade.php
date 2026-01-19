<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Login </title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- Favicon -->
    <link rel="icon" href="{{asset('/')}}assets/images/brand-logos/favicon.ico" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{asset('/')}}assets/js/authentication-main.js"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{asset('/')}}assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >

    <!-- Style Css -->
    <link href="{{asset('/')}}assets/css/styles.min.css" rel="stylesheet" >

    <!-- Icons Css -->
    <link href="{{asset('/')}}assets/css/icons.min.css" rel="stylesheet" >


    <link rel="stylesheet" href="{{asset('/')}}assets/libs/swiper/swiper-bundle.min.css">
    @livewireStyles
</head>

<body class="bg-white">



<div class="row authentication mx-0">

    <div class="col-xxl-7 col-xl-7 col-lg-12">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-xxl-6 col-xl-7 col-lg-7 col-md-7 col-sm-8 col-12">
                <div class="p-5">
                    <div class="mb-3">
                        <a href="{{route('admin.login')}}">
                            <img src="{{asset('/')}}assets/images/brand-logos/desktop-logo.png" alt="" class="authentication-brand desktop-logo">
                            <img src="{{asset('/')}}assets/images/brand-logos/desktop-dark.png" alt="" class="authentication-brand desktop-dark">
                        </a>
                    </div>
                    <p class="h5 fw-semibold mb-2">Sign In</p>
                    <p class="mb-3 text-muted op-7 fw-normal">Welcome back Admin !</p>

                    <div class="text-center my-5 authentication-barrier">

                    </div>

                  <livewire:admin.auth.login/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-5 col-xl-5 col-lg-5 d-xl-block d-none px-0">
        <div class="authentication-cover">
            <div class="aunthentication-cover-content rounded">
                <div class="swiper keyboard-control">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                <div>
                                    <div class="mb-5">
                                        <img src="{{asset('/')}}assets/images/authentication/2.png" class="authentication-image" alt="">
                                    </div>
                                    <h6 class="fw-semibold">Sign In</h6>
                                    <p class="fw-normal fs-14 op-7"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa eligendi expedita aliquam quaerat nulla voluptas facilis. Porro rem voluptates possimus, ad, autem quae culpa architecto, quam labore blanditiis at ratione.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                <div>
                                    <div class="mb-5">
                                        <img src="{{asset('/')}}assets/images/authentication/3.png" class="authentication-image" alt="">
                                    </div>
                                    <h6 class="fw-semibold">Sign In</h6>
                                    <p class="fw-normal fs-14 op-7"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa eligendi expedita aliquam quaerat nulla voluptas facilis. Porro rem voluptates possimus, ad, autem quae culpa architecto, quam labore blanditiis at ratione.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="text-fixed-white text-center p-5 d-flex align-items-center justify-content-center">
                                <div>
                                    <div class="mb-5">
                                        <img src="{{asset('/')}}assets/images/authentication/2.png" class="authentication-image" alt="">
                                    </div>
                                    <h6 class="fw-semibold">Sign In</h6>
                                    <p class="fw-normal fs-14 op-7"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa eligendi expedita aliquam quaerat nulla voluptas facilis. Porro rem voluptates possimus, ad, autem quae culpa architecto, quam labore blanditiis at ratione.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Custom-Switcher JS -->
<script src="{{asset('/')}}assets/js/custom-switcher.min.js"></script>

<!-- Bootstrap JS -->
<script src="{{asset('/')}}assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Swiper JS -->
<script src="{{asset('/')}}assets/libs/swiper/swiper-bundle.min.js"></script>

<!-- Internal Sing-Up JS -->
<script src="{{asset('/')}}assets/js/authentication.js"></script>

<!-- Show Password JS -->
<script src="{{asset('/')}}assets/js/show-password.js"></script>
@livewireScripts
</body>

</html>
