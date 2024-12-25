  <!-- department start   -->
  @if (count($web_menus->where('section', 2)))
      <div class="rs-degree rs-college-institute style1 modify gray-bg pt-100 pb-100 md-pt-70 md-pb-70 bg2">
          <div class="container">
              <div class="sec-title mb-60 text-center">
                  <h2 class="title mb-0">{{ __('panel.institute_departments') }}</h2>
              </div>
              <div class="row y-middle">
                  <div class="col-lg-12 col-md-12 mb-30">
                      <div class="rs-carousel owl-carousel" data-loop="true" data-items="3" data-margin="30"
                          data-autoplay="true" data-hoverpause="true" data-autoplay-timeout="5000"
                          data-smart-speed="800" data-dots="false" data-nav="false" data-nav-speed="false"
                          data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false"
                          data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="false"
                          data-ipad-device-dots="false" data-ipad-device2="1" data-ipad-device-nav2="false"
                          data-ipad-device-dots2="false" data-md-device="4" data-md-device-nav="false"
                          data-md-device-dots="false">
                          @foreach ($web_menus->where('section', 2) as $college_menu)
                              <div class="blog-item">
                                  <div class="degree-wrap">
                                      @php
                                          if (
                                              $college_menu->photos->first() != null &&
                                              $college_menu->photos->first()->file_name != null
                                          ) {
                                              $college_menu_img = asset(
                                                  'assets/academic_program_menus/' .
                                                      $college_menu->photos->first()->file_name,
                                              );

                                              if (
                                                  !file_exists(
                                                      public_path(
                                                          'assets/academic_program_menus/' .
                                                              $college_menu->photos->first()->file_name,
                                                      ),
                                                  )
                                              ) {
                                                  // $college_menu_img = asset('frontend/images/degrees/1.jpg');
                                                  $college_menu_img = asset('image/not_found/placeholder.jpg');
                                              }
                                          } else {
                                              // $college_menu_img = asset('frontend/images/degrees/1.jpg');
                                              $college_menu_img = asset('image/not_found/placeholder.jpg');
                                          }
                                      @endphp

                                      <img src="{{ $college_menu_img }}" alt="">
                                      <div class="title-part">
                                          <h4 class="title">{{ $college_menu->title }}</h4>
                                      </div>
                                      <div class="content-part">
                                          <h4 class="title"><a
                                                  href="{{ url($college_menu->link) }}">{{ $college_menu->title }}</a>
                                          </h4>
                                          <style>
                                              .desc~p {
                                                  color: #777777;
                                              }
                                          </style>
                                          <p class="desc">
                                              {!! $college_menu->description !!}
                                          </p>
                                          <div class="btn-part">
                                              <a href="{{ url($college_menu->link) }}">{{ __('panel.read_more') }}</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @endforeach

                      </div>
                  </div>
              </div>
          </div>
      </div>
  @endif
  <!-- department End -->
