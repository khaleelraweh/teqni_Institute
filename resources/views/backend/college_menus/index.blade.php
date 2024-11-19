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
                        {{ __('panel.show_college_menus') }}
                    </li>
                </ul>
            </div>
            <div class="ml-auto">
                @ability('admin', 'create_college_menus')
                    <a href="{{ route('admin.college_menus.create') }}" class="btn btn-primary">
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
            @include('backend.college_menus.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ __('panel.title') }}</th>
                            <th class="d-none d-sm-table-cell">{{ __('panel.author') }}</th>
                            <th>{{ __('panel.status') }}</th>
                            <th class="d-none d-sm-table-cell">{{ __('panel.created_at') }}</th>
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($college_menus as $college_menu)
                            <tr>
                                <td>
                                    {{ $college_menu->title }}
                                    <br>
                                    @if ($college_menu->parent != null)
                                        <small
                                            style="background: #17a2b8;color:white;padding:1px 3px;border-radius: 5px; font-size:11px">
                                            {{-- تابع للقائمة: --}}
                                            <span>{{ $college_menu->parent?->title }}</span> </small>
                                    @endif

                                </td>
                                <td class="d-none d-sm-table-cell">{{ $college_menu->created_by }}</td>
                                <td>
                                    <span
                                        class="btn btn-round  rounded-pill btn-success btn-xs">{{ $college_menu->status() }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">{{ $college_menu->created_at }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">

                                        <a href="{{ route('admin.college_menus.edit', $college_menu->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-product-category-{{ $college_menu->id }}').submit();}else{return false;}"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin.college_menus.destroy', $college_menu->id) }}"
                                        method="post" class="d-none" id="delete-product-category-{{ $college_menu->id }}">
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
                <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="float-right">
                                {!! $college_menus->appends(request()->all())->links() !!}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </div>

        </div>
    </div>
@endsection
