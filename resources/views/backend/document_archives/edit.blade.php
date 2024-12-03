@extends('layouts.admin')
@section('style')
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('backend/vendors/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('backend/vendors/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection

@section('content')
    {{-- main holder documentArchive  --}}
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_document_archive') }}

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
                        <a href="{{ route('admin.document_archives.index') }}">
                            {{ __('panel.show_document_archives') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

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


                <form action="{{ route('admin.document_archives.update', $documentArchive->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')



                    <div class="row">
                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="doc_archive_name" class="control-label">
                                <span>{{ __('panel.document_archive_name') }}</span>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-10 pt-3">
                            <input type="text" id="doc_archive_name" name="doc_archive_name"
                                value="{{ old('doc_archive_name', $documentArchive->doc_archive_name) }}"
                                class="form-control" placeholder="">
                            @error('doc_archive_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- row -->
                    <div class="row">

                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="doc_archive_name" class="control-label">
                                <span>{{ __('panel.attach_the_document') }}</span>
                            </label>
                        </div>

                        <div class="col-sm-12 col-md-10 pt-3">
                            <input type="file" name="doc_archive_attached_file" class="dropify"
                                data-default-file="{{ asset('assets/document_archives/' . $documentArchive->doc_archive_attached_file) }}"
                                accept=".pdf, .docx" />
                            <p class="text-muted card-sub-title pt-2">
                                <small> {{ __('panel.document_format_message') }} </small>
                            </p>
                            @error('doc_archive_attached_file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-2 pt-3">
                            {{ __('panel.published_on') }}
                        </div>
                        <div class="col-sm-12 col-md-10 pt-3">
                            <div class="input-group flatpickr" id="flatpickr-datetime">
                                <input type="text" name="published_on" class="form-control" placeholder="Select date"
                                    data-input
                                    value="{{ old('published_on', $documentArchive->published_on ? \Carbon\Carbon::parse($documentArchive->published_on)->format('Y/m/d h:i A') : '') }}">
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
                        <div class="col-sm-12 col-md-2 pt-3">
                            <label for="status" class="control-label">
                                <span>{{ __('panel.status') }}</span>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-10 pt-3">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="status" id="status_active"
                                    value="1" {{ old('status', $documentArchive->status) == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_active">
                                    {{ __('panel.status_active') }}
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="status" id="status_inactive"
                                    value="0" {{ old('status', $documentArchive->status) == '0' ? 'checked' : '' }}>
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
                        <div class="col-sm-12 ">
                            {{-- submit button  --}}
                            <div class="form-group pt-3">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    {{ __('panel.save_data') }}</button>
                            </div>
                        </div>
                    </div>

                </form>


            </div>


        </div>
    @endsection


    @section('script')
        <!--Internal Fileuploads js-->
        <script src="{{ URL::asset('backend/vendors/fileuploads/js/fileupload.js') }}"></script>w
        <script src="{{ URL::asset('backend/vendors/fileuploads/js/file-upload.js') }}"></script>
        <!--Internal Fancy uploader js-->
        <script src="{{ URL::asset('backend/vendors/fancyuploder/jquery.ui.widget.js') }}"></script>
        <script src="{{ URL::asset('backend/vendors/fancyuploder/jquery.fileupload.js') }}"></script>
        <script src="{{ URL::asset('backend/vendors/fancyuploder/jquery.iframe-transport.js') }}"></script>
        <script src="{{ URL::asset('backend/vendors/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
        <script src="{{ URL::asset('backend/vendors/fancyuploder/fancy-uploader.js') }}"></script>
    @endsection
