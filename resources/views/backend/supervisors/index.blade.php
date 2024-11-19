@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_users') }}
                </h3>
                <ul class="breadcrumb pt-1">
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

        {{-- filter form part  --}}

        @include('backend.supervisors.filter.filter')

        {{-- table part --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
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
                                        $supervisor_img = asset('assets/supervisors/' . $supervisor->user_image);

                                        if (
                                            !file_exists(public_path('assets/supervisors/' . $supervisor->user_image))
                                        ) {
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
                            <td>{{ $supervisor->status() }}</td>
                            <td class="d-none d-sm-table-cell">{{ $supervisor->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
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
                                </form>
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
