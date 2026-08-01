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
        <!-- <h3 class="page-title">{{ $title }}</h3> -->
        <h3 class="page-title">Products</h3>
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

                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1  ||
                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)
                            
                            <div class="col-lg-4">
                                @if(!$readOnly)  <!-- Block for absents-->
                                    <button type="button" class="btn btn-primary float-right"
                                            data-toggle="modal"  data-target="#addProductModal" >
                                        Add Product
                                    </button>
                                @endif
                            </div>

                        @endif                     

                    </div>



                <br/>




             <!--Data Table Start-->

                    <div class="table-rep-plugin">
                        <div class="table-responsive b-0" data-pattern="priority-columns">


                            <table id="datatable"   class="table table-striped table-bordered"
                                   cellspacing="0"
                                   width="100%">

                                <thead>
                                    <tr>
                                        <th>PRODUCT ID</th>
                                        <th>PRODUCT CATEGORY</th>
                                        <th>PRODUCT NAME</th>
                                        <th>PRICE</th>
                                        <th>QUANTITY</th>
                                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1  ||
                                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3) 

                                            @if(!$readOnly)      <!-- Block for absents-->                                   
                                                <th>STATUS</th>
                                            @endif 

                                        @endif 
                                        <th>OPTIONS</th>
                                    </tr>
                                </thead>

                                <tbody>

                                @if(isset($products))
                                    @if(count($products)>0)
                                        @foreach($products as $product)

                                            <tr>
                                                
                                                <td>PR - {{$product->idproduct}}</td>

                                                <td>{{$product->product_category}}</td>

                                                <td>{{$product->product_name}}</td>

                                                <td>{{$product->price}}</td>

                                                
                                                <!--Quantity Start--> 
                                                @if($product->quantity===0)
                                                    <td>
                                                        <span class="badge badge-pill badge-danger">Out of Stock</span>
                                                    </td>
                                                @elseif($product->quantity<5)
                                                    <td>
                                                        <span class="badge badge-pill badge-warning">Low Stock</span>
                                                        </br> </br>
                                                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1  ||
                                                        \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3) 
                                                            Stock - {{$product->quantity}}
                                                        @endif 
                                                    </td>
                                                @else
                                                    <td>
                                                        <span class="badge badge-pill badge-success">In Stock</span>
                                                        </br> </br>
                                                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1  ||
                                                        \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3) 
                                                            Stock - {{$product->quantity}}
                                                        @endif 
                                                    </td>
                                                @endif
                                                <!--Quantity ends--> 

                                                <!--Status Start-->                                                
                                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1  ||
                                                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3) 

                                                    @if(!$readOnly)     <!-- Block for absents-->
                                                                                                        
                                                        <td>
                                                            <p>
                                                                <input type="checkbox"
                                                                    onchange="adMethod('{{ $product->idproduct }}', 'product')"
                                                                    id="{{ 'c' . $product->idproduct }}"
                                                                    switch="none" {{ $product->status == 1 ? 'checked' : '' }} />
                                                                <label for="{{ 'c' . $product->idproduct }}"
                                                                    data-on-label="On"
                                                                    data-off-label="Off"></label>
                                                            </p>  
                                                        </td>
                                                    @endif 

                                                @endif 
                                                <!--Status End-->


                                                <!--Options Start-->
                                                <td>

                                                    <p>

                                                        <button type="button" title="View"
                                                                class="btn btn-sm btn-default  waves-effect waves-light"
                                                                data-toggle="modal"

                                                                data-category="{{ $product->product_category }}"
                                                                data-name="{{ $product->product_name }}"
                                                                data-price="{{ $product->price }}"

                                                                id="viewProductID"
                                                                data-target="#viewProductModal">
                                                            <i class="fa fa-eye"></i>
                                                        </button>

                                                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1 ||
                                                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)

                                                            @if(!$readOnly)     <!-- Block for absents-->

                                                                <button type="button"
                                                                        class="btn btn-sm btn-warning  waves-effect waves-light"
                                                                        data-toggle="modal"

                                                                        data-id="{{ $product->idproduct }}"
                                                                        data-category="{{ $product->product_category }}"
                                                                        data-name="{{ $product->product_name }}"
                                                                        data-price="{{ $product->price }}"
                                                                        data-quantity="{{ $product->quantity }}"

                                                                        id="uProductID"
                                                                        data-target="#updateProductModal"><i
                                                                            class="fa fa-edit"></i>
                                                                </button>

                                                                <button type="button"
                                                                        class="btn btn-sm btn-danger  waves-effect waves-light"
                                                                        onclick="deleteProduct({{ $product->idproduct }})">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            @endif 
                                                            
                                                        @endif 

                                                    </p>

                                                </td>
                                                <!--Options End-->

                                            </tr>

                                        @endforeach
                                    @endif
                                @endif

                                </tbody>

                            </table>

                        </div>
                    </div>


              <!--Data Table End-->

                </div>
            </div>
        </div>
    </div> <!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->








<!-- Add Category Modal Start-->
<div class="modal fade" id="addProductModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

                <div class="modal-body">


                    <div class="form-group">
                        <label>Product Category <span style="color:red">*</span> </label>
                        <input type="text" class="form-control" name="productcategory"
                               id="productcategory" required placeholder="Product Category" />
                        <span class="text-danger" id="productCategoryError"></span>
                    </div>

                    <div class="form-group">
                        <label>Product Name <span style="color:red">*</span> </label>
                        <input type="text" class="form-control" name="product"
                               id="product" required placeholder="Product Name" />
                        <span class="text-danger" id="productError"></span>
                    </div>

                    <div class="form-group">
                        <label>Price <span style="color:red">*</span> </label>
                        <input type="text" class="form-control" name="price"
                               id="price" required placeholder="Price" />
                        <span class="text-danger" id="priceError"></span>
                    </div>

                    <div class="form-group">
                        <label>Quantity <span style="color:red">*</span> </label>
                        <input type="text" class="form-control" name="quantity"
                               id="quantity" required placeholder="Quantity" />
                        <span class="text-danger" id="quantityError"></span>
                    </div>

                    <div class="form-group">
                        <button type="button"  class="btn btn-primary float-right"
                                onclick="saveProduct()" >
                          Save Product
                        </button>
                    </div>

                </div>

        </div>

    </div>
</div>
<!-- Add Category Modal End-->







<!--View Category modal Start-->
<div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Product Details</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Product Category</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="viewProductCategory" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Product Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="viewProduct" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Price</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="viewPrice" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-md btn-outline-primary waves-effect float-right" data-dismiss="modal" >Close</button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<!--View Category modal End-->








<!-- Update Category Modal Start-->
<div class="modal fade" id="updateProductModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Update Product</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">


                <div class="form-group">
                    <label>Product Category</label>

                    <input type="text" class="form-control" name="updateProductCategory"
                           id="updateProductCategory" required placeholder="Product Category"/>
                    <span class="text-danger" id="updateProductCategoryError"></span>
                </div>


                <div class="form-group">
                    <label>Product Name</label>


                    <input type="hidden" id="hiddenProductId" name="hiddenProductId">


                    <input type="text" class="form-control" name="updateProduct"
                           id="updateProduct" required placeholder="Product Name"/>
                    <span class="text-danger" id="updateProductError"></span>
                </div>


                <div class="form-group">
                    <label>Price</label>
                    <input type="text" class="form-control" name="updatePrice"
                           id="updatePrice" required placeholder="Price"/>
                    <span class="text-danger" id="updatePriceError"></span>
                </div>


                <div class="form-group">
                    <label>Quantity</label>
                    <input type="text" class="form-control" name="updateQuantity"
                           id="updateQuantity" required placeholder="Quantity"/>
                    <span class="text-danger" id="updateQuantityError"></span>
                </div>

                <div class="form-group">
                    <button type="button"  class="btn btn-primary float-right"
                            onclick="updateProduct()" >
                        Update Product</button>
                </div>

            </div>

        </div>

    </div>
</div>
<!-- Update Category Modal End-->







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

    });

    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });









    //Change Status
    function adMethod(dataID, tableName) {

        $.post('activateDeactivate', {id: dataID, table: tableName}, function (data) {

        });
    }








//Save Product Start
    function saveProduct() {

        var productcategory=$("#productcategory").val();
        var product=$("#product").val();
        var price=$("#price").val();
        var quantity=$("#quantity").val();


        $.post('saveProduct', {

            productcategory:productcategory,
            product:product,
            price:price,
            quantity:quantity

        },function (data) {

            if (data.errors != null) { //If there is validation errors

                if(data.errors.productcategory){
                    var p = document.getElementById('productCategoryError');
                    p.innerHTML = data.errors.productcategory[0];
                }

                if(data.errors.product){
                    var p = document.getElementById('productError');
                    p.innerHTML = data.errors.product[0];
                }

                if(data.errors.price){
                    var p = document.getElementById('priceError');
                    p.innerHTML = data.errors.price[0];
                }

                if(data.errors.quantity){
                    var p = document.getElementById('quantityError');
                    p.innerHTML = data.errors.quantity[0];
                }

            }


            if(data.success != null){ //if there is no errors
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'PRODUCT SAVED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });


                setTimeout(function () {
                    location.reload();
                }, 1000);

            }

        })

    }
//Save Product End






//View Product Details Start

    $(document).on('click', '#viewProductID', function () {

        var productcategory = $(this).data("category");
        var productName = $(this).data("name");
        var price = $(this).data("price");


        $("#viewProductCategory").val(productcategory);
        $("#viewProduct").val(productName);
        $("#viewPrice").val(price);

    });

//View Product Details End










//Update Product Start
    $(document).on('click', '#uProductID', function () {

        var productId = $(this).data("id");
        var productcategoryName = $(this).data("category");
        var productName = $(this).data("name");
        var price = $(this).data("price");
        var quantity = $(this).data("quantity");



        $("#hiddenProductId").val(productId);
        $("#updateProductCategory").val(productcategoryName);
        $("#updateProduct").val(productName);
        $("#updatePrice").val(price);
        $("#updateQuantity").val(quantity);

    });

    function updateProduct() {

        var hiddenProductId=$("#hiddenProductId").val();
        var productcategory=$("#updateProductCategory").val();
        var product=$("#updateProduct").val();
        var price=$("#updatePrice").val();
        var quantity=$("#updateQuantity").val();


        $.post('updateProduct',{

            hiddenProductId:hiddenProductId,
            productcategory:productcategory,
            product:product,
            price:price,
            quantity:quantity

        },function (data) {


            if (data.errors != null) { //If there is validation errors

                if(data.errors.productcategory){
                    var p = document.getElementById('updateProductCategoryError');
                    p.innerHTML = data.errors.productcategory[0];
                }

                if(data.errors.product){
                    var p = document.getElementById('updateProductError');
                    p.innerHTML = data.errors.product[0];
                }

                if(data.errors.price){
                    var p = document.getElementById('updatePriceError');
                    p.innerHTML = data.errors.price[0];
                }

                if(data.errors.quantity){
                    var p = document.getElementById('updateQuantityError');
                    p.innerHTML = data.errors.quantity[0];
                }

            }



            if(data.success != null){
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'PRODUCT UPDATED',
                    autoHide: true, //true | false
                    delay: 2500, //number ms
                    position: {
                        x: "right",
                        y: "top"
                    },
                    icon: '<img src="{{ URL::asset('assets/images/correct.png')}}" />',
                    message: data.success,
                });

                setTimeout(function () {
                    location.reload();
                }, 1000);


            }
        })
    }
//Update Product End








//Delete Product Start
    function deleteProduct(id) {


        $("#errorAlert2").hide();
        $("#errorAlert2").html('');

        swal({
            title: 'Are you sure?',
            text: 'Want to delete the product?',
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
            $.post('deleteProduct', {
                id:id
            }, function(data) {
                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'PRODUCT DELETED',
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
                    }, 1000);
                }
            })

        })
    }
    //Delete Product End











    //Hide Validation errors after closing the modal without refreshing
    $('.modal').on('hidden.bs.modal', function () {

    //Add Product
    $('#productCategoryError').html('');
    $('#productError').html('');
    $('#priceError').html('');
    $('#quantityError').html('');


    //Update Product
    $('#updateProductCategoryError').html('');
    $('#updateProductError').html('');
    $('#updatePriceError').html('');
    $('#updateQuantityError').html('');


    $('input').val(''); //Clear input values of input fields

    });





</script>

@include('includes/footer_end')