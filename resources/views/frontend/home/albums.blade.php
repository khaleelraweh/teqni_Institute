 <!--  album Start  -->
 @if (count($albums))
     <div class="rs-degree rs-college-album style1 modify gray-bg pt-100 pb-100 md-pt-70 md-pb-70">
         <div class="container">
             <div class="sec-title mb-40 md-mb-40 text-center">
                 <h2 class="title mb-0">{{ __('panel.photo_album') }}</h2>
             </div>
             <div class="row  album-container">
                 <div class="col-lg-12 col-md-12 mt-10 mb-10">
                     <div class="rs-carousel owl-carousel" data-loop="true" data-items="3" data-margin="30"
                         data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800"
                         data-dots="false" data-nav="false" data-nav-speed="false" data-center-mode="false"
                         data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false"
                         data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="false"
                         data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="false"
                         data-md-device="4" data-md-device-nav="false" data-md-device-dots="false">
                         @foreach ($albums as $album)
                             <div class="blog-item degree-wrap">
                                 @php
                                     if ($album->album_profile != null) {
                                         $album_img = asset('assets/albums/' . $album->album_profile);

                                         if (!file_exists(public_path('assets/albums/' . $album->album_profile))) {
                                             $album_img = asset('image/not_found/placeholder.jpg');
                                         }
                                     } else {
                                         $album_img = asset('image/not_found/placeholder.jpg');
                                     }
                                 @endphp
                                 <img src="{{ $album_img }}" alt="">
                                 <div class="title-part">
                                     <a href="{{ route('frontend.album_single', $album->slug) }}">
                                         <h4 class="title">{{ $album->title }}</h4>
                                     </a>
                                 </div>
                             </div>
                         @endforeach

                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endif
 <!--  album End -->
