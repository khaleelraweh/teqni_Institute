@extends('layouts.admin')
@section('style')
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('frontend/assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('frontend/assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
@endsection

@section('content')
    {{-- main holder page  --}}
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
                    <div class="col-sm-12 col-md-12">

                        <div class="row">
                            <div class="col-sm-12 col-md-12 pt-3">
                                <label for="doc_archive_name"> {{ __('panel.document_archive_name') }} </label>
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
    <script src="{{ URL::asset('frontend/assets/plugins/fileuploads/js/fileupload.js') }}"></script>w
    <script src="{{ URL::asset('frontend/assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('frontend/assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
@endsection
