@extends('admin.layout.authIndex')

@section('title') Admin Login @endsection

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
                <form class="col-lg-12" id="loginform" method="post"  action="{{ url('/admin/login')}}">
                {{ csrf_field() }}
                    <h5 class="title">Sign in to your Account</h5>
                    <div class="form-group form-float">
                        <div class="form-line">
                        <input class="form-control" type="email"  id="email" name="email" placeholder="" tabindex="1" required data-validation-required-message= "Please enter your email">    
                        
                            <label class="form-label">Email</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                        <input class="form-control" type="password" name="password" id="password" placeholder="" tabindex="2" required data-validation-required-message= "Please enter your password"> 
                            <label class="form-label">Password</label>
                        </div>
                    </div>
                    <div>
                        <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-cyan">
                        <label for="rememberme">Remember Me</label>
                    </div> 
                    <div class="col-lg-12">
                        
                        <input type="submit" value="Log In" class="btn btn-raised btn-primary waves-effect btnLogin">                  
                    </div> 
                    <div class="col-lg-12 m-t-20">
                        <a class="" href="{{ route('adminForgotPassword') }}">Forgot Password?</a>
                    </div>                      
                </form>
                
                                   
            </div>
        </div>
   
    </div>
</div>


@endsection

@section('js')

    <script src="{{ url('admin-assets/js/jquery.validate.min.js') }}" ></script>
    <script type="text/javascript">
        function showPassword() 
        {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") 
            {
                passwordInput.type = "text";
                $('#passwordIconId').find('i').removeClass("fas fa-eye-slash").addClass("fas fa-eye");
            } 
            else 
            {
                passwordInput.type = "password";
                $('#passwordIconId').find('i').removeClass("fas fa-eye").addClass("fas fa-eye-slash");
            }
        } 
       
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

            $("#loginform").validate({
                rules: {
                    email: {
                        required: true,
                        email:email,
                        regex:emailpattern
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter email",
                        email:"Please enter valid email",
                        regex:"Please enter valid email"
                    },
                    password: {
                        required: "Please enter password",
                    }
                },
                submitHandler: function (form)
                {   
                    $('.btnLogin').attr('disabled',true);
                    form.submit();
                }
            });
        });
    </script>
@endsection