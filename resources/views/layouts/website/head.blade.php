<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('websiteAsset/img/favicon.svg') }}" type="image/x-icon">
    <title>Moshtreatk | @yield('head_title')</title>
    <meta name="title" content="">
    <meta name="description" content="">

    <!-- Sites meta Data -->
    <meta name="application-name" content="Forex" />
    <meta name="author" content="thetork" />
    <meta name="keywords" content="EForex" />
    <meta name="description" content="Forex." />

    <!-- OG meta data -->
    <meta property="og:title" content="Forex" />
    <meta property="og:site_name" content="Forex" />
    <meta property="og:url" content="" />
    <meta property="og:description" content="Forex" />
    <meta property="og:type" content="Forex" />
    <meta property="og:image" content="{{asset('assets/images/og.png')}}" />
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="">
    <meta property="twitter:title" content="">
    <meta property="twitter:description" content="">
    <meta property="twitter:image" content="">
    <link rel="stylesheet" href="{{ asset('websiteAsset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('websiteAsset/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('websiteAsset/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('websiteAsset/css/intlTelInput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('websiteAsset/css/toastr.min.css?v=1.36.2') }}">
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    @livewireStyles

    <link
      rel="preload"
      href="{{asset('assets/css/fonts/dm.css')}}"
      as="style"
      onload="this.rel='stylesheet'"
    />
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />
    @if(app()->getLocale() == 'en')
    <link rel="stylesheet" href="{{asset('assets/css/ar.css')}}" />
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
    href="https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@200..1000&family=Inter:wght@200;300;400;500;600;700;800;900&family=Manrope:wght@300;400;500;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
    rel="stylesheet"
    />
</head>
