 <!-- Videos Section Start -->
 @if (count($playlists))
     <div id="rs-blog" class=" rs-faq-part rs-college-videos style1 main-home pb-80 pt-80 md-pt-60 md-pb-60">
         <div class="container">
             <div class="sec-title mb-60 md-mb-30 text-center">
                 <h2 class="title mb-0 ">{{ __('panel.newest_video') }}</h2>
             </div>
             <div class="rs-carousel owl-carousel" data-loop="true" data-items="3" data-margin="30" data-autoplay="true"
                 data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false"
                 data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1"
                 data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2"
                 data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="1"
                 data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="4"
                 data-md-device-nav="false" data-md-device-dots="false">
                 @foreach ($playlists as $playlist)
                     <div class="blog-item">
                         @php
                             if ($playlist->photos->first() != null && $playlist->photos->first()->file_name != null) {
                                 $playlist_img = asset('assets/playlists/' . $playlist->photos->first()->file_name);

                                 if (
                                     !file_exists(
                                         public_path('assets/playlists/' . $playlist->photos->first()->file_name),
                                     )
                                 ) {
                                     // $playlist_img = asset('frontend/images/faq/1.jpg');
                                     $playlist_img = asset('image/not_found/placeholder.jpg');
                                 }
                             } else {
                                 // $playlist_img = asset('frontend/images/faq/1.jpg');
                                 $playlist_img = asset('image/not_found/placeholder.jpg');
                             }
                         @endphp
                         <div class="img-part media-icon " style="background-image: url({{ $playlist_img }})">
                             <a class="popup-videos" href="{{ $playlist->videoLinks()->first()->link ?? '' }}">
                                 <i class="fa fa-play"></i>
                             </a>
                         </div>
                     </div>
                 @endforeach
             </div>
         </div>
     </div>
 @endif
 <!-- Videos Section End -->
