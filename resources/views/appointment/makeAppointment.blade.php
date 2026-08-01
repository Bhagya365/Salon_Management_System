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

                    <div class="row">
                        <div class="col-lg-8">
                        </div>
                        <div class="col-lg-4">
                            <button type="button" class="btn btn-primary float-right"
                                    data-toggle="modal"  data-target="#addAppointmentModal" >
                                Add Appointment</button>
                        </div>
                    </div>

            <br/>

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
                                    <th>Stylist Name</th>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Time Slot</th>
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
                                                <td>{{$apnt->User->first_name}} {{$apnt->User->last_name}}</td>
                                                <td>{{$apnt->Category->service_name}}</td>
                                                <td>{{$apnt->date}}</td>
                                                <td>{{$apnt->TimeSlot->time_slot}}</td>

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









<!--Add Appointment Modal-->
<div class="modal fade" id="addAppointmentModal"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Appointment</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>


            <div class="modal-body">
                <div class="row">

                    <div class="col-md-4 sm-12">
                        <div class="form-group">
                            <label>Client</label>


                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 4)
                                    <select class="form-control tab" name="client" id="client" required disabled>
                                        <option value="" disabled selected>Select Client</option>

                                        <option value="{{"$userLogged->idmaster_user"}}" selected>
                                            {{$userLogged->contact_number}} {{"$userLogged->first_name"}}
                                        </option>
                                    </select>
                                @endif


                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1)
                                    <select class="form-control select2 tab" name="client" id="client" required>
                                        <option value="" disabled selected>Select Client</option>
                                        @if(isset($userClients))
                                            @foreach($userClients as $userClient)
                                                <option value="{{"$userClient->idmaster_user"}}">  {{"$userClient->contact_number"}} {{"$userClient->first_name"}} </option>
                                            @endforeach
                                        @endif
                                    </select>

                                @endif


                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)

                                    <select class="form-control select2 tab" name="client" id="client" required>
                                        <option value="" disabled selected>Select Client  </option>
                                        @if(isset($userClients))
                                            @foreach($userClients as $userClient)
                                                <option value="{{"$userClient->idmaster_user"}}">  {{"$userClient->contact_number"}} {{"$userClient->first_name"}} </option>
                                            @endforeach
                                        @endif
                                    </select>

                                @endif

                            <small class="text-danger" id="clientError"></small>

                        </div>
                    </div>





                    <div class="col-md-4 sm-12">
                        <div class="form-group" >
                            <label>Category</label>
                            <select onchange="getServices(this.value)" class="form-control" name="servicecategory"
                                id="servicecategory">
                                <option disabled value="" selected>Select Category</option>
                                @if(isset($servicecategories))
                                    @foreach($servicecategories as $servicecategory)
                                        <option value="{{"$servicecategory->category_name"}}">  {{"$servicecategory->category_name"}} </option>
                                    @endforeach
                                @endif

                            </select>

                            <small class="text-danger" id="servicecategoryError"></small>

                        </div>
                    </div>



                    <div class="col-md-4 sm-12">
                        <div class="form-group">
                            <label>Service</label>
                            <select  onchange="showAmount(this.value)" class="form-control" name="category" id="category" required>
                                <option disabled value="" selected>Select Sevice</option>
                            </select>

                            <small class="text-danger" id="categoryError"></small>

                        </div>
                    </div>



                    <div class="col-md-4 sm-12">
                        <div class="form-group">
                            <label>Date</label>
                            <input  onchange="getStylistsForDate()" type="date" class="form-control" id="date" name="date" min="{{date('Y-m-d')}}"
                                   max="{{$maxDays->format('Y-m-d')}}"/>
                            <small class="text-danger" id="dateError"></small>
                        </div>
                    </div>



                    <div class="col-md-4 sm-12">
                        <div class="form-group">
                            <label>Stylist</label>
                            <select onchange="getTimeSlot()" class="form-control select2" name="stylist"
                                     id="stylist" required disabled>
                                <option disabled value="" selected>Select Date First</option>
                            </select>

                            <small class="text-danger" id="stylistError"></small>

                        </div>
                    </div>
              



                    <div class="col-md-4 sm-12">
                        <div class="form-group">
                            <label>Time Slot</label>
                            <div id="timeSlotBOx">
                                <select class="form-control" id="timeBox" required disabled>
                                    <option disabled value="" selected>Select Stylist First</option>
                                </select>
                            </div>
                            <small class="text-danger" id="timeSlotError"></small>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control" value="" readonly />
                        </div>
                    </div>
                    

                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-primary" onclick="saveAppointment()">
                            Save Appointment</button>
                    </div>
                </div>
                
            </div>



        </div>
    </div>
</div>
</div>


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
        $('#servicecategory').select2({
            placeholder: "Select Category",
            allowClear: false
        });  

        $('#category').select2({
            placeholder: "Select Service",
            allowClear: false
        });  


        $('#stylist').select2({
            placeholder: "Select Date First",
            allowClear: false
        });  

        $('#timeBox').select2({
            placeholder: "Select Time Slot",
            allowClear: false
        });

    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });






    function saveAppointment(){

        var client=$('#client').val();
        var category=$('#category').val();
        var date=$('#date').val();
        var timeSlot=$("#timeSlot").val();
        var stylist=$('#stylist').val();




        $.post('saveAppointment',{
            category:category,
            date:date,
            timeSlot:timeSlot,
            stylist:stylist,
            client:client


        },function (data) {



            if (data.errors != null) {

                if(data.errors.category){
                    var p = document.getElementById('categoryError');
                    p.innerHTML = data.errors.category[0];
                }


                if(data.errors.client){
                    var p = document.getElementById('clientError');
                    p.innerHTML = data.errors.client[0];
                }


                if(data.errors.date){
                    var p = document.getElementById('dateError');
                    p.innerHTML = data.errors.date[0];
                }


                if(data.errors.timeSlot){
                    var p = document.getElementById('timeSlotError');
                    p.innerHTML = data.errors.timeSlot[0];
                }


                if(data.errors.stylist){
                    var p = document.getElementById('stylistError');
                    p.innerHTML = data.errors.stylist[0];
                }


            }


            if(data.success != null){
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
                $('input').val('');
                setTimeout(function () {
                    $('#addAppointmentModal').modal('hide');
                }, 200);

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        })
    }



    function getServices(categoryName) {

        $.post('getServicesByCategory', {
            category_name: categoryName
        }, function (data) {

            var options = '<option disabled value="" selected>Select Service</option>';

            $.each(data, function (index, service) {
                options += '<option value="' + service.idcategory + '">' + service.service_name + '</option>';
            });

            $('#category').html(options).trigger('change'); // refreshes select2 display
            $('#amount').val(''); // clear old amount until new service is picked
        });
    }


    // automatically amount display
    function showAmount(categoryId) {

        if (!categoryId) {
            $("#amount").val('');
            return;
        }

        $.post('showAppointmentAmount',{
            categoryId:categoryId
        },function (data) {
        console.log(data)
            $("#amount").val(data ? data.amount: '');

        })

    }




    function getStylistsForDate() {

        var date = $("#date").val();

        // Reset dependent dropdowns whenever date changes
        $('#stylist').html('<option disabled value="" selected>Loading...</option>')
            .prop('disabled', true).trigger('change');

        $("#timeSlotBOx").html(
            '<select class="form-control" id="timeBox" required disabled>' +
            '<option disabled value="" selected>Select Stylist First</option></select>'
        );

        if (!date) {
            $('#stylist').html('<option disabled value="" selected>Select Date First</option>').trigger('change');
            return;
        }

        $.post('getStylistsForDate', {
            date: date
        }, function (data) {

            var options = '<option disabled value="" selected>Select Stylist</option>';

            $.each(data, function (index, stylist) {
                options += '<option value="' + stylist.idmaster_user + '">' + stylist.first_name + ' ' + stylist.last_name + '</option>';
            });

            $('#stylist').html(options).prop('disabled', false).trigger('change');
        });
    }


    // load time slots
    function getTimeSlot() {

        var date=$("#date").val();
        var stylist=$("#stylist").val();

        if (!date || !stylist) {
            return;
        }

        $.post('getTimeSlot',{
            date:date,
            stylist:stylist
        },function (data) {
            
            $("#timeSlotBOx").html(data);
            // re-init select2 since the select element was replaced
            $('#timeBox').select2({
                placeholder: "Select Time Slot",
                allowClear: false
            });
        })
    }


        //Hide Validation errors after closing the modal without refreshing
        $('.modal').on('hidden.bs.modal', function () {

            $('#categoryError').html('');
            $("#clientError").html('');
            $("#dateError").html('');
            $("#timeSlotError").html('');
            $("#stylistError").html('');


            $('input').val(''); //Clear input values of input fields

            $('#client').val(null).trigger('change');
            $('#servicecategory').val(null).trigger('change');
            $('#category').html('<option disabled value="" selected>Select Service</option>').trigger('change');

            $('#stylist').html('<option disabled value="" selected>Select Date First</option>')
                .prop('disabled', true).trigger('change');

            $("#timeSlotBOx").html(
                '<select class="form-control" id="timeBox" required disabled>' +
                '<option disabled value="" selected>Select Stylist First</option></select>'
            );

        });




</script>
@include('includes/footer_end')