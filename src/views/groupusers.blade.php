@extends('vendor.superadmin.layout')
@section('content')
<div class="panel">
	<!-- Panel Header -->
	<div class="panel-heading border">
		<ol class="breadcrumb mb0 no-padding">
            <li><a href="/superadmin/users">Home</a></li>
            <li class="active">Groups</li>
        </ol>
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
    <div class="panel-body" id="groupsTable">

    </div>
</div>

<!-- Modal PoP Up for Get Users for a Group -->
<div class="modal bs-modal-sm get-users" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Users for the Group</h4>
        </div>
        <div class="modal-body">
           
       	</div>
      </div>
    </div>
</div>
@endsection