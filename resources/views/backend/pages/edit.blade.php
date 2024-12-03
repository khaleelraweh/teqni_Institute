@extends('layouts.admin')

@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_page') }}
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
                        <a href="{{ route('admin.pages.index') }}">
                            {{ __('panel.show_pages') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        {{-- body part  --}}
        <div class="card-body">

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger pt-0 pb-0 mb-0">
                        <ul class="px-2 py-3 m-0" style="list-style-type: circle">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.pages.update', $page->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                                type="button" role="tab" aria-controls="content"
                                aria-selected="true">{{ __('panel.content_tab') }}</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="SEO-tab" data-bs-toggle="tab" data-bs-target="#SEO"
                                type="button" role="tab" aria-controls="SEO"
                                aria-selected="false">{{ __('panel.SEO_tab') }}
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="content-tab">

                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="category_id"> {{ __('panel.category_title') }}</label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <select name="page_category_id" class="form-control">
                                        <option value=""> {{ __('panel.category_name') }} __ </option>
                                        @forelse ($page_categories as $page_category)
                                            <option value="{{ $page_category->id }}"
                                                {{ old('page_category_id', $page->page_category_id) == $page_category->id ? 'selected' : null }}>
                                                {{ $page_category->title }} </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            @foreach (config('locales.languages') as $key => $val)
                                <div class="row ">
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
                                            value="{{ old('title.' . $key, $page->getTranslation('title', $key)) }}"
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
                                        <label for="content[{{ $key }}]">
                                            {{ __('panel.f_content') }}
                                            <span class="language-type">
                                                <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                    title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                                {{ __('panel.' . $key) }}
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-10 pt-3">
                                        <textarea id="tinymceExample" name="content[{{ $key }}]" rows="10" class="form-control ">{!! old('content.' . $key, $page->getTranslation('content', $key)) !!}</textarea>
                                        @error('content.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                            @endforeach

                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="images">
                                        {{ __('panel.image') }} / {{ __('panel.images') }}
                                        <span>
                                            <br>
                                            <small> {{ __('panel.best_size') }}</small>
                                            <small> 350 * 250</small>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
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
                                    {{ __('panel.published_on') }}
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <div class="input-group flatpickr" id="flatpickr-datetime">
                                        <input type="text" name="published_on" class="form-control"
                                            placeholder="Select date" data-input
                                            value="{{ old('published_on', $page->published_on ? \Carbon\Carbon::parse($page->published_on)->format('Y/m/d h:i A') : '') }}">
                                        <span class="input-group-text input-group-addon" data-toggle>
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </div>
                                    @error('published_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="status" class="control-label">
                                        <span>{{ __('panel.status') }}</span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status" id="status_active"
                                            value="1" {{ old('status', $page->status) == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_active">
                                            {{ __('panel.status_active') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status"
                                            id="status_inactive" value="0"
                                            {{ old('status', $page->status) == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_inactive">
                                            {{ __('panel.status_inactive') }}
                                        </label>
                                    </div>
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
                                            value="{{ old('metadata_title.' . $key, $page->getTranslation('metadata_title', $key)) }}"
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
                                            value="{{ old('metadata_description.' . $key, $page->getTranslation('metadata_description', $key)) }}"
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
                                            value="{{ old('metadata_keywords.' . $key, $page->getTranslation('metadata_keywords', $key)) }}"
                                            class="form-control">
                                        @error('metadata_keywords.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="row">
                            <div class="col-sm-12 col-md-2 pt-3 d-none d-md-block">
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="icon-lg  me-2" data-feather="corner-down-left"></i>
                                    {{ __('panel.update_data') }}
                                </button>

                                <a href="{{ route('admin.pages.index') }}" name="submit"
                                    class=" btn btn-outline-danger">
                                    <i class="icon-lg  me-2" data-feather="x"></i>
                                    {{ __('panel.cancel') }}
                                </a>

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
                    maxFileCount: 5,
                    allowedFileTypes: ['image'],
                    showCancel: true,
                    showRemove: false,
                    showUpload: false,
                    overwriteInitial: false,
                    // اضافات للتعامل مع الصورة عند التعديل علي احد اقسام المنتجات
                    // delete images from photos and assets/products 
                    // because there are maybe more than one image we will go for each image and show them in the edit page 
                    initialPreview: [
                        @if ($page->photos()->count() > 0)
                            @foreach ($page->photos as $media)
                                "{{ asset('assets/pages/' . $media->file_name) }}",
                            @endforeach
                        @endif
                    ],
                    initialPreviewAsData: true,
                    initialPreviewFileType: 'image',
                    initialPreviewConfig: [
                        @if ($page->photos()->count() > 0)
                            @foreach ($page->photos as $media)
                                {
                                    caption: "{{ $media->file_name }}",
                                    size: '{{ $media->file_size }}',
                                    width: "120px",
                                    // url : الراوت المستخدم لحذف الصورة
                                    url: "{{ route('admin.pages.remove_image', ['image_id' => $media->id, 'page_id' => $page->id, '_token' => csrf_token()]) }}",
                                    key: {{ $media->id }}
                                },
                            @endforeach
                        @endif

                    ]
                }).on('filesorted', function(event, params) {
                    console.log(params.previewId, params.oldIndex, params.newIndex, params.stack);
                });
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

                // when change date 
                $('#published_on').change(function() {
                    selected_ci_date = "";
                    selected_ci_date = now() // make selected start date in picker = start_date value  

                });

                $('#published_on_time').pickatime({
                    clear: ''
                });

            });
        </script>
    @endsection
