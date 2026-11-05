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
        <h3 class="page-title">Services</h3>
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

                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1 ||
                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)
                            
                            <div class="col-lg-4">

                                @if(!$readOnly)  <!-- Block for absents-->
                                    <button type="button" class="btn btn-primary float-right"
                                            data-toggle="modal"  data-target="#addCategoryModal" >
                                        Add Service
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
                                        <th>SERVICE ID</th>
                                        <th>CATEGORY NAME</th>
                                        <th>SERVICE NAME</th>
                                        <th>AMOUNT</th>
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

                                @if(isset($categories))
                                    @if(count($categories)>0)
                                        @foreach($categories as $category)

                                            <tr>
                                                
                                                <td>SER - {{$category->idcategory}}</td>

                                                <td>{{$category->category_name}}</td>

                                                <td>{{$category->service_name}}</td>

                                                <td>{{$category->amount}}</td>


                                         <!--Status Start-->                                                
                                                @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1  ||
                                                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3) 

                                                    @if(!$readOnly)      <!-- Block for absents-->    
                                                        <td>
                                                            <p>
                                                                <input type="checkbox"
                                                                    onchange="adMethod('{{ $category->idcategory }}', 'category')"
                                                                    id="{{ 'c' . $category->idcategory }}"
                                                                    switch="none" {{ $category->status == 1 ? 'checked' : '' }} />
                                                                <label for="{{ 'c' . $category->idcategory }}"
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

                                                                data-category="{{ $category->category_name }}"
                                                                data-name="{{ $category->service_name }}"
                                                                data-amount="{{ $category->amount }}"

                                                                id="viewCategoryID"
                                                                data-target="#viewCategoryModal">
                                                            <i class="fa fa-eye"></i>
                                                        </button>

                                                        @if (\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 1 ||
                                                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role == 3)

                                                            @if(!$readOnly)      <!-- Block for absents-->    

                                                                <button type="button"
                                                                        class="btn btn-sm btn-warning  waves-effect waves-light"
                                                                        data-toggle="modal"

                                                                        data-id="{{ $category->idcategory }}"
                                                                        data-category="{{ $category->category_name }}"
                                                                        data-name="{{ $category->service_name }}"
                                                                        data-amount="{{ $category->amount }}"

                                                                        id="uCategoryID"
                                                                        data-target="#updateCategoryModal"><i
                                                                            class="fa fa-edit"></i>
                                                                </button>

                                                                <button type="button"
                                                                        class="btn btn-sm btn-danger  waves-effect waves-light"
                                                                        onclick="deleteCategory({{ $category->idcategory }})">
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
<div class="modal fade" id="addCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Add Service</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

                <div class="modal-body">


                    <div class="form-group">
                        <label>Category Name <span style="color:red">*</span> </label>
                        <input type="text" class="form-control" name="servicecategory"
                               id="servicecategory" required placeholder="Category Name" />
                        <span class="text-danger" id="serviceCategoryError"></span>
                    </div>

                    <div class="form-group">
                        <label>Service Name <span style="color:red">*</span> </label>
                        <input type="text" class="form-control" name="category"
                               id="category" required placeholder="Service Name" />
                        <span class="text-danger" id="categoryError"></span>
                    </div>

                    <div class="form-group">
                        <label>Amount <span style="color:red">*</span> </label>
                        <input type="text" class="form-control" name="amount"
                               id="amount" required placeholder="Amount" />
                        <span class="text-danger" id="amountError"></span>
                    </div>

                    <div class="form-group">
                        <button type="button"  class="btn btn-primary float-right"
                                onclick="saveCategory()" >
                          Save Service
                        </button>
                    </div>

                </div>

        </div>

    </div>
</div>
<!-- Add Category Modal End-->







<!--View Category modal Start-->
<div class="modal fade" id="viewCategoryModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Service Details</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Category Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="viewServiceCategory" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Service Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="viewCategory" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Amount</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="viewAmount" readonly>
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
<div class="modal fade" id="updateCategoryModal" tabindex="-1"
     role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title mt-0">Update Service</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">×
                </button>
            </div>

            <div class="modal-body">


                <div class="form-group">
                    <label>Category Name</label>

                    <input type="text" class="form-control" name="updateServiceCategory"
                           id="updateServiceCategory" required placeholder="Category Name"/>
                    <span class="text-danger" id="updateServiceCategoryError"></span>
                </div>


                <div class="form-group">
                    <label>Service Name</label>


                    <input type="hidden" id="hiddenCategoryId" name="hiddenCategoryId">


                    <input type="text" class="form-control" name="updateCategory"
                           id="updateCategory" required placeholder="Service Name"/>
                    <span class="text-danger" id="updateCategoryError"></span>
                </div>


                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" name="updateAmount"
                           id="updateAmount" required placeholder="Category Amount"/>
                    <span class="text-danger" id="updateAmountError"></span>
                </div>



                <div class="form-group">
                    <button type="button"  class="btn btn-primary float-right"
                            onclick="updateCategory()" >
                        Update Service</button>
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








//Save Category Start
    function saveCategory() {

        var servicecategory=$("#servicecategory").val();
        var category=$("#category").val();
        var amount=$("#amount").val();


        $.post('saveCategory', {

            servicecategory:servicecategory,
            category:category,
            amount:amount

        },function (data) {

            if (data.errors != null) { //If there is validation errors

                if(data.errors.servicecategory){
                    var p = document.getElementById('serviceCategoryError');
                    p.innerHTML = data.errors.servicecategory[0];
                }

                if(data.errors.category){
                    var p = document.getElementById('categoryError');
                    p.innerHTML = data.errors.category[0];
                }

                if(data.errors.amount){
                    var p = document.getElementById('amountError');
                    p.innerHTML = data.errors.amount[0];
                }

            }


            if(data.success != null){ //if there is no errors
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'CATEGORY SAVED',
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
//Save Category End






//View Category Details Start

    $(document).on('click', '#viewCategoryID', function () {

        var servicecategoryName = $(this).data("category");
        var categoryName = $(this).data("name");
        var amount = $(this).data("amount");


        $("#viewServiceCategory").val(servicecategoryName);
        $("#viewCategory").val(categoryName);
        $("#viewAmount").val(amount);

    });

//View Category Details End










//Update Category Start
    $(document).on('click', '#uCategoryID', function () {

        var categoryId = $(this).data("id");
        var servicecategoryName = $(this).data("category");
        var categoryName = $(this).data("name");
        var amount = $(this).data("amount");



        $("#hiddenCategoryId").val(categoryId);
        $("#updateServiceCategory").val(servicecategoryName);
        $("#updateCategory").val(categoryName);
        $("#updateAmount").val(amount);

    });

    function updateCategory() {

        var hiddenCategoryId=$("#hiddenCategoryId").val();
        var servicecategory=$("#updateServiceCategory").val();
        var category=$("#updateCategory").val();
        var amount=$("#updateAmount").val();


        $.post('updateCategory',{

            hiddenCategoryId:hiddenCategoryId,
            servicecategory:servicecategory,
            category:category,
            amount:amount

        },function (data) {


            if (data.errors != null) { //If there is validation errors

                if(data.errors.servicecategory){
                    var p = document.getElementById('updateServiceCategoryError');
                    p.innerHTML = data.errors.servicecategory[0];
                }

                if(data.errors.category){
                    var p = document.getElementById('updateCategoryError');
                    p.innerHTML = data.errors.category[0];
                }

                if(data.errors.amount){
                    var p = document.getElementById('updateAmountError');
                    p.innerHTML = data.errors.amount[0];
                }

            }



            if(data.success != null){
                notify({
                    type: "success", //alert | success | error | warning | info
                    title: 'CATEGORY UPDATED',
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
//Update Category End








//Delete Category Start
    function deleteCategory(id) {


        $("#errorAlert2").hide();
        $("#errorAlert2").html('');

        swal({
            title: 'Are you sure?',
            text: 'Want to delete the service?',
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
            $.post('deleteCategory', {
                id:id
            }, function(data) {
                if (data.success != null) {
                    notify({
                        type: "success", //alert | success | error | warning | info
                        title: 'CATEGORY DELETED',
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
    //Delete Category End











    //Hide Validation errors after closing the modal without refreshing
    $('.modal').on('hidden.bs.modal', function () {

    //Add Category
    $('#serviceCategoryError').html('');
    $('#categoryError').html('');
    $('#amountError').html('');


    //Update Category
    $('#updateServiceCategoryError').html('');
    $('#updateCategoryError').html('');
    $('#updateAmountError').html('');


    $('input').val(''); //Clear input values of input fields

    });





</script>

@include('includes/footer_end')