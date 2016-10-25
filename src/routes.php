<?php
Route::get('superadmin/index',function(){
  return view('vendor.superadmin.index');
});
Route::post('superadmin/createuser',['uses'=>'SuperAdmin\SuperAdminController@usercreate']);
Route::get('testadmin',function(){
  return "Hero";
});
