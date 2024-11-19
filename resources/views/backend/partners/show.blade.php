@extends('layouts.admin')
@section('content')
    {{-- first section --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('transf.Course Landing Page') }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            <i class="fa fa-solid fa-chevron-left chevron"></i>
                        @else
                            <i class="fa fa-solid fa-chevron-right chevron"></i>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('admin.courses.index') }}">
                            {{ __('panel.show_courses') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="ml-auto mt-3 mt-sm-0">
                <form action="{{ route('admin.courses.update_course_status', $course->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-row align-items-center">
                        <label class="sr-only" for="inlineFormInputGroupOrderStatus">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ __('panel.course_status') }}</div>
                            </div>
                            <select name="course_status" style="outline-style:none;" onchange="this.form.submit()"
                                class="form-control">

                                <option value=""> {{ __('panel.course_choose_appropriate_event') }} </option>
                                @foreach ($course_status_array as $key => $value)
                                    <option value="{{ $key }}"> {{ $value }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>{{ __('transf.course_title') }}</th>
                                <td>{{ $course->title }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('transf.Course subtitle') }}</th>
                                <td>
                                    {{ $course->subtitle }}
                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <th> {{ __('panel.created_at') }} </th>
                                <td>{{ $course->created_at->format('Y-m-d h:i a') }}</td>
                            </tr>
                            <tr>
                                <th> {{ __('panel.course_status') }}</th>
                                <td>{!! $course->statusWithLabel() !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                @php
                    if ($course->photos->first() != null && $course->photos->first()->file_name != null) {
                        $course_image = asset('assets/courses/' . $course->photos->first()->file_name);

                        if (!file_exists(public_path('assets/courses/' . $course->photos->first()->file_name))) {
                            $course_image = asset('image/not_found/item_image_not_found.webp');
                        }
                    } else {
                        $course_image = asset('image/not_found/item_image_not_found.webp');
                    }
                @endphp
                <img src="{{ $course_image }}" style="display: block;width:100%;height:200px;" alt="{{ $course->title }}">
            </div>
        </div>

    </div>

    {{-- second section  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('transf.Course Landing Page') }}
                </h3>

            </div>

            <div class="ml-auto mt-3 mt-sm-0">

            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <textarea name="description" rows="10" class="form-control">{!! old('description', $course->description) !!}</textarea>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="row">
                    <div class="col-sm-12 p-4">
                        <div class="d-block d-block rounded border p-2 shadow mb-6 bg-white">
                            <a href="{{ $course->video_promo }}"
                                class="d-flex justify-content-center align-items-center sk-thumbnail rounded mb-1"
                                data-fancybox>
                                <div style="width: 50px;height:50px;"
                                    class="h-60p w-60p rounded-circle bg-white size-20-all d-inline-flex align-items-center justify-content-center position-absolute center z-index-1">
                                    <!-- Icon -->
                                    <svg width="14" height="16" viewBox="0 0 14 16"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.8704 6.15374L3.42038 0.328572C2.73669 -0.0923355 1.9101 -0.109836 1.20919 0.281759C0.508282 0.673291 0.0898438 1.38645 0.0898438 2.18929V13.7866C0.0898438 15.0005 1.06797 15.9934 2.27016 16C2.27344 16 2.27672 16 2.27994 16C2.65563 16 3.04713 15.8822 3.41279 15.6591C3.70694 15.4796 3.79991 15.0957 3.62044 14.8016C3.44098 14.5074 3.05697 14.4144 2.76291 14.5939C2.59188 14.6982 2.42485 14.7522 2.27688 14.7522C1.82328 14.7497 1.33763 14.3611 1.33763 13.7866V2.18933C1.33763 1.84492 1.51713 1.53907 1.81775 1.3711C2.11841 1.20314 2.47294 1.21064 2.76585 1.39098L12.2159 7.21615C12.4999 7.39102 12.6625 7.68262 12.6618 8.01618C12.6611 8.34971 12.4974 8.64065 12.2118 8.81493L5.37935 12.9983C5.08548 13.1783 4.9931 13.5623 5.17304 13.8562C5.35295 14.1501 5.73704 14.2424 6.03092 14.0625L12.8625 9.87962C13.5166 9.48059 13.9081 8.78496 13.9096 8.01868C13.9112 7.25249 13.5226 6.55524 12.8704 6.15374Z"
                                            fill="currentColor" />
                                    </svg>

                                </div>

                                <img class="rounded shadow-light-lg" style="width:350px;height:200px;"
                                    src="{{ $course_image }}" alt="...">
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-12"></div>
                </div>
            </div>
        </div>


    </div>

    {{-- third sectin  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('transf.course_info_tab') }}
                </h3>

            </div>
            <div class="card-naving">

            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>{{ __('transf.Course Language') }}</th>
                                <td>{{ $course->language() }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('transf.Course Level') }}</th>
                                <td>
                                    {{ $course->skill_level() }}
                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <th> {{ __('transf.Course type') }} </th>
                                <td>{{ $course->course_type() }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('transf.course_category_title') }}</th>
                                <td>{{ $course->courseCategory->title }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('transf.certificate') }}</th>
                                <td>{{ $course->certificate() }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('transf.deadline_of_the_course') }}</th>
                                <td>{{ $course->deadline }}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>{{ __('panel.price') }} </th>
                                <td>{{ $course->price }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('panel.offer_price') }}</th>
                                <td>
                                    {{ $course->offer_price }}
                                </td>
                            </tr>

                            <tr>
                                <th> {{ __('panel.offer_ends') }} </th>
                                <td>{{ $course->offer_ends }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('panel.published_date') }}</th>
                                <td>{{ $course->published_on }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('panel.status') }}</th>
                                <td>{{ $course->status() }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('transf.Descriptional video') }}</th>
                                <td>
                                    <a href="{{ $course->video_description }}">Click here to see</a>

                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    {{-- Course Objective  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('transf.intended_learners') }}
                </h3>

            </div>
            <div class="card-naving">

            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="card-naving pt-3">
                    <h3 class="font-weight-bold text-primary h4">
                        <i class="fa fa-edit"></i>
                        {{ __('transf.what_will_students_learn_in_your_course?') }}
                    </h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            @if ($course->objectives != null && $course->objectives->isNotEmpty())
                                @foreach ($course->objectives as $index => $item)
                                    <tr>
                                        <th style="width: 45px;">{{ $index }} - </th>
                                        <td> {{ $item->title }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="card-naving pt-3">
                    <h3 class="font-weight-bold text-primary h4">
                        <i class="fa fa-edit"></i>
                        {{ __('transf.what_are_the_requirements_or_prerequisites_for_taking_your_course?') }}
                    </h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            @if ($course->requirements != null && $course->requirements->isNotEmpty())
                                @foreach ($course->requirements as $index => $item)
                                    <tr>
                                        <th style="width: 45px;">{{ $index }} - </th>
                                        <td>{{ $item->title }}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>

                <div class="card-naving pt-3">
                    <h3 class="font-weight-bold text-primary h4">
                        <i class="fa fa-edit"></i>
                        {{ __('transf.who_is_this_course_for?') }}
                    </h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            @if ($course->intendeds != null && $course->intendeds->isNotEmpty())
                                @foreach ($course->intendeds as $index => $item)
                                    <tr>
                                        <th style="width: 45px;">{{ $index }} - </th>
                                        <td>{{ $item->title }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>


    {{-- Course Curriculum  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('transf.curriculum') }}
                </h3>

            </div>
            <div class="card-naving">

            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-12">

                @if ($course->sections != null && $course->sections->isNotEmpty())
                    @foreach ($course->sections as $section)
                        <div class="card-naving pt-3">
                            <h3 class="font-weight-bold text-primary h4">
                                <i class="fa fa-edit"></i>
                                {{ $section->title }}
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>Title</th>
                                    <th>Url</th>
                                    <th>Duration</th>
                                </thead>
                                <tbody>
                                    @if ($section->lessons != null && $section->lessons->isNotEmpty())
                                        @foreach ($section->lessons as $lesson)
                                            <tr>
                                                <th>{{ $lesson->title }}</th>
                                                <td> <a href="{{ $lesson->url }}">click here to see video</a></td>
                                                <td> {{ $lesson->duration_minutes }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @endif


            </div>

        </div>


    </div>
@endsection
