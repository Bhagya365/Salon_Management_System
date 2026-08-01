@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<!-- Responsive datatable examples -->
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

<!-- Plugins css -->
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/mdb.css')}}" rel="stylesheet" type="text/css">
<!-- Custom CSS -->
<link rel="stylesheet" href="{{ asset('user_assets/css/styletheme.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}"/>


@include('includes/header_end')

<!-- Page title -->
<ul class="list-inline menu-left mb-0">
    <li class="list-inline-item">
        <button type="button" class="button-menu-mobile open-left waves-effect">
            <i class="ion-navicon"></i>
        </button>
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">{{ $title }}</h3>
    </li>
</ul>

<div class="clearfix"></div>
</nav>

</div>
<!-- Top Bar End -->

<!-- ==================
     PAGE CONTENT START
     ================== -->

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable"   class="table table-striped table-bordered"
                                   cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Client ID</th>
                                    <th>Client Name</th>
                                    <th>Service</th>
                                    <th>Stylist Name</th>
                                    <th>Date</th>
                                    <th>Time Slot</th>
                                    <th>Status</th>

                                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role != 2)
                                        @if(!$readOnly)  <!-- Block for absents-->
                                            <th>Options</th>
                                        @endif
                                    @endif

                                </tr>
                                </thead>

                                <tbody>
                                @if(isset($appointments))
                                    @if(count($appointments)>0)
                                        @foreach($appointments as $apnt)
                                            <tr>
                                                <td>APT - {{$apnt->idappointment}}</td>
                                                <td>REG - {{$apnt->client_id}}</td>
                                                <td>{{$apnt->Client->first_name}} {{$apnt->Client->last_name}}</td>
                                                <td>{{$apnt->Category->service_name}}</td>
                                                <td>{{$apnt->User->first_name}} {{$apnt->User->last_name}}</td>
                                                <td>{{$apnt->date}}</td>
                                                <td>{{$apnt->TimeSlot->time_slot}}</td>

                                                <!-- status column starts-->
                                                @if($apnt->status==0)
                                                    <td>
                                                        <span class="badge badge-pill badge-warning">Pending</span>

                                                    </td>
                                                @endif

                                                @if($apnt->status==1)
                                                    <td>
                                                        <span class="badge badge-pill badge-success">Completed</span>

                                                    </td>
                                                @endif

                                                @if($apnt->status==2)
                                                    <td>
                                                        <span class="badge badge-pill badge-danger">Canceled</span>

                                                    </td>
                                                @endif
                                                <!-- status column ends-->


                                                <!-- option column starts--> 
                                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role != 2)
                                                    @if(!$readOnly)  <!-- Block for absents-->

                                                        <td>
                                                            @if($apnt->status==0)
                                                                                    
                                                                    <!-- if pending - show buttons -->
                                                                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1  ||
                                                                        \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)  {{--Showing payment button only if user role is 1 and 3--}}

                                                                        <p>
                                                                        <button type="button" class="btn btn-primary " onclick="setPaymentAmount({{$apnt->idappointment}},{{$apnt->amount}},{{$apnt->Client}})"
                                                                                data-toggle="modal"  data-target="#paymentModal" >
                                                                            Payment
                                                                        </button>

                                                                        </p>

                                                                    @endif



                                                                    &nbsp;
                                                                    &nbsp;


                                                                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1  ||
                                                                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3 ||
                                                                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 4)


                                                                            <p>
                                                                                <button type="button" class="btn btn-danger " onclick="cancelAppointment({{$apnt->idappointment}})">
                                                                                    Cancel
                                                                                </button>
                                                                            </p>

                                                                        @endif
                                                                

                                                            @endif

                                                            @if($apnt->status==1)

                                                                <p>
                                                                <!-- if completed - show feedback button -->

                                                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 4)

                                                                    <p>
                                                                        <button type="button" class="btn btn-primary " onclick="setAppointmnetId({{$apnt->idappointment}})"
                                                                            data-toggle="modal"  data-target="#feedbackModal">
                                                                            Feedback
                                                                        </button>
                                                                    </p>

                                                                @endif

                                                                </p>
                                                            @endif

                                                        </td>
                                                    @endif
                                                @endif

                                                <!-- option column ends-->

                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                                </tbody>

                            </table>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->

</div>






<!--Payment Modal Start-->
<div class="modal fade" id="paymentModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Make Payment</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>


            <div class="modal-body">
                <input type="hidden" class="form-control" name="appointmentId"
                       id="appointmentId" />

                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" class="form-control" name="nameAppointment"
                           id="nameAppointment" value="" readonly/>
                    <span class="text-danger" id="nameError"></span>
                </div>


                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" name="amount_app" readonly
                           id="amount_app" value="" required />
                    <span class="text-danger" id="categoryError"></span>
                </div>

                <div class="form-group">
                    <label>Payment Method <span style="color: red">*</span></label>
                    <select class="form-control" name="paytype" id="paytype" required>
                        <option disabled value="">Select Payment Method</option>
                        <option> CASH </option>
                        <option> CARD </option>
                    </select>
                    <span class="text-danger" id="paytypeError"></span>
                </div>


                <div class="form-group">
                    <button type="button"  class="btn btn-primary float-right"
                            onclick="savePayment()" >
                        Save Payment
                    </button>
                </div>


            </div>

        </div>
    </div>
</div>
<!--Payment Modal End-->


<!--Feedback Modal Start-->
<div class="modal fade" id="feedbackModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Feed Back Form</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>


            <div class="modal-body">
                <input type="hidden" name="fbAppointmentId" id="fbAppointmentId" />

                <div class="form-group">
                    <label>Appointment Id</label>
                    <input type="text" class="form-control" name="feedbackAppointmentId"
                           id="feedbackAppointmentId" value="" readonly/>
                    <span class="text-danger" id="idError"></span>
                </div>


                <div class="form-group">
                    <label>Rate</label>
                    <div class="star-rating" id="starRating">
                        <i class="star" data-value="1">&#9733;</i>
                        <i class="star" data-value="2">&#9733;</i>
                        <i class="star" data-value="3">&#9733;</i>
                        <i class="star" data-value="4">&#9733;</i>
                        <i class="star" data-value="5">&#9733;</i>
                    </div>
                    <input type="hidden" name="rate" 
                           id="rate" value="" required />
                    <span class="text-danger" id="rateError"></span>
                </div>

                <div class="form-group">
                    <label>Comment</label>
                    <input type="text" class="form-control" name="comment" 
                           id="comment" value="" required />
                    <span class="text-danger" id="commentError"></span>
                </div>


                <div class="form-group">
                    <button type="button"  class="btn btn-primary float-right"
                            onclick="saveFeedback()" >
                        Save Feedback
                    </button>
                </div>


            </div>

        </div>
    </div>
</div>
<!--Feedback Modal End-->






@include('includes/footer_start')

<!-- Plugins js -->
<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}"
        type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<!-- Responsive examples -->
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>

<!-- Datatable init js -->
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>

<!-- Parsley js -->
<script type="text/javascript" src="{{ URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/bootstrap-notify.js')}}"></script>
<script src="{{ URL::asset('assets/js/jquery.notify.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Select2 initialization
        $('#paytype').select2({
            placeholder: "Select Payment Method",
            allowClear: false,
            minimumResultsForSearch: -1
        });   

    

    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });





    // save appointment 
    function saveAppointment(){
        var category=$('#category').val();
        var date=$('#date').val();
        var timeSlot=$("#timeSlot").val();     

        $.post('saveAppointment',{
            category:category,
            date:date,
            timeSlot:timeSlot

        },function (data) {

            if(data.success){
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'Appointment Saved',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });
                //cleared EVERY input on the page
                $('input').val('');
                setTimeout(function () {
                    $('#addAppointmentModal').modal('hide');
                }, 200);

                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                // added the failure case
                notify({
                    type: "error",
                    title: 'Could Not Save',
                    autoHide: true,
                    delay: 3000,
                    position: { x: "right", y: "top" },
                    message: data.message || 'Something went wrong while saving the appointment.',
                });
            }
        })
    }


    // dynamically change displays a price
    function showAmount(categoryId) {

        $.post('showAmount',{
            categoryId:categoryId
        },function (data) {
            console.log(data)

            $("#amount").html(data);
        })

    }



    
    // save payment 
    function savePayment() {

        var appointmentID=$("#appointmentId").val();
        var amount=$("#amount_app").val();
        var payment_type=$("#paytype").val();

        // clear previous errors
        $("#paytypeError").html("");

        if (!payment_type) {
            $("#paytypeError").html("Payment method is required");
            return;
        }

        $.post('savePayment',{
            appointmentID:appointmentID,
            amount:amount,
            payment_type: payment_type
            
        },function (data) {
            if(data.success){
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'Payment Saved',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });
                $('input').val('');
                setTimeout(function () {
                    $('#paymentModal').modal('hide');
                }, 200);

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        })  
        
    }



    //cancel button

    function cancelAppointment(aptId) {

        $("#errorAlert2").hide();
        $("#errorAlert2").html('');

        swal({
            title: 'Are you sure?',
            text: 'Want to cancel the appointment?',
            //type: 'warning',
            dangerMode: true,
            buttons: true,
            showCancelButton: true,
            confirmButtonText: 'YES',
            confirmButtonColor: '#CC0000',
            cancelButtonColor: '#00695c',
            cancelButtonText: 'NO',
            confirmButtonClass: 'btn btn-md btn-danger waves-effect',
            cancelButtonClass: 'btn btn-md btn-primary waves-effect',
            buttonsStyling: true
        }).then(function() {
            $.post('cancelAppointment', {
                aptId: aptId
            }, function(data) {
                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'APPOINTMENT CANCELED',
                        autoHide: true, //true | false
                        delay: 2500, //number ms
                        position: {
                            x: "right",
                            y: "top"
                        },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',

                        message: data.success,
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                }
            })

        })
    }




    
    //show readonly values in modal 
    function setPaymentAmount(appointmentId,amount,user) {

        $("#appointmentId").val(appointmentId);
        $("#nameAppointment").val(user.first_name+' '+user.last_name)        
        $("#amount_app").val(amount);

    }



    //show readonly values in modal 
    function setAppointmnetId(appointmentId) {

        $("#fbAppointmentId").val(appointmentId);             
        $("#feedbackAppointmentId").val("APT - " + appointmentId);

    }


    //star rating interaction logic
    var selectedRate = 0;

    $(document).on('click', '.star-rating .star', function () {
        selectedRate = $(this).data('value');
        $('#rate').val(selectedRate);
        highlightStars(selectedRate);
    });

    $(document).on('mouseenter', '.star-rating .star', function () {
        highlightStars($(this).data('value'));
    });

    $(document).on('mouseleave', '#starRating', function () {
        highlightStars(selectedRate);
    });

    function highlightStars(count) {
        $('.star-rating .star').each(function () {
            $(this).toggleClass('selected', $(this).data('value') <= count);
        });
    }




    // feedback button
    function saveFeedback() {

 
        var appointmentID=$("#fbAppointmentId").val();
        var rate=$("#rate").val();
        var comment=$("#comment").val();

        // clear previous errors
        $("#rateError").html("");
        $("#commentError").html("");

        if (!rate) {
            $("#rateError").html("Rate is required");
        }
        if (!comment) {
            $("#commentError").html("Comment is required");
        }
        if (!rate || !comment) {
            return;                            // both errors appears
        }

        $.post('saveFeedback',{
            appointmentID:appointmentID,
            rate:rate,
            comment: comment
            
        },function (data) {

        
            if(data.success){
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'Feedback Saved',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });
                $('input').val('');
                // reset stars
                selectedRate = 0;       
                highlightStars(0);
                setTimeout(function () {
                    $('#feedbackModal').modal('hide');
                }, 200);

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        })

    }


    // clear error 
        $("#paytype").on("change", function () {
            $("#paytypeError").html("");
        });

    // reset the modal fields when its closed
        $('#paymentModal').on('hidden.bs.modal', function () {
            $("#appointmentId").val("");
            $("#nameAppointment").val("");
            $("#amount_app").val("");
            $("#paytypeError").html("");
            $("#paytype").val(null).trigger("change"); // .trigger('change') needed so select2's UI updates too
            
        });

        // reset the modal fields when its closed
        $('#feedbackModal').on('hidden.bs.modal', function () {
            $("#feedbackAppointmentId").val("");
            $("#rate").val("");
            $("#comment").val("");
            $("#rateError").html("");
            $("#commentError").html("");

            selectedRate = 0;     
            highlightStars(0);
        });
        


</script>
@include('includes/footer_end')