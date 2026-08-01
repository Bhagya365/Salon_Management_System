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


            <!-- Summary Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card m-b-20" style="background-color:#F1C40F;">
                        <div class="card-body text-white">
                            <h4 class="text-white">Pending Cards</h4>
                            <hr style="border-color: rgba(255,255,255,0.4);">
                            <h2 class="text-white">{{ $pendingCount }}</h2>
                            <p class="mb-0">Cards not yet started.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card m-b-20" style="background-color:#3498DB;">
                        <div class="card-body text-white">
                            <h4 class="text-white">In Progress</h4>
                            <hr style="border-color: rgba(255,255,255,0.4);">
                            <h2 class="text-white">{{ $inProgressCount }}</h2>
                            <p class="mb-0">Services currently being done.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card m-b-20" style="background-color:#16A085;">
                        <div class="card-body text-white">
                            <h4 class="text-white">Completed</h4>
                            <hr style="border-color: rgba(255,255,255,0.4);">
                            <h2 class="text-white">{{ $completedCount }}</h2>
                            <p class="mb-0">Ready for invoicing.</p>
                        </div>
                    </div>
                </div>
            </div>



            <!-- table starts -->
            <div class="col-lg-12">
                <div class="card m-b-20">
                    <div class="card-body">

                        <div class="table-rep-plugin">
                            <div class="table-responsive b-0" data-pattern="priority-columns">
                                <table id="datatable-servicecards" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>CARD ID</th>
                                        <th>CLIENT NAME</th>
                                        <th>APPOINTMENTS</th>
                                        <th>DATE</th>
                                        <th>STATUS</th>
                                        <th>OPTIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(isset($cards))
                                        @if(count($cards)>0)
                                            @forelse($cards as $card)
                                                <tr>
                                                    <td>SC - {{ $card->idservice_card }}</td>
                                                    <td>{{ $card->client->first_name ?? '' }} {{ $card->client->last_name ?? '' }}</td>
                                                    <td>{{ $card->appointments->count() }} APPOINTMENT(S)</td>
                                                    <td>{{ $card->created_at->format('d/m/Y') }}</td>

                                                    <!-- status column starts-->
                                                    <td>
                                                        @if($card->status == \App\ServiceCard::STATUS_PENDING)
                                                            <span class="badge badge-pill badge-warning">Pending</span>
                                                        @elseif($card->status == \App\ServiceCard::STATUS_IN_PROGRESS)
                                                            <span class="badge badge-pill badge-info">In Progress</span>
                                                        @elseif($card->status == \App\ServiceCard::STATUS_COMPLETED)
                                                            <span class="badge badge-pill badge-success">Completed</span>
                                                        @endif
                                                        
                                                    </td>
                                                    <!-- status column ends-->

                                                     <!-- option column starts--> 
                                                    <td>  
                                                        <p>
                                                            <button type="button" title="View"
                                                                    class="btn btn-sm btn-default waves-effect waves-light viewServiceCardBtn"
                                                                    data-toggle="modal"
                                                                    data-id="{{ $card->idservice_card }}"
                                                                    data-client="{{ $card->client->first_name ?? '' }} {{ $card->client->last_name ?? '' }}"
                                                                    data-date="{{ $card->created_at->format('d/m/Y') }}"
                                                                    data-status="{{ $card->status }}"
                                                                    data-target="#viewServiceCardModal">
                                                                <i class="fa fa-eye"></i>
                                                            </button>

                                                            @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1 ||
                                                                \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3 )

                                                                @if(!$readOnly)  <!-- Block for absents-->

                                                                    @if($card->status == 0 || $card->status == \App\ServiceCard::STATUS_PENDING)

                                                                        <button type="button" title="Set In Progress"
                                                                                class="btn btn-sm btn-info waves-effect waves-light ml-1"
                                                                                onclick="setInProgress({{ $card->idservice_card }})">
                                                                                In Progress
                                                                        </button>

                                                                    @endif
                                                                @endif

                                                            @endif
                                                        </p>
                                                    </td>
                                                    <!-- option column ends-->

                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="6" style="text-align:center; font-weight:bold;">No service cards found.</td>
                                                </tr>
                                            @endforelse
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


<div class="modal fade" id="viewServiceCardModal" tabindex="-1" role="dialog"
     aria-labelledby="viewServiceCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Service Card Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Service Card ID</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewCardId" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Client Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewClientName" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Created Date</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewCardDate" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-8" style="padding-top: 7px;">
                        <span id="viewCardStatusBadge"></span>
                    </div>
                </div>

                <hr/>

                <h6 class="font-weight-bold mb-3">Appointments List</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>APPOINTMENT ID</th>
                                <th>SERVICE / CATEGORY</th>
                                <th>AMOUNT</th>
                                <th>DATE</th>
                            </tr>
                        </thead>
                        <tbody id="viewAppointmentsList">

                        </tbody>
                    </table>
                </div>

                <div class="form-group row mt-3 mb-0">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-md btn-outline-primary waves-effect float-right" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- View Service Card Modal End -->





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

        $('#datatable-servicecards').DataTable();

        $('#scClient').select2({
            placeholder: "Select Client",
            allowClear: false
        });


    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });






    $(document).on('click', '.viewServiceCardBtn', function () {
        var cardId = $(this).data("id");
        var clientName = $(this).data("client");
        var createdDate = $(this).data("date");
        var status = $(this).data("status");

        $("#viewCardId").val("SC - " + cardId);
        $("#viewClientName").val(clientName);
        $("#viewCardDate").val(createdDate);

        var statusBadge = '';
        if(status == 0){
            statusBadge = '<span class="badge badge-pill badge-warning" style="font-size:13px; padding: 6px 12px;">Pending</span>';
        } else if(status == 2){
            statusBadge = '<span class="badge badge-pill badge-info" style="font-size:13px; padding: 6px 12px;">In Progress</span>';
        } else if(status == 1){
            statusBadge = '<span class="badge badge-pill badge-success" style="font-size:13px; padding: 6px 12px;">Completed</span>';
        }
        $("#viewCardStatusBadge").html(statusBadge);

        $("#viewAppointmentsList").html('<tr><td colspan="4" class="text-center text-muted">Loading appointments...</td></tr>');

        $.get('getServiceCardData/' + cardId, function(data){
            var html = '';
            var appointments = (data.card && data.card.appointments) ? data.card.appointments : data.appointments;
            if(appointments && appointments.length > 0){
                $.each(appointments, function(index, apt){
                    var categoryName = apt.category ? apt.category.category_name 
                                     : (apt.Category ? apt.Category.category_name : 'N/A');
                    html += '<tr>' +
                        '<td>APT - ' + apt.idappointment + '</td>' +
                        '<td>' + categoryName + '</td>' +
                        '<td>LKR ' + parseFloat(apt.amount).toFixed(2) + '</td>' +
                        '<td>' + (apt.date ? apt.date : '') + '</td>' +
                        '</tr>';
                });
            } else {
                html = '<tr><td colspan="4" class="text-center text-muted">No appointments linked.</td></tr>';
            }
            $("#viewAppointmentsList").html(html);
        });
    });


    // Open Edit modal — load existing card data via AJAX
    function openEditModal(cardId){

        $('#editCardId').val(cardId);
        $('#scEditAppointmentsList').html('<p class="text-muted">Loading...</p>');
        $('#editServiceCardModal').modal('show');

        $.get('getServiceCardData/' + cardId, function(data){

            var selectedIds = data.selectedIds;
            var html = '';

            $.each(data.appointments, function(index, apt){
                var checked = selectedIds.includes(apt.idappointment) ? 'checked' : '';
                html += '<div class="custom-control custom-checkbox mb-2">' +
                    '<input type="checkbox" class="custom-control-input sc-edit-apt-checkbox" id="edit-apt-' + apt.idappointment + '" value="' + apt.idappointment + '" ' + checked + '>' +
                    '<label class="custom-control-label" for="edit-apt-' + apt.idappointment + '">' +
                    'APT - ' + apt.idappointment + ' — ' + (apt.Category ? apt.Category.service_name : 'Service') +
                    ' — LKR ' + parseFloat(apt.amount).toFixed(2) +
                    '</label></div>';
            });

            $('#scEditAppointmentsList').html(html || '<p class="text-muted">No appointments available.</p>');
        });
    }

    
    function setInProgress(cardId){
        $.post('setInProgress/' + cardId, {}, handleCardActionResponse);
    }


    function handleCardActionResponse(data){
        if(data.errors != null){
            var msg = data.errors.permission ? data.errors.permission[0]
                    : (data.errors.status ? data.errors.status[0] : 'Something went wrong.');
            notify({ type: "danger", title: 'Error', autoHide: true, delay: 2500,
                    position: { x: "right", y: "top" }, message: msg });
            return;
        }
        if(data.success != null){
            notify({ type: "success", title: 'Updated', autoHide: true, delay: 2500,
                    position: { x: "right", y: "top" }, message: data.success });
            setTimeout(function(){ location.reload(); }, 1000);
        }
    }

    // Reset the Add modal when closed
    $('#addServiceCardModal').on('hidden.bs.modal', function () {
        $('#scClientError').html('');
        $('#scAppointmentsError').html('');
        $('#scClient').val(null).trigger('change');
        $('#scAppointmentsList').html('<p class="text-muted">Select a client first.</p>');
    });



</script>
@include('includes/footer_end')