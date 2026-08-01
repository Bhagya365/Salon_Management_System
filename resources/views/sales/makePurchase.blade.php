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
                                    data-toggle="modal"  data-target="#addPurchaseModal">
                                Add Purchase
                            </button>
                        </div>
                    </div>

                    <br/>

                    <!-- Cart table starts-->

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">

                            <table id="cartTable"   class="table table-striped table-bordered"
                                   cellspacing="0"
                                   width="100%">
                                    <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Date</th>
                                        <th>Subtotal</th>
                                        <th>Option</th>
                                    </tr>
                                    </thead>

                                    <tbody id="cartBody">
                                        <tr id="cartEmptyRow">
                                            <td colspan="7" class="text-center text-muted">Cart is empty</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-right">Total</th>
                                            <th colspan="2">Rs. <span id="cartTotal">0.00</span></th>
                                        </tr>
                                    </tfoot>

                            </table>

                        </div>
                    </div>

                    <button type="button" class="btn btn-primary float-right" onclick="checkout()">                   
                        Complete Purchase
                    </button>

                    <!-- Cart table ends-->

                </div>
            </div>
        </div>


        <!-- Recent Purchases starts -->
        <div class="col-lg-12">
            <div class="card m-b-20">
                <div class="card-body">
                    <h5 class="card-title">Recent Purchases</h5>

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">
                            <table id="datatable"   class="table table-striped table-bordered"
                                   cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>SALE ID</th>
                                    <th>CLIENT NAME</th>
                                    <th>ITEMS</th>
                                    <th>TOTAL</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td>SL - {{ $sale->idsale }}</td>
                                            <td>{{$sale->Client->first_name}} {{$sale->Client->last_name}}</td>
                                            <td>{{ $sale->items->sum('quantity') }}</td>
                                            <td>Rs. {{ number_format($sale->total_amount, 2) }}</td>
                                            <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>

                                            <!-- status column starts-->
                                            @if($sale->status==0)
                                                <td>
                                                    <span class="badge badge-pill badge-warning">Pending</span>
                                                </td>
                                            @elseif($sale->status==1)
                                                <td>
                                                    <span class="badge badge-pill badge-success">Completed</span>
                                                </td>
                                            @elseif($sale->status==2)
                                                <td>
                                                    <span class="badge badge-pill badge-danger">Canceled</span>
                                                </td>
                                            @endif
                                            <!-- status column ends-->

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Purchases ends -->

    </div> <!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->





<!--Add Purchase Modal-->
<div class="modal fade" id="addPurchaseModal"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Purchase</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
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
                                        @if(isset($clients))
                                            @foreach($clients as $client)
                                                <option value="{{"$client->idclient"}}">  {{"$client->contact_number"}} {{"$client->first_name"}} </option>
                                            @endforeach
                                        @endif
                                    </select>

                                @endif



                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)

                                    <select class="form-control select2 tab" name="client" id="client" required>
                                        <option value="" disabled selected>Select Client  </option>
                                        @if(isset($clients))
                                            @foreach($clients as $client)
                                                <option value="{{"$client->idclient"}}">  {{"$client->contact_number"}} {{"$client->first_name"}} </option>
                                            @endforeach
                                        @endif
                                    </select>

                                @endif

                            <small class="text-danger" id="clientError"></small>

                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Category</label>
                            <select onchange="getProducts(this.value)" class="form-control" name="productcategory"
                                id="productcategory">
                                <option disabled value="" selected>Select Category</option>
                                @if(isset($productcategories))
                                    @foreach($productcategories as $productcategory)
                                        <option value="{{"$productcategory->product_category"}}">  {{"$productcategory->product_category"}} </option>
                                    @endforeach
                                @endif

                            </select>

                            <small class="text-danger" id="productcategoryError"></small>

                        </div>
                    </div>
                

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Product</label>
                            <select  onchange="showAmount(this.value)" class="form-control" name="product" id="product" required>
                                <option disabled value="" selected>Select Product</option>

                            </select>

                            <small class="text-danger" id="productError"></small>

                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" name="amount" id="amount" class="form-control" value="" readonly />
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" min="1" value="1" class="form-control" id="quantity"/>

                            <small class="text-danger" id="quantityError"></small>

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-primary" onclick="addToCart()">
                            Add to Cart
                        </button>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</div>


<!-- View Cart Item Modal -->
<div class="modal fade" id="viewCartItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Purchase Item Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Client</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewCartClient" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Product</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewCartProduct" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Quantity</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewCartQuantity" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Unit Price</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewCartPrice" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Date</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewCartDate" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Subtotal</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="viewCartSubtotal" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-md btn-outline-primary waves-effect float-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Edit Cart Item Modal -->
<div class="modal fade" id="editCartItemModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Update Quantity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editCartIndex">

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Product</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="editCartProduct" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Quantity</label>
                    <div class="col-sm-8">
                        <input type="number" min="1" class="form-control" id="editCartQuantity" required>
                        <small class="text-danger" id="editCartQuantityError"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-primary float-right" onclick="saveCartItemEdit()">Update Quantity</button>
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

    var today = "{{ date('Y-m-d') }}";

    $(document).ready(function () {
        $('form').parsley();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if ($.fn.DataTable && $.fn.DataTable.isDataTable('#cartTable')) {
            $('#cartTable').DataTable().destroy();
        }

        // Select2 initialization
        $('#productcategory').select2({
            placeholder: "Select Category",
            allowClear: false
        }); 

        $('#product').select2({
            placeholder: "Select Product",
            allowClear: false
        });



    });
    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });



    function getProducts(categoryName) {

        $.post('getProductsByCategory', {
            product_category: categoryName
        }, function (data) {

            var options = '<option disabled value="" selected>Select Product</option>';

            $.each(data, function (index, product) {
                options += '<option value="' + product.idproduct + '" data-price="' + product.price + '" data-quantity="' + product.quantity + '">' + product.product_name + '</option>';
            });

            $('#product').html(options).trigger('change'); 
            $('#amount').val(''); 
        });
    }


    function showAmount(productId) {

        if (!productId) {
            $("#amount").val('');
            return;
        }

        $.post('showAmount',{
            productId:productId
        },function (data) {
        console.log(data)
            $("#amount").val(data ? data.price : '');

        })

    }


    var cart = [];

    function addToCart() {

        document.getElementById('clientError').innerHTML = '';
        document.getElementById('productcategoryError').innerHTML = '';
        document.getElementById('productError').innerHTML = '';
        document.getElementById('quantityError').innerHTML = '';


        var clientId = $('#client').val();
        var clientName = $('#client option:selected').text().trim();
        var productId = $('#product').val();
        var productOption = $('#product option:selected');
        var productText = productOption.text();
        var price = parseFloat(productOption.data('price'));
        var stock = parseInt(productOption.data('quantity'));
        var qty = parseInt($('#quantity').val());


        var hasError = false;

        if (!clientId) {
            var p = document.getElementById('clientError');
            p.innerHTML = 'Client should be Selected!';
            hasError = true;
        }
   
        if (!productId) {
            var p = document.getElementById('productcategoryError');
            p.innerHTML = 'Please choose a category first.';
            hasError = true;
        }

 
        if (!productId) {
            var p = document.getElementById('productError');
            p.innerHTML = 'Please choose a product first.';
            hasError = true;
        }

 
        if (!qty || qty <= 0) {
            var p = document.getElementById('quantityError');
            p.innerHTML = 'Quantity must be at least 1.';
            hasError = true;
        }

        if (hasError) {
            return;
        }

        if (cart.length > 0 && cart[0].clientId !== clientId) {
            notify({
                type: 'error',
                title: 'Different Client',
                autoHide: true,
                delay: 2500,
                position: {x: "right", y: "top"},
                message: 'You can only add items for the same client in a single purchase. Please complete or clear the current cart first.'
            });
            return;
        }

        var existing = cart.find(function (i) { return i.product_id == productId; });
        var newQtyInCart = qty;

        if (existing) {
            newQtyInCart = existing.quantity + qty;
        } 

        if (stock - newQtyInCart < 0) {
            notify({
                type: 'warning',
                title: 'Low Stock',
                autoHide: true,
                delay: 2500,
                position: {x: "right",
                            y: "top"},
                message: 'Available stock for "' + productText + '" is only ' + stock + '.You cannot proceed.'
            });
            return;
            }

            if (existing) {
                existing.quantity = newQtyInCart;
            } else {
                cart.push({
                    clientId: clientId,
                    clientName: clientName,
                    product_id: productId,
                    name: productText,
                    price: price,
                    quantity: qty,
                    stock: stock // Save available stock to memory
                });
            } 
            notify({
                type: 'success',
                title: 'Added to cart',
                autoHide: true,
                delay: 2500,
                position: {x: "right",
                            y: "top"},
                icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',           
                message: productText + ' added.'
            });setTimeout(function () {
                    $('#addPurchaseModal').modal('hide');
                }, 300);
 
        renderCart();

        $('#quantity').val(1);
        $('#product').val('').trigger('change');
    }


    function renderCart() {
        var rows = '';
        var total = 0;

        if (cart.length === 0) {
            rows = '<tr id="cartEmptyRow"><td colspan="7" class="text-center text-muted">Cart is empty</td></tr>';
        } else {
            cart.forEach(function (item, index) {
                var subtotal = item.price * item.quantity;
                total += subtotal;

                rows += '<tr>' +
                    '<td>' + item.clientName + '</td>' +
                    '<td>' + item.name + '</td>' +
                    '<td>' + item.quantity + '</td>' +
                    '<td>Rs. ' + item.price.toFixed(2) + '</td>' +
                    '<td>' + today + '</td>' +
                    '<td>Rs. ' + subtotal.toFixed(2) + '</td>' +
                    '<td>' +
                        '<button type="button" title="View" class="btn btn-sm btn-default waves-effect waves-light" onclick="viewCartItem(' + index + ')" ><i class="fa fa-eye"></i></button> ' +
                        '<button type="button" title="Edit quantity" class="btn btn-sm btn-default waves-effect waves-light" onclick="editCartItem(' + index + ')" ><i class="fa fa-pencil"></i></button> ' +
                        '<button type="button" title="Remove" class="btn btn-sm btn-danger waves-effect waves-light" onclick="removeFromCart(' + index + ')"><i class="fa fa-trash"></i></button>' +
                    '</td>' +
                    '</tr>';
            });
        }

        $('#cartBody').html(rows);
        $('#cartTotal').text(total.toFixed(2));
    }


    function viewCartItem(index) {
        var item = cart[index];
        if (!item) return;

        $('#viewCartClient').val(item.clientName);
        $('#viewCartProduct').val(item.name);
        $('#viewCartQuantity').val(item.quantity);
        $('#viewCartPrice').val('Rs. ' + item.price.toFixed(2));
        $('#viewCartDate').val(today);
        $('#viewCartSubtotal').val('Rs. ' + (item.price * item.quantity).toFixed(2));

        $('#viewCartItemModal').modal('show');
    }


    // "Option" column has view/update/delete actions.
    // Edit lets the user change the quantity of an item already in the cart.
    function editCartItem(index) {
        var item = cart[index];
        if (!item) return;

        var newQty = prompt('Update quantity for "' + item.name + '":', item.quantity);
        if (newQty === null) return; // cancelled

        newQty = parseInt(newQty);
        if (!newQty || newQty <= 0) {
            notify({type: 'error', 
            title: 'Invalid quantity', 
            autoHide: true, 
            delay: 2500, 
            position: {
                x: "right",
                y: "top"
            },
            message: 'Quantity must be at least 1.'});
            return;
        }

        item.quantity = newQty;
        renderCart();
    }   
    
    function editCartItem(index) {
        var item = cart[index];
        if (!item) return;

        $('#editCartIndex').val(index);
        $('#editCartProduct').val(item.name);
        $('#editCartQuantity').val(item.quantity);
        $('#editCartQuantityError').text('');

        $('#editCartItemModal').modal('show');
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        renderCart();
    }


    function saveCartItemEdit() {
        var index = parseInt($('#editCartIndex').val());
        var newQty = parseInt($('#editCartQuantity').val());
        var item = cart[index];

        // Clear previous error
        $('#editCartQuantityError').text('');

        if (item.stock !== undefined && newQty > item.stock) {
            $('#editCartQuantityError').text('Cannot exceed available stock (' + item.stock + ').');
            return;
        }

        item.quantity = newQty;
        $('#editCartItemModal').modal('hide');
        renderCart();
    }
    // Auto-clear edit error when user types a valid quantity
    $('#editCartQuantity').on('input', function () {
        var qty = parseInt($(this).val());
        if (qty && qty > 0) {
            $('#editCartQuantityError').text('');
        }
    });


    function checkout() {

        if (cart.length === 0) {
            notify({
                type: 'error', 
                title: 'Empty cart', 
                autoHide: true, 
                delay: 2500, 
                position: {
                    x: "right",
                    y: "top"
                },
                message: 'Add at least one product before checking out.'
            });
            return;
        }

        var clientId = cart[0].clientId;

        
        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role != 4)
            if (!clientId) {
                notify({type: 'error', 
                title: 'Select a client', 
                autoHide: true, 
                delay: 2500, 
                position: {
                    x: "right",
                    y: "top"
                },
                message: 'Please select the client for this sale.'
            });
            return;
        }
        @endif

        var items = cart.map(function (i) {
            return {product_id: i.product_id, quantity: i.quantity};
        });



        $.post('savePurchase', {
            client_id: clientId,
            items: items
        }, function (data) {

            if (data.errors != null) {
                var messages = [];
                $.each(data.errors, function (key, val) {
                    messages.push(val[0]);
                });
                notify({type: 'error', 
                        title: 'Could not complete sale', 
                        autoHide: true, 
                        delay: 2500, 
                        position: {
                            x: "right",
                            y: "top"
                        },
                        message: messages.join('<br/>')
                    });
                return;
            }

            if (data.error != null) {
                    notify({type: 'error', 
                    title: 'Error',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    message: data.error
                });
                return;
            }

            if (data.success != null) {
                notify({
                    type: 'success',
                    title: 'PURCHASE COMPLETED',
                    autoHide: true,
                    delay: 2500,
                    position: {x: 'right', 
                               y: 'top'},
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success
                });

                if (data.warnings && data.warnings.length > 0) {
                    notify({
                        type: 'warning',
                        title: 'Low Stock Warning',
                        autoHide: true,
                        delay: 2500,
                        position: {x: 'right', 
                                   y: 'top'},
                        message: data.warnings.join('<br/>')
                    });
                }

                cart = [];
                renderCart();
                $('input').val('');

                setTimeout(function () {
                    location.reload();
                }, 400);
            }
        });
    }

        //Hide Validation errors after closing the modal without refreshing
        $('#addPurchaseModal').on('hidden.bs.modal', function () {

            $('#clientError').html('');
            $('#productcategoryError').html('');
            $('#productError').html('');
            $('#quantityError').html('');


            @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role != 4)
                $('#client').val(null).trigger('change');
            @endif
            
            $('#product').html('<option disabled value="" selected>Select Product</option>').trigger('change');
            $('#productcategory').val(null).trigger('change');

            
        });




</script>
@include('includes/footer_end')