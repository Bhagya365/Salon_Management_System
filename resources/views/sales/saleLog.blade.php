@include('includes/header_start')

<link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet"/>
<link href="{{ URL::asset('assets/css/custom_checkbox.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/css/jquery.notify.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/mdb.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('user_assets/css/styletheme.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}"/>

@include('includes/header_end')

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

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Sale ID</th>
                                    <th>Client ID</th>
                                    <th>Client Name</th>
                                    <th>Items</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role != 2)
                                        @if(!$readOnly)  <!-- Block for absents-->
                                            <th>Options</th>
                                        @endif
                                    @endif
                                </tr>
                                </thead>

                                <tbody>

                                @if(isset($sales))
                                    @if(count($sales) > 0)
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td>SL - {{ $sale->idsale }}</td>
                                                <td>REG - {{ $sale->client_idclient }}</td>
                                                <td>{{ $sale->Client->first_name }} {{ $sale->Client->last_name }}</td>
                                                <td>{{ $sale->items->sum('quantity') }}</td>
                                                <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                                                <td>Rs. {{ number_format($sale->total_amount, 2) }}</td>

                                                <!-- status column starts-->
                                                @if($sale->status == 0)

                                                    <td><span class="badge badge-pill badge-warning">Pending</span></td>

                                                @endif

                                                @if($sale->status == 1)

                                                    <td><span class="badge badge-pill badge-success">Completed</span></td>

                                                @endif

                                                @if($sale->status == 2)

                                                    <td><span class="badge badge-pill badge-danger">Canceled</span></td>

                                                @endif
                                                <!-- status column ends-->


                                                <!-- option column starts--> 
                                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role != 2)
                                                    @if(!$readOnly)  <!-- Block for absents-->
                                                        <td>
                                                            @if($sale->status == 0)
                                                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1 ||
                                                                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)
                                                                    <p>
                                                                        <button type="button" class="btn btn-primary"
                                                                                onclick="setPaymentAmount({{ $sale->idsale }}, {{ $sale->total_amount }}, '{{ addslashes($sale->Client->first_name.' '.$sale->Client->last_name) }}')"
                                                                                data-toggle="modal" data-target="#paymentModal">
                                                                            Payment
                                                                        </button>
                                                                    </p>
                                                                @endif

                                                                &nbsp;&nbsp;

                                                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1 ||
                                                                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3 ||
                                                                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 4)
                                                                    <p>
                                                                        <button type="button" class="btn btn-danger" onclick="cancelSale({{ $sale->idsale }})">
                                                                            Cancel
                                                                        </button>
                                                                    </p>
                                                                @endif
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
    </div>
</div>
</div>

<!--Payment Modal Start-->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Make Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" name="saleId" id="saleId" />
                <div class="form-group">
                    <label>Client Name</label>
                    <input type="text" class="form-control" name="nameSale" id="nameSale" value="" readonly/>
                    <span class="text-danger" id="nameError"></span>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" name="amount_sale" readonly id="amount_sale" value="" required />
                    <span class="text-danger" id="amountError"></span>
                </div>
                <div class="form-group">
                    <label>Payment Method <span style="color: red">*</span></label>
                    <select class="form-control" name="paytype" id="paytype" required>
                        <option disabled value="">Select Payment Method</option>
                        <option>CASH</option>
                        <option>CARD</option>
                    </select>
                    <span class="text-danger" id="paytypeError"></span>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary float-right" onclick="savePayment()">
                        Save Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Payment Modal End-->

@include('includes/footer_start')

<script src="{{ URL::asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/pages/form-advanced.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/pages/sweet-alert.init.js')}}"></script>
<script src="{{ URL::asset('assets/pages/datatables.init.js')}}"></script>
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

        $('#paytype').select2({
            placeholder: "Select Payment Method",
            allowClear: false,
            minimumResultsForSearch: -1
        });
    });

    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });

    function savePayment() {
        var saleID = $("#saleId").val();
        var amount = $("#amount_sale").val();
        var payment_type = $("#paytype").val();

        $("#paytypeError").html("");

        if (!payment_type) {
            $("#paytypeError").html("Payment method is required");
            return;
        }

        $.post('saveSalePayment', {
            saleID: saleID,
            amount: amount,
            payment_type: payment_type
        }, function (data) {
            if (data.success) {
                notify({
                    type: "success",
                    title: 'Payment Saved',
                    autoHide: true,
                    delay: 2500,
                    position: { x: "right", y: "top" },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });
                $('input').val('');
                setTimeout(function () { $('#paymentModal').modal('hide'); }, 200);
                setTimeout(function () { location.reload(); }, 1000);
            } else if (data.error) {
                $("#paytypeError").html(data.error);
            }
        });
    }

    function cancelSale(saleId) {
        $("#errorAlert2").hide();
        $("#errorAlert2").html('');

        swal({
            title: 'Are you sure?',
            text: 'Want to cancel the purchase?',
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
        }).then(function () {
            $.post('cancelPurchase', { saleId: saleId }, function (data) {
                if (data.success != null) {
                    notify({
                        type: "success",
                        title: 'PURCHASE CANCELED',
                        autoHide: true,
                        delay: 2500,
                        position: { x: "right", y: "top" },
                        icon: '<img src="{{ URL::asset('assets/images/correct.png') }}" />',
                        message: data.success,
                    });
                    setTimeout(function () { location.reload(); }, 800);
                }
            });
        });
    }

    function setPaymentAmount(saleId, amount, clientName) {
        $("#saleId").val(saleId);
        $("#nameSale").val(clientName);
        $("#amount_sale").val(amount);
    }

    $("#paytype").on("change", function () {
        $("#paytypeError").html("");
    });

    $('#paymentModal').on('hidden.bs.modal', function () {
        $("#saleId").val("");
        $("#nameSale").val("");
        $("#amount_sale").val("");
        $("#paytypeError").html("");
        $("#paytype").val(null).trigger("change");
    });
</script>
@include('includes/footer_end')