<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lemongrass Restaurant')</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <style>
        html, body {
            scrollbar-width: none;          /* Firefox */
            -ms-overflow-style: none;       /* IE and Edge */
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none;                  /* Chrome, Safari, Opera */
        }      
        .header_section {
            position: sticky !important;
            top: 0;
            width: 100%;
            z-index: 9999; 
            background: rgba(0, 0, 0, 0.9);
            /* خفيف شفاف */
            backdrop-filter: blur(20px);
          
            
        }

        /* شكل مودال Pick Up / Delivery */
        #orderTypeModal .modal-content {
            background: #f8f9fa;
            /* Light Gray */
            border-radius: 15px;
        }

        /* شكل مودال Details */
        .details-modal .modal-content {
            border-radius: 15px;
            background: #f8f9fa;
            animation: pulseOpen 0.4s ease;
        }

        /* Animation عند الفتح */
        @keyframes pulseOpen {
            0% {
                transform: scale(0.95);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        }

        /* لتخفيف Animation داخل Bootstrap Modal */
        .modal.fade .modal-dialog {
            transition: none !important;
        }
    </style>

    <!-- Fonts and Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Open+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>

    <main>
        @yield('content')
    </main>


    <!-- JS Files -->
    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>

    <!-- Popper -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.js') }}"></script>

    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Nice Select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>

    <!-- Isotope JS -->
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>

    <!-- Main Custom Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @yield('scripts')

    
</body>

</html>
