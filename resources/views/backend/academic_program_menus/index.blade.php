@extends('layouts.admin')

@section('content')
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_menus') }}
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
                        {{ __('panel.show_academic_program_menus') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_academic_program_menus')
                    <a href="{{ route('admin.academic_program_menus.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_content') }}</span>
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">

            {{-- filter form part  --}}
            @include('backend.academic_program_menus.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ __('panel.title') }}</th>
                            <th class="d-none d-sm-table-cell">{{ __('panel.author') }}</th>
                            <th>{{ __('panel.status') }}</th>
                            <th class="d-none d-sm-table-cell">{{ __('panel.published_on') }}</th>
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($academic_program_menus as $academic_program_menu)
                            <tr>
                                <td>
                                    {{ $academic_program_menu->title }}
                                    <br>
                                    @if ($academic_program_menu->parent != null)
                                        <small
                                            style="background: #17a2b8;color:white;padding:1px 3px;border-radius: 5px; font-size:11px">
                                            {{-- تابع للقائمة: --}}
                                            <span>{{ $academic_program_menu->parent?->title }}</span> </small>
                                    @endif

                                </td>
                                <td class="d-none d-sm-table-cell">{{ $academic_program_menu->created_by }}</td>
                                <td>

                                    @if ($academic_program_menu->status == 1)
                                        <a href="javascript:void(0);" class="updateAcademicProgramMenuStatus "
                                            id="academic-program-menu-{{ $academic_program_menu->id }}"
                                            academic_program_menu_id="{{ $academic_program_menu->id }}">
                                            <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true"
                                                status="Active" style="font-size: 1.6em"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" class="updateAcademicProgramMenuStatus"
                                            id="academic-program-menu-{{ $academic_program_menu->id }}"
                                            academic_program_menu_id="{{ $academic_program_menu->id }}">
                                            <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true"
                                                status="Inactive" style="font-size: 1.6em"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    {{ \Carbon\Carbon::parse($academic_program_menu->published_on)->diffForHumans() }}
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
                                                    href="{{ route('admin.academic_program_menus.edit', $academic_program_menu->id) }}">
                                                    <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_edit') }}</span>
                                                </a>

                                                <a href="javascript:void(0);"
                                                    onclick="confirmDelete('delete-academic-program-menu-{{ $academic_program_menu->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')"
                                                    class="dropdown-item d-flex align-items-center">
                                                    <i data-feather="trash" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                                <form
                                                    action="{{ route('admin.academic_program_menus.destroy', $academic_program_menu->id) }}"
                                                    method="post" class="d-none"
                                                    id="delete-academic-program-menu-{{ $academic_program_menu->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                    data-copy-text="https://ibbuniv.era-t.com/academic_program_menus/{{ $academic_program_menu->slug }}"
                                                    data-id="{{ $academic_program_menu->id }}" title="Copy the link">
                                                    <i data-feather="copy" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_copy_link') }}</span>
                                                </a>


                                            </div>
                                            <span class="copyMessage" data-id="{{ $academic_program_menu->id }}"
                                                style="display:none;">
                                                {{ __('panel.copied') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">{{ __('panel.no_found_item') }}</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $academic_program_menus->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </div>

        </div>
    </div>
@endsection
