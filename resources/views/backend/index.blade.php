@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">{{ __('panel.welcome_to_dashboard') }}</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            ...
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">{{ __('panel.total_posts') }}</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $totalPosts }}</h3>
                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    {{-- <div id="customersChart" class="mt-md-3 mt-xl-0"></div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">{{ __('panel.total_menus') }}</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $totalMainMenus }}</h3>

                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    {{-- <div id="ordersChart" class="mt-md-3 mt-xl-0"></div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">{{ __('panel.total_supervisors') }}</h6>
                                <div class="dropdown mb-2">
                                    <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $totalSupervisor }}</h3>

                                </div>
                                <div class="col-6 col-md-12 col-xl-7">
                                    {{-- <div id="growthChart" class="mt-md-3 mt-xl-0"></div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
@endsection
