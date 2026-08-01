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
    </li>
    <li class="hide-phone list-inline-item app-search">
        <h3 class="page-title">Client Report</h3>
    </li>
    <li class="hide-phone list-inline-item app-search">

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

                    <form action="{{ route('clientReport') }}" method="get">

                        <div class="row">
                            {{ csrf_field() }}



                            <!-- Search by Client ID -->
                            <!-- <div class="form-group col-md-4">
                                <input type="text" class="form-control" id="clientId" name="clientId"
                                       placeholder="Search by Client ID"
                                       value=""/>
                            </div> -->

                            <!-- Search by Client -->
                            <!-- <div class="form-group col-md-4">
                                <select class="form-control" id="clientName" name="clientName">
                                    <option value="">Search by Client</option>
                                    @if(isset($clients))
                                        @foreach($clients as $client)
                                            <option value="{{"$client->idclient"}}">  {{ $client->first_name }}  {{ $client->last_name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div> -->


                            <!-- Search by Contact number -->
                            <!-- <div class="form-group col-md-4">
                                <select class="form-control" id="contactNo" name="contactNo">
                                    <option value="">Search by Contact number</option>
                                    @if(isset($clients))
                                        @foreach($clients as $client)
                                            <option value="{{"$client->contact_number"}}">  {{ $client->contact_number }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div> -->


                            <!-- Start Date -->
                            <div class="form-group col-md-4">
                                <label>Start Date:</label>
                                <input type="date" class="form-control" id="startDate" name="startDate"
                                       value=""/> &nbsp; &nbsp; &nbsp; &nbsp;
                            </div>

                            <!-- End Date -->
                            <div class="form-group col-md-4">
                                <label>End Date:</label>
                                <input type="date" class="form-control" id="endDate" name="endDate"
                                       value=""/>
                            </div>


                            <div class="form-group col-md-2" style="padding-top: 28px">
                                <button type="submit" class="btn btn-md btn-primary waves-effect"
                                >Search
                                </button>

                                <!-- reset button -->
                                <a href="{{ route('clientReport') }}" class="btn btn-md btn-primary waves-effect" style="margin-left: 20px;">Clear</a>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <!--PDF,Excel Options-->
                            <table  class="table table-striped table-bordered" id="datatable-buttons"
                                    cellspacing="0"
                                    width="100%">
                                <thead>
                                <tr>
                                    <th>CLIENT ID</th>
                                    <th>REGISTERED DATE</th>
                                    <th>CLIENT NAME</th>
                                    <th>CONTACT NO</th>
                                    <th>USER NAME</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($clients))
                                    @if(count($clients)!=0)

                                        @foreach($clients as $client)
                                            <tr>
                                                <td>REG-{{$client->idclient}}</td>
                                                <td>{{$client->created_at->format('d/m/Y')}}</td>
                                                <td>{{$client->first_name}} {{$client->last_name}}</td>
                                                <td>{{$client->contact_number}}</td>
                                                <td>{{$client->user_name}}</td>

                                            </tr>
                                        @endforeach


                                    @else
                                        <tr>
                                            <!--colspan-No of columns of the table-->
                                            <td colspan="5" style="text-align: center;font-weight: bold  ">Sorry no results found. </td>
                                        </tr>


                                    @endif
                                @endif


                                </tbody>
                            </table>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->



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
        // $('#clientName').select2({
        //     placeholder: "Search by Client",
        //     allowClear: false
        // });  

        // $('#contactNo').select2({
        //     placeholder: "Search by Contact Number",
        //     allowClear: false
        // });


    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });


</script>
@include('includes/footer_end')