@extends('layouts.admin')



@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">
        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-plus-square"></i>
                    {{ __('panel.add_new_page') }}
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


                <form action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                                type="button" role="tab" aria-controls="content"
                                aria-selected="true">{{ __('panel.content_tab') }}
                            </button>
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
                                <div class="col-sm-12 col-md-2 pt-3 ">
                                    <label for="category_id">
                                        {{ __('panel.category_title') }}
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">

                                    <select name="page_category_id" class="form-control" id="page_category_id">
                                        <option value="">{{ __('panel.category_name') }} __</option>
                                        @forelse ($page_categories as $page_category)
                                            <option value="{{ $page_category->id }}"
                                                {{ old('page_category_id') == $page_category->id ? 'selected' : null }}>
                                                {{ $page_category->title }}
                                            </option>

                                        @empty
                                        @endforelse
                                    </select>
                                    @error('page_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

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
                                            id="title[{{ $key }}]" value="{{ old('title.' . $key) }}"
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
                                        <textarea id="tinymceExample" name="content[{{ $key }}]" rows="10" class="form-control ">{!! old('content.' . $key) !!}</textarea>
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
                                        <input type="file" name="images[]" id="product_images"
                                            class="file-input-overview" multiple="multiple">
                                    </div>
                                    @error('images')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    {{ __('panel.published_on') }}
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <div class="input-group flatpickr" id="flatpickr-datetime">
                                        <input type="text" name="published_on" value="{{ old('published_on') }}"
                                            class="form-control" placeholder="Select date" data-input>
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
                                            value="1" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_active">
                                            {{ __('panel.status_active') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status"
                                            id="status_inactive" value="0"
                                            {{ old('status') == '0' ? 'checked' : '' }}>
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
                                            value="{{ old('metadata_title.' . $key) }}" class="form-control">
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
                                            value="{{ old('metadata_description.' . $key) }}" class="form-control">
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
                                            value="{{ old('metadata_keywords.' . $key) }}" class="form-control">
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
                                    {{ __('panel.save_data') }}
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

                $("#product_images").fileinput({
                    theme: "fa5",
                    maxFileCount: 5,
                    allowedFileTypes: ['image'],
                    showCancel: true,
                    showRemove: false,
                    showUpload: false,
                    overwriteInitial: false
                });

            });
        </script>

        <script>
            $(function() {
                'use strict';

                const locale = "{{ app()->getLocale() }}";

                // datetime picker
                if ($('#flatpickr-datetime').length) {
                    const defaultDate = "{{ old('published_on') }}" ?
                        "{{ old('published_on') }}" :
                        new Date(); // Set to now if no old date exists

                    flatpickr("#flatpickr-datetime", {
                        enableTime: true,
                        wrap: true,
                        dateFormat: "Y/m/d h:i K",
                        minDate: "today", // Prevent dates before today
                        locale: typeof flatPickrLanguage !== 'undefined' ? flatPickrLanguage : 'en',
                        defaultDate: defaultDate,
                    });
                }
            });
        </script>
    @endsection
