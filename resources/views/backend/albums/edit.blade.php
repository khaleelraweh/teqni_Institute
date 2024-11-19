@extends('layouts.admin')

@section('style')
    <style>
        .language-type {
            display: inline-block;
            background-color: #f8f9fa;
            color: black;
            padding: 5px 7px;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_album') }}
                </h3>
                <ul class="breadcrumb pt-2">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            /
                        @else
                            \
                        @endif
                    </li>
                    <li class="ms-1">
                        <a href="{{ route('admin.albums.index') }}">
                            {{ __('panel.show_albums') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        {{-- body part  --}}
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.albums.update', $album->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                            type="button" role="tab" aria-controls="content"
                            aria-selected="true">{{ __('panel.content_tab') }}</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="SEO-tab" data-bs-toggle="tab" data-bs-target="#SEO" type="button"
                            role="tab" aria-controls="SEO" aria-selected="false">{{ __('panel.SEO_tab') }}
                        </button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="content-tab">
                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="title[{{ $key }}]">
                                        {{ __('panel.title') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <input type="text" name="title[{{ $key }}]"
                                        id="title[{{ $key }}]"
                                        value="{{ old('title.' . $key, $album->getTranslation('title', $key)) }}"
                                        class="form-control">
                                    @error('title.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row ">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="description[{{ $key }}]">
                                        {{ __('panel.f_description') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <textarea id="tinymceExample" name="description[{{ $key }}]" rows="10" class="form-control ">{!! old('description.' . $key, $album->getTranslation('description', $key)) !!}</textarea>
                                    @error('description.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="row">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="images">
                                    {{ __('panel.album_profile_image') }}
                                    <span>
                                        <br>
                                        <small> {{ __('panel.best_size') }}</small>
                                        <small> 350 * 250</small>
                                    </span>
                                </label>

                            </div>
                            <div class="col-sm-12 col-md-10">
                                <div class="file-loading">
                                    <input type="file" name="album_profile" id="album_profile"
                                        class="file-input-overview" multiple="multiple">
                                    @error('images')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="images">
                                    {{ __('panel.album_images') }}
                                    <span>
                                        <br>
                                        <small> {{ __('panel.best_size') }}</small>
                                        <small> 350 * 250</small>
                                    </span>
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10">
                                <div class="file-loading">
                                    <input type="file" name="images[]" id="course_images" class="file-input-overview"
                                        multiple="multiple">
                                    @error('images')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="status" class="control-label">
                                    <span>{{ __('panel.status') }}</span>
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <select name="status" class="form-control">
                                    <option value="1" {{ old('status', $album->status) == '1' ? 'selected' : null }}>
                                        {{ __('panel.status_active') }}
                                    </option>
                                    <option value="0" {{ old('status', $album->status) == '0' ? 'selected' : null }}>
                                        {{ __('panel.status_inactive') }}
                                    </option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="SEO" role="tabpanel" aria-labelledby="SEO-tab">
                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-3">
                                    <label for="metadata_title[{{ $key }}]">
                                        {{ __('panel.metadata_title') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-3">
                                    <input type="text" name="metadata_title[{{ $key }}]"
                                        id="metadata_title[{{ $key }}]"
                                        value="{{ old('metadata_title.' . $key, $album->getTranslation('metadata_title', $key)) }}"
                                        class="form-control">
                                    @error('metadata_title.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-3">
                                    <label for="metadata_description[{{ $key }}]">
                                        {{ __('panel.metadata_description') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-3">
                                    <input type="text" name="metadata_description[{{ $key }}]"
                                        id="metadata_description[{{ $key }}]"
                                        value="{{ old('metadata_description.' . $key, $album->getTranslation('metadata_description', $key)) }}"
                                        class="form-control">
                                    @error('metadata_description.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-3">
                                    <label for="metadata_keywords[{{ $key }}]">
                                        {{ __('panel.metadata_keywords') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-3">
                                    <input type="text" name="metadata_keywords[{{ $key }}]"
                                        id="metadata_keywords[{{ $key }}]"
                                        value="{{ old('metadata_keywords.' . $key, $album->getTranslation('metadata_keywords', $key)) }}"
                                        class="form-control">
                                    @error('metadata_keywords.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pt-3">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    {{ __('panel.update_data') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div>



            </form>
        </div>

    </div>

@endsection


@section('script')
    <script>
        $(function() {
            $("#course_images").fileinput({
                theme: "fa5",
                maxFileCount: 200,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($album->photos()->count() > 0)
                        @foreach ($album->photos as $media)
                            "{{ asset('assets/albums/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($album->photos()->count() > 0)
                        @foreach ($album->photos as $media)
                            {
                                caption: "{{ $media->file_name }}",
                                size: '{{ $media->file_size }}',
                                width: "120px",
                                // url : الراوت المستخدم لحذف الصورة
                                url: "{{ route('admin.albums.remove_image', ['image_id' => $media->id, 'album_id' => $album->id, '_token' => csrf_token()]) }}",
                                key: {{ $media->id }}
                            },
                        @endforeach
                    @endif

                ]
            }).on('filesorted', function(event, params) {
                console.log(params.previewId, params.oldIndex, params.newIndex, params.stack);
            });
        });


        $("#album_profile").fileinput({
            theme: "fa5",
            maxFileCount: 1,
            allowedFileTypes: ['image'],
            showCancel: true,
            showRemove: false,
            showUpload: false,
            overwriteInitial: false,
            initialPreview: [
                @if ($album->album_profile != '')
                    "{{ asset('assets/albums/' . $album->album_profile) }}",
                @endif
            ],
            initialPreviewAsData: true,
            initialPreviewFileType: 'image',
            initialPreviewConfig: [
                @if (auth()->user()->user_image != '')
                    {
                        caption: "{{ $album->album_profile }}",
                        size: '1111',
                        width: "120px",
                        url: "{{ route('admin.albums.remove_album_image', ['album_id' => $album->id, '_token' => csrf_token()]) }}",
                        key: {{ $album->id }}
                    }
                @endif
            ]
        });



        $(function() {
            $('.summernote').summernote({
                tabSize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


        });
    </script>
@endsection
