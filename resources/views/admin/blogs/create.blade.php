@extends('admin.layout.index')
@section('title') Blogs @endsection

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Blog Us</h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-12">
                <div class="card">
                    <div class="body">
                        @include('admin.common.flash')
                        @if(empty($blogDetail))
                        <form class="form" name="blogCreate" id="blogCreate" method="post" enctype="multipart/form-data" action="{{ route('blogs.store') }}">
                            @else
                            <form class="form" name="blogUpdate" id="blogUpdate" action="{{ route('blogs.update', ['blog' => $blogDetail->id])}}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @endif


                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="custom-label">Blog Title</label>
                                                <input type="text" class="form-control" name="title" id="title" value="{{$blogDetail->title ?? ''}}">
                                            </div>
                                        </div>
                                    </div>        
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="custom-label">Blog Image</label>
                                        <div class="form-group">
                                            <div class="text-center preview_holder">
                                                <img id="imagePreview" class="img-responsive img-thumbnail" />
                                            </div>

                                            <div class="text-center m-b-10">
                                                <div class="form-group text-center">
                                                    <div class="">
                                                        <span class="btn g-bg-blue waves-effect m-b-15 btn-file">
                                                            Change <input type="file" id="blog_image" name="blog_image" data-value="{{$blogDetail->blog_image ?? ''}}" class="filestyle" data-parsley-pattern="[^.]+(.png|.jpg|.jpeg|.PNG|.JPG|.JPEG)$" data-parsley-pattern-message="Please upload image with valid extension" data-parsley-trigger="change" data-parsley-errors-container=".profile_error" />
                                                        </span>

                                                    </div>
                                                    <label id="blog_image-error" class="error" for="blog_image" style="display: none;">Please select blog image</label>
                                                    <span class="profile_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="custom-label">Blog Content</label>
                                        <div class="form-group">

                                            <textarea id="ckeditor" name="blog_content" placeholder="Enter blogs">
                                                @if(isset($blogDetail->blog_content))
                                                {{  $blogDetail->blog_content }}
                                                @endif
                                            </textarea>
                                            <label id="ckeditor-error" class="error" for="ckeditor" style="display: none;">Please enter blog content</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="custom-label">Status</label>
                                            <input name="is_active" type="radio" id="active" class="with-gap radio-col-blue" {{(!empty($blogDetail) && ($blogDetail->is_active == 1)) ? 'checked' : (empty($blogDetail) ? 'checked' : '')}} value="1" data-parsley-multiple="type">
                                            <label for="active">Active</label>
                                            <input name="is_active" type="radio" id="in_active" class="with-gap radio-col-blue" {{(!empty($blogDetail) && ($blogDetail->is_active == 0)) ? 'checked' : ''}} value="0" data-parsley-multiple="type">
                                            <label for="in_active">In Active</label>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4 offset-md-4">
                                        <div class="form-group form-float">

                                            <button type="submit" class="btn btn-raised bg-app waves-effect m-t-20">Submit</button>
                                            <button type="reset" class="btn btn-raised btn-default waves-effect m-t-20">Cancel</button>

                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')

<script type="text/javascript" src="{{url('admin-assets/plugins/ckeditor_full_4/ckeditor/ckeditor.js')}}"></script>

<script>
    @if(!empty($blogDetail))
    $("#imagePreview").css("background-image", "url('{{config('constant.S3_bLOGS').$blogDetail->blog_image}}')");
    @endif

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#blog_image").change(function() {
        readURL(this);
    });



    jQuery(document).ready(function($) {

        CKEDITOR.replace('ckeditor', {
            width: 1000,
            height: 200,
            // resize_dir: 'none',
            resize_minWidth: 200,
            resize_minHeight: 300,
            resize_maxWidth: 800
        });
    });

    $(".form").validate({
        ignore: [],
        debug: true,
        rules: {
            title : {
                required : true
            },
            blog_content: {
                ckrequired : true,
            }
        },
        messages: {
            blog_content: {
                ckrequired: 'Please enter blog content'
            },
            title : {
                required : 'Please enter blog title'
            }
        },
        submitHandler: function(form) {

            if (checkFileExtention()) {
                form.submit();
            }

        }
    });

    function checkFileExtention() {
        if ($('#blog_image').val() != "") {
            var ext = $('#blog_image').val().split('.').pop().toLowerCase();
        } else {
            var ext = $('#blog_image').data('value').split('.').pop().toLowerCase();
        }

        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            $('#blog_image-error').text('Please upload image with valid extention (gif,png,jpg,jpeg)');
            $('#blog_image-error').show();
            return false;
        }
        return true;
    }
</script>
@endsection