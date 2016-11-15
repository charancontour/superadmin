@extends('vendor.superadmin.layout')
@section('content')
<!-- Start of Panel -->
<div class="panel">
  <!-- Panel Header -->
  <div class="panel-heading border">
    <ol class="breadcrumb mb0 no-padding">
            <li><a href="/superadmin/index">Home</a></li>
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
<!-- /End of Panel -->

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
            <!-- Start of Stats -->
            <div class="row">
              <div class="col-md-6"> 
                <div> 
                  <div class="widget bg-white" style="border:1px solid #ddd;"> 
                    <div class="widget-icon bg-blue pull-left fa fa-users"> </div> 
                    <div class="overflow-hidden"> 
                      <span class="widget-title" id="efront-users">0</span> 
                      <span class="widget-subtitle">Efront Users</span> 
                    </div> 
                  </div> 
                </div> 
              </div>
              <div class="col-md-6"> 
                <div> 
                  <div class="widget bg-white" style="border:1px solid #ddd;"> 
                    <div class="widget-icon bg-info pull-left fa fa-users"> </div> 
                    <div class="overflow-hidden"> 
                      <span class="widget-title" id="app-users">0</span> 
                      <span class="widget-subtitle">Users In App</span> 
                    </div> 
                  </div> 
                </div> 
              </div>
            </div>
            <!-- /End of Stats -->
            <div class="users-for-location"></div>
        </div>
      </div>
    </div>
</div>  
@endsection