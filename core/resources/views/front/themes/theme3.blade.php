@extends('master.front')
@section('meta')
    <meta name="keywords" content="{{ $setting->meta_keywords }}">
    <meta name="description" content="{{ $setting->meta_description }}">
@endsection

@section('content')


   

    @if ($extra_settings->is_t3_slider == 1)
        <div  class="hero-area3" >
            <div class="background"></div>
            <div class="heroarea-slider owl-carousel">
                @foreach ($sliders as $slider)
                <!--<div class="item" style="background: url('{{ url('/core/public/storage/images/' . $slider->photo) }}')">-->
                <div class="item" style="background: linear-gradient(135deg, #7BB932 0%, #2E8744 100%);">
                    <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 d-flex align-self-center">
                            <div class="left-content color-white">
                                <div class="content">
                                    <div class="layer-1">
                                        <p class="subtitle">
                                            {{ $slider->title }}
                                        </p>
                                    </div>
                                    <div class="layer-2">
                                        <h1 class="title">
                                            {{ $slider->details }}
                                        </h1>
                                    </div>
                                    @if($slider->link != '#')
                                    <div class="layer-3">
                                        <div class="links">
                                        <a href="{{ $slider->link }}" class="btn btn-primary">
                                            <span>
                                                {{ __('Buy Now') }}
                                            </span>
                                        </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6 order-first order-lg-last">
                        <div class="layer-4">
                            <div class="right-img">
                            <img class="img-fluid full-img" src="{{ url($slider->logo) }}" alt="">
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ($extra_settings->is_t3_service_section == 1)
        <section class="service-section mt-30 pt-0">
            <div class="container">
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-lg-3 col-sm-6 text-center mb-30">
                            <div class="single-service single-service2">
                                <img src="{{ url($service->photo) }}" alt="Shipping">
                                <div class="content">
                                    <h6 class="mb-2">{{ $service->title }}</h6>
                                    <p class="text-sm text-muted mb-0">{{ $service->details }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    
    <!-- About us section -->
    @if (Auth::user())
    @else
        <section class="w-100 clearfix aboutUs" >
            <div class="container">
                <div class="aboutUsInner py-50 bg-white px-3">
                   <div class="row">
                      <div class="col-lg-6 order-2 order-sm-1 mb-4 mb-lg-0">                     
                         <div class="scootersConsumableImg mb-3 mb-sm-0">
                            <img src="{{ url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/assets/about2.png') }}" alt="image" class="img-fluid">
                         </div>
                      </div>
                      <div class="col-lg-6 order-1 order-sm-2">
                         <div class="commonHeading">
                            <h5 class="text-color">
                               <svg width="15" height="26" viewBox="0 0 15 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M2.69011 25.9987C2.09042 25.9987 1.39079 25.7987 0.89105 25.2987C-0.208378 24.2987 -0.308326 22.5987 0.691153 21.4987L5.7885 15.7987H3.18985C2.19037 15.7987 1.19089 15.1987 0.791099 14.2987C0.391308 13.3987 0.491257 12.1987 1.19089 11.3987L9.78641 0.998683C10.6859 -0.201317 12.485 -0.301319 13.5844 0.598681C14.7838 1.49868 14.8838 3.29868 13.9842 4.39868L9.08678 10.3987H11.9853C13.0847 10.3987 13.9842 10.9987 14.484 11.9987C14.8838 12.9987 14.7838 14.0987 13.9842 14.8987L4.68907 25.0987C4.08938 25.6987 3.38975 25.9987 2.69011 25.9987Z" fill="#7BB932"></path>
                               </svg>
                               <span>
                                  ABOUT Scooty EV
                               </span>
                            </h5>
                            <h2>Welcome to <span class="text-color">Ferranza</span> Electric Vehicle</h2>
                         </div>
                         <div class="scootersConsumableContent">
                            <div class="evCommonInnerPageHeading">
                               <p>India's leading electric Scooty company revolutionizing urban mobility. Founded with a vision to create a sustainable and eco-friendly future, we are committed to delivering innovative, high-performance electric Scootys that are not only good for the environment but also for your pocket.</p>
                               <p>Our journey began with a simple yet powerful idea: to make everyday transportation smarter, greener, and more accessible for everyone. At Ferranza Electric Vehicle, we blend cutting-edge technology, sleek design, and unmatched reliability to offer Scootys that cater to the needs of modern commuters.</p>
                            </div>
                         </div>
                      </div>
                </div>
                </div>
            </div>
        </section>
    @endif

    @if ($extra_settings->is_t3_3_column_banner_first == 1)
        <div class="bannner-section py-50 sam">
            <div class="container ">
                <div class="row gx-3">
                    <div class="col-md-4">
                        <a href="{{$banner_first['firsturl1']}}" class="genius-banner">
                            <img src="{{ url($banner_first['img1']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_first['subtitle1']))
                                    <p>{{$banner_first['subtitle1']}}</p>
                                @endif
                                @if (isset($banner_first['title1']))
                                    <h4>{{$banner_first['title1']}}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{$banner_first['firsturl2']}}" class="genius-banner">
                            <img src="{{ url($banner_first['img2']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_first['subtitle2']))
                                    <p>{{$banner_first['subtitle2']}}</p>
                                @endif
                                @if (isset($banner_first['title2']))
                                    <h4>{{$banner_first['title2']}}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{$banner_first['firsturl3']}}" class="genius-banner">
                            <img src="{{ url($banner_first['img3']) }}" alt="">
                            <div class="inner-content">
                                @if (isset($banner_first['subtitle3']))
                                    <p>{{$banner_first['subtitle3']}} </p>
                                @endif
                                @if (isset($banner_first['title3']))
                                    <h4>{{$banner_first['title3']}}</h4>
                                @endif
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (Auth::user())
        @if ($extra_settings->is_t3_pecialpick == 1)
            <section class="selected-product-section mt-50">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title section-title2  section-title3">
                                <h2 class="h3">{{ __('Special Pick') }}</h2>
    
                            </div>
                            <div class="popular-category theme3">
                                <div class="links">
                                    <a data-href="{{route('front.get.product','feature')}}" data-target="type_product_view" href="javascript:;" class="product_get active">{{__('Featured')}}</a>
                                    <a data-href="{{route('front.get.product','best')}}" data-target="type_product_view" class="product_get" href="javascript:;">{{__('Best Seller')}}</a>
                                    <a data-href="{{route('front.get.product','top')}}" data-target="type_product_view" class="product_get" href="javascript:;">{{__('Top Rated')}}</a>
                                    <a data-href="{{route('front.get.product','new')}}" data-target="type_product_view" class="product_get" href="javascript:;">{{__('New Product')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="type_product_view d-none">
                            <img  src="{{url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/assets/ajax_loader.gif')}}" alt="">
                        </div>
                        <div class="col-lg-12" id="type_product_view">
    
                            <div class="features-slider  owl-carousel" >
                                @foreach ($products->orderBy('id','DESC')->get()  as $item)
                                    @if ($item->is_type == 'feature')
                                        <div class="slider-item">
                                            <a href="{{route('front.product',$item->slug)}}">
                                            <div class="product-card ">
                                                    <div class="product-thumb" >
                                                        @if (!$item->is_stock())
                                                        <div class="product-badge bg-secondary border-default text-body
                                                        ">{{__('out of stock')}}</div>
                                                        @endif
                                                        @if($item->previous_price && $item->previous_price !=0)
                                                        <div class="product-badge product-badge2 bg-info"> -{{PriceHelper::DiscountPercentage($item)}}</div>
                                                        @endif
                                                        <img class="lazy" data-src="{{url($item->thumbnail)}}" alt="Product">
                                                        <div class="product-button-group"><a class="product-button wishlist_store" href="{{route('user.wishlist.store',$item->id)}}" title="{{__('Wishlist')}}"><i class="icon-heart"></i></a>
                                                            <!--<a data-target="{{route('fornt.compare.product',$item->id)}}" class="product-button product_compare" href="javascript:;" title="{{__('Compare')}}"><i class="icon-repeat"></i></a>-->
                                                            @include('includes.item_footer',['sitem' => $item])
                                                        </div>
                                                    </div>
                                                    <div class="product-card-inner">
                                                        <div class="product-card-body">
                                                        <div class="product-category"><a href="{{route('front.catalog').'?category='.$item->category->slug}}">{{$item->category->name}}</a></div>
                                                        <h3 class="product-title">
                                                            <a href="{{route('front.product',$item->slug)}}">{{ Str::limit($item->name,35) }}</a>
                                                        </h3>
                                                        <div class="rating-stars">
                                                            {!! Helper::renderStarRating($item->reviews->avg('rating')) !!}
                                                        </div>
                                                        <h4 class="product-price">
                                                        @if ($item->previous_price != 0)
                                                            <del>{{PriceHelper::setPreviousPrice($item->previous_price)}}</del>
                                                        @endif
                                                        {{PriceHelper::grandCurrencyPrice($item)}}
                                                        </h4>
                                                    </div>
                                                    </div>
                                            </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
    
                    </div>
                </div>
            </section>
        @endif
    
        @if ($extra_settings->is_t3_popular_category == 1)
            <section class="newproduct-section mt-50">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title section-title2 section-title3">
                                <h2 class="h3">{{ $popular_category_title }}</h2>
    
                            </div>
                            <div class="popular-category theme3">
                                <div class="links">
                                    @foreach ($popular_categories as $key => $popular_categorie)
                                    <a class="category_get {{$loop->first ? 'active' : ''}}" data-target="popular_category_view" data-href="{{route('front.popular.category',[$popular_categorie->slug,'popular_category','slider'])}}"  href="javascript:;" class="{{$loop->first ? 'active' : ''}}">{{$popular_categorie->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="popular_category_view d-none">
                        <img  src="{{url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/assets/ajax_loader.gif')}}" alt="">
                    </div>
    
                    <div class="row" id="popular_category_view">
                        <div class="col-lg-12">
                            <div class="popular-category-slider  owl-carousel">
                                @foreach ($popular_category_items as $popular_category_item)
                                <div class="slider-item">
                                    <div class="product-card">
                                        <a href="{{route('front.product',$popular_category_item->slug)}}">
                                            <div class="product-thumb">
                                                @if (!$popular_category_item->is_stock())
                                                    <div class="product-badge bg-secondary border-default text-body
                                                    ">{{__('out of stock')}}</div>
                                                @endif
                                                @if($popular_category_item->previous_price && $popular_category_item->previous_price !=0)
                                                <div class="product-badge product-badge2 bg-info"> -{{PriceHelper::DiscountPercentage($popular_category_item)}}</div>
                                                @endif
                                                    <img class="lazy" data-src="{{url($popular_category_item->thumbnail)}}" alt="Product">
                                                <div class="product-button-group"><a class="product-button wishlist_store" href="{{route('user.wishlist.store',$popular_category_item->id)}}" title="{{__('Wishlist')}}"><i class="icon-heart"></i></a>
                                                    <!--<a data-target="{{route('fornt.compare.product',$popular_category_item->id)}}" class="product-button product_compare" href="javascript:;" title="{{__('Compare')}}"><i class="icon-repeat"></i></a>-->
        
                                                @include('includes.item_footer',['sitem' => $popular_category_item])
                                                </div>
                                            </div>
                                            <div class="product-card-body">
                                                <div class="product-category"><a href="{{route('front.catalog').'?category='.$popular_category_item->category->slug}}">{{$popular_category_item->category->name}}</a></div>
                                                <h3 class="product-title"><a href="{{route('front.product',$popular_category_item->slug)}}">
                                                    {{ Str::limit($popular_category_item->name,35) }}
                                                </a></h3>
                                                <div class="rating-stars">
                                                <i class="fas fa-star filled"></i><i class="fas fa-star filled"></i><i class="fas fa-star filled"></i><i class="fas fa-star filled"></i><i class="fas fa-star filled"></i>
                                                </div>
                                                <h4 class="product-price">
                                                    @if ($popular_category_item->previous_price != 0)
                                                        <del>{{PriceHelper::setPreviousPrice($popular_category_item->previous_price)}}</del>
                                                    @endif
        
                                                    {{PriceHelper::grandCurrencyPrice($popular_category_item)}}
                                                    </h4>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
    
                    </div>
                </div>
            </section>
        @endif
    
        @if ($extra_settings->is_t3_three_column_category == 1)
        <div class="flash-sell-area three_column_product mt-50">
            <div class="container">
                <div class="row gx-3 justify-content-center">
                    @foreach ($two_column_categoriess as $two_column_key => $two_column_category)
                    <div class="col-xl-4 col-lg-6">
                        <div class="section-title">
                            <h2 class="h3">{{ $two_column_category['name']->name }}</h2>
                        </div>
                        <div class="main-content">
                            <div class="newproduct-slider owl-carousel">
                                @foreach ($two_column_categoriess[$two_column_key]['items']->chunk(4) as $two_column_category_itemt)
                                    <div class="slider-item">
                                        @foreach ($two_column_category_itemt as $two_column_category_item)
                                        <div class="product-card p-col">
                                            <a class="product-thumb" href="{{route('front.product',$two_column_category_item->slug)}}">
                                                @if(!$two_column_category_item->is_stock())
                                                    <div class="product-badge bg-secondary border-default text-body
                                                    ">{{__('out of stock')}}</div>
                                                    @endif
    
                                                <img class="lazy" data-src="{{url($two_column_category_item->thumbnail)}}" alt="Product"></a>
                                            <div class="product-card-body">
                                                <h3 class="product-title"><a href="{{route('front.product',$two_column_category_item->slug)}}">
                                                    {{ Str::limit($two_column_category_item->name,40) }}
                                                </a></h3>
                                                <div class="rating-stars">
                                                    {!! Helper::renderStarRating($two_column_category_item->reviews->avg('rating')) !!}
                                                </div>
                                                <h4 class="product-price">
                                                @if ($two_column_category_item->previous_price != 0)
                                                    <del>{{PriceHelper::setPreviousPrice($two_column_category_item->previous_price)}}</del>
                                                @endif
                                                    {{PriceHelper::grandCurrencyPrice($two_column_category_item)}}
                                                </h4>
                                            </div>
                                        </div>
                                        @endforeach
    
                                    </div>
                                @endforeach
                            </div>
    
                        </div>
                    </div>
                    @endforeach
    
                </div>
            </div>
        </div>
        @endif
    @else
        <!-- Achievment section -->
        <section class="w-100 clearfix achivements">
            <div class="container">
                <div class=" bg-white py-50 px-3">
                    <div class="commonHeading text-center">
                        <h5 class="justify-content-center text-color">
                                <svg width="15" height="26" viewBox="0 0 15 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.69011 25.9987C2.09042 25.9987 1.39079 25.7987 0.89105 25.2987C-0.208378 24.2987 -0.308326 22.5987 0.691153 21.4987L5.7885 15.7987H3.18985C2.19037 15.7987 1.19089 15.1987 0.791099 14.2987C0.391308 13.3987 0.491257 12.1987 1.19089 11.3987L9.78641 0.998683C10.6859 -0.201317 12.485 -0.301319 13.5844 0.598681C14.7838 1.49868 14.8838 3.29868 13.9842 4.39868L9.08678 10.3987H11.9853C13.0847 10.3987 13.9842 10.9987 14.484 11.9987C14.8838 12.9987 14.7838 14.0987 13.9842 14.8987L4.68907 25.0987C4.08938 25.6987 3.38975 25.9987 2.69011 25.9987Z" fill="#7BB932"></path>
                                </svg>
                                <span>
                                Know Us
                                </span>
                            </h5>
                        <h2>Our Achivements</h2>
                    </div>
                    <div class="achivementsCard">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
                                <div class="achivementsItem">
                                    <div class="achivementsIcon">
                                        <span>
                                            <img src="{{ url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/assets/scooty.png') }}" alt="our-achivement-icon">
                                        </span>
                                    </div>
                                    <div class="achivementsContent text-center">
                                        <h4><span class="counter" data-countto="30" data-duration="8000">4.3</span>K</h4>
                                        <p>SCOOTY SOLD</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
                                <div class="achivementsItem">
                                    <div class="achivementsIcon">
                                        <span>
                                            <img src="{{ url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/assets/material.png') }}" alt="our-achivement-icon">
                                        </span>
                                    </div>
                                    <div class="achivementsContent text-center">
                                        <h4><span class="counter" data-countto="99.9" data-duration="8000">99</span>%</h4>
                                        <p>BEST MATERIALS</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
                                <div class="achivementsItem">
                                    <div class="achivementsIcon">
                                        <span>
                                            <img src="{{ url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/assets/customer.png') }}" alt="our-achivement-icon">
                                        </span>
                                    </div>
                                    <div class="achivementsContent text-center">
                                        <h4><span class="counter" data-countto="52" data-duration="8000">5.2</span>K</h4>
                                        <p>HAPPY CUSTOMERS</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
                                <div class="achivementsItem">
                                    <div class="achivementsIcon">
                                        <span>
                                            <img src="{{ url('https://kth-storage.hel1.your-objectstorage.com/ferranza-image/images/assets/free-delivery.png') }}" alt="our-achivement-icon">
                                        </span>
                                    </div>
                                    <div class="achivementsContent text-center">
                                        <h4><span class="counter" data-countto="99" data-duration="8000">99</span>%</h4>
                                        <p>FREE DELIVERIES</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
    @endif

    @if ($extra_settings->is_t3_2_column_banner == 1)
    <div class="bannner-section mt-50 mb-50">
        <div class="container ">
            <div class="row gx-3">
                <div class="col-md-6">
                    <a href="{{$banner_third['url1']}}" class="genius-banner">
                        <img class="lazy" src="{{ url($banner_third['img1']) }}" alt="">
                        <div class="inner-content">
                            @if (isset($banner_third['subtitle1']))
                                <p>{{$banner_third['subtitle1']}}</p>
                            @endif
                            @if (isset($banner_third['title1']))
                                <h4>{{$banner_third['title1']}}</h4>
                            @endif
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{$banner_third['url2']}}" class="genius-banner">
                        <img class="lazy" src="{{ url($banner_third['img2']) }}" alt="">
                        <div class="inner-content">
                            @if (isset($banner_third['subtitle2']))
                                <p>{{$banner_third['subtitle2']}} </p>
                            @endif
                            @if (isset($banner_third['title2']))
                                <h4>{{$banner_third['title2']}}</h4>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!--@if ($extra_settings->is_t3_blog_section == 1)-->
    <!--    <div class="blog-section-h page_section mt-50 mb-30">-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-lg-12">-->
    <!--                    <div class="section-title section-title2 section-title3">-->
    <!--                        <h2 class="h3">{{ __('Our Blog') }}</h2>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row justify-content-center">-->
    <!--                <div class="col-lg-12">-->
    <!--                    <div class="home-blog-slider owl-carousel">-->
    <!--                        @foreach ($posts as $post)-->
    <!--                            <div class="slider-item">-->
    <!--                                <a href="{{route('front.blog.details',$post->slug)}}" class="blog-post">-->
    <!--                                    <div class="post-thumb">-->
    <!--                                        <img class="lazy" data-src="{{ url('/core/public/storage/images/' . json_decode($post->photo, true)[array_key_first(json_decode($post->photo, true))]) }}"-->
    <!--                                            alt="Blog Post">-->
    <!--                                        </div>-->
    <!--                                    <div class="post-body">-->

    <!--                                        <h3 class="post-title"> {{ Str::limit($post->title, 55) }}-->
    <!--                                        </h3>-->
    <!--                                        <ul class="post-meta">-->

    <!--                                            <li><i class="icon-user"></i>{{ __('Admin') }}</li>-->
    <!--                                            <li><i class="icon-clock"></i>{{ date('jS F, Y', strtotime($post->created_at)) }}</li>-->
    <!--                                        </ul>-->
    <!--                                        <p>{{ Str::limit(strip_tags($post->content), 120, '...') }}-->
    <!--                                        </p>-->
    <!--                                    </div>-->
    <!--                                </a>-->
    <!--                            </div>-->
    <!--                        @endforeach-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--@endif-->

    <!--@if ($extra_settings->is_t3_brand_section == 1)-->
    <!--    <section class="brand-section mt-30 mb-60">-->
    <!--        <div class="container ">-->
    <!--            <div class="row">-->
    <!--                <div class="col-lg-12 ">-->
    <!--                    <div class="section-title section-title2 section-title3">-->
    <!--                        <h2 class="h3">{{ __('Popular Brands') }}</h2>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="col-lg-12">-->
    <!--                    <div class="brand-slider owl-carousel">-->
    <!--                        @foreach ($brands as $brand)-->
    <!--                        <div class="slider-item">-->
    <!--                            <a class="text-center" href="{{ route('front.catalog') . '?brand=' . $brand->slug }}">-->
    <!--                                <img class="d-block hi-50 lazy"-->
    <!--                                data-src="{{ url('/core/public/storage/images/' . $brand->photo) }}"-->
    <!--                                    alt="{{ $brand->name }}" title="{{ $brand->name }}">-->
    <!--                            </a>-->
    <!--                        </div>-->
    <!--                        @endforeach-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <!--@endif-->


@endsection

