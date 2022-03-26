@extends('admin.layout.index')
@section('title') {{!empty($userDetail) ? 'Edit' : 'Add'}} User @endsection

@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2> {{!empty($userDetail) ? 'Edit' : 'Add'}} User
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
                        @if(empty($userDetail))
                        <form class="form" name="createUser" id="createUser" method="post" enctype="multipart/form-data" action="{{ route('users.store') }}">
                            @else
                            <form class="form" name="updateUser" id="updateUser" action="{{ route('users.update', ['user' => $userDetail->id])}}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @endif

                                {{ csrf_field() }}

                                <input type="hidden" name="user_id" id="user_id" value="{{$userDetail->id ?? ''}}">

                                <h3> User Details</h3>

                                <div class="row demo-masked-input">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="custom-label">First Name</label>
                                                <input type="text" class="form-control alphaOnly" name="first_name" id="first_name" value="{{$userDetail->first_name ?? ''}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="custom-label">Last Name</label>
                                                <input type="text" class="form-control alphaOnly" name="last_name" id="last_name" value="{{$userDetail->last_name ?? ''}}">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row demo-masked-input">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="custom-label">Email Address</label>
                                                <input type="email" class="form-control " name="email" id="email" value="{{$userDetail->email ?? ''}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="custom-label">Password</label>
                                                @if(!empty($userDetail))
                                                <input type="text" class="form-control " name="password" id="password" value="**********************" disabled>
                                                @else
                                                <input type="text" class="form-control " name="password" id="password" value="{{$userDetail->password ?? ''}}">
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row demo-masked-input">

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="custom-label">Phone Number</label>
                                                <input type="text" class="form-control numeric" name="phone_number" id="phone_number" value="{{$userDetail->phone_number ?? ''}}">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="text-center preview_holder">
                                        <img id="imagePreview" class="img-responsive img-thumbnail" />
                                    </div>
                                    <div class="text-center m-b-10">
                                        <div class="form-group text-center">
                                            <div class="">
                                                <span class="btn g-bg-blue waves-effect m-b-15 btn-file">
                                                    Change <input type="file" id="profile_image" name="profile_image" data-value="{{$userDetail->profile_image ?? ''}}" class="filestyle" data-parsley-pattern="[^.]+(.png|.jpg|.jpeg|.PNG|.JPG|.JPEG)$" data-parsley-pattern-message="Please upload image with valid extension" data-parsley-trigger="change" data-parsley-errors-container=".profile_error" />
                                                </span>

                                            </div>
                                            <label id="profile_image-error" class="error" for="profile_image" style="display: none;">Please select profile image</label>
                                            <span class="profile_error"></span>
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
        @include('admin.common.footer_detail')
    </div>
</section>
@endsection

@section('js')

<script>


    $(document).ready(function() {
    
        $("#imagePreview").css("background-image", "url('{{(!empty($userDetail->profile_image) ? $userDetail->profile_image : '')}}')");

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $("#imagePreview").css("background-image", "url("+e.target.result+")");
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#profile_image").change(function () {
        readURL(this);
    });

        var emailpattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,9}|[0-9]{1,3})(\]?)$/;

        $.validator.addMethod(
            "regex",
            function(value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Please check your input."
        );

        $(".form").validate({
            rules: {

                first_name: {
                    required: true,
                    maxlength: 100
                },
                last_name: {
                    required: true,
                    maxlength: 100
                },
                email: {
                    required: true,
                    email: email,
                    regex: emailpattern,
                    remote: {
                            url:url+'/check/unique/users/email/id',
                            type: "post",
                            data: {
                                value: function() {
                                    return $( "#email" ).val();
                                },
                                id: function() {
                                   return $( "#user_id" ).val();
                                },
                            }
                        },
                },
                password: {
                    required: true,
                    maxlength: 50
                },
                phone_number: {
                    required: true,
                    maxlength: 10
                }

            },
            messages: {
                first_name: {
                    required: 'Please enter first name',
                    maxlength: 'First name must be less than {0} characters',
                },
                last_name: {
                    required: 'Please enter last name',
                    maxlength: 'Last name must be less than {0} characters',
                },
                email: {
                    required: 'Please enter email address',
                    email: "Please enter valid email address",
                    regex: "Please enter valid email address"
                },
                password: {
                    required: 'Please enter password',
                    maxlength: 'Password must be less than {0} characters',
                },
                phone_number: {
                    required: 'Please enter phone number',
                    maxlength: 'Phone number must be less than {0} characters',
                }

            }
        });
    });
</script>
@endsection