@extends('layouts.admin')
@section('content')

    {{-- main holder tag  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_tag') }}
                </h3>
                <ul class="breadcrumb pt-3">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            \
                        @else
                            /
                        @endif
                    </li>
                    <li class="ms-1">
                        <a href="{{ route('admin.tags.index') }}">
                            {{ __('panel.show_tags') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- body part  --}}
        <div class="card-body">

            {{-- erorrs show is exists --}}
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

                <form action="{{ route('admin.tags.update', $tag->id) }}" method="post">
                    @csrf
                    @method('PATCH')

                    @foreach (config('locales.languages') as $key => $val)
                        <div class="row ">
                            <div class="col-sm-12 col-md-3 pt-3">
                                <label for="title[{{ $key }}]">
                                    {{ __('panel.tag_name') }}
                                    <span class="language-type">
                                        <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                            title="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                        {{ __('panel.' . $key) }}
                                    </span>
                                </label>
                            </div>

                            <div class="col-sm-12 col-md-9 pt-3">
                                <input type="text" name="name[{{ $key }}]" id="name[{{ $key }}]"
                                    value="{{ old('name.' . $key, $tag->getTranslation('name', $key)) }}"
                                    class="form-control">
                                @error('name.' . $key)
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    @endforeach

                    <div class="row">
                        <div class="col-sm-12 col-md-3 pt-3">
                            <label for="status" class="control-label">
                                <span>{{ __('panel.tag_type') }}</span>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-9 pt-3">
                            <select name="section" class="form-control">
                                <option value="1" {{ old('section', $tag->section) == '1' ? 'selected' : null }}>
                                    {{ __('panel.course_tag') }}
                                </option>
                                <option value="2" {{ old('section', $tag->section) == '2' ? 'selected' : null }}>
                                    {{ __('panel.event_tag') }}
                                </option>
                                <option value="3" {{ old('section', $tag->section) == '3' ? 'selected' : null }}>
                                    {{ __('panel.post_tag') }}
                                </option>
                            </select>
                            @error('section')
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
                                <input type="text" name="published_on" class="form-control" placeholder="Select date"
                                    data-input
                                    value="{{ old('published_on', $tag->published_on ? \Carbon\Carbon::parse($tag->published_on)->format('Y/m/d h:i A') : '') }}">
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
                                    value="1" {{ old('status', $tag->status) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_active">
                                    {{ __('panel.status_active') }}
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="status" id="status_inactive"
                                    value="0" {{ old('status', $tag->status) == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_inactive">
                                    {{ __('panel.status_inactive') }}
                                </label>
                            </div>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-3 pt-3 d-none d-md-block">
                        </div>
                        <div class="col-sm-12 col-md-9 pt-3">
                            <button type="submit" name="submit" class="btn btn-primary">
                                <i class="icon-lg  me-2" data-feather="corner-down-left"></i>
                                {{ __('panel.update_data') }}
                            </button>

                            <a href="{{ route('admin.tags.index') }}" name="submit" class=" btn btn-outline-danger">
                                <i class="icon-lg  me-2" data-feather="x"></i>
                                {{ __('panel.cancel') }}
                            </a>

                        </div>
                    </div>

                </form>
            </div>

        </div>
    @endsection


    @section('script')
        {{-- pickadate calling js --}}

        <script>
            $(function() {

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
