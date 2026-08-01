<?php

Auth::routes();




//Client Interface
Route::get('/clientInterface', 'ClientInterfaceController@index')->name('clientInterface');
Route::post('/saveContactUs', 'ClientInterfaceController@saveContactUs')->name('saveContactUs');


Route::get('/signin', function () {
        return view('signin');
        })->middleware('guest');


//Login Sign In
Route::post('/signin', 'SecurityController@login')->name('login');


//Client Sign Up
Route::get('/clientSignup', 'SecurityController@signup')->name('clientSignup');
Route::post('/saveClient', 'ClientController@saveClient')->name('saveClient');



//After Login ('auth')
Route::group(['middleware' => 'auth', 'prefix' => ''], function () {




    //Dashboard
    Route::get('/index', 'DashboardController@dashboardIndex')->name('index');
    Route::get('/', 'DashboardController@dashboardIndex')->name('/');



    //Log Out
    Route::get('/logout', 'SecurityController@logoutNow')->name('logout');



    //Status Change
    Route::post('/activateDeactivate', 'StatusController@activateDeactivate')->name('activateDeactivate');



    //Appointment
    Route::get('/makeAppointment', 'AppointmentController@index')->name('makeAppointment');
    Route::post('/saveAppointment','AppointmentController@saveAppointment')->name('saveAppointment');
    Route::post('/showAppointmentAmount','AppointmentController@showAmount')->name('showAppointmentAmount');
    Route::post('/getTimeSlot','AppointmentController@getTimeSlot')->name('getTimeSlot');
    Route::post('/getServicesByCategory','AppointmentController@getServicesByCategory')->name('getServicesByCategory');
    Route::post('getStylistsForDate', 'AppointmentController@getStylistsForDate');

    
    //Appointment Log
    Route::get('/appointmentLog', 'AppointmentLogController@appointmentLog')->name('appointmentLog');
    Route::post('/savePayment','AppointmentLogController@savePayment')->name('savePayment');
    Route::post('/cancelAppointment','AppointmentLogController@cancelAppointment')->name('cancelAppointment');


    //Payment Log
    Route::get('/paymentLog', 'PaymentLogController@index')->name('paymentLog');




    //Category
    Route::get('/category', 'CategoryController@index')->name('category');
    Route::post('/saveCategory', 'CategoryController@categorySave')->name('saveCategory');
    Route::post('/updateCategory', 'CategoryController@categoryUpdate')->name('updateCategory');
    Route::post('/deleteCategory', 'CategoryController@categoryDelete')->name('deleteCategory');

     //product
    Route::get('/product', 'ProductController@index')->name('product');   
    Route::post('/saveProduct', 'ProductController@productSave')->name('saveProduct');
    Route::post('/updateProduct', 'ProductController@productUpdate')->name('updateProduct');
    Route::post('/deleteProduct', 'ProductController@productDelete')->name('deleteProduct');


    //Client Management In Admin
    Route::get('/clientManagement', 'ClientController@index')->name('clientManagement');
    Route::post('/saveClientByAdmin', 'ClientController@saveClientByAdmin')->name('saveClientByAdmin');
    Route::post('/updateClient', 'ClientController@updateClient')->name('updateClient');




    //User Management In Admin
    Route::get('/userManagement', 'UserController@index')->name('userManagement');
    Route::post('/saveUser', 'UserController@saveUser')->name('saveUser');
    Route::post('/updateUser', 'UserController@updateUser')->name('updateUser');






    //My Account
    Route::get('/myAccount', 'MyAccountController@index')->name('myAccount');
    Route::post('/getUserDetails', 'MyAccountController@getUserDetails')->name('getUserDetails');
    Route::post('/updateUserDetails', 'MyAccountController@updateUserDetails')->name('updateUserDetails');
    Route::post('/changePassword', 'MyAccountController@changePassword')->name('changePassword');




    //Reports
    Route::get('/incomeReport', 'IncomeReportController@incomeReportIndex')->name('incomeReport');
    Route::get('/clientReport', 'ClientReportController@clientReportIndex')->name('clientReport');
    Route::get('/appointmentReport', 'AppointmentReportController@appointmentReportIndex')->name('appointmentReport');
    Route::get('/salesReport', 'SalesReportController@salesReportIndex')->name('salesReport');
    Route::get('/feedbackReport', 'FeedbackReportController@feedbackReportIndex')->name('feedbackReport');


    //Contact US
    Route::get('/contactUs', 'ContactUsController@index')->name('contactUs');


    //Feed back
    Route::get('/feedBack', 'FeedbackController@index')->name('feedBack');
    Route::post('/saveFeedback','AppointmentLogController@saveFeedback')->name('saveFeedback');


    //Attendance
    Route::get('/attendance', 'AttendanceController@index')->name('attendance');
    Route::post('markAttendance', 'AttendanceController@markAttendance');


  
   // Service Card
    Route::get('/makeServiceCard', 'ServiceCardController@index')->name('makeServiceCard');
    Route::post('getFilteredAppointments', 'ServiceCardController@getFilteredAppointments');
    Route::post('saveServiceCard', 'ServiceCardController@saveServiceCard');
    Route::get('/showServiceCard/{id}', 'ServiceCardLogController@show')->name('showServiceCard');
    Route::get('/getServiceCardData/{id}', 'ServiceCardLogController@getServiceCardData')->name('getServiceCardData');


    //Service Card Log

    Route::get('/serviceCardLog', 'ServiceCardLogController@index')->name('serviceCardLog');
    Route::post('/setInProgress/{id}', 'ServiceCardLogController@setInProgress')->name('setInProgress');
  

    //Purchase 
    Route::get('/makePurchase', 'PurchaseController@index')->name('makePurchase');
    Route::post('/getProductsByCategory','PurchaseController@getProductsByCategory')->name('getProductsByCategory');
    Route::post('/savePurchase','PurchaseController@purchaseSave')->name('savePurchase');
    Route::post('/purchaseDetails','PurchaseController@detailsPurchase')->name('purchaseDetails');
    Route::post('/showAmount','PurchaseController@showAmount')->name('showAmount');
    Route::post('/completePurchase','PurchaseController@completePurchase')->name('completePurchase');
  

    //Sales Log
    Route::get('/saleLog', 'SaleLogController@saleLog')->name('saleLog');
    Route::post('/saveSalePayment','SaleLogController@savePayment')->name('saveSalePayment');
    Route::post('/cancelPurchase','SaleLogController@cancelPurchase')->name('cancelPurchase');


});



    // absents cannot login 

Route::middleware(['auth', 'blockAbsent'])->group(function () {

    Route::get('/makeAppointment', 'AppointmentController@index')->name('makeAppointment');
    Route::get('/clientManagement', 'ClientController@index')->name('clientManagement');
    Route::get('/makeServiceCard', 'ServiceCardController@index')->name('makeServiceCard');
    // Route::get('/serviceCardLog', 'ServiceCardLogController@index')->name('serviceCardLog');
    Route::get('/attendance', 'AttendanceController@index')->name('attendance');
    Route::get('/makePurchase', 'PurchaseController@index')->name('makePurchase');

});
