@extends('layouts.admin')

@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-plus-square"></i>
                    {{ __('panel.add_new_slider') }}
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.advertisor_sliders.store') }}" method="post" enctype="multipart/form-data">
                @csrf

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
                                                            value="fas fa-archive" type="text" name="icon">
                                                        <span class="input-group-addon btn btn-primary">
                                                            <i class="fas fa-archive"></i>
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
                                                    id="title[{{ $key }}]" value="{{ old('title.' . $key) }}"
                                                    class="form-control">
                                                @error('title.' . $key)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Slider Subtitle --}}
                                    <div class="row ">
                                        <div class="col-sm-12 pt-3">
                                            <div class="form-group">
                                                <label for="subtitle[{{ $key }}]">
                                                    {{ __('panel.subtitle') }}
                                                    {{ __('panel.in') }} {{ __('panel.' . $key) }}
                                                </label>
                                                <input type="text" name="subtitle[{{ $key }}]"
                                                    id="subtitle[{{ $key }}]"
                                                    value="{{ old('subtitle.' . $key) }}" class="form-control">
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
                                            <textarea name="description[{{ $key }}]" rows="10" class="form-control" id="tinymceExample">{!! old('description.' . $key) !!}</textarea>
                                        </div>
                                    </div>

                                </div>

                                {{-- مرفق الصور  --}}
                                <div class=" {{ $loop->index == 0 ? 'col-md-5' : 'd-none' }}  col-sm-12 ">

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 pt-4">
                                            <label for="images">
                                                {{ __('panel.image') }}
                                                /
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
                                <input type="text" name="btn_title" id="btn_title" value="{{ old('btn_title') }}"
                                    class="form-control" placeholder="">
                                @error('btn_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- url fields --}}
                        <div class="row">
                            <div class="col-md-12 col-sm-12 pt-4">
                                <label for="url">{{ __('panel.url_link') }}</label>
                                <input type="text" name="url" id="url" value="{{ old('url') }}"
                                    class="form-control" placeholder="">
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
                                    <option value="_self" {{ old('target') == '1' ? 'selected' : null }}>
                                        {{ __('panel.in_the_same_tab') }}
                                    </option>
                                    <option value="_blanck" {{ old('target') == '0' ? 'selected' : null }}>
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
                                    <option value="1" {{ old('show_btn_title') == '1' ? 'selected' : null }}>
                                        {{ __('panel.yes') }}
                                    </option>
                                    <option value="0" {{ old('show_btn_title') == '0' ? 'selected' : null }}>
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

                        {{-- publish_start publish time field --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <div class="form-group">
                                    <label for="published_on">{{ __('panel.published_date') }}</label>
                                    <div class="input-group flatpickr" id="flatpickr-datetime">
                                        <input type="text" name="published_on" class="form-control"
                                            placeholder="Select date" data-input>
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

                        {{-- status and featured field --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <label for="status">{{ __('panel.status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ old('status') == '1' ? 'selected' : null }}>
                                        {{ __('panel.status_active') }}
                                    </option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : null }}>
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
                                    <option value="1" {{ old('show_info') == '1' ? 'selected' : null }}>
                                        {{ __('panel.yes') }}
                                    </option>
                                    <option value="0" {{ old('show_info') == '0' ? 'selected' : null }}>
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
                            {{ __('panel.save_data') }}</button>
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
                overwriteInitial: false
            });


        });
    </script>
@endsection
