@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">

        {{-- breadcrumb part --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_about_instatute_section') }}
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
                        {{ __('panel.show_about_instatutes') }}
                    </li>
                </ul>
            </div>
            @if (count($about_instatutes) <= 0)
                <div class="ml-auto">
                    @ability('admin', 'create_about_instatutes')
                        <a href="{{ route('admin.president_speeches.create') }}" class="btn btn-primary">
                            <span class="icon text-white-50">
                                <i class="fa fa-plus-square"></i>
                            </span>
                            <span class="text">{{ __('panel.add_new_content') }}</span>
                        </a>
                    @endability
                </div>
            @endif

        </div>

        {{-- @include('backend.president_speeches.filter.filter') --}}

        <div class="card-body">

            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">{{ __('panel.image') }}</th>
                        <th>{{ __('panel.title') }}</th>
                        <th class="d-none d-sm-table-cell">{{ __('panel.author') }}</th>
                        <th>{{ __('panel.status') }}</th>
                        <th class="d-none d-sm-table-cell">{{ __('panel.created_at') }}</th>
                        <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>

                    </tr>
                </thead>


                <tbody>
                    @forelse ($about_instatutes as $about_instatute)
                        <tr>
                            <td class="d-none d-sm-table-cell">
                                @php
                                    if ($about_instatute->promotional_image != null) {
                                        $about_instatute_img = asset(
                                            'assets/president_speeches/' . $about_instatute->promotional_image,
                                        );

                                        if (
                                            !file_exists(
                                                public_path(
                                                    'assets/president_speeches/' . $about_instatute->promotional_image,
                                                ),
                                            )
                                        ) {
                                            $about_instatute_img = asset('image/not_found/avator1.webp');
                                        }
                                    } else {
                                        $about_instatute_img = asset('image/not_found/avator1.webp');
                                    }
                                @endphp
                                <img src="{{ $about_instatute_img }}" width="60" height="60" alt="not found">

                            </td>
                            <td>
                                {{ $about_instatute->title }}
                            </td>
                            <td class="d-none d-sm-table-cell">{{ $about_instatute->created_by ?? 'admin' }}</td>
                            <td>
                                <span
                                    class="btn btn-round rounded-pill btn-success btn-xs">{{ $about_instatute->status() }}</span>
                            </td>
                            <td class="d-none d-sm-table-cell">{{ $about_instatute->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.president_speeches.edit', $about_instatute->id) }}"
                                        class="btn btn-primary" title="Edit the About Instatute">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <span class="copyMessage" style="display:none;">{{ __('panel.copied') }}</span>

                                    <a href="javascript:void(0);"
                                        onclick="if(confirm('{{ __('panel.confirm_delete_message') }}')){document.getElementById('delete-product-category-{{ $about_instatute->id }}').submit();}else{return false;}"
                                        class="btn btn-danger" title="Delete the About Instatute">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </div>
                                <form action="{{ route('admin.president_speeches.destroy', $about_instatute->id) }}"
                                    method="post" class="d-none" id="delete-product-category-{{ $about_instatute->id }}">
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
    @endsection @section('script')
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
