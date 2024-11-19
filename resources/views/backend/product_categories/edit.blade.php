@extends('layouts.admin')
@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- menu part  --}}
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">ُEdit Category {{$productCategory->name}}</h6>
            <div class="ml-auto">
                <a href="{{route('admin.product_categories.index')}}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Categories</span>
                </a>
            </div>
        </div>

        {{-- body part  --}}
        <div class="card-body">
            {{-- enctype used cause we will save images  --}}
            {{-- we send route name and the id of product Category that will be update --}}
            <form action="{{route('admin.product_categories.update',$productCategory->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- تستخدم مع عملية ارسال فورم لدالة ابديت --}}
                @method('PATCH')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{old('name',$productCategory->name)}}" class="form-control" placeholder="name">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="parent_id">Parent</label>
                        <select name="parent_id" class="form-control">
                            <option value="">---</option>
                            @forelse ($main_categories as $main_category)
                            <option value="{{$main_category->id}}" {{old('parent_id',$productCategory->parent_id) == $main_category->id ? 'selected' : null }}>{{ $main_category->name }}</option>
                            @empty 
                            @endforelse
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="">---</option>
                            <option value="1" {{ old('status',$productCategory->status) == '1' ? 'selected' : null}}>Active</option>
                            <option value="0" {{ old('status',$productCategory->status) == '0' ? 'selected' : null}}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{$message}}</span>@enderror
                    </div>

                </div>
                {{-- end row --}}

                <div class="row pt-4">
                    <div class="col-12">
                        <label for="cover">Cover</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="cover" id="category_image" class="file-input-overview ">
                            <span class="form-text text-muted">Image width should be 500px x 500px </span>
                            @error('cover')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Update Category</button>
                </div>

            </form>
        </div>
        
    </div>

@endsection

@section('script')
    {{--#category_image is the id in file input file above  --}}
    <script>
        $(function(){
            $("#category_image").fileinput({
                theme:"fa5",
                maxFileCount: 1 ,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial:false,
                // اضافات للتعامل مع الصورة عند التعديل علي احد اقسام المنتجات
                initialPreview: [
                    @if($productCategory->cover !='')
                    "{{ asset('assets/product_categories/' . $productCategory->cover)}}",
                    @endif
                ],
                initialPreviewAsData:true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($productCategory->cover !='')
                    {
                        caption: "{{$productCategory->cover }}",
                        size: '111' , 
                        width: "120px" , 
                        // url : الراوت المستخدم لحذف الصورة
                        url: "{{route('admin.product_categories.remove_image' , ['product_category_id'=>$productCategory->id , '_token'=> csrf_token()]) }}", 
                        key:{{ $productCategory->id}} 
                    }
                    @endif
                ]
            });
        });
    </script>
    
@endsection
