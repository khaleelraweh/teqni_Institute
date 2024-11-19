@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{asset('backend/vendor/select2/css/select2.min.css')}}">
@endsection

@section('content')

    {{-- main holder page  --}}
    <div class="card shadow mb-4">

        {{-- menu part  --}}
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">Edit Product {{$product->name}}</h6>
            <div class="ml-auto">
                <a href="{{route('admin.products.index')}}" class="btn btn-primary">
                    <span class="icon text-white-50">
                        <i class="fa fa-home"></i>
                    </span>
                    <span class="text">Products</span>
                </a>
            </div>
        </div>

        {{-- body part  --}}
        <div class="card-body">
            {{-- enctype used cause we will save images  --}}
            <form action="{{route('admin.products.update',$product->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{old('name',$product->name)}}" class="form-control" placeholder="name">
                            @error('name') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                    <div class="col-3">
                        <label for="category_id">Category</label>
                        <select name="product_category_id" class="form-control">
                            <option value="">---</option>
                            @forelse ($categories as $category)
                            <option value="{{$category->id}}" {{old('product_category_id',$product->product_category_id) == $category->id ? 'selected' : null }}>{{ $category->name }}</option>
                            @empty 
                            @endforelse
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="">---</option>
                            <option value="1" {{ old('status',$product->status) == '1' ? 'selected' : null}}>Active</option>
                            <option value="0" {{ old('status',$product->status) == '0' ? 'selected' : null}}>Inactive</option>
                        </select>
                        @error('status')<span class="text-danger">{{$message}}</span>@enderror
                    </div>
                </div>

                {{-- description row --}}
                <div class="row">
                    <div class="col-12">
                        <label for="description">Description</label>
                        <textarea name="description"  rows="10" class="form-control summernote">
                            {!!old('description',$product->description)!!} <!-- To get html code we use  -->
                        </textarea>
                    </div>
                </div>

                <div class="row pt-4">
                    
                    <div class="col-4">
                        <label for="quantity">Quantity</label>
                        <input type="text" name="quantity" id="quantity" value="{{old('quantity',$product->quantity)}}" class="form-control" placeholder="quantity">
                        @error('quantity') <span class="text-danger">{{$message}}</span> @enderror                        
                    </div>

                    <div class="col-4">
                        <label for="price">Price</label>
                        <input type="text" name="price" id="price" value="{{old('price',$product->price)}}" class="form-control" placeholder="price">
                        @error('price') <span class="text-danger">{{$message}}</span> @enderror                        
                    </div>

                    <div class="col-4">
                        <label for="featured">Featured</label>
                        <select name="featured" class="form-control">
                            <option value="">---</option>
                            <option value="1" {{ old('featured',$product->featured) == '1' ? 'selected' : null}}>Yes</option>
                            <option value="0" {{ old('featured',$product->featured) == '0' ? 'selected' : null}}>No</option>
                        </select>
                        @error('featured')<span class="text-danger">{{$message}}</span>@enderror                       
                    </div>

                </div>

                {{-- tags row --}}
                <div class="row pt-4">
                    <div class="col-12">
                        <label for="tags">tags</label>
                        <select name="tags" class="form-control select2" multiple="multiple">
                            {{-- tags we needed it as an array with only tags id to compare value to be selected --}}
                            @forelse ($tags as $tag)
                            {{-- check if $tag->id in array $product->tags->pluck('id')->toArray():[ex:1,2,3,..] of product tags id --}}
                                <option value="{{$tag->id}}" {{in_array($tag->id , $product->tags->pluck('id')->toArray()) ? 'selected' :null}} >{{$tag->name}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>


                <div class="row pt-4">
                    <div class="col-12">
                        <label for="images">Images</label>
                        <br>
                        <div class="file-loading">
                            <input type="file" name="images[]" id="product_images" class="file-input-overview" multiple="multiple">
                            @error('images')<span class="text-danger">{{$message}}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group pt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Update Product</button>
                </div>

            </form>
        </div>
        
    </div>

@endsection

@section('script')
    {{-- Call select2 plugin --}}
    <script src="{{asset('backend/vendor/select2/js/select2.full.min.js')}}"></script>
    
    <script>
        $(function(){
            
            $("#product_images").fileinput({
                theme:"fa5",
                maxFileCount: 5 ,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial:false,
                // اضافات للتعامل مع الصورة عند التعديل علي احد اقسام المنتجات
                // delete images from media and assets/products 
                // because there are maybe more than one image we will go for each image and show them in the edit page 
                initialPreview: [
                    @if($product->media()->count() > 0)
                        @foreach($product->media as $media)
                            "{{ asset('assets/products/' . $media->file_name)}}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData:true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if($product->media()->count() > 0)
                        @foreach($product->media as $media)
                            { 
                                caption: "{{$media->file_name }}",
                                size: '{{$media->file_size}}' , 
                                width: "120px" , 
                                // url : الراوت المستخدم لحذف الصورة
                                url: "{{route('admin.products.remove_image' , ['image_id' => $media->id , 'product_id' => $product->id , '_token'=> csrf_token()]) }}", 
                                key:{{ $media->id}} 
                            },                        
                        @endforeach
                    @endif
                    
                ]
            }).on('filesorted',function(event,params){
                console.log(params.previewId ,params.oldIndex,params.newIndex,params.stack);
            });

            $('.summernote').summernote({
                tabSize:2,
                height:200,
                toolbar:[
                    ['style' ,['style']],
                    ['font',['bold','underline','clear']],
                    ['color',['color']],
                    ['para',['ul','ol','paragraph']],
                    ['table',['table']],
                    ['insert',['link','picture','video']],
                    ['view',['fullscreen','codeview','help']]
                ]
            });


             //select2: code to search in data 
             function matchStart(params, data) {
                    // If there are no search terms, return all of the data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Skip if there is no 'children' property
                    if (typeof data.children === 'undefined') {
                        return null;
                    }

                    // `data.children` contains the actual options that we are matching against
                    var filteredChildren = [];
                    $.each(data.children, function (idx, child) {
                        if (child.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        filteredChildren.push(child);
                        }
                    });

                    // If we matched any of the timezone group's children, then set the matched children on the group
                    // and return the group object
                    if (filteredChildren.length) {
                        var modifiedData = $.extend({}, data, true);
                        modifiedData.children = filteredChildren;

                        // You can return modified objects from here
                        // This includes matching the `children` how you want in nested data sets
                        return modifiedData;
                    }

                    // Return `null` if the term should not be displayed
                    return null;
            }

            // select2 : .select2 : is  identifier used with element to be effected
            $(".select2").select2({
                tags:true,
                colseOnSelect:false,
                minimumResultsForSearch: Infinity,
                matcher: matchStart
            });

        });
    </script>

  
    
@endsection
