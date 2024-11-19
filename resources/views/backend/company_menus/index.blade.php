@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- breadcrumb part  --}}
                <div class="card-header py-3 d-flex justify-content-between">
                    <div class="card-naving">
                        <h3 class="font-weight-bold text-primary">
                            <i class="fa fa-folder"></i>
                            {{ __('panel.manage_company_menus') }}
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                                @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                                    <i class="fa fa-solid fa-chevron-left chevron"></i>
                                @else
                                    <i class="fa fa-solid fa-chevron-right chevron"></i>
                                @endif
                            </li>
                            <li>
                                {{ __('panel.show_company_menus') }}
                            </li>
                        </ul>
                    </div>
                    <div class="ml-auto">
                        @ability('admin', 'create_company_menus')
                            <a href="{{ route('admin.company_menus.create') }}" class="btn btn-primary">
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
                    @include('backend.company_menus.filter.filter')

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
                                @forelse ($company_menus as $menu)
                                    <tr>
                                        <td>
                                            {{ $menu->title }}
                                            <br>
                                            @if ($menu->parent != null)
                                                <small
                                                    style="background: #17a2b8;color:white;padding:1px 3px;border-radius: 5px; font-size:11px">
                                                    {{-- تابع للقائمة: --}}
                                                    <span>{{ $menu->parent?->title }}</span>
                                                </small>
                                            @endif
                                        </td>
                                        <td class="d-none d-sm-table-cell">{{ $menu->created_by }}</td>
                                        <td>
                                            <span
                                                class="btn btn-round  rounded-pill btn-success btn-xs">{{ $menu->status() }}</span>
                                        </td>
                                        <td class="d-none d-sm-table-cell">{{ $menu->created_at }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.company_menus.edit', $menu->id) }}"
                                                    class="btn btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    onclick=" if( confirm('Are you sure to delete this record?') ){document.getElementById('delete-product-category-{{ $menu->id }}').submit();}else{return false;}"
                                                    class="btn btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                            <form action="{{ route('admin.company_menus.destroy', $menu->id) }}"
                                                method="post" class="d-none"
                                                id="delete-product-category-{{ $menu->id }}">
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
                                        {!! $company_menus->appends(request()->all())->links() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
