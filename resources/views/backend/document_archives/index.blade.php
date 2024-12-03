@extends('layouts.admin')


@section('content')


    <div class="card shadow mb-4">
        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_document_archive') }}
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
                        {{ __('panel.show_document_archives') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_document_archives')
                    <a href="{{ route('admin.document_archives.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        {{ __('panel.add_new_document_archive') }}
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">

            @include('backend.document_archives.filter.filter')


            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="wd-5p border-bottom-0">#</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.document_archive_name') }}</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.published_on') }}</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.published_by') }}</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.status') }}</th>
                            <th class="wd-15p border-bottom-0">Download pdf</th>
                            <th class="wd-15p border-bottom-0">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>


                        @forelse ($documentArchives as $document_archive)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="checkfilter"
                                        value="{{ $document_archive->id }}"></td>
                                <td>{{ $document_archive->doc_archive_name }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($document_archive->published_on)->diffForHumans() }}

                                </td>
                                <td>{{ $document_archive->created_by }}</td>
                                <td>
                                    @if ($document_archive->status == 1)
                                        <a href="javascript:void(0);" class="updateDocumentArchiveStatus "
                                            id="document-archive-{{ $document_archive->id }}"
                                            document_archive_id="{{ $document_archive->id }}">
                                            <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true"
                                                status="Active" style="font-size: 1.6em"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" class="updateDocumentArchiveStatus"
                                            id="document-archive-{{ $document_archive->id }}"
                                            document_archive_id="{{ $document_archive->id }}">
                                            <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true"
                                                status="Inactive" style="font-size: 1.6em"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('/download-pdf/' . $document_archive->doc_archive_attached_file) }}"
                                        class="btn btn-primary">Download PDF</a>
                                </td>
                                <td>
                                    {{-- <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.document_archives.edit', $document_archive->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-success copyButton"
                                            data-copy-text="https://ibbuniv.era-t.com/download-pdf/{{ $document_archive->doc_archive_attached_file }}"
                                            title="Copy the link">
                                            <i class="far fa-copy"></i>
                                        </a>
                                        <span class="copyMessage" style="display:none;">{{ __('panel.copied') }}</span>
                                        <a href="javascript:void(0);"
                                            onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-document-Archives-{{ $document_archive->id }}').submit();}else{return false;}"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash "></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin.document_archives.destroy', $document_archive->id) }}"
                                        method="post" class="d-none" id="delete-document-Archives-{{ $document_archive->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form> --}}
                                    <div class="btn-group btn-group-sm">
                                        <div class="dropdown mb-2 ">
                                            <a type="button" class="d-flex" id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                                                {{ __('panel.operation_options') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                    viewBox="0 0 25 15" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-chevron-down link-arrow">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item d-flex align-items-center"
                                                    href="{{ route('admin.document_archives.edit', $document_archive->id) }}">
                                                    <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_edit') }}</span>
                                                </a>

                                                <a href="javascript:void(0);"
                                                    onclick="confirmDelete('delete-document_archive-{{ $document_archive->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')"
                                                    class="dropdown-item d-flex align-items-center">
                                                    <i data-feather="trash" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                                <form
                                                    action="{{ route('admin.document_archives.destroy', $document_archive->id) }}"
                                                    method="post" class="d-none"
                                                    id="delete-document_archive-{{ $document_archive->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                    data-copy-text="https://ibbuniv.era-t.com/document_archives/{{ $document_archive->slug }}"
                                                    data-id="{{ $document_archive->id }}" title="Copy the link">
                                                    <i data-feather="copy" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_copy_link') }}</span>
                                                </a>

                                            </div>
                                            <span class="copyMessage" data-id="{{ $document_archive->id }}"
                                                style="display:none;">
                                                {{ __('panel.copied') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('panel.no_found_item') }}</td>
                            </tr>
                        @endforelse

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="float-right">
                                    {!! $documentArchives->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>


    </div>
@endsection

@section('script')
    <style>
        .copyButton {
            position: relative;
        }

        .copyMessage {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            display: none;
            z-index: 1000;
            font-size: 12px;
            width: auto;
            /* Ensure width fits content */
            white-space: nowrap;
            /* Prevents line break to ensure width fits content */
        }
    </style>

    <script>
        document.querySelectorAll(".copyButton").forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent form submission
                var textToCopy = button.getAttribute("data-copy-text"); // Get the dynamic text
                var tempInput = document.createElement("input");
                tempInput.value = textToCopy;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);

                var copyMessage = button.nextElementSibling; // Get the copyMessage span
                copyMessage.style.display = "inline";
                setTimeout(function() {
                    copyMessage.style.display = "none";
                }, 2000); // Hide the message after 2 seconds
            });
        });
    </script>
@endsection
