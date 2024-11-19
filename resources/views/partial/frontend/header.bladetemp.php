 <!--Full width header Start-->
 <div class="full-width-header home8-style4 main-home">
     <!--Header Start-->
     <header id="rs-header" class="rs-header">
         <!-- Menu Start -->
         <div class="menu-area menu-sticky">
             <div class="container">
                 <div class="row y-middle">
                     <div class="col-lg-2">
                         <div class="logo-cat-wrap">
                             <div class="logo-part">
                                 <a href="index.html">
                                     <img class="normal-logo" src="{{ asset('frontend/images/lite-logo.png') }}"
                                         alt="">
                                     <img class="sticky-logo" src="{{ asset('frontend/images/dark-logo.png') }}"
                                         alt="">
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="col-lg-8 text-right">
                         <div class="rs-menu-area">
                             <div class="main-menu">
                                 <div class="mobile-menu">
                                     <a class="rs-menu-toggle">
                                         <i class="fa fa-bars"></i>
                                     </a>
                                 </div>
                                 <nav class="rs-menu">
                                     <ul class="nav-menu">
                                         @foreach ($web_menus->where('section', 1) as $menu)
                                         <li
                                             class=" {{ count($menu->appearedChildren) > 0 ? 'menu-item-has-children has-children' : '' }}">
                                             <a
                                                 href="{{ count($menu->appearedChildren) > 0 ? 'javascript:void(0)' : $menu->link }}">{{ $menu->title }}</a>
                                             @if (count($menu->appearedChildren) > 0)
                                             <ul class="sub-menu">
                                                 @foreach ($menu->appearedChildren as $sub_menu)
                                                 <li
                                                     class=" {{ count($sub_menu->appearedChildren) > 0 ? 'menu-item-has-children has-children' : '' }}">
                                                     <a
                                                         href="{{ $sub_menu->link }}">{{ $sub_menu->title }}</a>
                                                     @if (count($sub_menu->appearedChildren) > 0)
                                                     <ul class="sub-menu">
                                                         @foreach ($sub_menu->appearedChildren as $sub_sub_menu)
                                                         <li>
                                                             <a
                                                                 href="{{ $sub_sub_menu->link }}">{{ $sub_sub_menu->title }}</a>
                                                         </li>
                                                         @endforeach
                                                     </ul>
                                                     @endif
                                                 </li>
                                                 @endforeach
                                             </ul>
                                             @endif
                                         </li>
                                         @endforeach
                                     </ul> <!-- //.nav-menu -->
                                 </nav>

                             </div> <!-- //.main-menu -->

                         </div>
                     </div>
                     <div class="col-lg-2 text-right">
                         <div class="expand-btn-inner">
                             <ul>

                                 <li>
                                     <a class="hidden-xs rs-search" data-target=".search-modal" data-toggle="modal"
                                         href="#">
                                         <i class="flaticon-search"></i>
                                     </a>
                                 </li>
                                 <li class="user-icon cart-inner no-border mini-cart-active">
                                     <a href="#"><i class="fa fa-shopping-bag"></i></a>
                                     <div class="woocommerce-mini-cart text-left">
                                         <div class="cart-bottom-part">
                                             <ul class="cart-icon-product-list">
                                                 <li class="display-flex">
                                                     <div class="icon-cart">
                                                         <a href="#"><i class="fa fa-times"></i></a>
                                                     </div>
                                                     <div class="product-info">
                                                         <a href="cart.html">Law Book</a><br>
                                                         <span class="quantity">1 × $30.00</span>
                                                     </div>
                                                     <div class="product-image">
                                                         <a href="cart.html"><img
                                                                 src="{{ asset('frontend/images/shop/1.jpg') }}"
                                                                 alt="Product Image"></a>
                                                     </div>
                                                 </li>
                                                 <li class="display-flex">
                                                     <div class="icon-cart">
                                                         <a href="#"><i class="fa fa-times"></i></a>
                                                     </div>
                                                     <div class="product-info">
                                                         <a href="cart.html">Spirit Level</a><br>
                                                         <span class="quantity">1 × $30.00</span>
                                                     </div>
                                                     <div class="product-image">
                                                         <a href="cart.html"><img
                                                                 src="{{ asset('frontend/images/shop/2.jpg') }}"
                                                                 alt="Product Image"></a>
                                                     </div>
                                                 </li>
                                             </ul>

                                             <div class="total-price text-center">
                                                 <span class="subtotal">Subtotal:</span>
                                                 <span class="current-price">$85.00</span>
                                             </div>

                                             <div class="cart-btn text-center">
                                                 <a class="crt-btn btn1" href="cart.html">View Cart</a>
                                                 <a class="crt-btn btn2" href="checkout.html">Check Out</a>
                                             </div>
                                         </div>
                                     </div>
                                 </li>
                                 <li class="user-icon last-icon">
                                     <a href="#"><i class="fa fa-user" aria-hidden="true"></i></a>
                                 </li>

                             </ul>
                             <span>
                                 <a id="nav-expander" class="nav-expander">
                                     <span class="dot1"></span>
                                     <span class="dot2"></span>
                                     <span class="dot3"></span>
                                 </a>
                             </span>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Menu End -->

         <!-- Canvas Menu start -->
         <nav class="right_menu_togle hidden-md">
             <div class="close-btn">
                 <div id="nav-close">
                     <div class="line">
                         <span class="line1"></span><span class="line2"></span>
                     </div>
                 </div>
             </div>
             <div class="canvas-logo">
                 <a href="index.html"><img src="{{ asset('frontend/images/dark-logo.png') }}" alt="logo"></a>
             </div>
             <div class="offcanvas-text">
                 <p>We denounce with righteous indige nationality and dislike men who are so beguiled and demo by
                     the charms of pleasure of the moment data com so blinded by desire.</p>
             </div>
             <div class="offcanvas-gallery">
                 <div class="gallery-img">
                     <a class="image-popup" href="{{ asset('frontend/images/gallery/1.jpg') }}"><img
                             src="{{ asset('frontend/images/gallery/1.jpg') }}" alt=""></a>
                 </div>
                 <div class="gallery-img">
                     <a class="image-popup" href="{{ asset('frontend/images/gallery/2.jpg') }}"><img
                             src="{{ asset('frontend/images/gallery/2.jpg') }}" alt=""></a>
                 </div>
                 <div class="gallery-img">
                     <a class="image-popup" href="{{ asset('frontend/images/gallery/3.jpg') }}"><img
                             src="{{ asset('frontend/images/gallery/3.jpg') }}" alt=""></a>
                 </div>
                 <div class="gallery-img">
                     <a class="image-popup" href="{{ asset('frontend/images/gallery/4.jpg') }}"><img
                             src="{{ asset('frontend/images/gallery/4.jpg') }}" alt=""></a>
                 </div>
                 <div class="gallery-img">
                     <a class="image-popup" href="{{ asset('frontend/images/gallery/5.jpg') }}"><img
                             src="{{ asset('frontend/images/gallery/5.jpg') }}" alt=""></a>
                 </div>
                 <div class="gallery-img">
                     <a class="image-popup" href="{{ asset('frontend/images/gallery/6.jpg') }}"><img
                             src="{{ asset('frontend/images/gallery/6.jpg') }}" alt=""></a>
                 </div>
             </div>
             <div class="map-img">
                 <img src="{{ asset('frontend/images/map.jpg') }}" alt="">
             </div>
             <div class="canvas-contact">
                 <ul class="social">
                     <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                     <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                     <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                     <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                 </ul>
             </div>
         </nav>
         <!-- Canvas Menu end -->
     </header>
     <!--Header End-->
 </div>
 <!--Full width header End-->