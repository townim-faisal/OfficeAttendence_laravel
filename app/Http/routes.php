<?php

Route::auth();

Route::group(['prefix'=>'attendence', 'middleware' => ['auth', 'roles'] ], function(){
	Route::get('/', [
		'uses' => 'AttendenceController@index',
		'as' => 'attendence',
		'roles' => ['Admin', 'User']
	]);

	Route::post('/check_in', [
		'uses' => 'AttendenceController@store',
		'as' => 'attendence.in',
		'roles' => ['Admin', 'User']
	]);

	Route::post('/check_out', [
		'uses' => 'AttendenceController@update',
		'as' => 'attendence.out',
		'roles' => ['Admin', 'User']
	]);
});

Route::group(['prefix'=>'settings', 'middleware' => ['auth', 'roles'] ], function(){
	Route::get('/attendence', [
		'uses' => 'AdminController@getAttendenceSettings',
		'as' => 'settings.attendence',
		'roles' => ['Admin']
	]);

	Route::post('/attendence', [
		'uses' => 'AdminController@postAttendenceSettings',
		'as' => 'settings.attendence',
		'roles' => ['Admin']
	]);

	Route::get('/acl', [
		'uses' => 'AdminController@getAssignRoles',
		'as' => 'settings.acl',
		'roles' => ['Admin']
	]);

	Route::post('/acl', [
		'uses' => 'AdminController@postAssignRoles',
		'as' => 'settings.acl',
		'roles' => ['Admin']
	]);
});



