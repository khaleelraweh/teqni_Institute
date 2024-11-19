@extends('layouts.admin')
@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-plus-square"></i>
                    {{ __('panel.add_new_customer') }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            <i class="fa fa-solid fa-chevron-left chevron"></i>
                        @else
                            <i class="fa fa-solid fa-chevron-right chevron"></i>
                        @endif
                    </li>
                    <li>
                        <a href="{{ route('admin.customers.index') }}">
                            {{ __('panel.show_customers') }}
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
            <form action="{{ route('admin.customers.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active " id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                            type="button" role="tab" aria-controls="content" aria-selected="true">
                            {{ __('panel.content_tab') }}
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

                    {{-- content tab --}}
                    <div class="tab-pane fade active show" id="content" role="tabpanel" aria-labelledby="content-tab">

                        <div class="row">

                            <div class="col-sm-12 col-md-8">

                                <div class="row">
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="first_name"> {{ __('panel.first_name') }}</label>
                                            <input type="text" id="first_name" name="first_name"
                                                value="{{ old('first_name') }}" class="form-control" placeholder="">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="last_name">{{ __('panel.last_name') }}</label>
                                            <input type="text" id="last_name" name="last_name"
                                                value="{{ old('last_name') }}" class="form-control" placeholder="">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="username">{{ __('panel.user_name') }}</label>
                                            <input type="text" id="username" name="username"
                                                value="{{ old('username') }}" class="form-control" placeholder="">
                                            @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="password">{{ __('panel.user_password') }}</label>
                                            <input type="text" id="password" name="password"
                                                value="{{ old('password') }}" class="form-control" placeholder="">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="email">{{ __('panel.email') }}</label>
                                            <input type="text" id="email" name="email" value="{{ old('email') }}"
                                                class="form-control" placeholder="">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 pt-4">
                                        <div class="form-group">
                                            <label for="mobile">{{ __('panel.mobile') }}</label>
                                            <input type="text" id="mobile" name="mobile"
                                                value="{{ old('mobile') }}" class="form-control" placeholder="">
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4">

                                <div class="row pt-4">
                                    <div class="col-12">
                                        <label for="user_image"> {{ __('panel.image') }}
                                            <span><small> ( {{ __('panel.best_size') }}: 250 * 240 )</small></span>

                                        </label>
                                        <br>
                                        <span class="form-text text-muted">{{ __('panel.user_image_size') }} </span>
                                        <div class="file-loading">
                                            <input type="file" name="user_image" id="customer_image"
                                                value="{{ old('customer_image') }}" class="file-input-overview ">
                                            <span class="form-text text-muted">{{ __('panel.user_image_size') }} </span>
                                            @error('user_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
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
                                    <input type="text" id="published_on" name="published_on"
                                        value="{{ old('published_on', now()->format('Y-m-d')) }}" class="form-control">
                                    @error('published_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-4">
                                <div class="form-group">
                                    <label for="published_on_time">{{ __('panel.published_time') }}</label>
                                    <input type="text" id="published_on_time" name="published_on_time"
                                        value="{{ old('published_on_time', now()->format('h:m A')) }}"
                                        class="form-control">
                                    @error('published_on_time')
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
    {{-- #user_image is the id in file input file above  --}}
    <script>
        $(function() {
            $("#customer_image").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            })
        });

        // ======= start pickadate codeing ===========
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
            selected_ci_date = $('#published_on').val();
            if (selected_ci_date != null) {
                var cidate = new Date(selected_ci_date);
                min_codate = "";
                min_codate = new Date();
                min_codate.setDate(cidate.getDate() + 1);
                enddate.set('min', min_codate);
            }

        });

        $('#published_on_time').pickatime({
            clear: ''
        });
        // ======= End pickadate codeing ===========
    </script>
@endsection
