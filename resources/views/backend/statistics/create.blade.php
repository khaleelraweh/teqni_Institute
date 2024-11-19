@extends('layouts.admin')

@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-plus-square"></i>
                    {{ __('panel.add_new_statistic') }}
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
                        <a href="{{ route('admin.statistics.index') }}">
                            {{ __('panel.show_statistics') }}
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

            <form action="{{ route('admin.statistics.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                            type="button" role="tab" aria-controls="content"
                            aria-selected="true">{{ __('panel.content_tab') }}
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="SEO-tab" data-bs-toggle="tab" data-bs-target="#SEO" type="button"
                            role="tab" aria-controls="SEO" aria-selected="false">{{ __('panel.SEO_tab') }}
                        </button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="content-tab">

                        <div class="row ">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="icon">
                                    {{ __('panel.choose_icon') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
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

                        <div class="row">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="statistic_number">{{ __('panel.statistic_number') }}</label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <input type="number" name="statistic_number" id="statistic_number"
                                    value="{{ old('statistic_number') }}" class="form-control" placeholder="">
                                @error('statistic_number')
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

                        <div class="row">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="images">
                                    {{ __('panel.statistic_image') }}
                                    <span>
                                        <br>
                                        <small> {{ __('panel.best_size') }}</small>
                                        <small> 350 * 250</small>

                                    </span>

                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <div class="file-loading">
                                    <input type="file" name="statistic_image" id="statistic_image"
                                        class="file-input-overview">
                                </div>
                                @error('images')
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
                        <div class="col-md-12">
                            <div class="form-group pt-3 ">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    {{ __('panel.save_data') }}
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

            $("#statistic_image").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            });

        });
    </script>
@endsection
