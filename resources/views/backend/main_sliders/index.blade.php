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
                        {{ __('panel.show_main_slider') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_main_sliders')
                    <a href="{{ route('admin.main_sliders.create') }}" class="btn btn-primary">
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
            @include('backend.main_sliders.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                    <thead>
                        <tr>
                            <th>{{ __('panel.image') }}</th>
                            <th>{{ __('panel.title') }}</th>
                            <th class="d-none d-sm-table-cell">{{ __('panel.author') }}</th>
                            <th class="d-none d-sm-table-cell"> {{ __('panel.created_at') }} </th>
                            <th>{{ __('panel.status') }}</th>
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mainSliders as $slider)
                            <tr>
                                <td>

                                    @php
                                        if ($slider->firstMedia != null && $slider->firstMedia->file_name != null) {
                                            $slider_img = asset(
                                                'assets/main_sliders/' . $slider->firstMedia->file_name,
                                            );

                                            if (
                                                !file_exists(
                                                    public_path(
                                                        'assets/main_sliders/' . $slider->firstMedia->file_name,
                                                    ),
                                                )
                                            ) {
                                                $slider_img = asset('image/not_found/item_image_not_found.webp');
                                            }
                                        } else {
                                            $slider_img = asset('image/not_found/item_image_not_found.webp');
                                        }
                                    @endphp

                                    <img src="{{ $slider_img }}" width="60" height="60"
                                        alt="{{ $slider->title }}">



                                </td>
                                <td>{{ $slider->title }}</td>
                                <td class="d-none d-sm-table-cell">{{ $slider->created_by }}</td>
                                <td class="d-none d-sm-table-cell">{{ $slider->created_at }}</td>
                                <td>{{ $slider->status() }}</td>
                                <td>

                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.main_sliders.edit', $slider->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);"
                                            onclick=" if( confirm('{{ __('panel.confirm_delete_message') }}') ){document.getElementById('delete-product-{{ $slider->id }}').submit();}else{return false;}"
                                            class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin.main_sliders.destroy', $slider->id) }}" method="post"
                                        class="d-none" id="delete-product-{{ $slider->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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
                                    {!! $mainSliders->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

    </div>
@endsection
