<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('user_assets/css/styletheme.css') }}">

<!-- Begin page -->
<div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu side-bar">

        <!-- LOGO -->
        <div class="topbar-left">
            <div class="">
                <!--<a href="index" class="logo text-center">Fonik</a>-->

                <a href="{{ URL::asset('index')}}" class="logo"><img src="{{ URL::asset('assets/images/logoRB.png')}}"
                                                                     height="90" alt="logo"></a>

            </div>
        </div>

        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">

                <ul>

                    <li class="menu-title">Main</li>

                        <li>
                            <a href="index" class="waves-effect"><i
                                        class="fa fa-area-chart"></i><span>Dashboard </span></a>
                        </li>

                        <li>
                            <a href="myAccount" class="waves-effect"><i
                                        class="fa fa-user"></i><span>My Account</span></a>
                        </li>


                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role!=4)
                        <li class="menu-title">Service Card </li>
                    @endif
                    
                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                        \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3)
    
                        <li>
                            <a href="makeServiceCard" class="waves-effect"><i
                                        class="fa fa-pencil-square"></i><span> Make Service Card</span></a>
                        </li>

                    @endif

                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                        \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==2 ||
                        \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3)


                        <li>
                            <a href="serviceCardLog" class="waves-effect"><i
                                        class="fa fa-vcard"></i><span> Service Card Log</span></a>
                        </li>


                    @endif



                    <li class="menu-title">Appointment</li>


                        @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3 ||
                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==4)

                            <li>
                                <a href="makeAppointment" class="waves-effect"><i
                                            class="fa fa-calendar-plus-o"></i><span>Make Appointment</span></a>
                            </li>


                        @endif


                        <li>
                            <a href="appointmentLog" class="waves-effect"><i
                                        class="fa fa-tasks"></i><span>Appointment Log</span></a>
                        </li>






                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3)

                    <li class="menu-title">Master Files</li>


                    @endif




                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3)

                        <li>
                            <a href="clientManagement" class="waves-effect"><i
                                        class="fa fa-user"></i><span>Client Management</span></a>
                        </li>

                    @endif


                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1)

                        <li>
                            <a href="userManagement" class="waves-effect"><i
                                        class="fa fa-user"></i><span>User Management</span></a>
                        </li>

                    @endif


                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3)

                        <li>
                            <a href="attendance" class="waves-effect"><i
                                        class="fa fa-check-square-o"></i><span>Staff Attendance</span></a>
                        </li>

                    @endif


                    
                    <li class="menu-title">Service & Product</li>

                        <li>
                            <a href="category" class="waves-effect"><i
                                        class="fa fa-book"></i><span>Services</span></a>
                        </li>

                        <li>
                            <a href="product" class="waves-effect"><i
                                        class="fa fa-bitbucket"></i><span>Products</span></a>
                        </li>



                    <li class="menu-title">Sales</li>


                        @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3 ||
                            \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==4)

                            <li>
                                <a href="makePurchase" class="waves-effect"><i
                                            class="fa fa-cart-plus"></i><span>Make Purchase</span></a>
                            </li>


                        @endif


                        <li>
                            <a href="saleLog" class="waves-effect"><i
                                        class="fa fa-tasks"></i><span>Sales Log</span></a>
                        </li>



                    
                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                    \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3)

                        <li class="menu-title">Payment</li>
                            <li>
                                <a href="paymentLog" class="waves-effect"><i
                                            class="fa fa-tasks"></i><span>Payment Log</span></a>
                            </li>

                    @endif


                    <li class="menu-title">Feed Back</li>

                        <li>
                            <a href="feedBack" class="waves-effect"><i
                                        class="fa fa-comment"></i><span>Feed Backs</span></a>
                        </li>
                    



                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 )


                    <li class="menu-title">Reports</li>


                        <li>
                            <a href="clientReport" class="waves-effect"><i
                                        class="fa fa-file-text-o"></i><span>Client Report</span></a>
                        </li>

                        <li>
                            <a href="appointmentReport" class="waves-effect"><i
                                        class="fa fa-file-text-o"></i><span>Appointment Report</span></a>
                        </li>

                        <li>
                            <a href="incomeReport" class="waves-effect"><i
                                        class="fa fa-file-text-o"></i><span>Income Report</span></a>
                        </li>

                        <li>
                            <a href="salesReport" class="waves-effect"><i
                                        class="fa fa-file-text-o"></i><span>Sales Report</span></a>
                        </li>

                        <li>
                            <a href="feedbackReport" class="waves-effect"><i
                                        class="fa fa-file-text-o"></i><span>Feed Back Report</span></a>
                        </li>

                    @endif




                    @if(\Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==1 ||
                        \Illuminate\Support\Facades\Auth::user()->user_role_iduser_role==3)


                    <li class="menu-title">Contact Us </li>

                        <li>
                            <a href="contactUs" class="waves-effect"><i
                                        class="fa fa-phone"></i><span>Contact Us</span></a>
                        </li>


                    @endif







                </ul>

            </div>




            <div class="clearfix"></div>

        </div> <!-- end sidebarinner -->
    </div> <!-- Left Sidebar End -->