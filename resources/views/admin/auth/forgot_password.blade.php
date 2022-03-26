@extends('admin.layout.authIndex')

@section('title') Admin Forgot Password @endsection

@section('content')
<div class="authentication">
@include('admin.common.flash')
    <div class="card">
        <div class="body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header slideDown">
                        <div class="logo"><img src="{{url('admin-assets/images/')}}" width="52%" alt=""></div>
                        <h1>Welcome To {{config('constant.PROJECT_NAME')}} E-Shop Admin</h1>
                       
                    </div>                        
                </div>

                <form id="forgotform" class="col-lg-12" id="forgot_password" method="POST">
                    {{csrf_field()}}
                    <h5 class="title">Forgot Password?</h5>
                    <small class="msg">Enter your e-mail address below to reset your password.</small>
                    <div class="form-group form-float">
                            <div class="form-line">
                                <input type="email" class="form-control" name="email" id="email">
                                <label class="form-label">Email</label>
                            </div>
                        </div>
               
                <div class="col-lg-12">
                    <input type="submit" value="Reset my password" class="btn btn-raised btn-primary waves-effect" disabled>
                </div>
                </form>
                <div class="col-lg-12 m-t-20">
                    <a href="{{route('adminLogin')}}" title="">Sign In!</a>
                </div>
                                   
            </div>
        </div>
   
    </div>
</div>
@endsection

@section('js')

    <script src="{{ url('admin-assets/js/jquery.validate.min.js') }}" ></script>

    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });

    </script>

    <!--  jquery validation -->
    <script type="text/javascript">
        $(document).ready(function ()
        {
            var emailpattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,9}|[0-9]{1,3})(\]?)$/;

            $.validator.addMethod(
                    "regex",
                    function(value, element, regexp) {
                        var re = new RegExp(regexp);
                        return this.optional(element) || re.test(value);
                    },
                    "Please check your input."
            );

            $("#forgotform").validate({
                rules: {
                    email: {
                        required: true,
                        email:email,
                        regex:emailpattern,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email",
                        email:"Please enter valid email",
                        regex:"Please enter valid email"
                    }
                },
                submitHandler: function (form)
                {   

                     $('.btnForgot').attr('disabled',true);
                    form.submit();
                }
            });


        });
    </script>

@endsection