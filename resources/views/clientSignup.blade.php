@include('includes.header_account')

<link rel="stylesheet" href="{{ asset('user_assets/css/styletheme.css') }}">

<script src="user_assets\js\clientSignup.js" defer></script>

<!-- Begin page -->

<!--Background Image-->
<div class="accountbg" style="background-image: url('{{ asset('assets/images/bg_6.jpg') }}');"> </div>



<div class="wrapper-page" >

    <div class="card custom-card custom-input">
        <div class="card-body">
            <div class="p-3">
                <h4 class="font-22 m-b-5 text-center gold-label">Sign Up</h4>

                <form class="form-horizontal m-t-30" enctype="multipart/form-data" action="{{ route('saveClient') }}" method="POST" id="saveUser">
                    {{csrf_field()}}

                    <div class="form-group">
                        <label class="gold-label">First Name<span style="color: red"> *</span></label>
                        <input type="text" class="form-control custom-input" id="fName" autocomplete="off" name="fName" placeholder="First Name" required>
                        <small class="text-danger" id="fNameError"></small>
                    </div>

                    <div class="form-group">
                        <label class="gold-label">Last Name<span style="color: red"> *</span></label>
                        <input type="text" class="form-control custom-input" id="lName" autocomplete="off" name="lName" placeholder="Last Name" required>
                        <small class="text-danger" id="lNameError"></small>
                    </div>

                    <div class="form-group">
                        <label class="gold-label">Contact No<span style="color: red"> *</span></label>
                        <input type="tel" class="form-control custom-input" id="contactNo" autocomplete="off" name="contactNo" placeholder="+(94) XX XXX XXXX" maxlength="10">
                        <small class="text-danger" id="contactNoError"></small>
                    </div>
                   

                    <div class="form-group">
                        <label class="gold-label">Gender<span style="color: red"> *</span></label>
                        <select class="form-control custom-input" name="gender" id="gender" required>
                            <option disabled value="" selected> Select Gender</option>
                            <option> Male </option>
                            <option> Female </option>
                        </select>
                        <small class="text-danger" id="genderError"></small>
                    </div>

                    <div class="form-group fDg">
                        <label class="gold-label">Date of Birth<span style="color: red"> *</span></label>
                        <input type="date" class="form-control custom-input date1" id="date" autocomplete="off" name="date" placeholder="Date of Birth" required max="<?php echo date('Y-m-d'); ?>">
                        <div class="inDateBox"></div>
                        <small class="text-danger" id="dateError"></small>
                    </div>

                    <div class="form-group">
                        <label for="username" class="gold-label">User Name<span style="color: red"> *</span></label>
                        <input type="email" class="form-control custom-input" id="username" autocomplete="new-email" name="username"
                               placeholder="example@email.com">
                        <small class="text-danger" id="usernameError"></small>
                    </div>

                    <div class="form-group">
                        <label for="password" class="gold-label">Password<span style="color: red"> *</span></label>
                        <input type="password" class="form-control custom-input" id="password" autocomplete="new-password" name="password" placeholder="Enter password">
                        <small class="text-danger" id="passwordError"></small>
                    </div>


                    <div class="form-group row m-t-20">
                        <div class="col-lg" align="right">
                            <a href="{{ route('clientInterface') }}" class="btn btn-gold-black">Back</a>
                        </div>

                        <div class="col-lg" align="right">
                            <button class="btn btn-gold-black" type="submit">Register</button>
                        </div>
                    </div>


                </form>


            </div>
        </div>
    </div>

</div>



@include('includes.footer_account')


<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });





    //Sign Up
    $("#saveUser").on("submit", function (event) {

            $("#fNameError").html('');
            $("#lNameError").html('');
            $("#contactNoError").html('');
            $("#genderError").html('');
            $("#dateError").html('');
            $("#usernameError").html('');
            $("#passwordError").html('');


            event.preventDefault();

            $.ajax({
                url: '{{route('saveClient')}}',
                type: 'POST',
                data: $(this).serialize(),
                success: function (data) {

                 if (data.errors != null) {

                        if(data.errors.fName) {
                            var p = document.getElementById('fNameError');
                            p.innerHTML = data.errors.fName[0];
                        }

                         if(data.errors.lName) {
                             var p = document.getElementById('lNameError');
                             p.innerHTML = data.errors.lName[0];
                         }

                        if(data.errors.contactNo) {
                            var p = document.getElementById('contactNoError');
                            p.innerHTML = data.errors.contactNo[0];
                        }

                        if(data.errors.gender) {
                            var p = document.getElementById('genderError');
                            p.innerHTML = data.errors.gender[0];
                        }

                        if(data.errors.date) {
                            var p = document.getElementById('dateError');
                            p.innerHTML = data.errors.date[0];
                        }

                        if(data.errors.username) {
                            var p = document.getElementById('usernameError');
                            p.innerHTML = data.errors.username[0];
                        }

                         if(data.errors.password) {
                             var p = document.getElementById('passwordError');
                             p.innerHTML = data.errors.password[0];
                         }


                    }



                    if (data.success != null) {


                        notify({
                            type: "success", //alert | success | error | warning | info
                            title: 'Registration Success',
                            autoHide: true, //true | false
                            delay: 200, //number ms
                            position: {
                                x: "right",
                                y: "top"
                            },
                            // icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',

                            message: data.success,
                        });

                        setTimeout(function () {
                           // location.reload();
                           window.location.href = "signin"; //After Sign Up, loads signin page for Login

                        }, 200);
                    }

                }
            });
        }
    );

</script>

