<?php
Route::get('superadmin/index',function(){
  return view('vendor.superadmin.index');
});
Route::get('testadmin',function(){
  return "Hero";
});
