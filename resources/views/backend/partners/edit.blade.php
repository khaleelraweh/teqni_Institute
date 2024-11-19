@extends('layouts.admin')

@section('style')
    <style>
        .note-editor.note-airframe,
        .note-editor.note-frame {
            margin-bottom: 0;
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
                    <i class="fa fa-edit"></i>
                    {{ __('panel.edit_existing_partner') }}
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

            {{-- enctype used cause we will save images  --}}
            <form action="{{ route('admin.partners.update', $partner->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- links of tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content"
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
                            <div class="col-md-7 col-sm-12 ">

                                {{-- partner name field --}}
                                <div class="row ">
                                    <div class="col-sm-12 pt-3">
                                        <div class="form-group">
                                            <label for="name">
                                                {{ __('panel.partner_name') }}
                                            </label>

                                            <div class="input-group">
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name', $partner->name) }}" class="form-control"
                                                    maxlength="60">
                                                <span class="input-group-text" id="charCount">60</span>
                                            </div>

                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                {{--  description field --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 pt-4">
                                        <label for="description">
                                            {{ __('panel.description') }}

                                        </label>
                                        <textarea name="description" rows="10" class="form-control" id="tinymceExample">
                                            {!! old('description', $partner->description) !!}
                                        </textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- partner link field --}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 pt-3">
                                        <label for="partner_link">
                                            {{ __('panel.partner_link') }}
                                        </label>
                                        <div class="input-group">
                                            <input type="text" name="partner_link" id="partner_link"
                                                value="{{ old('partner_link', $partner->partner_link) }}"
                                                class="form-control">
                                        </div>
                                        @error('partner_link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- status --}}
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 pt-3">
                                        <label for="status" class="control-label col-md-2 col-sm-12 ">
                                            <span>{{ __('panel.status') }}</span>
                                        </label>
                                        <select name="status" class="form-control">
                                            <option value="0"
                                                {{ old('status', $partner->status) == '0' ? 'selected' : null }}>
                                                {{ __('panel.status_inactive') }}
                                            </option>
                                            <option value="1"
                                                {{ old('status', $partner->status) == '1' ? 'selected' : null }}>
                                                {{ __('panel.status_active') }}
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            {{-- مرفق الصور  --}}
                            <div class="col-md-5 col-sm-12 ">

                                <div class="row">
                                    <div class="col-12 pt-4">
                                        <label for="images">{{ __('panel.image') }}/
                                            {{ __('panel.images') }}</label>
                                        <br>
                                        <div class="file-loading">
                                            <input type="file" name="partner_image" id="partner_image"
                                                class="file-input-overview" multiple="multiple">
                                            @error('images')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group pt-4">
                        <button type="submit" name="submit" class="btn btn-primary">
                            {{ __('panel.update_data') }}
                        </button>
                    </div>

                </div>

            </form>
        </div>

    </div>

@endsection

@section('script')
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
                overwriteInitial: false,
                initialPreview: [
                    @if ($partner->partner_image != '')
                        "{{ asset('assets/partners/' . $partner->partner_image) }}",
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($partner->partner_image != '')
                        {
                            caption: "{{ $partner->partner_image }}",
                            size: '1111',
                            width: "120px",
                            url: "{{ route('admin.partners.remove_image', ['partner_id' => $partner->id, '_token' => csrf_token()]) }}",
                            key: {{ $partner->id }}
                        }
                    @endif
                ]
            });

        });
    </script>
@endsection
