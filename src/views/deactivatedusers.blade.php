@extends('vendor.superadmin.layout')
@section('content')
<div class="panel">
	<!-- Panel Header -->
	<div class="panel-heading border">
		<ol class="breadcrumb mb0 no-padding">
            <li><a href="/superadmin/users">Home</a></li>
            <li class="active">Deactivated Users</li>
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
    <div class="panel-body" id="deactivated-users-table">

    </div>
</div>