<?php

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


    Route::get('/dispute', 'DisputeController@index');
    Route::get('/dispute/create', 'DisputeController@create');
    Route::post('/dispute', 'DisputeController@store');
    Route::delete('/dispute/{id}', 'DisputeController@destroy')->name('dispute.destroy');

    Route::get('/dispute/summery/{id}', 'DisputeController@summery');

    Route::get('/dispute/details/{id}/{typeID}', 'DisputeController@details');
    Route::get('/dispute/export/{id}/{typeID}', 'DisputeController@export');

    Route::resource('/appointments/events', 'AptEventController');

    Route::resource('/appointments/timeslot', 'AptTimeSlotController');
    Route::delete('timeslotDeleteBulk', 'AptTimeSlotController@bulk_delete');

    Route::get('/appointments/list', 'AptListController@index')->name('appointment.index');
    Route::get('/appointments/{id}/edit', 'AptListController@edit')->name('appointment.edit');
    Route::delete('/appointments/{id}', 'AptListController@destroy')->name('appointment.destroy');
    Route::put('/appointments/{id}', 'AptListController@update')->name('appointment.update');

    Route::get('/documents', 'DocumentController@index');
    Route::post('/document/upload', 'DocumentController@upload');
    Route::get('/document/{id}/show', 'DocumentController@show');
    Route::get('/document/{id}/delete', 'DocumentController@delete');
    Route::post('/document/get_signature', 'DocumentController@getSignature');
    Route::resource('/signature', 'SignatureController');
    
    

    Route::resource('/agreement/type', 'AgmtTypeController');

    Route::get('/agreement/list', 'AgmtListController@index')->name('agreement.index');
    Route::get('/agreement/all', 'AgmtListController@list')->name('agreement.list');
    Route::get('/agreement/create/{id}', 'AgmtListController@create')->name('agreement.create');
    Route::post('/agreement', 'AgmtListController@store');
    Route::get('/agreement/{id}/edit', 'AgmtListController@edit')->name('agreement.edit');
    Route::get('/agreement/{id}/upload', 'AgmtListController@upload')->name('agreement.upload');
    Route::post('/agreement/upload/files', 'AgmtListController@upload_store')->name('agreement.upload_store');
    Route::get('/agreement/{id}/download', 'AgmtListController@download')->name('agreement.download');
    Route::delete('/agreement/{id}', 'AgmtListController@destroy')->name('agreement.destroy');
    Route::put('/agreement/{id}', 'AgmtListController@update')->name('agreement.update');

    /*Agreement module ask TR(Trade Reference)*/
    Route::get('/agreement/ask-tr/{agreement_id}','AgmtListController@askTr')->name('askTr');

    Route::resource('/users', 'UserController');
    
    Route::post('/tickets', 'TicketController@store');
    Route::get('/tickets', 'TicketController@index');
    Route::get('/ticket/create', 'TicketController@create');
    Route::get('/ticket/{id}/show', 'TicketController@show');
    Route::get('/ticket/mtest', 'TicketController@mtest');
    Route::get('/ticket/create_ticket', 'TicketController@create_ticket');
    Route::post('/ticket/reply', 'ReplyController@save');
});

Route::get('/appointments', 'GuestAreaController@apt_list');
Route::get('/appointments/{id}', 'GuestAreaController@apt_create');
Route::get('/timeSlotsDate/{event}/{emp}', 'GuestAreaController@apt_get_date');
Route::get('/timeSlots/{event}/{emp}/{date}', 'GuestAreaController@apt_get_slot');
Route::post('/appointments', 'GuestAreaController@apt_store');

Route::get('/agreements/all', 'GuestAreaController@agmt_list');
Route::get('/agreements/{id}', 'GuestAreaController@agmt_create');
Route::post('/agreements', 'GuestAreaController@agmt_store');