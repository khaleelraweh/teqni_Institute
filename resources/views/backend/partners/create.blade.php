@extends('layouts.admin')
@section('style')
    <style>
        .note-editor.note-airframe,
        .note-editor.note-frame {
            margin-bottom: 0;
        }

        #offer_ends_group .picker--opened .picker__holder {
            transform: translateY(-342px) perspective(600px) rotateX(0);
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
                    {{ __('panel.add_new_partner') }}
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
                        <a href="{{ route('admin.partners.index') }}">
                            {{ __('panel.show_partners') }}
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


            {{-- enctype used cause we will save partner_image  --}}
            <form id="my_form_id" action="{{ route('admin.partners.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
                            type="button" role="tab" aria-controls="content" aria-selected="true">
                            {{ __('panel.content_tab') }}
                        </button>
                    </li>

                </ul>
                {{-- contents of links tabs  --}}
                <div class="tab-content" id="myTabContent">

                    {{-- Content Tab --}}
                    <div class="tab-pane fade show active" id="content" role="tabpanel" aria-labelledby="content">

                        <div class="row">
                            {{-- البيانات الاساسية --}}
                            <div class="col-md-12 col-sm-12 ">

                                @foreach (config('locales.languages') as $key => $val)
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 pt-3">
                                            <label for="name[{{ $key }}]">
                                                {{ __('panel.partner_name') }}
                                                <span class="language-type">
                                                    <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                        name="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                                    {{ __('panel.' . $key) }}
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-sm-12 col-md-10 pt-3">
                                            <input type="text" name="name[{{ $key }}]"
                                                id="name[{{ $key }}]" value="{{ old('name.' . $key) }}"
                                                class="form-control">
                                            @error('name.' . $key)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach

                                <hr>

                                @foreach (config('locales.languages') as $key => $val)
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 pt-3">
                                            <label for="description[{{ $key }}]">
                                                {{ __('panel.description') }}
                                                <span class="language-type">
                                                    <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                        description="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                                    {{ __('panel.' . $key) }}
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-sm-12 col-md-10 pt-3">
                                            <input type="text" name="description[{{ $key }}]"
                                                id="description[{{ $key }}]"
                                                value="{{ old('description.' . $key) }}" class="form-control">
                                            @error('description.' . $key)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach

                                <hr>

                                @foreach (config('locales.languages') as $key => $val)
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 pt-3">
                                            <label for="partner_link[{{ $key }}]">
                                                {{ __('panel.partner_link') }}
                                                <span class="language-type">
                                                    <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }} mt-1 "
                                                        partner_link="{{ app()->getLocale() == 'ar' ? 'ye' : 'us' }}"></i>
                                                    {{ __('panel.' . $key) }}
                                                </span>
                                            </label>
                                        </div>
                                        <div class="col-sm-12 col-md-10 pt-3">
                                            <input type="text" name="partner_link[{{ $key }}]"
                                                id="partner_link[{{ $key }}]"
                                                value="{{ old('partner_link.' . $key) }}" class="form-control">
                                            @error('partner_link.' . $key)
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach

                                <hr>

                                {{-- status --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-2 pt-3">
                                        <label for="status">{{ __('panel.status') }}</label>
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

                                <hr>

                                <div class="row ">
                                    <div class="col-sm-12 col-md-2 pt-3">
                                        <label for="partner_image">
                                            {{ __('panel.image') }}
                                            /
                                            {{ __('panel.partner_image') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-12 col-md-10 pt-3">
                                        <div class="file-loading">
                                            <input type="file" name="partner_image" id="partner_image"
                                                class="file-input-overview" multiple="multiple">
                                            @error('partner_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                    <div class="form-group pt-3">
                        <button type="submit" name="submit" class="btn btn-primary">
                            {{ __('panel.save_data') }}</button>
                    </div>

                </div>
            </form>
        </div>

    </div>

@endsection

@section('script')
    {{-- Call select2 plugin --}}
    <script src="{{ asset('backend/vendor/select2/js/select2.full.min.js') }}"></script>

    {{-- name counter  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const charCount = document.getElementById('charCount');
            const maxChars = 60;

            // Function to update the character count
            function updateCharCount() {
                const remainingChars = maxChars - nameInput.value.length;
                charCount.textContent = remainingChars;
            }

            // Initialize the character count on page load
            updateCharCount();

            // Update the character count on input
            nameInput.addEventListener('input', updateCharCount);
        });
    </script>




    <script>
        $(function() {


            $("#partner_image").fileinput({
                theme: "fa5",
                maxFileCount: 1,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false
            })


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

            // start deadline 
            $('#deadline').pickadate({
                format: 'yyyy-mm-dd',
                min: new Date(),
                selectMonths: true, // Creates a dropdown to control month
                selectYears: true, // creates a dropdown to control years
                clear: 'Clear',
                close: 'OK',
                colseOnSelect: true // Close Upon Selecting a date
            });

            var publishedOn = $('#deadline').pickadate(
                'picker'); // set startdate in the picker to the start date in the #start_date elemet

            // when change date 
            $('#deadline').change(function() {
                selected_ci_date = "";
                selected_ci_date = $('#deadline').val();
                if (selected_ci_date != null) {
                    var cidate = new Date(selected_ci_date);
                    min_codate = "";
                    min_codate = new Date();
                    min_codate.setDate(cidate.getDate() + 1);
                    enddate.set('min', min_codate);
                }

            });
            // end deadline 

            // ======= start pickadate codeing ===========
            $('#publish_date').pickadate({
                format: 'yyyy-mm-dd',
                selectMonths: true, // Creates a dropdown to control month
                selectYears: true, // creates a dropdown to control years
                clear: 'Clear',
                close: 'OK',
                colseOnSelect: true // Close Upon Selecting a date
            });

            $('#offer_ends').pickadate({
                format: 'yyyy-mm-dd',
                selectMonths: true, // Creates a dropdown to control month
                selectYears: true, // creates a dropdown to control years
                clear: 'Clear',
                close: 'OK',
                colseOnSelect: true // Close Upon Selecting a date
            });


            $('.summernote').summernote({
                tabSize: 2,
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });
    </script>
@endsection
