@extends('layouts.loginmaster')
@section('title','Reset Password')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v1 px-2">
                <div class="auth-inner py-2">
                    <!-- Reset Password v1 -->
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="javascript:void(0);" class="brand-logo align-items-center">                                
                                <h2 class="brand-text text-primary">Demo</h2>
                            </a>

                            <h4 class="card-title mb-1">Reset Password 🔒</h4>
                            <!-- <p class="card-text mb-2">Your new password must be different from previously used passwords</p> -->
                            @include('errormessage')
                            {!! Form::open(['route' => array('reset-password',$token,$isMobile),'class'=>'auth-reset-password-form mt-2','id'=>'reset-password-form','name'=>'reset-password-form','method'=>"POST"]) !!}
                            @csrf
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label for="reset-password-new">New Password</label>
                                </div>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control form-control-merge" id="password" name="password" placeholder="Enter Password" aria-describedby="reset-password-new" tabindex="1" autofocus />
                                    <div class="input-group-append">
                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label for="reset-password-confirm">Confirm Password</label>
                                </div>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control form-control-merge" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password" aria-describedby="reset-password-confirm" tabindex="2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block submitbutton" type="submit" tabindex="3">Set New Password</button>
                            {{ Form::close() }}

                            <!-- <p class="text-center mt-2">
                                <a href=""> <i data-feather="chevron-left"></i> Back to login </a>
                            </p> -->
                        </div>
                    </div>
                    <!-- /Reset Password v1 -->
                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function () {
    // Password Custom Validation Method
    $.validator.addMethod("password", function (value, element) {
        let password = value;
        if (!(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[#?!@$%^&*-])/.test(password))) {
            return false;
        }
        return true;
    }, function (value, element) {
        let password = $(element).val();
        if (!(/^(?=.*[A-Z])/.test(password))) {
            return "Password must contains at least one Uppercase.";
        } else if (!(/^(?=.*[a-z])/.test(password))) {
            return "Password must contains at least one Lowercase.";
        } else if (!(/^(?=.*[0-9])/.test(password))) {
            return "Password must contains at least one Digit.";
        } else if (!(/^(?=.*[#?!@$%^&*-])/.test(password))) {
            return "Password must contains at least one Special Character";
        }
        return false;
    });

    $("#reset-password-form").validate({
        rules: {
            password: {
                required: true,
                password: true,
                minlength: 8,
                maxlength: 20
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            }
        },
        submitHandler: function(form) {
                if($("#reset-password-form").validate().checkForm()){
                $(".submitbutton").attr("type", "button");
                $(".submitbutton").addClass("disabled");
                form.submit();
            }
        }
    });
});
</script>
@endsection

