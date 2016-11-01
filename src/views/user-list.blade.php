@extends('vendor.superadmin.layout')
@section('content')
<div class="panel">
    <div class="panel-heading border">
        <ol class="breadcrumb mb0 no-padding">
            <li> <a href="/superadmin/users">Home</a> </li>
            <li class="active">Users</li>
        </ol>
        <div class="pull-right">
        	<button type="button" class="btn btn-danger" onclick="getDeactivatedUsers()" style="width:200px;margin-top:-2em" data-toggle="modal" data-target=".deactivated-users" data-dismiss="modal">
        		Deactivated Users
        	</button>
        	<button type="button" class="btn btn-warning" style="width:200px;margin-top:-2em" data-toggle="modal" data-target=".create-user" data-dismiss="modal">Create User</button>
        </div>
        <br/>
        @if(count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		@if(Session::has('success_message'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				{{Session::get('success_message')}}
			</div>
		@endif

		@if(Session::has('fail_message'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				{{Session::get('fail_message')}}
			</div>
		@endif
    </div>

    <div class="panel-body" id="userListTable">

    </div>
</div>

<!-- Modal PoPUp for Edit User -->
<div class="modal bs-modal-sm edit-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Edit User</h4>
        </div>
        <div class="modal-body">
	        <form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/updateuser') }}">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	            <?php 
	               // $user = App\User::find(2);
	               // $user_name = $user->login;
	               // $user_name = str_replace(Config::get('efront.LoginPrefix'),"",$user_name);
	               // if(!is_numeric($user_name)){
	               //   $user_name = $user->login;
	               // }
	            ?>
                
                <input type="hidden" name="user_id" id="user_id" value="">
	            
	            <div class="form-group">
					<label class="col-md-4 control-label">Payroll Number</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="login" id="payroll-number" value="" required>
					</div>
				</div>
	            <div class="form-group">
					<label class="col-md-4 control-label">Firstname</label>
					<div class="col-md-6">
						<input type="text" id="firstname" class="form-control" name="firstname" value="" required>
					</div>
				</div>
	            <div class="form-group">
					<label class="col-md-4 control-label">Lastname</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="lastname" name="lastname" value="" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label">E-Mail Address</label>
					<div class="col-md-6">
						<input type="email" class="form-control" id="email" name="email" value="" required>
					</div>
				</div>
	            <div class="form-group">
					<label class="col-md-4 control-label">Location</label>
					<div class="col-md-6">
	                    <select class="form-control" id="location_id" name="location_id" value="" required>
	                     @foreach(App\Location::all() as $location)
	                        <option value={{$location->id}}>{{$location->location_name}}</option>
	                      @endforeach
	                    </select>   
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label">Password</label>
					<div class="col-md-6">
						<input type="password" class="form-control" name="password" placeholder="Leave it blank if you donot like to change password">
					</div>
				</div>
	            <div class="form-group">
					<label class="col-md-4 control-label">Confirm Password</label>
					<div class="col-md-6">
						<input type="password" class="form-control" name="confirm-password" placeholder="Leave it blank if you donot like to change password">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary btn-block">Update Student Info</button>
					</div>
				</div>
			</form>
       	</div>
      </div>
    </div>
  </div>

<!-- Modal PoPUP for Create User -->
<!-- Modal PoPUp -->
<div class="modal bs-modal-sm create-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Create User</h4>
        </div>
        <div class="modal-body">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/createuser') }}">
      				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
      							<label class="col-md-4 control-label">Payroll Number</label>
      							<div class="col-md-6">
      								<input type="text" class="form-control" required name="login" value="{{ old('login') }}">
      							</div>
      			    </div>
                  	<div class="form-group">
						<label class="col-md-4 control-label">Firstname</label>
						<div class="col-md-6">
							<input type="text" class="form-control" required name="firstname" value="{{ old('firstname') }}">
						</div>
					</div>
	                <div class="form-group">
						<label class="col-md-4 control-label">Lastname</label>
						<div class="col-md-6">
							<input type="text" class="form-control" required name="lastname" value="{{ old('lastname') }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">E-Mail Address</label>
						<div class="col-md-6">
							<input type="email" class="form-control" required name="email" value="{{ old('email') }}">
						</div>
					</div>
                    <div class="form-group">
          							<label class="col-md-4 control-label">Location</label>
          							<div class="col-md-6">
	                      <select class="form-control" name="location_id" required>
	                        @foreach(App\Location::all() as $location)
	                          <option value={{$location->id}}>{{$location->location_name}}</option>
	                        @endforeach
	                      </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label">Password</label>
						<div class="col-md-6">
							<input type="password" required class="form-control" name="password">
						</div>
					</div>
                    <div class="form-group">
					<label class="col-md-4 control-label">Confirm Password</label>
						<div class="col-md-6">
							<input type="password" required class="form-control" name="confirm-password">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="btn btn-primary btn-block">Create Student</button>
						</div>
					</div>
  			</form>
        </div>
      </div>
    </div>
  </div>	

<!-- Modal PoP Up for Deactivated Users -->
<div class="modal bs-modal-sm deactivated-users" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Deactivated Users</h4>
        </div>
        <div class="modal-body">
	       
       	</div>
      </div>
    </div>
</div>
@endsection