   <!-- start statistics -->
   @if (count($statistics))
       <div class=" main-home event-bg rs-statistics pt-100 pb-100 md-pt-70 md-pb-70 bg12">
           {{-- <div class=" main-home event-bg rs-statistics pt-100 pb-100 md-pt-70 md-pb-70 bg2"> --}}
           <div class="rs-counter style2-about">
               <div class="container">
                   {{-- <div class="sec-title mb-40 md-mb-40 text-center">
               <h2 class="title mb-0">{{ __('panel.statistics_and_numbers') }}</h2>
           </div> --}}
                   <div class="row couter-area">
                       @foreach ($statistics as $statistic)
                           <div
                               class="col-lg-3 col-md-6 {{ $loop->last ? '' : 'md-mb-30' }}  {{ !$loop->last && count($statistics) > 4 ? 'lg-mb-70' : ' ' }} ">
                               <div class="counter-item text-center">

                                   {{-- <div class="statistic-image">
                               @php
                                   if ($statistic->statistic_image != null) {
                                       $statistic_img = asset('assets/statistics/' . $statistic->statistic_image);

                                       if (
                                           !file_exists(
                                               public_path('assets/statistics/' . $statistic->statistic_image),
                                           )
                                       ) {
                                           $statistic_img = asset('image/not_found/placeholder.jpg');
                                       }
                                   } else {
                                       $statistic_img = asset('image/not_found/placeholder.jpg');
                                   }
                               @endphp
                               <img src="{{ $statistic_img }}" alt="" class="image">

                           </div> --}}
                                   {{-- <div class="statistic-content"> --}}
                                   <div class="statistic-content text-center">
                                       <h2 class="rs-count">{{ $statistic->statistic_number }}</h2>
                                       <h4 class="title mb-0 ">{{ $statistic->title }}</h4>
                                   </div>


                               </div>
                           </div>
                       @endforeach

                   </div>
               </div>
           </div>
       </div>
   @endif
   <!-- end statistics -->
