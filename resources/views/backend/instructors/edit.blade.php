@extends('layouts.admin')
@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_instructor') }}
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
                        <a href="{{ route('admin.instructors.index') }}">
                            {{ __('panel.show_instructors') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- body part  --}}
        <div class="card-body">

            {{-- erorrs show is exists --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- enctype used cause we will save images  --}}
            <form action="{{ route('admin.instructors.update', $instructor->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active " id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                            type="button" role="tab" aria-controls="content" aria-selected="true">
                            {{ __('panel.content_tab') }}
                        </button>
                    </li>

                    {{-- motavation tab --}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="motavation-tab" data-bs-toggle="tab" data-bs-target="#motavation"
                            type="button" role="tab" aria-controls="motavation"
                            aria-selected="false">{{ __('panel.motavation_tab') }}
                        </button>
                    </li>

                    {{-- social tab --}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social"
                            type="button" role="tab" aria-controls="social"
                            aria-selected="false">{{ __('panel.social_tab') }}
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="published-tab" data-bs-toggle="tab" data-bs-target="#published"
                            type="button" role="tab" aria-controls="published"
                            aria-selected="false">{{ __('panel.published_tab') }}
                        </button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">

                    {{-- content tab --}}
                    <div class="tab-pane fade active show" id="content" role="tabpanel" aria-labelledby="content-tab">
                        <div class="row">

                            <div class="col-sm-12 col-md-8">

                                <div class="row">
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="first_name"> {{ __('panel.first_name') }}</label>
                                            <input type="text" id="first_name" name="first_name"
                                                value="{{ old('first_name', $instructor->first_name) }}"
                                                class="form-control" placeholder="">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="last_name">{{ __('panel.last_name') }}</label>
                                            <input type="text" id="last_name" name="last_name"
                                                value="{{ old('last_name', $instructor->last_name) }}" class="form-control"
                                                placeholder="">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="username">{{ __('panel.user_name') }}</label>
                                            <input type="text" id="username" name="username"
                                                value="{{ old('username', $instructor->username) }}" class="form-control"
                                                placeholder="">
                                            @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="password">{{ __('panel.user_password') }}</label>
                                            <input type="password" id="password" name="password"
                                                value="{{ old('password') }}" class="form-control" placeholder="">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="email">{{ __('panel.email') }}</label>
                                            <input type="text" id="email" name="email"
                                                value="{{ old('email', $instructor->email) }}" class="form-control"
                                                placeholder="">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="mobile">{{ __('panel.mobile') }}</label>
                                            <input type="text" id="mobile" name="mobile"
                                                value="{{ old('mobile', $instructor->mobile) }}" class="form-control"
                                                placeholder="">
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                {{-- specializations row --}}
                                <div class="row pt-4">
                                    <div class="col-12">
                                        <label for="specializations">{{ __('panel.specializations') }}</label>
                                        <select name="specializations[]" class="form-control select2 child"
                                            multiple="multiple">
                                            @forelse ($specializations as $specialization)
                                                <option value="{{ $specialization->id }}"
                                                    {{ in_array($specialization->id, old('specializations', $instructorSpecializations)) ? 'selected' : null }}>
                                                    {{ $specialization->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>

                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-4">

                                <div class="row pt-4">
                                    <div class="col-12">
                                        <label for="user_image"> {{ __('panel.image') }}

                                            <span><small> ( {{ __('panel.best_size') }}: 250 * 240 )</small></span>

                                        </label>
                                        <br>
                                        <span class="form-text text-muted">{{ __('panel.user_image_size') }} </span>
                                        <div class="file-loading">
                                            <input type="file" name="user_image" id="instructor_image"
                                                value="{{ old('instructor_image') }}" class="file-input-overview ">
                                            <span class="form-text text-muted">{{ __('panel.user_image_size') }} </span>
                                            @error('user_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- motavation content --}}
                    <div class="tab-pane fade a" id="motavation" role="tabpanel" aria-labelledby="motavation-tab">

                        {{-- instructor description field --}}
                        <div class="row">
                            @foreach (config('locales.languages') as $key => $val)
                                <div class="col-sm-12 col-md-6 pt-3">
                                    <label for="description[{{ $key }}]">
                                        {{ __('panel.instructor_description') }}
                                        {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                    </label>
                                    <textarea name="description[{{ $key }}]" style="height: 120px" class="form-control summernote">{!! old('description.' . $key, $instructor->getTranslation('description', $key)) !!}</textarea>
                                    @error('course_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                        {{-- instructor motavation field --}}
                        <div class="row">
                            @foreach (config('locales.languages') as $key => $val)
                                <div class="col-sm-12 col-md-6 pt-3">
                                    <label for="motavation[{{ $key }}]">
                                        {{ __('panel.instructor_motavation') }}
                                        {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                    </label>
                                    <textarea name="motavation[{{ $key }}]" rows="10" style="height: 120px"
                                        class="form-control summernote">{!! old('motavation.' . $key, $instructor->getTranslation('motavation', $key)) !!}</textarea>
                                    @error('course_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endforeach
                        </div>

                    </div>

                    {{-- social content --}}
                    <div class="tab-pane fade a" id="social" role="tabpanel" aria-labelledby="social-tab">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="facebook">{{ __('panel.facebook') }}</label>
                                    <input type="text" id="facebook" name="facebook"
                                        value="{{ old('facebook', $instructor->facebook) }}" class="form-control">
                                    @error('facebook')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="twitter">{{ __('panel.twitter') }}</label>
                                    <input type="text" id="twitter" name="twitter"
                                        value="{{ old('twitter', $instructor->twitter) }}" class="form-control">
                                    @error('twitter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="instagram">{{ __('panel.instagram') }}</label>
                                    <input type="text" id="instagram" name="instagram"
                                        value="{{ old('instagram', $instructor->instagram) }}" class="form-control">
                                    @error('instagram')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 pt-4">
                                <div class="form-group">
                                    <label for="linkedin">{{ __('panel.linkedin') }}</label>
                                    <input type="text" id="linkedin" name="linkedin"
                                        value="{{ old('linkedin', $instructor->linkedin) }}" class="form-control">
                                    @error('linkedin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Published Tab --}}
                    <div class="tab-pane fade" id="published" role="tabpanel" aria-labelledby="published-tab">

                        {{-- published_on and published_on_time  --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <div class="form-group">
                                    <label for="published_on"> {{ __('panel.published_date') }}</label>
                                    <input type="text" id="published_on" name="published_on"
                                        value="{{ old('published_on', \Carbon\Carbon::parse($instructor->published_on)->Format('Y-m-d')) }}"
                                        class="form-control">
                                    @error('published_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <div class="form-group">
                                    <label for="published_on_time">{{ __('panel.published_time') }}</label>
                                    <input type="text" id="published_on_time" name="published_on_time"
                                        value="{{ old('published_on_time', \Carbon\Carbon::parse($instructor->published_on)->Format('h:i A')) }}"
                                        class="form-control">
                                    @error('published_on_time')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 pt-3">
                                <label for="status" class="control-label col-md-2 col-sm-12 ">
                                    <span>{{ __('panel.status') }}</span>
                                </label>
                                <select name="status" class="form-control">
                                    <option value="1"
                                        {{ old('status', $instructor->status) == '1' ? 'selected' : null }}>
                                        {{ __('panel.status_active') }}
                                    </option>
                                    <option value="0"
                                        {{ old('status', $instructor->status) == '0' ? 'selected' : null }}>
                                        {{ __('panel.status_inactive') }}
                                    </option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>



                    <div class="form-group pt-4">
                        <button type="submit" name="submit" class="btn btn-primary">
                            {{ __('panel.update_data') }}
                        </button>
                    </div>

                </div>

            </form>
        </div>

    </div>

@endsection

@section('script')
    {{-- #user_image is the id in file input file above  --}}
    <script>
        $(function() {
            $("#instructor_image").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($instructor->user_image != '')
                        "{{ asset('assets/instructors/' . $instructor->user_image) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($instructor->user_image != '')
                        {
                            caption: "{{ $instructor->user_image }}",
                            size: '1111',
                            width: "120px",
                            url: "{{ route('admin.instructors.remove_image', ['instructor_id' => $instructor->id, '_token' => csrf_token()]) }}",
                            key: {{ $instructor->id }}
                        }
                    @endif
                ]
            });

            // ======= start pickadate codeing  for start and end date ===========
            $('#published_on').pickadate({
                format: 'yyyy-mm-dd',
                min: new Date(),
                selectMonths: true, // Creates a dropdown to control month
                selectYears: true, // creates a dropdown to control years
                clear: 'Clear',
                close: 'OK',
                colseOnSelect: true // Close Upon Selecting a date
            });
            var publishedOn = $('#published_on').pickadate(
                'picker'); // set startdate in the picker to the start date in the #start_date elemet
            $('#published_on').change(function() {
                selected_ci_date = "";
                selected_ci_date = now() // make selected start date in picker = start_date value  

            });

            $('#published_on_time').pickatime({
                clear: ''
            });

            // ======= End pickadate codeing for publish start and end date  ===========


        });
    </script>
@endsection
