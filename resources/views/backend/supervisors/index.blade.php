@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_users') }}
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
                        {{ __('panel.show_supervisors') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_supervisors')
                    <a href="{{ route('admin.supervisors.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_supervisor') }}</span>
                    </a>
                @endability
            </div>

        </div>

        @include('backend.supervisors.filter.filter')

        <div class="card-body">
            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell">{{ __('panel.image') }}</th>
                        <th>{{ __('panel.advertisor_name') }}</th>
                        <th class="d-none d-sm-table-cell">{{ __('panel.email') }} {{ __('panel.and') }}
                            {{ __('panel.mobile') }} </th>
                        <th>{{ __('panel.status') }}</th>
                        <th class="d-none d-sm-table-cell">{{ __('panel.created_at') }}</th>
                        <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($supervisors as $supervisor)
                        <tr>
                            <td class="d-none d-sm-table-cell">
                                @php
                                    if ($supervisor->user_image != null) {
                                        $supervisor_img = asset('assets/users/' . $supervisor->user_image);

                                        if (!file_exists(public_path('assets/users/' . $supervisor->user_image))) {
                                            $supervisor_img = asset('image/not_found/avator1.webp');
                                        }
                                    } else {
                                        $supervisor_img = asset('image/not_found/avator1.webp');
                                    }
                                @endphp

                                <img src="{{ $supervisor_img }}" width="60" height="60"
                                    alt="{{ $supervisor->full_name }}">

                            </td>
                            <td>


                                {{ $supervisor->full_name }} <br>
                                <small>
                                    <span class="bg-info px-2 text-white rounded-pill">
                                        {{ __('panel.username') }}:
                                        <strong>{{ $supervisor->username }}</strong>
                                    </span>
                                </small>

                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ $supervisor->email }} <br>
                                {{ $supervisor->mobile }}
                            </td>
                            <td>

                                @if ($supervisor->status == 1)
                                    <a href="javascript:void(0);" class="updateSupervisorStatus "
                                        id="supervisor-{{ $supervisor->id }}" supervisor_id="{{ $supervisor->id }}">
                                        <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true" status="Active"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @else
                                    <a href="javascript:void(0);" class="updateSupervisorStatus"
                                        id="supervisor-{{ $supervisor->id }}" supervisor_id="{{ $supervisor->id }}">
                                        <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true" status="Inactive"
                                            style="font-size: 1.6em"></i>
                                    </a>
                                @endif
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{ \Carbon\Carbon::parse($supervisor->published_on)->diffForHumans() }}
                            </td>
                            <td>
                                {{-- <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.supervisors.edit', $supervisor->id) }}"
                                        class="btn btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                        onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-supervisor-{{ $supervisor->id }}').submit();}else{return false;}"
                                        class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                <form action="{{ route('admin.supervisors.destroy', $supervisor->id) }}" method="post"
                                    class="d-none" id="delete-supervisor-{{ $supervisor->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form> --}}
                                <div class="btn-group btn-group-sm">
                                    <div class="dropdown mb-2 ">
                                        <a type="button" class="d-flex" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-lg text-muted pb-3px" data-feather="more-vertical"></i>
                                            {{ __('panel.operation_options') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                viewBox="0 0 25 15" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-chevron-down link-arrow">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item d-flex align-items-center"
                                                href="{{ route('admin.supervisors.edit', $supervisor->id) }}">
                                                <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_edit') }}</span>
                                            </a>

                                            <a href="javascript:void(0);"
                                                onclick="confirmDelete('delete-supervisor-{{ $supervisor->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')"
                                                class="dropdown-item d-flex align-items-center">
                                                <i data-feather="trash" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_delete') }}</span>
                                            </a>
                                            <form action="{{ route('admin.supervisors.destroy', $supervisor->id) }}"
                                                method="post" class="d-none" id="delete-supervisor-{{ $supervisor->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <a href="javascript:void(0);"
                                                class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                data-copy-text="https://ibbuniv.era-t.com/supervisor-single/{{ $supervisor->slug }}"
                                                data-id="{{ $supervisor->id }}" title="Copy the link">
                                                <i data-feather="copy" class="icon-sm me-2"></i>
                                                <span class="">{{ __('panel.operation_copy_link') }}</span>
                                            </a>

                                        </div>
                                        <span class="copyMessage" data-id="{{ $supervisor->id }}" style="display:none;">
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
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $supervisors->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
@endsection
