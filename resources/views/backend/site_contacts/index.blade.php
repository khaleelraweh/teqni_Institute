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
                        {{ __('panel.show_site_contact') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto d-none">
                @ability('admin', 'create_main_sliders')
                    <a href="{{ route('admin.main_sliders.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_site_contact') }}</span>
                    </a>
                @endability
            </div>

        </div>

        {{-- body part  --}}
        <div class="card-body">

            <form action="{{ route('admin.settings.site_contacts.update', 2) }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="content-tab" data-toggle="tab" href="#content" role="tab"
                            aria-controls="content" aria-selected="true"> {{ __('panel.content_tab') }} </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade active show" id="content" role="tabpanel" aria-labelledby="content-tab">

                        @php
                            static $counter = 1;
                        @endphp

                        @foreach ($siteSettings as $item)
                            @if ($item->section == 2)
                                <div class="row">

                                    <div class="col-sm-12 col-md-2 pt-3">

                                        <label for="{{ $item->key }}"> {{ __('panel.' . $item->key) }} </label>
                                    </div>
                                    <div class="col-sm-12 col-md-10 pt-3">
                                        <input type="text" id="{{ $item->key }}" name="{{ $item->key }}"
                                            value="{{ old($item->key, $item->value) }}" class="form-control"
                                            placeholder="{{ $item->key }}">
                                        @error('{{ $item->key }}')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                </div>
                            @endif
                        @endforeach





                    </div>


                </div>

                @ability('admin', 'update_site_contacts')
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
