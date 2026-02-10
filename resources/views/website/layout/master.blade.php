<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFC</title>
    <link rel="stylesheet" href="{{ asset('website/scss/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/primeicons@6.0.1/primeicons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</head>
<body>
<div
    id="loader"
    class="fixed inset-0 z-50 flex items-center justify-center bg-[#123057] transition-opacity duration-700 ease-out"
>
    <div class="relative w-24 h-24">
        <div class="absolute inset-0 rounded-full border-4 border-white/30"></div>
        <div class="absolute! inset-0! rounded-full! border-4! border-[#1BB2B1]! border-t-transparent! animate-spin!"></div>
        <div class="absolute inset-6 rounded-full bg-white"></div>
    </div>
</div>
<div class="flex items-center text-white font-bold justify-center p-4 gap-10 w-full bg-[#03315A]">
    <p class="[direction:ltr]"><i class="pi pi-phone text-white mx-2 text-[18px]"></i> +2 01022335566  </p>
    <p class="[direction:ltr]"><i class="pi pi-envelope text-white mx-2 text-[18px]"></i> info@pulse-plus.com </p>
</div>
<!-- nav -->
<nav class="hidden lg:flex py-4 px-20 bg-white/90 shadow-md flex justify-between items-center">
    <div class="flex items-center gap-4"  >
        <a href="index.html" class="text-2xl font-bold text-gray-800"><img src="img/logo.png" class="w-[120px]" alt=""></a>
        <div>
            <a href="index.html" class="mx-4 text-teal-500!  transition duration-150  font-semibold before:w-full before:h-0.5 before:bg-teal-500 before:absolute before:-bottom-2 before:left-0 relative">الرئيسية</a>
            <a href="#products" class="relative  transition duration-150 font-semibold mx-4 hover:text-teal-500 "> المتجر</a>
            <a href="#features" class="hover:text-teal-500! transition duration-150  font-semibold mx-4">خدماتنا</a>
            <a href="#features" class="hover:text-teal-500! transition duration-150  font-semibold mx-4 ">من نحن</a>
            <a href="contact-us.html" class="hover:text-teal-500! transition duration-150  font-semibold mx-4 ">اتصل بنا</a>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <button  class="flex! items-center! justify-center! w-[50px]! h-[50px]! text-[18px]! rounded-full! shadow-xl!"><i class="pi pi-moon"></i></button>
        <button  class="flex! items-center! justify-center! w-[50px]! h-[50px]! text-[18px]! rounded-full! shadow-xl!">
            EN
        </button>
        <a href="login.html" class="bg-teal-500! text-white! px-5! py-2! rounded-[30px]! shadow-lg! font-semibold! hover:bg-teal-600! transition duration-150!">
            تسجيل الدخول
        </a>
    </div>

</nav>
<nav class=" lg:hidden block w-full bg-white shadow-md px-6 py-4 flex items-center justify-between relative">

    <div>
        <a href="/index.html">
            <div class=""><img src="img/logo.png" class="w-[100px]" alt=""></div>
        </a>
    </div>
    <div class="flex items-center justify-center gap-4">
        <a href="profile.html" class="w-9! h-9! rounded-full! flex! items-center! justify-center! bg-[#1BB2B1]! cursor-pointer! text-white! shadow-xl!"><i class="pi pi-user"></i></a>
        <button class="w-9! h-9! rounded-full! flex! items-center! justify-center! bg-[#FF6760]! cursor-pointer! text-white! shadow-xl!" id="menu-btn"><i class="pi pi-bars"></i></button>
    </div>


    <div id="burgerMenu" class="absolute hidden   flex-col z-50 p-6 bg-white/80 top-[100%] left-0  backdrop-blur-md  shadow-lg">
        <div>
            <button class="bg-[#123057]! rounded-4xl! py-3! px-7! text-white! cursor-pointer! font-semibold!">EN</button>
            <button class="bg-[#123057]! rounded-4xl! py-3! px-7! text-white! cursor-pointer! font-semibold!"><i class="pi pi-moon"></i></button>
        </div>
        <div>
            <ul class="p-2 flex flex-col gap-2 text-right ">
                <li>
                    <a href="index.html" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">
                        الرئيسية
                    </a>
                </li>
                <li>
                    <a href="#products" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">
                        المتجر
                    </a>
                </li>
                <li>
                    <a href="#features" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">
                        خدماتنا
                    </a>
                </li>
                <li>
                    <a href="#features" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">
                        من نحن
                    </a>
                </li>
                <li>
                    <a href="contact-us.html" class="block py-2 px-3 rounded hover:bg-[#123057] hover:text-white transition-all">
                        اتصل بنا
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- header -->
<section>
    <section class="w-full h-[70vh]">
        <div class="swiper mySwiper w-full h-full">
            <div class="swiper-wrapper">

                <div class="swiper-slide relative">
                    <img
                        src="img/slide.png"
                        class="w-full h-full object-cover"
                        alt="Slide 1"
                    />

                    <div class="absolute inset-0 flex items-end justify-start [direction:ltr]">
                        <div class="hidden lg:block px-20 pb-20 max-w-xl">
                            <h2 class="text-5xl font-extrabold text-black mb-4">
                                NFC WRISTBAND
                            </h2>
                            <p class="text-gray-600 text-lg mb-6">
                                Your digital business card, on your wrist with the latest NFC technology
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide relative">
                    <img
                        src="img/slide.png"
                        class="w-full h-full object-cover"
                        alt="Slide 1"
                    />

                    <div class="absolute inset-0 flex items-end justify-start [direction:ltr]">
                        <div class="hidden lg:block px-20 pb-20 max-w-xl">
                            <h2 class="text-5xl font-extrabold text-black mb-4">
                                NFC WRISTBAND
                            </h2>
                            <p class="text-gray-600 text-lg mb-6">
                                Your digital business card, on your wrist with the latest NFC technology
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide relative">
                    <img
                        src="img/slide.png"
                        class="w-full h-full object-cover"
                        alt="Slide 1"
                    />

                    <div class="absolute inset-0 flex items-end justify-start [direction:ltr]">
                        <div class="hidden lg:block px-20 pb-20 max-w-xl">
                            <h2 class="text-5xl font-extrabold text-black mb-4">
                                NFC WRISTBAND
                            </h2>
                            <p class="text-gray-600 text-lg mb-6">
                                Your digital business card, on your wrist with the latest NFC technology
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
</section>
<!-- features -->
<section id="features" class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800">لماذا تختار Pulse+ ؟</h2>
    </div>

    <div class="max-w-6xl mx-auto grid lg:grid-cols-3 grid-cols-1 gap-8 px-4">
        <div class="bg-white text-center p-6 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
            <div class="flex items-center justify-center ">
                <img src="img/vector-1.png" class="w-[60px] m-4" alt="">
            </div>
            <h3 class="text-xl px-10 font-bold text- mb-2">أمان وخصوصية</h3>
            <p class="text-gray-600 text-[14px] font-semibold px-10">تحكم كامل في المعلومات التي تظهر للعموم والمعلومات المخصصة للطوارئ</p>
        </div>

        <div class="bg-white text-center p-6 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
            <div class="flex items-center justify-center ">
                <img src="img/vector-2.png" class="w-[60px] m-4" alt="">
            </div>
            <h3 class="text-lg px-10 font-bold mb-2">دعم مرضى الزهايمر ومتلازمة داون</h3>
            <p class="text-gray-600 text-[14px] font-semibold px-10">سهولة الوصول لأرقام الطوارئ في حال تاه الشخص أو التعرض لحادث</p>
        </div>


        <div class="bg-white text-center p-6 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
            <div class="flex items-center justify-center ">
                <img src="img/vector-3.png" class="w-[60px] m-4" alt="">
            </div>
            <h3 class="text-lg px-10 font-bold mb-2">تقنية NFC و QR</h3>
            <p class="text-gray-600 text-[14px] font-semibold px-10">وصول فوري للملف الطبي من خلال لمس السوار بالهاتف أو مسح الرمز</p>
        </div>
    </div>
</section>
<!-- products -->
<section id="products" class="py-16">
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800">اختر الأمان الذي يناسبك</h2>
    </div>
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 px-4">
        <div class="p-10">
            <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                <img src="img/product-2.png" class="w-[240px]" alt="">
            </div>
            <div class="p-2 text-center">
                <h3 class="text-xl font-bold mt-4!">
                    السوار الطبي
                </h3>
                <button class="flex items-center  text-teal-500! font-semibold! mt-4! ">
                    اطلب الان <i class="pi pi-arrow-circle-left mt-2"></i>
                </button>
            </div>
        </div>
        <div class="p-10">
            <div class="bg-gray-50 flex items-center justify-center h-[320px] p-10 rounded-3xl shadow-xl transform transition duration-500 hover:scale-105 hover:shadow-2xl cursor-pointer relative overflow-hidden">
                <img src="img/product-1.png" class="w-[240px]" alt="">
            </div>
            <div class="p-2 text-center">
                <h3 class="text-xl font-bold mt-4!">
                    السلسلة الذكية
                </h3>
                <button class="flex items-center  text-teal-500! font-semibold! mt-4! ">
                    اطلب الان <i class="pi pi-arrow-circle-left mt-2"></i>
                </button>
            </div>
        </div>
    </div>
</section>
<!-- footer -->
<footer class="bg-[#03315A] text-white">
    <div class="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row justify-between gap-8">

        <div class="md:w-1/3 flex justify-center md:justify-start text-center md:text-right">
            <div class="w-full md:w-auto">
                <div class="flex justify-center md:justify-start items-center gap-3 mb-3">
                    <img src="img/footer-logo.png" class="w-[150px] md:w-[200px]" alt="">
                </div>
                <p class="text-sm">
                    نحن نؤمن أن التكنولوجيا يجب أن تخدم الإنسانية، خصوصاً في لحظات الضغف والقوة
                </p>
            </div>
        </div>

        <div class="md:w-1/3 flex justify-center">
            <div>
                <h3 class="font-semibold mb-2 text-center md:text-left">روابط سريعة</h3>
                <ul class="space-y-1 text-sm text-center md:text-left">
                    <li><a href="#" class="hover:text-teal-400 transition-colors">خدماتنا</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">المتجر</a></li>
                    <li><a href="#" class="hover:text-teal-400 transition-colors">من نحن</a></li>
                </ul>
            </div>
        </div>

        <div class="md:w-1/3 flex justify-center md:justify-end text-center md:text-right">
            <div>
                <h3 class="font-semibold mb-2">تواصل معنا</h3>
                <p class="text-sm">info@pulse-plus.com</p>
                <p class="text-sm">+2 01022335566</p>
            </div>
        </div>

    </div>

    <div class="border-t border-white/20 mt-6 py-4 text-center text-xs text-white/70">
        © 2024 Pulse+ جميع الحقوق محفوظة
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('website/js/main.js') }}"></script>
</body>
</html>
