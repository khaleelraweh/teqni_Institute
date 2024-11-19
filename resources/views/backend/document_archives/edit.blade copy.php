@extends('layouts.admin')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    {{-- flat picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

    {{-- new  --}}
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    <a
                        href="{{ route('admin.document_archives.index') }}">{{ __('panel.manage_document_categories') }}</a>
                </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    /
                    {{ __('panel.edit_existing_document_archive') }}
                </span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">


            <div class="pr-1 mb-3 mb-xl-0">
                <a href="{{ route('admin.document_archives.edit', $documentArchive->id) }}"
                    class="btn btn-warning  btn-icon ml-2">
                    <i class="mdi mdi-refresh"></i>
                </a>
            </div>


        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm ">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">
                            <i class="fa fa-edit me-3" style="font-size: 20px;"></i>
                            {{ __('panel.edit_existing_document_archive') }}
                        </h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>

                    </div>
                </div>
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



                    <form action="{{ route('admin.document_archives.update', $documentArchive->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-sm-12 col-md-9">

                                <!-- document category -->
                                <div class="row">



                                    <div class="col-sm-12 col-md-6   pt-3">
                                        <label for="document_category_id" class="text-small text-uppercase">
                                            {{ __('panel.document_category_name') }} </label>
                                        <select class="form-control form-control-lg" name="document_category_id"
                                            wire:model="document_category_id">
                                            <option value="">---</option>
                                            @forelse ($document_categories as $document_category)
                                                <option value="{{ $document_category->id }}"
                                                    {{ old('document_category_id', $documentArchive->documentType->documentCategory->id) == $document_category->id ? 'selected' : null }}>
                                                    {{ $document_category->doc_cat_name }}

                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('document_category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-12  col-md-6 pt-3">

                                        <label for="document_type_id" class="text-small text-uppercase">
                                            {{ __('panel.document_type_name') }}
                                        </label>
                                        <select class="form-control form-control-lg" name="document_type_id"
                                            wire:model="document_type_id">
                                            <option value="">---</option>
                                            @forelse ($document_types as $document_type)
                                                <option value="{{ $document_type->id }}">
                                                    {{ $document_type->doc_type_name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('document_type_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 pt-3">
                                        <label for="doc_archive_name"> {{ __('panel.document_archive_name') }} </label>
                                        <input type="text" id="doc_archive_name" wire:model="doc_archive_name"
                                            name="doc_archive_name" value="{{ old('doc_archive_name') }}"
                                            class="form-control" placeholder="">
                                        @error('doc_archive_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- row -->
                                <div class="row" wire:ignore>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div>
                                                    <h6 class="card-title mb-1">ارفق مستند هنا </h6>
                                                    <p class="text-muted card-sub-title">يجب ان يكون المستند ضمن الصيغ
                                                        التالية ( .pdf ,
                                                        .docx)</p>
                                                </div>

                                                <div>

                                                    <input type="file" name="doc_archive_attached_file" class="dropify"
                                                        data-default-file="{{ asset('assets/document_archives/' . $documentArchive->doc_archive_attached_file) }}"
                                                        accept=".pdf, .docx" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12 col-md-3">

                                {{-- publish_start publish time field --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 pt-3">
                                        <label for="published_on"> {{ __('panel.published_date') }} </label>
                                        <input type="text" id="published_on" wire:model.defer="published_on"
                                            name="published_on"
                                            value="{{ old('published_on', now()->format('Y-m-d H:i A')) }}"
                                            class="form-control flatpickr_publihsed_on">
                                        @error('published_on')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 pt-3">
                                        <label for="status">{{ __('panel.status') }}</label>
                                        <div class="main-toggle-group-demo">
                                            <div class="main-toggle main-toggle-success {{ $status == 1 ? 'on' : '' }}"
                                                id="main-toggler" wire:click="toggleStatus">
                                                <span></span>
                                            </div>
                                        </div>
                                        <input type="hidden" wire:model.defer="status" name="status" id="status"
                                            value="{{ $status }}">
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 ">
                                {{-- submit button  --}}
                                <div class="form-group pt-3">
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        {{ __('panel.save_data') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>



                    {{-- <div class="row">
                            <div class="col-sm-12 col-md-6 pt-3">
                                <div class="form-group">
                                    <label for="doc_type_name">{{ __('panel.document_archive_name') }}</label>
                                    <input type="text" id="doc_type_name" name="doc_type_name"
                                        value="{{ old('doc_type_name', $documentArchive->doc_type_name) }}"
                                        class="form-control" placeholder="">
                                    @error('doc_type_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 pt-3">
                                <div class="form-group">
                                    <label for="doc_type_note">{{ __('panel.document_archive_note') }}</label>
                                    <input type="text" id="doc_type_note" name="doc_type_note"
                                        value="{{ old('doc_type_note', $documentArchive->doc_type_note) }}"
                                        class="form-control" placeholder="">
                                    @error('doc_type_note')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6  pt-3">
                                <div class="form-group">
                                    <label for="published_on"> {{ __('panel.published_date') }} </label>
                                    <input type="text" id="published_on" name="published_on"
                                        value="{{ old('published_on', \Carbon\Carbon::parse($documentArchive->published_on)->Format('Y-m-d H:i K')) }}"
                                        class="form-control flatpickr_publihsed_on">
                                    @error('published_on')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 pt-3">
                                <label for="status"> {{ __('panel.status') }} </label>
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
                        </div> --}}


                </div>
            </div>
        </div>

    </div>

    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!-- Include the Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/{{ app()->getLocale() }}.js"></script>

    {{-- new  --}}
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>w
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!-- Internal TelephoneInput js-->
    <script src="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js') }}"></script>
    {{-- new end --}}




    <script>
        $(function() {

            // for offer ends
            flatpickr('.flatpickr_publihsed_on', {
                enableTime: true,
                dateFormat: "Y-m-d H:i K",
                minDate: "today"

            });

        });
    </script>
@endsection
