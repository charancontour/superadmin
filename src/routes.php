<?php
Route::get('superadmin/users',['uses'=>'SuperAdmin\SuperAdminController@usersget']);
Route::get('superadmin/index',function(){
  return view('vendor.superadmin.index');
});
Route::post('superadmin/createuser',['uses'=>'SuperAdmin\SuperAdminController@usercreate']);
Route::post('superadmin/updateuser',['uses'=>'SuperAdmin\SuperAdminController@userupdate']);
Route::get('superadmin/deactivateuser/{id}',['uses'=>'SuperAdmin\SuperAdminController@userdeactivate']);
Route::get('superadmin/activateuser/{id}',['uses'=>'SuperAdmin\SuperAdminController@useractivate']);
Route::get('testadmin',function(){
  return "Hero";
});
