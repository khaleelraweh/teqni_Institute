<?php use Carbon\Carbon; ?>
@extends('layouts.admin')

@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_adv_slider') }}
                </h3>
                <ul class="breadcrumb pt-3">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            /
                        @else
                            \
                        @endif
                    </li>
                    <li class="ms-1">
                        <a href="{{ route('admin.advertisor_sliders.index') }}">
                            {{ __('panel.show_adv_slider') }}
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
            <form action="{{ route('admin.advertisor_sliders.update', $advertisorSlider->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach (config('locales.languages') as $key => $val)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->index == 0 ? 'active' : '' }}" id="{{ $key }}-tab"
                                data-bs-toggle="tab" data-bs-target="#{{ $key }}" type="button" role="tab"
                                aria-controls="{{ $key }}" aria-selected="true">
                                {{ __('panel.content_tab') }} {{ __('panel.in') }} ({{ __('panel.' . $key) }})
                            </button>
                        </li>
                    @endforeach

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url" type="button"
                            role="tab" aria-controls="url" aria-selected="true">{{ __('panel.url_tab') }}
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
                    {{-- Content Tab --}}

                    @foreach (config('locales.languages') as $key => $val)
                        <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : '' }}" id="{{ $key }}"
                            role="tabpanel" aria-labelledby="{{ $key }}">

                            <div class="row">

                                {{-- البيانات الاساسية --}}
                                <div class=" {{ $loop->index == 0 ? 'col-md-7' : '' }} col-sm-12 ">

                                    @if ($loop->first)
                                        <div class="row ">
                                            <div class="col-sm-12 pt-3">
                                                <div class="form-group">
                                                    <label for="icon"> {{ __('panel.choose_icon') }} </label>

                                                    <div class="input-group iconpicker-container ">
                                                        <input data-placement="bottomRight"
                                                            class="form-control icp icp-auto iconpicker-element iconpicker-input icon-picker form-control"
                                                            value=" {{ old('icon', $advertisorSlider->icon) ?? 'fas fa-archive' }}"
                                                            type="text" name="icon">
                                                        <span class="input-group-addon btn btn-primary">
                                                            <i
                                                                class="{{ $advertisorSlider->icon ?? 'fas fa-archive' }}"></i>
                                                        </span>
                                                    </div>

                                                    @error('icon')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- slider title field --}}
                                    <div class="row ">
                                        <div class="col-sm-12 pt-3">
                                            <div class="form-group">
                                                <label for="title[{{ $key }}]">
                                                    {{ __('panel.title') }}
                                                    {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                                </label>
                                                <input type="text" name="title[{{ $key }}]"
                                                    id="title[{{ $key }}]"
                                                    value="{{ old('title.' . $key, $advertisorSlider->getTranslation('title', $key)) }}"
                                                    class="form-control">
                                                @error('title.' . $key)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- slider subtitle field --}}
                                    <div class="row ">
                                        <div class="col-sm-12 pt-3">
                                            <div class="form-group">
                                                <label for="subtitle[{{ $key }}]">
                                                    {{ __('panel.subtitle') }}
                                                    {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                                </label>
                                                <input type="text" name="subtitle[{{ $key }}]"
                                                    id="subtitle[{{ $key }}]"
                                                    value="{{ old('subtitle.' . $key, $advertisorSlider->getTranslation('subtitle', $key)) }}"
                                                    class="form-control">
                                                @error('subtitle.' . $key)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{--  description field --}}
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 pt-4">
                                            <label for="description[{{ $key }}]">
                                                {{ __('panel.description') }}
                                                {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                            </label>
                                            <textarea name="description[{{ $key }}]" rows="10" class="form-control" id="tinymceExample">{!! old('description.' . $key, $advertisorSlider->getTranslation('description', $key)) !!}</textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- مرفق الصور  --}}
                                <div class=" {{ $loop->index == 0 ? 'col-md-5' : 'd-none' }}  col-sm-12 ">

                                    <div class="row pt-4">
                                        <div class="col-12">
                                            <label for="images">{{ __('panel.image') }}/
                                                {{ __('panel.images') }}
                                                <span><small> ( {{ __('panel.best_size') }}: 1920 * 960 )</small></span>

                                            </label>

                                            <br>
                                            <div class="file-loading">
                                                <input type="file" name="images[]" id="slider_images"
                                                    class="file-input-overview" multiple="multiple">
                                                @error('images')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach

                    {{-- url Tab --}}
                    <div class="tab-pane fade" id="url" role="tabpanel" aria-labelledby="url-tab">


                        {{-- url browse button link --}}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 pt-4">
                                <label for="btn_title">{{ __('panel.browse_button_title') }}</label>
                                <input type="text" name="btn_title" id="btn_title"
                                    value="{{ old('btn_title', $advertisorSlider->btn_title) }}" class="form-control"
                                    placeholder="">
                                @error('btn_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- url fields --}}
                        <div class="row">
                            {{-- url field --}}
                            <div class="col-md-12 col-sm-12 pt-4">
                                <label for="url">{{ __('panel.url_link') }}</label>
                                <input type="text" name="url" id="url"
                                    value="{{ old('url', $advertisorSlider->url) }}" class="form-control"
                                    placeholder="http://youtlinks.com ">
                                @error('url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{--  target  fields --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4 pt-4">
                                <label for="target">{{ __('panel.url_target') }} </label>
                                <select name="target" class="form-control">
                                    <option value="_self"
                                        {{ old('target', $advertisorSlider->target) == '_self' ? 'selected' : null }}>
                                        {{ __('panel.in_the_same_tab') }}
                                    </option>
                                    <option value="_blank"
                                        {{ old('target', $advertisorSlider->target) == '_blank' ? 'selected' : null }}>
                                        {{ __('panel.in_new_tab') }}
                                    </option>
                                </select>
                                @error('target')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- show info field --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <label for="show_btn_title">{{ __('panel.show_browsing_button') }}</label>
                                <select name="show_btn_title" class="form-control">
                                    <option value="1"
                                        {{ old('show_btn_title', $advertisorSlider->show_btn_title) == '1' ? 'selected' : null }}>
                                        {{ __('panel.yes') }}
                                    </option>
                                    <option value="0"
                                        {{ old('show_btn_title', $advertisorSlider->show_btn_title) == '0' ? 'selected' : null }}>
                                        {{ __('panel.no') }}
                                    </option>
                                </select>
                                @error('show_btn_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    {{-- Published Tab --}}
                    <div class="tab-pane fade" id="published" role="tabpanel" aria-labelledby="published-tab">

                        {{-- published_on   --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <div class="form-group">
                                    <label for="published_on"> {{ __('panel.published_date') }}</label>
                                    <div class="input-group flatpickr" id="flatpickr-datetime">
                                        <input type="text" name="published_on" class="form-control"
                                            placeholder="Select date" data-input
                                            value="{{ old('published_on', Carbon::parse($advertisorSlider->published_on)->format('Y/m/d h:i A')) }}">
                                        <span class="input-group-text input-group-addon" data-toggle>
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </div>
                                    @error('published_on')
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
                                        {{ old('status', $advertisorSlider->status) == '1' ? 'selected' : null }}>
                                        {{ __('panel.status_active') }}
                                    </option>
                                    <option value="0"
                                        {{ old('status', $advertisorSlider->status) == '0' ? 'selected' : null }}>
                                        {{ __('panel.status_inactive') }}
                                    </option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- show info field --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <label for="show_info">{{ __('panel.show_slider_info') }}</label>
                                <select name="show_info" class="form-control">
                                    <option value="1"
                                        {{ old('show_info', $advertisorSlider->show_info) == '1' ? 'selected' : null }}>
                                        {{ __('panel.yes') }}
                                    </option>
                                    <option value="0"
                                        {{ old('show_info', $advertisorSlider->show_info) == '0' ? 'selected' : null }}>
                                        {{ __('panel.no') }}
                                    </option>
                                </select>
                                @error('show_info')
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
    <script>
        $(function() {

            $("#slider_images").fileinput({
                theme: "fa5",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                // اضافات للتعامل مع الصورة عند التعديل علي احد اقسام المنتجات
                // delete images from photos and assets/sliders 
                // because there are maybe more than one image we will go for each image and show them in the edit page 
                initialPreview: [
                    @if ($advertisorSlider->photos()->count() > 0)
                        @foreach ($advertisorSlider->photos as $media)
                            "{{ asset('assets/advertisor_sliders/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($advertisorSlider->photos()->count() > 0)
                        @foreach ($advertisorSlider->photos as $media)
                            {
                                caption: "{{ $media->file_name }}",
                                size: '{{ $media->file_size }}',
                                width: "120px",
                                // url : الراوت المستخدم لحذف الصورة
                                url: "{{ route('admin.advertisor_sliders.remove_image', ['image_id' => $media->id, 'slider_id' => $advertisorSlider->id, '_token' => csrf_token()]) }}",
                                key: {{ $media->id }}
                            },
                        @endforeach
                    @endif

                ]
            }).on('filesorted', function(event, params) {
                console.log(params.previewId, params.oldIndex, params.newIndex, params.stack);
            });
        });
    </script>
@endsection
