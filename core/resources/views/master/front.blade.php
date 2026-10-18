<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @if (url()->current() == route('front.index'))
    <title>@yield('hometitle')</title>
    @else
    <title>{{ $setting->title }} -@yield('title')</title>
    @endif

    <!-- SEO Meta Tags-->
    @if (url()->current() == route('front.index'))
    <meta name="author" content="GeniusDevs">
    <meta name="distribution" content="web">
    <meta name="description" content="{{ $setting->meta_description }}">
    <meta name="keywords" content="{{ $setting->meta_keywords }}">
    <meta name="image" content="{{ url($setting->meta_image) }}">
    <meta property="og:title" content="{{ $setting->title}}">
    <meta property="og:description" content="{{ $setting->meta_description }}">
    <meta property="og:image" content="{{ url($setting->meta_image) }}">
    <meta property="og:image:secure_url" content="{{ url($setting->meta_image) }}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="627" />
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $setting->title }}">
    <meta property="og:type" content="website">
    @else
    @yield('meta')
    @endif

    <!-- Mobile Specific Meta Tag-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Favicon Icons-->
    <link rel="icon" type="image/png" href="{{ url($setting->favicon) }}">
    <link rel="apple-touch-icon" href="{{ url($setting->favicon) }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url($setting->favicon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url($setting->favicon) }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ url($setting->favicon) }}">

    <!-- Vendor Styles including: Bootstrap, Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{ asset('assets/front/css/plugins.min.css') }}">

    @yield('styleplugins')

    <link id="mainStyles" rel="stylesheet" media="screen" href="{{ asset('assets/front/css/styles.min.css') }}">

    <link id="mainStyles" rel="stylesheet" media="screen" href="{{ asset('assets/front/css/responsive.css') }}">
    <!-- Color css -->
    <link
        href="{{ asset('assets/front/css/color.php?primary_color=') . str_replace('#', '', $setting->primary_color) }}"
        rel="stylesheet">

    <!-- Modernizr-->
    <script src="{{ asset('assets/front/js/modernizr.min.js') }}"></script>

    @if (DB::table('languages')->where('is_default', 1)->first()->rtl == 1)
    <link rel="stylesheet" href="{{ asset('assets/front/css/rtl.css') }}">
    @endif
    <style>
    {
            {
            $setting->custom_css
        }
    }
    </style>
    {{-- Google AdSense Start --}}
    @if ($setting->is_google_adsense == '1')
    {!! $setting->google_adsense !!}
    @endif
    {{-- Google AdSense End --}}

    {{-- Google AnalyTics Start --}}
    @if ($setting->is_google_analytics == '1')
    {!! $setting->google_analytics !!}
    @endif
    {{-- Google AnalyTics End --}}

    {{-- Facebook pixel  Start --}}
    @if ($setting->is_facebook_pixel == '1')
    {!! $setting->facebook_pixel !!}
    @endif
    {{-- Facebook pixel End --}}

</head>
<!-- Body-->

<body class="
@if ($setting->theme == 'theme1') body_theme1
@elseif($setting->theme == 'theme2')
body_theme2
@elseif($setting->theme == 'theme3')
body_theme3
@elseif($setting->theme == 'theme4')
body_theme4 @endif
">
    @if ($setting->is_loader == 1)
    <!-- Preloader Start -->
    @if ($setting->is_loader == 1)
    <div id="preloader">
        <img src="{{ url($setting->loader) }}" alt="{{ __('Loading...') }}">
    </div>
    @endif

    <!-- Preloader endif -->
    @endif

    <!-- Header-->

    <header class="site-header navbar-sticky">
        <div class="menu-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-6">
                        <div class="t-m-s-a">
                            <a class="track-order-link" href="{{ route('front.order.track') }}"><i
                                    class="icon-map-pin"></i>{{ __('Track Order') }}</a>
                            <!--<a class="track-order-link compare-mobile d-lg-none"-->
                            <!--    href="{{ route('fornt.compare.index') }}">{{ __('Compare') }}</a>-->
                        </div>
                    </div>
                    <div class="col-md-8 col-6">
                        <div class="right-area">

                            <!--<a class="track-order-link wishlist-mobile d-inline-block d-lg-none"-->
                            <!--    href="{{ route('user.wishlist.index') }}"><i-->
                            <!--        class="icon-heart"></i>{{ __('Wishlist') }}</a>-->

                            {{-- <div class="t-h-dropdown ">
                                <a class="main-link" href="#">{{ __('Language') }}<i class="icon-chevron-down"></i></a>
                            <div class="t-h-dropdown-menu">
                                @foreach (DB::table('languages')->whereType('Website')->get() as $language)
                                <a class="{{ Session::get('language') == $language->id ? 'active' : ($language->is_default == 1 && !Session::has('language') ? 'active' : '') }}"
                                    href="{{ route('front.language.setup', $language->id) }}"><i
                                        class="icon-chevron-right pr-2"></i>{{ $language->language }}</a>
                                @endforeach
                            </div>
                        </div> --}}


                        <!--<div class="t-h-dropdown ">-->
                        <!--    <a class="main-link" href="#">{{ __('Currency') }}<i-->
                        <!--            class="icon-chevron-down"></i></a>-->
                        <!--    <div class="t-h-dropdown-menu">-->
                        <!--        @foreach (DB::table('currencies')->get() as $currency)-->
                        <!--            <a class="{{ Session::get('currency') == $currency->id ? 'active' : ($currency->is_default == 1 && !Session::has('currency') ? 'active' : '') }}"-->
                        <!--                href="{{ route('front.currency.setup', $currency->id) }}"><i-->
                        <!--                    class="icon-chevron-right pr-2"></i>{{ $currency->name }}</a>-->
                        <!--        @endforeach-->
                        <!--    </div>-->
                        <!--</div>-->

                        <div class="login-register ">
                            @if (!Auth::user())
                            <a class="track-order-link mr-0" href="{{ route('user.login') }}">
                                {{ __('Login') }}
                            </a>
                            @else
                            <div class="t-h-dropdown">
                                <div class="main-link">
                                    <i class="icon-user pr-2"></i> <span
                                        class="text-label">{{ Auth::user()->first_name }}</span>
                                </div>
                                <div class="t-h-dropdown-menu">
                                    <a href="{{ route('user.dashboard') }}"><i
                                            class="icon-chevron-right pr-2"></i>{{ __('Dashboard') }}</a>
                                    <a href="{{ route('user.logout') }}"><i
                                            class="icon-chevron-right pr-2"></i>{{ __('Logout') }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Topbar-->
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between">
                            @if (Auth::user())
                            <!-- Logo-->
                            <div class="site-branding"><a class="site-logo align-self-center"
                                    href="{{ route('front.index') }}"><img
                                        src="{{ url($setting->logo) }}"
                                        alt="{{ $setting->title }}"></a></div>
                            <!-- Search / Categories-->

                            <div class="search-box-wrap d-none d-lg-block d-flex">
                                <div class="search-box-inner align-self-center">
                                    <div class="search-box d-flex">
                                        <select name="category" id="category_select" class="categoris">
                                            <option value="">{{ __('All') }}</option>
                                            @foreach (DB::table('categories')->whereStatus(1)->get() as $category)
                                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <form class="input-group" id="header_search_form"
                                            action="{{ route('front.catalog') }}" method="get">
                                            <input type="hidden" name="category" value="" id="search__category">
                                            <span class="input-group-btn">
                                                <button type="submit"><i class="icon-search"></i></button>
                                            </span>
                                            <input class="form-control" type="text"
                                                data-target="{{ route('front.search.suggest') }}" id="__product__search"
                                                name="search" placeholder="{{ __('Search by product name') }}">
                                            <div class="serch-result d-none">
                                                {{-- search result --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <span class="d-block d-lg-none close-m-serch"><i class="icon-x"></i></span>
                            </div>
                            @endif

                            <!-- Toolbar-->
                            @if (Auth::check())
                            <div class="toolbar d-flex">
                            @else
                            <div class="toolbar d-sm-none d-flex justify-content-between w-100">
                            @endif

                            @if (Auth::check())
                            <div class="toolbar-item close-m-serch visible-on-mobile"><a href="#">
                                    <div>
                                        <i class="icon-search"></i>
                                    </div>
                                </a>
                            </div>
                            @else
                                <div class="site-branding"><a class="site-logo align-self-center"
                                    href="{{ route('front.index') }}"><img
                                        src="{{ url($setting->logo) }}"
                                        alt="{{ $setting->title }}"></a></div>
                            @endif
                                <div class="toolbar-item visible-on-mobile mobile-menu-toggle"><a href="#">
                                        <div><i class="icon-menu"></i><span class="text-label">{{ __('Menu') }}</span>
                                        </div>
                                    </a>
                                </div>

                                <!--<div class="toolbar-item hidden-on-mobile"><a-->
                                <!--        href="{{ route('fornt.compare.index') }}">-->
                                <!--        <div><span class="compare-icon"><i class="icon-repeat"></i><span-->
                                <!--                    class="count-label compare_count">{{ Session::has('compare') ? count(Session::get('compare')) : '0' }}</span></span><span-->
                                <!--                class="text-label">{{ __('Compare') }}</span></div>-->
                                <!--    </a>-->
                                <!--</div>-->
                                @if (Auth::check())
                                <div class="toolbar-item hidden-on-mobile"><a href="{{ route('user.wishlist.index') }}">
                                        <div><span class="compare-icon"><i class="icon-heart"></i><span
                                                    class="count-label wishlist_count">{{ Auth::user()->wishlists->count() ?? 0 }}</span></span><span
                                                class="text-label">{{ __('Wishlist') }}</span></div>
                                    </a>
                                </div>
                                @else
                                @if (Auth::user())
                                <div class="toolbar-item hidden-on-mobile"><a href="{{ route('user.wishlist.index') }}">
                                        <div><span class="compare-icon"><i class="icon-heart"></i></span><span
                                                class="text-label">{{ __('Wishlist') }}</span></div>
                                    </a>
                                </div>
                                @endif
                                @endif

                                @if (Auth::user())
                                <div class="toolbar-item"><a href="{{ route('front.cart') }}">
                                        <div><span class="cart-icon"><i class="icon-shopping-cart"></i><span
                                                    class="count-label cart_count">{{ Session::has('cart') ? count(Session::get('cart')) : '0' }}
                                                </span></span><span class="text-label">{{ __('Cart') }}</span>
                                        </div>
                                    </a>
                                    <div class="toolbar-dropdown cart-dropdown widget-cart  cart_view_header"
                                        id="header_cart_load" data-target="{{ route('front.header.cart') }}">
                                        @include('includes.header_cart')
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Mobile Menu-->
                            <div class="mobile-menu">
                                <!-- Slideable (Mobile) Menu-->
                                <div class="mm-heading-area">
                                    <h4>{{ __('Navigation') }}</h4>
                                    <div class="toolbar-item visible-on-mobile mobile-menu-toggle mm-t-two">
                                        <a href="#">
                                            <div> <i class="icon-x"></i></div>
                                        </a>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation99">
                                        <span class="active" id="mmenu-tab" data-bs-toggle="tab" data-bs-target="#mmenu"
                                            role="tab" aria-controls="mmenu"
                                            aria-selected="true">{{ __('Menu') }}</span>
                                    </li>
                                    @if (Auth::user())
                                    <li class="nav-item" role="presentation99">
                                        <span class="" id="mcat-tab" data-bs-toggle="tab" data-bs-target="#mcat"
                                            role="tab" aria-controls="mcat"
                                            aria-selected="false">{{ __('Category') }}</span>
                                    </li>
                                    @endif
                                </ul>
                                <div class="tab-content p-0">
                                    <div class="tab-pane fade show active" id="mmenu" role="tabpanel"
                                        aria-labelledby="mmenu-tab">
                                        <nav class="slideable-menu">
                                            <ul>
                                                <li class="{{ request()->routeIs('front.index') ? 'active' : '' }}"><a
                                                        href="{{ route('front.index') }}"><i
                                                            class="icon-chevron-right"></i>{{ __('Home') }}</a>
                                                </li>
                                                @if ($setting->is_shop == 1)
                                                <li class="{{ request()->routeIs('front.catalog*') ? 'active' : '' }}">
                                                    <a href="{{ route('front.catalog') }}"><i
                                                            class="icon-chevron-right"></i>{{ __('Shop') }}</a>
                                                </li>
                                                @endif
                                                <li
                                                    class="{{ request()->url() == route('front.page', 'about-us') ? 'active' : '' }}">
                                                    <a href="{{ route('front.page', 'about-us') }}">
                                                        <i class="icon-chevron-right"></i>{{ __('About Us') }}
                                                    </a>
                                                </li>


                                                <!--@if ($setting->is_campaign == 1)-->
                                                <!--    <li-->
                                                <!--        class="{{ request()->routeIs('front.campaign') ? 'active' : '' }}">-->
                                                <!--        <a href="{{ route('front.campaign') }}"><i-->
                                                <!--                class="icon-chevron-right"></i>{{ __('Campaign') }}</a>-->
                                                <!--    </li>-->
                                                <!--@endif-->
                                                <!--@if ($setting->is_brands == 1)-->
                                                <!--    <li-->
                                                <!--        class="{{ request()->routeIs('front.brand') ? 'active' : '' }}">-->
                                                <!--        <a href="{{ route('front.brand') }}"><i-->
                                                <!--                class="icon-chevron-right"></i>{{ __('Brand') }}</a>-->
                                                <!--    </li>-->
                                                <!--@endif-->

                                                <!--@if ($setting->is_blog == 1)-->
                                                <!--    <li-->
                                                <!--        class="{{ request()->routeIs('front.blog*') ? 'active' : '' }}">-->
                                                <!--        <a href="{{ route('front.blog') }}"><i-->
                                                <!--                class="icon-chevron-right"></i>{{ __('Blog') }}</a>-->
                                                <!--    </li>-->
                                                <!--@endif-->

                                                <!--<li class="t-h-dropdown">-->
                                                <!--    <a class="" href="#"><i-->
                                                <!--            class="icon-chevron-right"></i>{{ __('Pages') }} <i-->
                                                <!--            class="icon-chevron-down"></i></a>-->
                                                <!--    <div class="t-h-dropdown-menu">-->
                                                <!--        @if ($setting->is_faq == 1)-->
                                                <!--            <a class="{{ request()->routeIs('front.faq*') ? 'active' : '' }}"-->
                                                <!--                href="{{ route('front.faq') }}"><i-->
                                                <!--                    class="icon-chevron-right pr-2"></i>{{ __('Faq') }}</a>-->
                                                <!--        @endif-->
                                                <!--        @foreach (DB::table('pages')->wherePos(0)->orwhere('pos', 2)->get() as $page)-->
                                                <!--            <a class="{{ request()->url() == route('front.page', $page->slug) ? 'active' : '' }} "-->
                                                <!--                href="{{ route('front.page', $page->slug) }}"><i-->
                                                <!--                    class="icon-chevron-right pr-2"></i>{{ $page->title }}</a>-->
                                                <!--        @endforeach-->
                                                <!--    </div>-->
                                                <!--</li>-->

                                                @if ($setting->is_contact == 1)
                                                <li class="{{ request()->routeIs('front.contact') ? 'active' : '' }}">
                                                    <a href="{{ route('front.contact') }}"><i
                                                            class="icon-chevron-right"></i>{{ __('Contact') }}</a>
                                                </li>
                                                @endif
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="tab-pane fade" id="mcat" role="tabpanel" aria-labelledby="mcat-tab">
                                        <nav class="slideable-menu">
                                            @include('includes.mobile-category')

                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Navbar-->
        <div class="navbar">
            <div class="container">

                <div class="row g-3 w-100">
                    @if ($setting->is_show_category == 1)
                    <div class="col-lg-3">
                        @if(Auth::user())
                        @include('includes.categories')

                        @else
                        <!-- Logo-->
                        <div class="site-branding"><a class="site-logo align-self-center"
                                href="{{ route('front.index') }}"><img
                                    src="{{ url($setting->logo) }}"
                                    alt="{{ $setting->title }}"></a></div>
                        @endif
                    </div>
                    @endif
                    <div
                        class="col-lg-9 d-flex justify-content-between {{ Auth::check() ? '' : 'align-items-center' }}">
                        <div class="nav-inner">
                            @include('master.inc.site-menu')
                        </div>
                        @php
                        $free_shipping = DB::table('shipping_services')
                        ->whereStatus(1)
                        ->whereIsCondition(1)
                        ->first();
                        @endphp
                    </div>
                </div>
            </div>
        </div>

    </header>
    <!-- Page Content-->
    @yield('content')

    <!-- announcement banner section start   -->
    <a class="announcement-banner" href="#announcement-modal"></a>
    <div id="announcement-modal" class="mfp-hide white-popup">
        @if ($setting->announcement_type == 'newletter')
        <div class="announcement-with-content">
            <div class="left-area">
                <img src="{{ url($setting->announcement) }}" alt="">
            </div>
            <div class="right-area">
                <h3 class="">{{ $setting->announcement_title }}</h3>
                <p>{{ $setting->announcement_details }}</p>
                <form class="subscriber-form" action="{{ route('front.subscriber.submit') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" type="email" name="email" placeholder="{{ __('Your e-mail') }}">
                        <span class="input-group-addon"><i class="icon-mail"></i></span>
                    </div>
                    <div aria-hidden="true">
                        <input type="hidden" name="b_c7103e2c981361a6639545bd5_1194bb7544" tabindex="-1">
                    </div>

                    <button class="btn btn-primary btn-block mt-2" type="submit">
                        <span>{{ __('Subscribe') }}</span>
                    </button>
                </form>
            </div>
        </div>
        @else
        <a href="{{ $setting->announcement_link }}">
            <img src="{{ url($setting->announcement) }}" alt="">
        </a>
        @endif


    </div>
    <!--    announcement banner section end   -->

    <!-- Site Footer-->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!-- Subscription-->
                    <section class="mb-5">
                        <h3 class="widget-title">{{ __('About') }}</h3>
                        <p>Welcome to Ferranza Electric Vehicle, India’s leading electric scooty brand driving the
                            future of urban mobility. Experience innovation, efficiency, and affordability — all in one
                            electric ride.</p>
                        <!--<form class="row subscriber-form" action="{{ route('front.subscriber.submit') }}"-->
                        <!--    method="post">-->
                        <!--    @csrf-->
                        <!--    <div class="col-sm-12">-->
                        <!--        <div class="input-group">-->
                        <!--            <input class="form-control" type="email" name="email"-->
                        <!--                placeholder="{{ __('Your e-mail') }}">-->
                        <!--            <span class="input-group-addon"><i class="icon-mail"></i></span>-->
                        <!--        </div>-->
                        <!--        <div aria-hidden="true">-->
                        <!--            <input type="hidden" name="b_c7103e2c981361a6639545bd5_1194bb7544"-->
                        <!--                tabindex="-1">-->
                        <!--        </div>-->

                        <!--    </div>-->
                        <!--    <div class="col-sm-12">-->
                        <!--        <button class="btn btn-primary btn-block mt-2" type="submit">-->
                        <!--            <span>{{ __('Subscribe') }}</span>-->
                        <!--        </button>-->
                        <!--    </div>-->
                        <!--    <div class="col-lg-12">-->
                        <!--        <p class="text-sm opacity-80 pt-2">-->
                        <!--            {{ __('Subscribe to our Newsletter to receive early discount offers, latest news, sales and promo information.') }}-->
                        <!--        </p>-->
                        <!--    </div>-->
                        <!--</form>-->

                        @php
                        $links = json_decode($setting->social_link, true)['links'];
                        $icons = json_decode($setting->social_link, true)['icons'];

                        @endphp
                        <div class="footer-social-links">
                            @foreach ($links as $link_key => $link)
                            <a href="{{ $link }}"><span><i class="{{ $icons[$link_key] }}"></i></span></a>
                            @endforeach
                        </div>
                    </section>

                </div>
                <div class="col-lg-4 col-sm-6">
                    <!-- Customer Info-->
                    <div class="widget widget-links widget-light-skin">
                        <h3 class="widget-title">{{ __('Usefull Links') }}</h3>
                        <ul>
                            @if ($setting->is_faq == 1)
                            <li>
                                <a class="" href="{{ route('front.faq') }}">{{ __('FAQ') }}</a>
                            </li>
                            @endif
                            @foreach (DB::table('pages')->wherePos(2)->orwhere('pos', 1)->get() as $page)
                            <li><a href="{{ route('front.page', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Contact Info-->
                    <section class="widget widget-light-skin">
                        <h3 class="widget-title">{{ __('Get In Touch') }}</h3>
                        <p class="mb-1"><strong>{{ __('Address') }}: </strong> {{ $setting->footer_address }}</p>
                        <p class="mb-1"><strong>{{ __('Phone') }}: </strong> {{ $setting->footer_phone }}</p>
                        <p class="mb-1"><strong>{{ __('Email') }}: </strong> <a
                                href="mailto:{{ $setting->footer_email }}">{{ $setting->footer_email }}</a></p>
                        <!--<ul class="list-unstyled text-sm">-->
                        <!--    <li><span class=""><strong>{{ $setting->working_days_from_to }}:-->
                        <!--            </strong></span>{{ $setting->friday_start }} - {{ $setting->friday_end }}</li>-->
                        <!--</ul>-->
                        <!--<div class="pt-3"><img class="d-block gateway_image"-->
                        <!--        src="{{ $setting->footer_gateway_img ? url('/core/public/storage/images/' . $setting->footer_gateway_img) : asset('system/resources/assets/images/placeholder.png') }}">-->
                        <!--</div>-->
                    </section>
                </div>
            </div>
            <!-- Copyright-->
            <!--<p class="footer-copyright"> {{ $setting->copy_right }}</p>-->
            <p class="footer-copyright"> © 2025 Ferranza Electric Vehicle Pvt. Ltd. All Rights Reserved. | Designed by
                <a href="https://kriscent.in/" target="_blank">Kriscent Techno Hub Pvt. Ltd.</a>
            </p>
        </div>
    </footer>

    <!-- Back To Top Button-->
    <a class="scroll-to-top-btn" href="#">
        <i class="icon-chevron-up"></i>
    </a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>

    <!-- Sticky Contact Buttons -->
    <div class="sticky-buttons">
        <a href="https://wa.me/9837229801" target="_blank" class="contact-btn whatsapp-btn"
            data-tooltip="Chat on WhatsApp">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
            </svg>
        </a>

        <a href="tel:+919667300984" class="contact-btn call-btn" data-tooltip="Call Us">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" />
            </svg>
        </a>
    </div>

    <!-- Cookie alert dialog  -->
    @if ($setting->is_cookie == 1)
    @include('cookie-consent::index')
    @endif
    <!-- Cookie alert dialog  -->


    @php
    $mainbs = [];
    $mainbs['is_announcement'] = $setting->is_announcement;
    $mainbs['announcement_delay'] = $setting->announcement_delay;
    $mainbs['overlay'] = $setting->overlay;
    $mainbs = json_encode($mainbs);
    @endphp


    <script>
        var mainbs = {"is_announcement":0,"announcement_delay":"1.00","overlay":null};
        var decimal_separator = '.';
        var thousand_separator = ',';
    </script>

    <script>
        let language = {
            Days: 'Days',
            Hrs: 'Hrs',
            Min: 'Min',
            Sec: 'Sec',
        }
    </script>

    <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
    <script type="text/javascript" src="{{ asset('assets/front/js/plugins.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/back/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/front/js/scripts.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/lazy.plugin.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/front/js/myscript.js') }}"></script>
    @yield('script')

    @if ($setting->is_facebook_messenger == '1')
    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "{{ $setting->facebook_messenger }}");
    chatbox.setAttribute("attribution", "biz_inbox");
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v11.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    @endif



    <script type="text/javascript">
    let mainurl = '{{ route('front.index') }}';

    let view_extra_index = 0;
    // Notifications
    function SuccessNotification(title) {
        $.notify({
            title: ` <strong>${title}</strong>`,
            message: '',
            icon: 'fas fa-check-circle'
        }, {
            element: 'body',
            position: null,
            type: "success",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class'
        });
    }

    function DangerNotification(title) {
        $.notify({
            // options
            title: ` <strong>${title}</strong>`,
            message: '',
            icon: 'fas fa-exclamation-triangle'
        }, {
            // settings
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class'
        });
    }
    // Notifications Ends
    </script>

    @if (Session::has('error'))
    <script>
    $(document).ready(function() {
        DangerNotification('{{Session::get('error')}}')
    })
    </script>
    @endif
    @if (Session::has('success'))
    <script>
    $(document).ready(function() {
        SuccessNotification('{{Session::get('success')}}');
    })
    </script>
    @endif

</body>

</html>