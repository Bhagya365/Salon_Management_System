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
                                    data-toggle="modal"  data-target="#addServiceCardModal">
                                Add Service Card
                            </button>
                        </div>
                    </div>

                    <br/>
                    <!-- Appointments table starts-->
                     <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">

                            <table id="selectedAppointmentsTable"   class="table table-striped table-bordered"
                                   cellspacing="0"
                                   width="100%">
                
                                <thead class="thead-light">
                                    <tr>
                                        <th>CLIENT NAME</th>
                                        <th>APPOINTMENT ID</th>
                                        <th>SERVICE / CATEGORY</th>
                                        <th>DATE</th>
                                        <th>AMOUNT (LKR)</th>                       
                                        <th>OPTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="selectedAppointmentsBody">
                                    <tr id="emptyCartRow">
                                        <td colspan="6" class="text-center text-muted">No appointments added yet.</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">Total Amount:</th>
                                        <th colspan="2">LKR <span id="totalCardAmount">0.00</span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12">

                            <button type="button" class="btn btn-primary float-right" onclick="submitServiceCard()">                   
                                Make Service Card
                            </button>

                        </div>
                    </div>
                    <!-- Appointments table ends-->
                </div>
            </div>
        </div>


        <!-- Recent Service Cards Table Section -->
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h5 class="card-title">Recent Service Cards</h5>

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0">
                            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>CARD ID</th>
                                        <th>CLIENT NAME</th>
                                        <th>APPOINTMENTS</th>
                                        <th>DATE</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($cards) && count($cards) > 0)
                                        @foreach($cards as $card)
                                            <tr>
                                                <td>SC - {{ $card->idservice_card }}</td>
                                                <td>{{ $card->client->first_name ?? '' }} {{ $card->client->last_name ?? '' }}</td>
                                                <td>{{ $card->appointments->count() }} APPOINTMENT(S)</td>
                                                <td>{{ $card->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($card->status == \App\ServiceCard::STATUS_PENDING)

                                                        <span class="badge badge-pill badge-warning">Pending</span>

                                                    @elseif($card->status == \App\ServiceCard::STATUS_IN_PROGRESS)

                                                        <span class="badge badge-pill badge-info">In Progress</span>

                                                    @elseif($card->status == \App\ServiceCard::STATUS_COMPLETED)

                                                        <span class="badge badge-pill badge-success">Completed</span>
                                                        
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No service cards found.</td>
                                        </tr>
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


<!-- Add Service Card Modal -->

<div class="modal fade" id="addServiceCardModal" role="dialog" aria-labelledby="addServiceCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Service Card</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body">
       

                <div class="form-group">
                    <label>Client <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="scClient" onchange="fetchClientAppointments(this.value)">
                        <option value="">Select Client</option>
                        @if(isset($clients))
                            @foreach($clients as $client)
                                <option value="{{ $client->idclient }}" data-name="{{ $client->first_name }} {{ $client->last_name }}">
                                    {{ $client->first_name }} {{ $client->last_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <small class="text-danger" id="scClientError"></small>
                </div>

 
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control" id="scDate" value="{{ date('Y-m-d') }}" onchange="fetchClientAppointments($('#scClient').val())">
                </div>

      
                <div class="form-group">
                    <label>Select Services / Booked Appointments <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="scAppointmentSelect">
                        <option value="">Select Client First </option>
                    </select>
                    <small class="text-danger" id="scAppointmentsError"></small>
                </div>

                <div class="form-group row mt-4 mb-0">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-primary float-right" onclick="addAppointmentFromModal()">                   
                            Add to List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- View Appointment Details Modal -->
<div class="modal fade" id="viewAptModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Appointment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Appointment ID</label>
                    <div class="col-sm-8"><input type="text" class="form-control" id="vAptId" readonly></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Service / Category</label>
                    <div class="col-sm-8"><input type="text" class="form-control" id="vAptService" readonly></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Date</label>
                    <div class="col-sm-8"><input type="text" class="form-control" id="vAptDate" readonly></div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Amount</label>
                    <div class="col-sm-8"><input type="text" class="form-control" id="vAptAmount" readonly></div>
                </div>             
                <div class="form-group row mb-0">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-md btn-outline-primary waves-effect float-right" data-dismiss="modal">Close</button>
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
    var addedAppointmentsMap = {}; // Stores added appointment objects by ID
    var currentSelectedClientId = null;

    $(document).ready(function () {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });


        $('#datatable').DataTable();
        $('#scClient').select2({ 
            placeholder: "Select Client", 
            allowClear: false, 
            dropdownParent: $('#addServiceCardModal') 
        });

        $('#scAppointmentSelect').select2({ 
            placeholder: "Select Appointment", 
            allowClear: false, 
            dropdownParent: $('#addServiceCardModal') 
        });
    });

  
    function fetchClientAppointments(clientId) {
        if(!clientId) {
            $('#scAppointmentSelect').html('<option value=""> Select Client First </option>').trigger('change');
            return;
        }

        if(currentSelectedClientId && currentSelectedClientId != clientId && Object.keys(addedAppointmentsMap).length > 0) {
            addedAppointmentsMap = {};
            renderCartTable();
        }
        currentSelectedClientId = clientId;

        var dateVal = $('#scDate').val();

        $.post('getFilteredAppointments', {
            client_id: clientId,
            appointment_date: dateVal
        }, function(data) {
            var html = '<option value=""> Select Appointment Service </option>';
            if(data && data.length > 0) {
                $.each(data, function(idx, apt) {
                    var serviceName = apt.category ? apt.category.category_name : (apt.Category ? apt.Category.category_name : 'Service');
                    var label = 'APT - ' + apt.idappointment + ' — ' + serviceName + ' (LKR ' + parseFloat(apt.amount).toFixed(2) + ')';
                    html += '<option value="' + apt.idappointment + '" data-apt=\'' + JSON.stringify(apt) + '\'>' + label + '</option>';
                });
            } else {
                html = '<option value="">No unassigned appointments found for this date</option>';
            }
            $('#scAppointmentSelect').html(html).trigger('change');
        });
    }

    // Add selected appointment from modal to the main page table
    function addAppointmentFromModal() {
        var selectedOpt = $('#scAppointmentSelect').find(':selected');
        var aptId = selectedOpt.val();

        if(!aptId) {
            $('#scAppointmentsError').html('Please select an appointment from the dropdown.');
            return;
        }
        $('#scAppointmentsError').html('');

        if(addedAppointmentsMap[aptId]) {
            notify({ type: "warning", 
            title: "Warning", 
            autoHide: true, delay: 2000, 
            position: { x: "right", y: "top" }, 
            message: "This appointment is already added to the table." });
            return;
        }

        var aptData = selectedOpt.data('apt');
        var clientName = $('#scClient option:selected').data('name') || ($('#scClient option:selected').text());

        addedAppointmentsMap[aptId] = {
            id: aptData.idappointment,
            clientName: clientName,
            serviceName: aptData.category ? aptData.category.category_name : (aptData.Category ? aptData.Category.category_name : 'Service'),
            amount: parseFloat(aptData.amount),
            date: aptData.date
        };

        renderCartTable();
        notify({ type: "success", 
        title: "Added", 
        autoHide: true, 
        delay: 2000, 
        position: { x: "right", y: "top" }, 
        message: "Appointment added to table." });
    }

    // Render table rows on main page and recalculate total
    function renderCartTable() {
        var keys = Object.keys(addedAppointmentsMap);
        if(keys.length === 0) {
            $('#selectedAppointmentsBody').html('<tr id="emptyCartRow"><td colspan="6" class="text-center text-muted">No appointments added yet. Click \'Add Service Card\' above to select client and add appointments.</td></tr>');
            $('#totalCardAmount').text('0.00');
            return;
        }

        var html = '';
        var total = 0;

        $.each(addedAppointmentsMap, function(id, apt) {
            total += apt.amount;
            html += '<tr id="row-apt-' + apt.id + '">' +
                '<td>' + apt.clientName + '</td>' +
                '<td>APT - ' + apt.id + '</td>' +
                '<td>' + apt.serviceName + '</td>' +
                '<td>LKR ' + apt.amount.toFixed(2) + '</td>' +
                '<td>' + apt.date + '</td>' +
                '<td>' +
                    '<button type="button" class="btn btn-sm btn-info waves-effect waves-light mr-1" onclick="viewAptDetails(' + apt.id + ')" title="View Details"><i class="fa fa-eye"></i> View</button>' 
                '</td>' +
                '</tr>';
        });

        $('#selectedAppointmentsBody').html(html);
        $('#totalCardAmount').text(total.toFixed(2));
    }

    // View modal details for an appointment in cart
    function viewAptDetails(aptId) {
        var apt = addedAppointmentsMap[aptId];
        if(apt) {
            $('#vAptId').val('APT - ' + apt.id);
            $('#vAptService').val(apt.serviceName);
            $('#vAptAmount').val('LKR ' + apt.amount.toFixed(2));
            $('#vAptDate').val(apt.date);
            $('#viewAptModal').modal('show');
        }
    }


    // Submit/Make Service Card (Saves Service Card with default status = 0)
    function submitServiceCard() {
        var clientId = $('#scClient').val();
        var appointmentIds = Object.keys(addedAppointmentsMap);

        if(!clientId) {
            notify({ type: "danger", title: "Error", autoHide: true, delay: 2500, position: { x: "right", y: "top" }, message: "Please open 'Add Service Card' modal and select a client." });
            return;
        }

        if(appointmentIds.length === 0) {
            notify({ type: "danger", title: "Error", autoHide: true, delay: 2500, position: { x: "right", y: "top" }, message: "Please add at least one appointment to the table before making a service card." });
            return;
        }

        $.post('saveServiceCard', {
            client_id: clientId,
            appointment_ids: appointmentIds
        }, function(data) {
            if(data.errors != null) {
                var msg = data.errors.client_id ? data.errors.client_id[0]
                        : (data.errors.appointment_ids ? data.errors.appointment_ids[0]
                        : (data.errors.permission ? data.errors.permission[0] : 'Error saving service card.'));
                notify({ type: "danger", 
                title: "Error", 
                autoHide: true, 
                delay: 2500, 
                position: { x: "right", y: "top" }, 
                message: msg });
                return;
            }

            if(data.success != null) {
                notify({
                    type: "success",
                    title: 'Service Card Created',
                    autoHide: true,
                    delay: 2500,
                    position: { x: "right", y: "top" },
                    message: data.success
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
    }
</script>

@include('includes/footer_end')