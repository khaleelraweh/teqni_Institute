@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">

        {{-- breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_pages') }}
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
                        {{ __('panel.show_pages') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_pages')
                    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_content') }}</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.pages.filter.filter')

        <div class="card-body">

            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="wd-5p border-bottom-0">#</th>
                        <th class="wd-40p border-bottom-0">{{ __('panel.title') }}</th>
                        <th class="d-none d-sm-table-cell wd-15p border-bottom-0">{{ __('panel.author') }}</th>
                        <th class="d-none d-sm-table-cell wd-15p border-bottom-0">{{ __('panel.status') }}</th>
                        <th class="d-none d-sm-table-cell wd-15p border-bottom-0">{{ __('panel.created_at') }}</th>
                        <th class="text-center border-bottom-0" style="width:30px;">{{ __('panel.actions') }}</th>
                    </tr>
                </thead>


                <tbody>
                    @forelse ($pages as $page)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="checkfilter" value="{{ $page->id }}">
                            </td>
                            <td>
                                {{ $page->title }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $page->created_by }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <span class="btn btn-round rounded-pill btn-success btn-xs">
                                    {{ $page->status() }}
                                </span>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $page->created_at->format('Y/m/d') }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-primary"
                                        title="Edit the page">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-success copyButton"
                                        data-copy-text="https://teqni.era-t.com/pages/{{ $page->slug }}"
                                        title="Copy the link">
                                        <i class="far fa-copy"></i>
                                    </a>
                                    <span class="copyMessage" style="display:none;">{{ __('panel.copied') }}</span>

                                    <a href="javascript:void(0);"
                                        onclick="if(confirm('{{ __('panel.confirm_delete_message') }}')){document.getElementById('delete-product-category-{{ $page->id }}').submit();}else{return false;}"
                                        class="btn btn-danger" title="Delete the page">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </div>
                                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="post" class="d-none"
                                    id="delete-product-category-{{ $page->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('panel.no_found_item') }}</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
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
