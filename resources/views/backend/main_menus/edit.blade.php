@extends('layouts.admin')

@section('content')
    {{-- main holder mainMenu  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_main_menu_item') }}
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
                        <a href="{{ route('admin.main_menus.index') }}">
                            {{ __('panel.show_main_menus') }}
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

                <form action="{{ route('admin.main_menus.update', $mainMenu->id) }}" method="post">
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
                                <div class="col-sm-12 col-md-3 pt-3">
                                    <label for="parent_id" class="control-label">
                                        <span>{{ __('panel.category_menu') }}</span>
                                    </label>
                                </div>

                                <div class="col-sm-12 col-md-9 pt-3">

                                    <select name="parent_id" class="form-control">
                                        <option value="">{{ __('panel.main_category') }} __</option>

                                        @foreach ($main_menus->where('section', 1) as $main_menu)
                                            @if (count($main_menu->appearedChildren) == false)
                                                <option style="color: black;font-weight: bold;font-size:18px;"
                                                    value="{{ $main_menu->id }}"
                                                    {{ old('parent_id', $mainMenu->parent_id) == $main_menu->id ? 'selected' : null }}>
                                                    {{ $main_menu->title }}
                                                </option>
                                            @else
                                                <option style="color: black;font-weight: bold;font-size:18px;"
                                                    value="{{ $main_menu->id }}"
                                                    {{ old('parent_id', $mainMenu->parent_id) == $main_menu->id ? 'selected' : null }}>
                                                    {{ $main_menu->title }}
                                                </option>
                                                @if ($main_menu->appearedChildren !== null && count($main_menu->appearedChildren) > 0)
                                                    @foreach ($main_menu->appearedChildren as $sub_menu)
                                                        @if (count($sub_menu->appearedChildren) == false)
                                                            <option style="color:blue;font-weight:bold;font-size:15px;"
                                                                value="{{ $sub_menu->id }}"
                                                                {{ old('parent_id', $mainMenu->parent_id) == $sub_menu->id ? 'selected' : null }}>
                                                                &nbsp; &nbsp; &nbsp;{{ $sub_menu->title }}
                                                            </option>
                                                        @else
                                                            <option style="color:blue;font-weight:bold;font-size:15px;"
                                                                value="{{ $sub_menu->id }}"
                                                                {{ old('parent_id', $mainMenu->parent_id) == $sub_menu->id ? 'selected' : null }}>
                                                                &nbsp; &nbsp; &nbsp;{{ $sub_menu->title }}
                                                            </option>
                                                            @if ($sub_menu->appearedChildren !== null && count($sub_menu->appearedChildren) > 0)
                                                                @foreach ($sub_menu->appearedChildren as $sub_menu_2)
                                                                    <option style="font-size: 14px;"
                                                                        value="{{ $sub_menu_2->id }}"
                                                                        {{ old('parent_id', $mainMenu->parent_id) == $sub_menu_2->id ? 'selected' : null }}>
                                                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                                                        &nbsp;{{ $sub_menu_2->title }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            @foreach (config('locales.languages') as $key => $val)
                                <div class="row ">
                                    <div class="col-sm-12 col-md-3 pt-3">
                                        <label for="title[{{ $key }}]">
                                            {{ __('panel.title') }}
                                            <span class="language-type">
                                                <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                    title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                                {{ __('panel.' . $key) }}
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-9 pt-3">
                                        <input type="text" name="title[{{ $key }}]"
                                            id="title[{{ $key }}]"
                                            value="{{ old('title.' . $key, $mainMenu->getTranslation('title', $key)) }}"
                                            class="form-control">
                                        @error('title.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>
                            @endforeach


                            @foreach (config('locales.languages') as $key => $val)
                                <div class="row ">
                                    <div class="col-sm-12 col-md-3 pt-3">
                                        <label for="description[{{ $key }}]">
                                            {{ __('panel.f_description') }}
                                            <span class="language-type">
                                                <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                    title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                                {{ __('panel.' . $key) }}
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-9 pt-3">
                                        <textarea id="tinymceExample" name="description[{{ $key }}]" rows="10" class="form-control ">{!! old('description.' . $key, $mainMenu->getTranslation('description', $key)) !!}</textarea>
                                        @error('description.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            @foreach (config('locales.languages') as $key => $val)
                                <div class="row ">
                                    <div class="col-sm-12 col-md-3 pt-3">
                                        <label for="link[{{ $key }}]">
                                            {{ __('panel.link') }}
                                            <span class="language-type">
                                                <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                    title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                                {{ __('panel.' . $key) }}
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-9 pt-3">
                                        <input type="text" name="link[{{ $key }}]"
                                            id="link[{{ $key }}]"
                                            value="{{ old('link.' . $key, $mainMenu->getTranslation('link', $key)) }}"
                                            class="form-control">
                                        @error('link.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            <div class="row ">
                                <div class="col-sm-12 col-md-3 pt-3">
                                    <label for="icon" class="control-label">
                                        <span>{{ __('panel.choose_icon') }}</span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-3">
                                    <div class="input-group iconpicker-container ">
                                        <input data-placement="bottomRight"
                                            class="form-control icp icp-auto iconpicker-element iconpicker-input icon-picker form-control"
                                            value=" {{ old('icon', $mainMenu->icon) ?? 'fas fa-archive' }}"
                                            type="text" name="icon">
                                        <span class="input-group-addon btn btn-primary">
                                            <i class="{{ $mainMenu->icon ?? 'fas fa-archive' }}"></i>
                                        </span>
                                    </div>
                                    @error('icon')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>


                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-3 pt-3">
                                    {{ __('panel.published_on') }}
                                </div>
                                <div class="col-sm-12 col-md-9 pt-3">
                                    <div class="input-group flatpickr" id="flatpickr-datetime">
                                        <input type="text" name="published_on" class="form-control"
                                            placeholder="Select date" data-input
                                            value="{{ old('published_on', $mainMenu->published_on ? \Carbon\Carbon::parse($mainMenu->published_on)->format('Y/m/d h:i A') : '') }}">
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
                                <div class="col-sm-12 col-md-3 pt-3">
                                    <label for="status" class="control-label">
                                        <span>{{ __('panel.status') }}</span>
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-9 pt-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status" id="status_active"
                                            value="1" {{ old('status', $mainMenu->status) == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_active">
                                            {{ __('panel.status_active') }}
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="status"
                                            id="status_inactive" value="0"
                                            {{ old('status', $mainMenu->status) == '0' ? 'checked' : '' }}>
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
                                            value="{{ old('metadata_title.' . $key, $mainMenu->getTranslation('metadata_title', $key)) }}"
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
                                            value="{{ old('metadata_description.' . $key, $mainMenu->getTranslation('metadata_description', $key)) }}"
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
                                            value="{{ old('metadata_keywords.' . $key, $mainMenu->getTranslation('metadata_keywords', $key)) }}"
                                            class="form-control">
                                        @error('metadata_keywords.' . $key)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="row">
                            <div class="col-sm-12 col-md-3 pt-3 d-none d-md-block">
                            </div>
                            <div class="col-sm-12 col-md-9 pt-3">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="icon-lg  me-2" data-feather="corner-down-left"></i>
                                    {{ __('panel.update_data') }}
                                </button>

                                <a href="{{ route('admin.main_menus.index') }}" name="submit"
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
