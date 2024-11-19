@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">

        {{-- breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_albums') }}
                </h3>
                <ul class="breadcrumb pt-2">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            {{-- <i class="fa fa-solid fa-chevron-left chevron"></i> --}}
                            /
                        @else
                            {{-- <i class="fa fa-solid fa-chevron-right chevron"></i> --}}
                            \
                        @endif
                    </li>
                    <li class="ms-1">
                        {{ __('panel.show_albums') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_albums')
                    <a href="{{ route('admin.albums.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50 d-none d-sm-inline-block">
                            <i class="fa fa-plus-square">

                            </i>
                        </span>
                        <span class="text">{{ __('panel.add_new_content') }}</span>
                    </a>
                @endability
            </div>
        </div>

        @include('backend.albums.filter.filter')

        <div class="card-body">

            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="wd-5p border-bottom-0">#</th>
                        <th class="wd-40p border-bottom-0">{{ __('panel.title') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.author') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.status') }}</th>
                        <th class="wd-15p border-bottom-0 d-none d-sm-table-cell ">{{ __('panel.created_at') }}</th>
                        <th class="text-center border-bottom-0" style="width:30px;">{{ __('panel.actions') }}</th>
                    </tr>
                </thead>


                <tbody>
                    @forelse ($albums as $album)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="checkfilter" value="{{ $album->id }}">
                            </td>
                            <td>
                                {{ $album->title }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $album->created_by }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <span class="btn btn-round rounded-pill btn-success btn-xs ">
                                    {{ $album->status() }}
                                </span>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $album->created_at->format('Y/m/d') }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn btn-primary"
                                        title="Edit the album">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-success copyButton"
                                        data-copy-text="https://teqni.era-t.com/albums/{{ $album->slug }}"
                                        title="Copy the link">
                                        <i class="far fa-copy"></i>
                                    </a>
                                    <span class="copyMessage" style="display:none;">{{ __('panel.copied') }}</span>

                                    <a href="javascript:void(0);"
                                        onclick="if(confirm('{{ __('panel.confirm_delete_message') }}')){document.getElementById('delete-product-category-{{ $album->id }}').submit();}else{return false;}"
                                        class="btn btn-danger" title="Delete the album">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </div>
                                <form action="{{ route('admin.albums.destroy', $album->id) }}" method="post"
                                    class="d-none" id="delete-product-category-{{ $album->id }}">
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
