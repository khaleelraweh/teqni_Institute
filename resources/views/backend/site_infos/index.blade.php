@extends('layouts.admin')
@php
    use App\Models\SiteSetting;
@endphp

@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_site_settings') }}

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
                        {{ __('panel.show_site_information') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto d-none">
                @ability('admin', 'create_main_sliders')
                    <a href="{{ route('admin.main_sliders.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_site_information') }}</span>
                    </a>
                @endability
            </div>

        </div>

        {{-- body part  --}}
        <div class="card-body">

            <form action="{{ route('admin.settings.site_main_infos.update', 1) }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                            type="button" role="tab" aria-controls="content"
                            aria-selected="true">{{ __('panel.content_tab') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="logo-tab" data-bs-toggle="tab" data-bs-target="#logo" type="button"
                            role="tab" aria-controls="logo" aria-selected="false">{{ __('panel.logo_tab') }}
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade active show" id="content" role="tabpanel" aria-labelledby="content-tab">

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">

                                    <label for="site_name_{{ $key }}">
                                        {{ __('panel.site_name') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-10 pt-3">
                                    <input type="text" id="site_name_{{ $key }}"
                                        name=" site_name[{{ $key }}]"
                                        value="{{ old('site_name.' . $key, $siteSettings['site_name']->getTranslation('value', $key)) }}"
                                        class="form-control">
                                    @error('site_name.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="site_short_name_{{ $key }}">
                                        {{ __('panel.site_short_name') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <input type="text" id="site_short_name_{{ $key }}"
                                        name="site_short_name[{{ $key }}]"
                                        value="{{ old('site_short_name.' . $key, $siteSettings['site_short_name']->getTranslation('value', $key)) }}"
                                        class="form-control" placeholder="{{ $siteSettings['site_short_name']->key }}">
                                    @error('site_short_name.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="site_address_{{ $key }}">
                                        {{ __('panel.site_address') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <input type="text" id="site_address_{{ $key }}"
                                        name="site_address[{{ $key }}]"
                                        value="{{ old('site_address.' . $key, $siteSettings['site_address']->getTranslation('value', $key)) }}"
                                        class="form-control" placeholder="{{ $siteSettings['site_address']->key }}">
                                    @error('site_address.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row ">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="site_description_{{ $key }}">
                                        {{ __('panel.f_description') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <textarea id="tinymceExample" name="site_description[{{ $key }}]" rows="10" class="form-control ">{!! old('site_description.' . $key, $siteSettings['site_description']->getTranslation('value', $key)) !!}</textarea>
                                    @error('site_description.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="site_link_{{ $key }}">
                                        {{ __('panel.site_link') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <input type="text" id="site_link_{{ $key }}"
                                        name="site_link[{{ $key }}]"
                                        value="{{ old('site_link.' . $key, $siteSettings['site_link']->getTranslation('value', $key)) }}"
                                        class="form-control">
                                    @error('site_link.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                        @endforeach

                        @foreach (config('locales.languages') as $key => $val)
                            <div class="row">
                                <div class="col-sm-12 col-md-2 pt-3">
                                    <label for="site_workTime_{{ $key }}">
                                        {{ __('panel.site_workTime') }}
                                        <span class="language-type">
                                            <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                            {{ __('panel.' . $key) }}
                                        </span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-10 pt-3">
                                    <input type="text" id="site_workTime_{{ $key }}"
                                        name="site_workTime[{{ $key }}]"
                                        value="{{ old('site_workTime.' . $key, $siteSettings['site_workTime']->getTranslation('value', $key)) }}"
                                        class="form-control" placeholder="{{ $siteSettings['site_workTime']->key }}">
                                    @error('site_workTime.' . $key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach


                        <hr>

                        <div class="row ">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="{{ $siteSettings['site_img']->key }}">
                                    {{ __('panel.site_img') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <div class="file-loading">
                                    <input type="file" name="{{ $siteSettings['site_img']->key }}"
                                        id="customer_image" class="file-input-overview ">
                                    <span class="form-text text-muted">Image width should be 500px x 500px </span>
                                    @error($siteSettings['site_img']->key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Site album  --}}
                        <div class="row">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="images">
                                    {{ __('panel.site_album') }}
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
                    </div>

                    <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">

                        <div class="row ">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="{{ $siteSettings['site_logo_large_light']->key }}">
                                    {{ __('panel.site_logo_large_light') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <div class="file-loading">
                                    <input type="file" name="{{ $siteSettings['site_logo_large_light']->key }}"
                                        id="site_logo_large_light" class="file-input-overview ">
                                    <span class="form-text text-muted">Image width should be 500px x 500px </span>
                                    @error($siteSettings['site_logo_large_light']->key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="{{ $siteSettings['site_logo_small_light']->key }}">
                                    {{ __('panel.site_logo_small_light') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <div class="file-loading">
                                    <input type="file" name="{{ $siteSettings['site_logo_small_light']->key }}"
                                        id="site_logo_small_light" class="file-input-overview ">
                                    <span class="form-text text-muted">Image width should be 500px x 500px </span>
                                    @error($siteSettings['site_logo_small_light']->key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row ">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="{{ $siteSettings['site_logo_large_dark']->key }}">
                                    {{ __('panel.site_logo_large_dark') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <div class="file-loading">
                                    <input type="file" name="{{ $siteSettings['site_logo_large_dark']->key }}"
                                        id="site_logo_large_dark" class="file-input-overview ">
                                    <span class="form-text text-muted">Image width should be 500px x 500px </span>
                                    @error($siteSettings['site_logo_large_dark']->key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="{{ $siteSettings['site_logo_small_dark']->key }}">
                                    {{ __('panel.site_logo_small_dark') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <div class="file-loading">
                                    <input type="file" name="{{ $siteSettings['site_logo_small_dark']->key }}"
                                        id="site_logo_small_dark" class="file-input-overview ">
                                    <span class="form-text text-muted">Image width should be 500px x 500px </span>
                                    @error($siteSettings['site_logo_small_dark']->key)
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                    </div>


                </div>

                @ability('admin', 'update_site_infos')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pt-3 mx-3">
                                <button type="submit" name="submit" class="btn btn-primary"> {{ __('panel.update_data') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endability

            </form>

        </div>

    </div>
@endsection


@section('script')
    <script>
        $(function() {

            $("#customer_image").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($siteSettings['site_img']->value != null)
                        "{{ asset('assets/site_settings/' . $siteSettings['site_img']->value) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($siteSettings['site_img']->value != null)
                        {
                            caption: "{{ $siteSettings['site_img']->value }}",
                            size: '1111',
                            width: "120px",
                            url: "{{ route('admin.site_infos.remove_image', ['site_info_id' => $siteSettings['site_img']->id, '_token' => csrf_token()]) }}",
                            key: {{ $siteSettings['site_img']->id }}
                        }
                    @endif
                ]
            });

            //-------------------Albums --------------


            $("#course_images").fileinput({
                theme: "fa5",
                maxFileCount: 6,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($site_album->photos()->count() > 0)
                        @foreach ($site_album->photos as $media)
                            "{{ asset('assets/site_settings/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($site_album->photos()->count() > 0)
                        @foreach ($site_album->photos as $media)
                            {
                                caption: "{{ $media->file_name }}",
                                size: '{{ $media->file_size }}',
                                width: "120px",
                                // url : الراوت المستخدم لحذف الصورة
                                url: "{{ route('admin.site_infos.remove_site_settings_albums', ['image_id' => $media->id, 'site_album_id' => $site_album->id, '_token' => csrf_token()]) }}",
                                key: {{ $media->id }}
                            },
                        @endforeach
                    @endif

                ]
            }).on('filesorted', function(event, params) {
                console.log(params.previewId, params.oldIndex, params.newIndex, params.stack);
            });


            //-----------------------------------------------

            // for logos large light 
            $("#site_logo_large_light").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($siteSettings['site_logo_large_light']->value != null)
                        "{{ asset('assets/site_settings/' . $siteSettings['site_logo_large_light']->value) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($siteSettings['site_logo_large_light']->value != null)
                        {
                            caption: "{{ $siteSettings['site_logo_large_light']->value }}",
                            size: '1111',
                            width: "120px",
                            url: "{{ route('admin.site_infos.remove_site_logo_large_light', ['site_info_id' => $siteSettings['site_logo_large_light']->id, '_token' => csrf_token()]) }}",
                            key: {{ $siteSettings['site_logo_large_light']->id }}
                        }
                    @endif
                ]
            });

            // for small light 
            $("#site_logo_small_light").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($siteSettings['site_logo_small_light']->value != null)
                        "{{ asset('assets/site_settings/' . $siteSettings['site_logo_small_light']->value) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($siteSettings['site_logo_small_light']->value != null)
                        {
                            caption: "{{ $siteSettings['site_logo_small_light']->value }}",
                            size: '1111',
                            width: "120px",
                            url: "{{ route('admin.site_infos.remove_site_logo_small_light', ['site_info_id' => $siteSettings['site_logo_small_light']->id, '_token' => csrf_token()]) }}",
                            key: {{ $siteSettings['site_logo_small_light']->id }}
                        }
                    @endif
                ]
            });

            //------------------------------------------------

            //for large dark 
            $("#site_logo_large_dark").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($siteSettings['site_logo_large_dark']->value != null)
                        "{{ asset('assets/site_settings/' . $siteSettings['site_logo_large_dark']->value) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($siteSettings['site_logo_large_dark']->value != null)
                        {
                            caption: "{{ $siteSettings['site_logo_large_dark']->value }}",
                            size: '1111',
                            width: "120px",
                            url: "{{ route('admin.site_infos.remove_site_logo_large_dark', ['site_info_id' => $siteSettings['site_logo_large_dark']->id, '_token' => csrf_token()]) }}",
                            key: {{ $siteSettings['site_logo_large_dark']->id }}
                        }
                    @endif
                ]
            });

            // for small light 
            $("#site_logo_small_dark").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($siteSettings['site_logo_small_dark']->value != null)
                        "{{ asset('assets/site_settings/' . $siteSettings['site_logo_small_dark']->value) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($siteSettings['site_logo_small_dark']->value != null)
                        {
                            caption: "{{ $siteSettings['site_logo_small_dark']->value }}",
                            size: '1111',
                            width: "120px",
                            url: "{{ route('admin.site_infos.remove_site_logo_small_dark', ['site_info_id' => $siteSettings['site_logo_small_dark']->id, '_token' => csrf_token()]) }}",
                            key: {{ $siteSettings['site_logo_small_dark']->id }}
                        }
                    @endif
                ]
            });




        });
    </script>
@endsection
