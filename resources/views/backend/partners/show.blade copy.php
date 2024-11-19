@extends('layouts.admin')
@section('content')
    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('transf.Course Landing Page') }}
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
                        <a href="{{ route('admin.courses.index') }}">
                            {{ __('panel.show_courses') }}
                        </a>
                    </li>
                </ul>
            </div>

            <div class="ml-auto mt-3 mt-sm-0">
                <form action="{{ route('admin.courses.update', $course->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-row align-items-center">
                        <label class="sr-only" for="inlineFormInputGroupOrderStatus">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{ __('panel.course_status') }}</div>
                            </div>
                            <select name="course_status" style="outline-style:none;" onchange="this.form.submit()"
                                class="form-control">

                                <option value=""> {{ __('panel.course_choose_appropriate_event') }} </option>
                                @foreach ($course_status_array as $key => $value)
                                    <option value="{{ $key }}"> {{ $value }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>{{ __('transf.course_title') }}</th>
                                <td>{{ $course->title }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('transf.Course subtitle') }}</th>
                                <td>
                                    {{ $course->subtitle }}
                                </td>
                            </tr>
                            <tr>
                            </tr>
                            <tr>
                                <th> {{ __('panel.created_at') }} </th>
                                <td>{{ $course->created_at->format('Y-m-d h:i a') }}</td>
                            </tr>
                            <tr>
                                <th> {{ __('panel.course_status') }}</th>
                                <td>{!! $course->statusWithLabel() !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                @php
                    if ($course->photos->first() != null && $course->photos->first()->file_name != null) {
                        $course_image = asset('assets/courses/' . $course->photos->first()->file_name);

                        if (!file_exists(public_path('assets/courses/' . $course->photos->first()->file_name))) {
                            $course_image = asset('image/not_found/item_image_not_found.webp');
                        }
                    } else {
                        $course_image = asset('image/not_found/item_image_not_found.webp');
                    }
                @endphp
                <img src="{{ $course_image }}" style="display: block;width:100%;height:200px;" alt="{{ $course->title }}">
            </div>
        </div>

    </div>

    <div class="card shadow mb-4">

        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex flex-column flex-sm-row justify-content-between">

            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-edit"></i>
                    {{ __('transf.Course Landing Page') }}
                </h3>

            </div>

            <div class="ml-auto mt-3 mt-sm-0">

            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <textarea name="description" rows="10" class="form-control">{!! old('description', $course->description) !!}</textarea>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>{{ __('panel.order_subtotal') }}</th>
                                <td>{{ $order->currency() . $order->subtotal }}</td>
                            </tr>
                            <tr>
                                <th> {{ __('panel.order_discount_code') }} </th>
                                <td>{{ $order->discount_code }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('panel.order_discount') }} </th>
                                <td>{{ $order->currency() . $order->discount }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('panel.order_shipping') }}</th>
                                <td>{{ $order->currency() . $order->shipping }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('panel.order_tax') }}</th>
                                <td>{{ $order->currency() . $order->tax }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('panel.order_amount') }}</th>
                                <td>{{ $order->currency() . $order->total }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection
