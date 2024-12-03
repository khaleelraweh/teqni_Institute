@extends('layouts.admin')
@section('content')

    <div class="card shadow mb-4">
        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_testimonials') }}
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
                        {{ __('panel.show_testimonials') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto">
                @ability('admin', 'create_testimonials')
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_testimonial') }}</span>
                    </a>
                @endability
            </div>

        </div>

        <div class="card-body">

            {{-- filter form part  --}}
            @include('backend.testimonials.filter.filter')

            {{-- table part --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>{{ __('panel.title') }}</th>
                            <th>{{ __('panel.author') }}</th>
                            <th> {{ __('panel.status') }} </th>
                            <th> {{ __('panel.published_on') }} </th>
                            <th class="text-center" style="width:30px;">{{ __('panel.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($testimonials as $testimonial)
                            <tr>
                                <td>
                                    {{ Str::limit($testimonial->title, 50) }}
                                </td>
                                <td>{{ $testimonial->created_by }}</td>
                                <td>


                                    @if ($testimonial->status == 1)
                                        <a href="javascript:void(0);" class="updateTestimonialStatus "
                                            id="testimonial-{{ $testimonial->id }}"
                                            testimonial_id="{{ $testimonial->id }}">
                                            <i class="fas fa-toggle-on fa-lg text-success" aria-hidden="true"
                                                status="Active" style="font-size: 1.6em"></i>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" class="updateTestimonialStatus"
                                            id="testimonial-{{ $testimonial->id }}"
                                            testimonial_id="{{ $testimonial->id }}">
                                            <i class="fas fa-toggle-off fa-lg text-warning" aria-hidden="true"
                                                status="Inactive" style="font-size: 1.6em"></i>
                                        </a>
                                    @endif

                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($testimonial->published_on)->diffForHumans() }}
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
                                                    href="{{ route('admin.testimonials.edit', $testimonial->id) }}">
                                                    <i data-feather="edit-2" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_edit') }}</span>
                                                </a>

                                                <a href="javascript:void(0);"
                                                    onclick="confirmDelete('delete-testimonial-{{ $testimonial->id }}', '{{ __('panel.confirm_delete_message') }}', '{{ __('panel.yes_delete') }}', '{{ __('panel.cancel') }}')"
                                                    class="dropdown-item d-flex align-items-center">
                                                    <i data-feather="trash" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_delete') }}</span>
                                                </a>
                                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}"
                                                    method="post" class="d-none"
                                                    id="delete-testimonial-{{ $testimonial->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <a href="javascript:void(0);"
                                                    class="dropdown-item d-flex align-items-center btn btn-success copyButton"
                                                    data-copy-text="https://ibbuniv.era-t.com/testimonials/{{ $testimonial->slug }}"
                                                    data-id="{{ $testimonial->id }}" title="Copy the link">
                                                    <i data-feather="copy" class="icon-sm me-2"></i>
                                                    <span class="">{{ __('panel.operation_copy_link') }}</span>
                                                </a>

                                            </div>
                                            <span class="copyMessage" data-id="{{ $testimonial->id }}"
                                                style="display:none;">
                                                {{ __('panel.copied') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">{{ __('panel.no_found_item') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="float-right">
                                    {!! $testimonials->appends(request()->all())->links() !!}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>
@endsection
