@extends('vendor.superadmin.layout')
@section('content')
<div class="panel">
	<!-- Panel Header -->
	<div class="panel-heading border">
		<ol class="breadcrumb mb0 no-padding">
            <li><a href="/superadmin/users">Home</a></li>
            <li class="active">Locations</li>
        </ol>
        <div class="pull-right">
        	<button type="button" class="btn btn-warning" style="width:200px;margin-top:-2em" data-toggle="modal" data-target=".add-location" data-dismiss="modal">Add Location</button>
        </div>
        <br/>
        @if (count($errors) > 0)
			<div class="alert alert-danger">
				<strong>Whoops!</strong> There were some problems with your input.<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
	</div>
	<!-- Panel Body -->
    <div class="panel-body" id="locationsTable">

    </div>
</div>

<!-- Modal PoP Up for Add Location -->
<div class="modal bs-modal-sm add-location" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Add Location</h4>
        </div>
        <div class="modal-body">
	        <form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/createlocation') }}">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                
	            <div class="form-group">
					<label class="col-md-4 control-label">Add Location</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="location_name" id="payroll-number" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary btn-block">Add Location</button>
					</div>
				</div>
			</form>
       	</div>
      </div>
    </div>
  </div>

<!-- Modal PoP Up for Get Users for a Location -->
<div class="modal bs-modal-sm get-users" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Users for the Location</h4>
        </div>
        <div class="modal-body">
	       
       	</div>
      </div>
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
	             //   $user_name = $user->login;
	             //   $user_name = str_replace(Config::get('efront.LoginPrefix'),"",$user_name);
	             //   if(!is_numeric($user_name)){
	             //     $user_name = $user->login;
	             //   }
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
						<button type="submit" class="btn btn-primary">Update Student Info</button>
					</div>
				</div>
			</form>
       	</div>
      </div>
    </div>
</div>
@endsection