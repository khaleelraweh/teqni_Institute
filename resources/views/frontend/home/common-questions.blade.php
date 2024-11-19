  <!-- Faq Section Start -->
  @if (count($common_questions) || $common_question_video)
      <div class="rs-faq-part style1  pt-100 pb-100 md-pt-70 md-pb-70">
          <div class="container">
              <div class="row">
                  @if (count($common_questions))
                      <div class=" {{ $common_question_video ? 'col-lg-6' : 'col-lg-12' }} padding-0">
                          <div class=" main-part">
                              <div class="title mb-40 md-mb-15">
                                  <h2 class="text-part">{{ __('panel.frequently_asked_questions') }}</h2>
                              </div>
                              <div class="faq-content">
                                  <div id="accordion" class="accordion">
                                      @foreach ($common_questions as $question)
                                          <div class="card">
                                              <div class="card-header">
                                                  <a class="card-link {{ $loop->first ? 'collapsed' : '' }}"
                                                      data-toggle="collapse" href="#collapse{{ $question->id }}">
                                                      {{ $question->title }}
                                                  </a>
                                              </div>
                                              <div id="collapse{{ $question->id }}"
                                                  class="collapse {{ $loop->first ? 'show' : '' }} "
                                                  data-parent="#accordion">
                                                  <div class="card-body">
                                                      {!! $question->description !!}
                                                  </div>
                                              </div>
                                          </div>
                                      @endforeach
                                  </div>
                              </div>
                          </div>
                      </div>
                  @endif

                  @if ($common_question_video)
                      <div class="{{ count($common_questions) ? 'col-lg-6' : 'col-lg-12' }} padding-0">
                          @php
                              if ($common_question_video && $common_question_video->question_video_image != null) {
                                  $common_question_video_img = asset(
                                      'assets/common_question_videos/' . $common_question_video->question_video_image,
                                  );

                                  if (
                                      !file_exists(
                                          public_path(
                                              'assets/common_question_videos/' .
                                                  $common_question_video->question_video_image,
                                          ),
                                      )
                                  ) {
                                      $common_question_video_img = asset('image/not_found/placeholder.jpg');
                                  }
                              } else {
                                  $common_question_video_img = asset('image/not_found/placeholder.jpg');
                              }
                          @endphp
                          <style>
                              .rs-faq-part.style1 .img-part {
                                  background-image: url({{ $common_question_video_img }})
                              }
                          </style>
                          <div class="img-part media-icon ">
                              <a class="popup-videos" href="{{ $common_question_video->link ?? '#' }}">
                                  <i class="fa fa-play"></i>
                              </a>
                          </div>
                      </div>
                  @endif
              </div>
          </div>
      </div>
  @endif
  <!-- faq Section Start -->
