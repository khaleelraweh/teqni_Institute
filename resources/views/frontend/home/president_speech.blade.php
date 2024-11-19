   <!-- President speech Section Start -->
   @if ($president_speech)
       <div class="rs-cta main-home ">
           @php
               if ($president_speech->promotional_image != null) {
                   $president_speech_img = asset('assets/president_speeches/' . $president_speech->promotional_image);

                   if (!file_exists(public_path('assets/president_speeches/' . $president_speech->promotional_image))) {
                       $president_speech_img = asset('image/not_found/placeholder.jpg');
                   }
               } else {
                   $president_speech_img = asset('image/not_found/placeholder.jpg');
               }
           @endphp

           <style>
               .rs-cta.main-home .partition-bg-wrap:after {
                   background-image: url({{ $president_speech_img }});
               }
           </style>
           <div class="partition-bg-wrap">
               <div class="container">
                   <div class="row">

                       <div class="offset-lg-6">
                       </div>
                       {{-- <div class="col-lg-6 pl-70 md-pl-15 "> --}}
                       <div class="col-lg-6 pl-70 md-pl-15 text-center">
                           <div class="sec-title3 mb-40">
                               <h2 class="title white-color mb-16">
                                   {!! $president_speech->title ?? '' !!}
                               </h2>
                               {{-- <div class="desc white-color pr-100 md-pr-0"> --}}
                               <div class="desc white-color pl-70 md-pl-15" style="text-align: justify;">>
                                   {!! $president_speech->content ?? '' !!}
                               </div>
                           </div>
                           {{-- <div class="btn-part">
                   <a class="readon  transparent" href="#">Register Now</a>
               </div> --}}
                       </div>
                   </div>
               </div>
           </div>
       </div>
   @endif
   <!-- president speech Section End -->
