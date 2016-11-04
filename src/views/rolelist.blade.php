@extends('vendor.superadmin.layout')
@section('content')
<div class="panel">
	<!-- Panel Header -->
	<div class="panel-heading border">
		<ol class="breadcrumb mb0 no-padding">
            <li><a href="/superadmin/users">Home</a></li>
            <li class="active">Roles</li>
        </ol>
        <div class="pull-right">
        	<button type="button" class="btn btn-warning" style="width:200px;margin-top:-2em" data-toggle="modal" data-target=".add-role" data-dismiss="modal">Add Role</button>
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
    <div class="panel-body" id="rolesTable">

    </div>
</div>


<!-- Modal PoP Up for Add Role -->
<div class="modal bs-modal-sm add-role" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Add Role</h4>
        </div>
        <div class="modal-body">
	        <form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/addrole') }}">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                
	            <div class="form-group">
					<label class="col-md-4 control-label">Add Role</label>
					<div class="col-md-6">
						<input type="text" class="form-control" name="role_name" required>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary btn-block">Add Role</button>
					</div>
				</div>
			</form>
       	</div>
      </div>
    </div>
  </div>
@endsection