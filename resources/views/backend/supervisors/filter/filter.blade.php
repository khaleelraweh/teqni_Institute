<div class="card-body">
    <form action="{{ route('admin.supervisors.index') }}" method="get">
        <div class="row">
            <div class="col-8 col-sm-4 col-md-2">
                <div class="form-group">
                    <input type="text" name="keyword" value="{{ old('keyword', request()->input('keyword')) }}"
                        class="form-control" placeholder="{{ __('panel.keyword') }}">
                </div>
            </div>
            <div class="col-md-2 d-none d-md-block">
                <div class="form-group">
                    <select name="status" class="form-control">
                        <option value="">{{ __('panel.show_all') }}</option>
                        <option value="1" {{ old('status', request()->input('status')) == '1' ? 'selected' : '' }}>
                            {{ __('panel.status_active') }}
                        </option>
                        <option value="0" {{ old('status', request()->input('status')) == '0' ? 'selected' : '' }}>
                            {{ __('panel.status_inactive') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="d-none d-sm-block col-sm-4 col-md-2">
                <div class="form-group">
                    <select name="sort_by" class="form-control">
                        <option value="id"
                            {{ old('sort_by', request()->input('sort_by')) == 'id' ? 'selected' : '' }}>
                            {{ __('panel.id') }}
                        </option>
                        <option value="first_name"
                            {{ old('sort_by', request()->input('sort_by')) == 'first_name' ? 'selected' : '' }}>
                            {{ __('panel.first_name') }}
                        </option>
                        <option value="last_name"
                            {{ old('sort_by', request()->input('sort_by')) == 'last_name' ? 'selected' : '' }}>
                            {{ __('panel.last_name') }}

                        </option>
                        <option value="created_at"
                            {{ old('sort_by', request()->input('sort_by')) == 'created_at' ? 'selected' : '' }}>
                            {{ __('panel.created_at') }}
                        </option>

                    </select>
                </div>
            </div>
            <div class="col-md-2 d-none d-md-block">
                <div class="form-group">
                    <select name="order_by" class="form-control">
                        {{-- <option value="">---</option> --}}
                        <option value="asc"
                            {{ old('order_by', request()->input('order_by')) == 'asc' ? 'selected' : '' }}>
                            {{ __('panel.asc') }}
                        </option>
                        <option value="desc"
                            {{ old('order_by', request()->input('order_by')) == 'desc' ? 'selected' : '' }}>
                            {{ __('panel.desc') }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-1 d-none d-md-block">
                <div class="form-group">
                    <select name="limit_by" class="form-control">
                        {{-- <option value="">---</option> --}}
                        <option value="10"
                            {{ old('limit_by', request()->input('limit_by')) == '10' ? 'selected' : '' }}>10</option>
                        <option value="20"
                            {{ old('limit_by', request()->input('limit_by')) == '20' ? 'selected' : '' }}>20</option>
                        <option value="50"
                            {{ old('limit_by', request()->input('limit_by')) == '50' ? 'selected' : '' }}>50</option>
                        <option value="100"
                            {{ old('limit_by', request()->input('limit_by')) == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
            <div class="col-2 col-sm-2 col-md-2 ">
            </div>
            <div class="col-2 col-sm-2 col-md-1">
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-link">{{ __('panel.search') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
