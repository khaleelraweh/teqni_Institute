@extends('layouts.admin')

@section('style')
    <style>
        .select2-container {
            display: block !important;
        }

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
                    <i class="fa fa-plus-square"></i>
                    {{ __('panel.add_new_news') }}

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
                        <a href="{{ route('admin.news.index') }}">
                            {{ __('panel.show_news') }}
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
            <form action="{{ route('admin.news.store') }}" method="post" enctype="multipart/form-data">
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
                                        id="title[{{ $key }}]" value="{{ old('title.' . $key) }}"
                                        class="form-control">
                                    @error('title.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
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
                                    <textarea name="content[{{ $key }}]" id="tinymceExample" rows="10" class="form-control">{!! old('content.' . $key) !!}</textarea>
                                    @error('content.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        {{--  tags field --}}
                        <div class="row ">
                            {{-- Tags field  --}}
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="tags">{{ __('panel.tags') }}</label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <select name="tags[]" class="form-control select2" multiple="multiple">
                                    @forelse ($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', [])) ? 'selected' : null }}>
                                            {{ $tag->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="row ">
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
                                    <input type="file" name="images[]" id="product_images" class="file-input-overview"
                                        multiple="multiple">
                                </div>
                                @error('images')
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
    {{-- Call select2 plugin --}}

    <script>
        $(function() {

            //select2: code to search in data 
            function matchStart(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Skip if there is no 'children' property
                if (typeof data.children === 'undefined') {
                    return null;
                }

                // `data.children` contains the actual options that we are matching against
                var filteredChildren = [];
                $.each(data.children, function(idx, child) {
                    if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        filteredChildren.push(child);
                    }
                });

                // If we matched any of the timezone group's children, then set the matched children on the group
                // and return the group object
                if (filteredChildren.length) {
                    var modifiedData = $.extend({}, data, true);
                    modifiedData.children = filteredChildren;

                    // You can return modified objects from here
                    // This includes matching the `children` how you want in nested data sets
                    return modifiedData;
                }

                // Return `null` if the term should not be displayed
                return null;
            }

            // select2 : .select2 : is  identifier used with element to be effected
            $(".select2").select2({
                tags: true,
                colseOnSelect: false,
                minimumResultsForSearch: Infinity,
                matcher: matchStart
            });

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
@endsection
