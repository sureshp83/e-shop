@extends('admin.layout.index')
@section('title') Products @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/plugins/select2/dist/css/select2.css') }}" />
@endsection
@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{!empty($productDetail) ? 'Edit' : 'Add'}} Product
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}"><i class="zmdi zmdi-home"></i> Home</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-12">
                <div class="card">
                    <div class="body">
                        @if(empty($productDetail))
                        <form class="form" name="createProduct" id="createProduct" method="post" enctype="multipart/form-data" action="{{ route('products.store') }}">
                        @else
                            <form class="form" name="updateProduct" id="updateProduct" action="{{ route('products.update', ['product' => $productDetail->id])}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @endif

                        {{ csrf_field() }}
                        <input type="hidden" name="productId" id="productId" value="{{$productDetail->id ?? ''}}">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            
                                            <label class="custom-label">Category</label>
                                            <select name="category_id" id="category_id" class="select2">
                                                <option value="">Select Parent Category</option>
                                                @forelse($parentCategories as $parent)
                                                <option value="{{$parent->id}}" {{(!empty($productDetail) && $productDetail->category_id == $parent->id) ? 'selected' : '' }}>{{$parent->category}}</option>
                                                @empty
                                                <option value="">Not found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row demo-masked-input">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="custom-label">Product Name</label>
                                            <input type="text" class="form-control alphaOnly" name="product_name" id="product_name" value="{{$productDetail->product_name ?? ''}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <label class="custom-label">Price</label>
                                            <input type="text" class="form-control numeric" name="price" id="price" value="{{$productDetail->price ?? ''}}">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="custom-label">Description</label>
                                <textarea id="ckeditor" name="description" placeholder="Enter description">
                                    @if(isset($productDetail->description))
                                    {{  $productDetail->description }}
                                    @endif
                                </textarea>
                                <label id="ckeditor-error" class="error" for="ckeditor" style="display: none;"></label>

                            </div>
                            
                           

                             


                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                    <label class="custom-label">Status</label>
                                        <input name="is_active" type="radio" id="active" class="with-gap radio-col-blue" {{(!empty($productDetail) && ($productDetail->is_active == 1)) ? 'checked' : (empty($productDetail) ? 'checked' : '')}} value="1" data-parsley-multiple="type">
                                        <label for="active">Active</label>
                                        <input name="is_active" type="radio" id="in_active" class="with-gap radio-col-blue" {{(!empty($productDetail) && ($productDetail->is_active == 0)) ? 'checked' : ''}} value="0" data-parsley-multiple="type">
                                        <label for="in_active">In Active</label>
                                        
                                    </div>
                                </div>      
                            </div>

                            <div class="row">
                                <div class="col-md-4 offset-md-2">
                                    <div class="form-group form-float">
                                        
                                        <button type="submit" class="btn btn-raised bg-app waves-effect m-t-20">Submit</button>
                                        <button type="reset" class="btn btn-raised btn-default waves-effect m-t-20">Cancel</button>
                                        
                                    </div>
                                </div>        
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ url('admin-assets/plugins/select2/dist/js/select2.min.js')}}"></script>

<script type="text/javascript" src="{{url('admin-assets/plugins/ckeditor_full_4/ckeditor/ckeditor.js')}}"></script>

<script>

jQuery(document).ready(function($) {
        
        CKEDITOR.replace( 'ckeditor',{
            width: 1000,
            height: 200,
            // resize_dir: 'none',
            resize_minWidth: 200,
            resize_minHeight: 300,
            resize_maxWidth: 800
    });
    });

        $("#category_id").select2({width: '100%'}).on("change", function(e) {
             if(e.val)
             {
                 $("#category_id option[value='"+e.val+"']").attr("selected","selected");
             }
         });

         $(".form").validate({
        rules: {
                product_name: {
                    required: true,
                    remote: {
                            url:url+'/check/unique/products/product_name/id',
                            type: "post",
                            data: {
                                value: function() {
                                    return $( "#product_name" ).val();
                                },
                                id: function() {
                                   return $( "#productId" ).val();
                                },
                            }
                        },
                },
                category_id : {
                    required : true,
                },
                price : {
                    required : true
                }
        },
        messages:{
            product_name : {
                required : 'Please enter product name',
                remote : 'This product name already exist'
            },
            category_id : {
                required : 'Please select category',
            },
            price : {
                required : 'Please enter product price'
            }
        },
        submitHandler: function (form)
            {   
                
                if(checkFileExtention())
                {
                    form.submit();
                }
                
            }    
    });    

    function checkFileExtention()
    {
        if($('#category_image').val() != "")
        {
            var ext = $('#category_image').val().split('.').pop().toLowerCase();
        }
        else{
            var ext = $('#category_image').data('value').split('.').pop().toLowerCase();
        }
        
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            $('#category_image-error').text('Please upload image with valid extention (gif,png,jpg,jpeg)');
            $('#category_image-error').show();
            return false;
        }
        return true;
    }

</script>
@endsection