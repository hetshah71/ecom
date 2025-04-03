<!-- Basic -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<!-- Site Metas -->
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="author" content="" />
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">

<title>
    Giftos
</title>

<!-- Critical CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.css')}}" />
<link href="{{asset('css/style.css')}}" rel="stylesheet" />

<!-- Deferred CSS -->
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
<link rel="preload" href="{{asset('css/responsive.css')}}" as="style" onload="this.onload=null;this.rel='stylesheet'" />

@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Async JavaScript -->
<script src="{{asset('js/jquery-3.4.1.min.js')}}" defer></script>
<script src="{{asset('js/bootstrap.js')}}" defer></script>
<script src="{{asset('js/custom.js')}}" defer></script>

<!-- Fallback for CSS preload -->
<noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}">
</noscript>