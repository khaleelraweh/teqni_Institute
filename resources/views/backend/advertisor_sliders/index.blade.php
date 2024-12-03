@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">
        {{-- {{ dd(Cookie::get('theme')) }} --}}

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_sliders') }}
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
                        {{ __('panel.show_adv_slider') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_advertisor_sliders')
                    <a href="{{ route('admin.advertisor_sliders.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_slider') }}</span>
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">

            {{-- filter form part  --}}
            @include('backend.advertisor_sliders.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ __('panel.icon') }}</th>
                            <th>{{ __('panel.title') }}</th>
                            <th class="d-none d-sm-table-cell">{{ __('panel.author') }}</th>
                            <th class="d-none d-sm-table-cell"> {{ __('panel.published_on') }} </th>
                            <th>{{ __('panel.status') }}</th>
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($advertisorSliders as $advertisor_slider)
                            <tr>
                                <td>
                                    {{-- @if ($advertisor_slider->firstMedia)
                                        <img src="{{ asset('assets/advertisor_sliders/' . $advertisor_slider->firstMedia->file_name) }}"
                                            width="60" height="60" alt="{{ $advertisor_slider->title }}">
                                    @else
                                        <img src="{{ asset('image/not_found/item_image_not_found.png') }}" width="60" height="60"
                                            alt="{{ $advertisor_slider->title }}">
                                    @endif --}}

                                    <i class="{{ $advertisor_slider->icon }}" style="font-size: 40px"></i>

                                </td>
                                <td>{{ $advertisor_slider->title }}</td>
                                <td class="d-none d-sm-table-cell">{{ $advertisor_slider->created_by }}</td>
                                <td class="d-none d-sm-table-cell">
                                    {{ \Carbon\Carbon::parse($advertisor_slider->published_on)->diffForHumans() }}
                                </td>
                                <td>
                                    {{-- {{ $advertisor_slider->status() }} --}}
                                    @if ($advertisor_slider->status == 1)
                                        <a href="javascript:void(0);" class="updateAdvertisorSliderStatus"
                                            id="advertisor-slider-{{ $advertisor_slider->id }}"
                                            advertisor_slider_id="{{ $advertisor_slider->id }}">
                                            <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true"
                                                status="Active" style="font-size: 1.6em"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" class="updateAdvertisorSliderStatus"
                                            id="advertisor-slider-{{ $advertisor_slider->id }}"
                                            advertisor_slider_id="{{ $advertisor_slider->id }}">
                                            <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true"
                                                status="Inactive" style="font-size: 1.6em"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
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
                                                    href="{{ route('admin.advertisor_sliders.edit', $advertisor_slider->id) }}">
                                                    <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_edit') }}</span>
                                                </a>

                                                <a href="javascript:void(0);"
                                                    onclick="confirmDelete('delete-advertisor_slider-{{ $advertisor_slider->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')"
                                                    class="dropdown-item d-flex align-items-center">
                                                    <i data-feather="trash" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                                <form
                                                    action="{{ route('admin.advertisor_sliders.destroy', $advertisor_slider->id) }}"
                                                    method="post" class="d-none"
                                                    id="delete-advertisor_slider-{{ $advertisor_slider->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                    data-copy-text="https://ibbuniv.era-t.com/advertisor_sliders/{{ $advertisor_slider->slug }}"
                                                    data-id="{{ $advertisor_slider->id }}" title="Copy the link">
                                                    <i data-feather="copy" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_copy_link') }}</span>
                                                </a>

                                            </div>
                                            <span class="copyMessage" data-id="{{ $advertisor_slider->id }}"
                                                style="display:none;">
                                                {{ __('panel.copied') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center"> {{ __('panel.no_found_item') }} </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6">
                                <div class="float-right">
                                    {!! $advertisorSliders->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
@endsection
