<?php
Route::get('testgroup',function(){

  return App\Group::with('test')->get();
   return App\Group::find(1)->with('groupUsers')->get();
});

//User Routes.
Route::get('superadmin/users',['uses'=>'SuperAdmin\SuperAdminController@usersget']);
Route::get('superadmin/deactivatedusers',['uses'=>'SuperAdmin\SuperAdminController@deactivatedusers']);
Route::get('superadmin/index',['uses' =>'SuperAdmin\SuperAdminController@index']);

Route::post('superadmin/createuser',['uses'=>'SuperAdmin\SuperAdminController@usercreate']);
Route::post('superadmin/updateuser',['uses'=>'SuperAdmin\SuperAdminController@userupdate']);
Route::get('superadmin/deactivateuser/{id}',['uses'=>'SuperAdmin\SuperAdminController@userdeactivate']);
Route::get('superadmin/activateuser/{id}',['uses'=>'SuperAdmin\SuperAdminController@useractivate']);

//Location Routes.
Route::get('superadmin/locationlist',['uses'=>'SuperAdmin\SuperAdminController@locationlist']);
Route::post('superadmin/createlocation',['uses'=>'SuperAdmin\SuperAdminController@createlocation']);
Route::get('superadmin/locationusers/{location_id}',['uses'=>'SuperAdmin\SuperAdminController@locationusers']);

//Group Routes.
Route::get('superadmin/groupusers/{group_id}',['uses'=>'SuperAdmin\SuperAdminController@groupusers']);
Route::post('superadmin/assignusertogroup',['uses'=>'SuperAdmin\SuperAdminController@assignusertogroup']);
Route::post('superadmin/removeuserfromgroup',['uses'=>'SuperAdmin\SuperAdminController@removeuserfromgroup']);
Route::get('superadmin/usersgroup',['uses'=>'SuperAdmin\SuperAdminController@getallgroupusers']);
Route::get('superadmin/grouplist',['uses'=>'SuperAdmin\SuperAdminController@grouplist']);

//Role Routes.
Route::get('superadmin/rolelist',['uses'=>'SuperAdmin\SuperAdminController@rolelist']);
Route::get('superadmin/rolegroups/{role_id}',['uses'=>'SuperAdmin\SuperAdminController@rolegroups']);
Route::post('superadmin/rolestore',['uses'=>'SuperAdmin\SuperAdminController@rolestore']);
Route::post('superadmin/assignrolegroup',['uses'=>'SuperAdmin\SuperAdminController@assignrolegroup']);
Route::post('superadmin/removerolegroup',['uses'=>'SuperAdmin\SuperAdminController@removerolegroup']);
Route::get('superadmin/roleusers/{role_id}',['uses'=>'SuperAdmin\SuperAdminController@roleusers']);
Route::post('superadmin/assignroleuser',['uses'=>'SuperAdmin\SuperAdminController@assignroleuser']);
Route::post('superadmin/removeroleuser',['uses'=>'SuperAdmin\SuperAdminController@removeroleuser']);

//Index Routes.
Route::get('superadmin/branchdetails/{branch_id}',['uses'=>'SuperAdmin\SuperAdminController@branchusers']);
Route::post('superadmin/adduserfromefront',['uses'=>'SuperAdmin\SuperAdminController@adduserfromefront']);
