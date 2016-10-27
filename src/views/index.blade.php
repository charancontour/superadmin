
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>SuperAdmin</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{asset/css/superadmin/dashboard.css}}" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Super Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
           <!--  <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li> -->
             <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
            <li class="createStudent"><a href="#">Create Student</a></li>
            <li class="editStudent"><a href="#">Edit Student</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="row">
          		<div class="col-md-8 col-md-offset-2">
          			<div class="panel panel-default">
          				<div class="panel-heading">Create Student</div>
          				<div class="panel-body">
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

          					<form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/createuser') }}">
          						<input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <div class="form-group">
          							<label class="col-md-4 control-label">Payroll Number</label>
          							<div class="col-md-6">
          								<input type="text" class="form-control" name="login" value="{{ old('login') }}">
          							</div>
          						</div>

                      <div class="form-group">
          							<label class="col-md-4 control-label">Firstname</label>
          							<div class="col-md-6">
          								<input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">
          							</div>
          						</div>

                      <div class="form-group">
          							<label class="col-md-4 control-label">Lastname</label>
          							<div class="col-md-6">
          								<input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">
          							</div>
          						</div>


          						<div class="form-group">
          							<label class="col-md-4 control-label">E-Mail Address</label>
          							<div class="col-md-6">
          								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
          							</div>
          						</div>


                      <div class="form-group">
          							<label class="col-md-4 control-label">Location</label>
          							<div class="col-md-6">
                          <select class="form-control" name="location_id">
                            @foreach(App\Location::all() as $location)
                              <option value={{$location->id}}>{{$location->location_name}}</option>
                            @endforeach
                          </select>
          							</div>
          						</div>

          						<div class="form-group">
          							<label class="col-md-4 control-label">Password</label>
          							<div class="col-md-6">
          								<input type="password" class="form-control" name="password">
          							</div>
          						</div>

                      <div class="form-group">
          							<label class="col-md-4 control-label">Confirm Password</label>
          							<div class="col-md-6">
          								<input type="password" class="form-control" name="confirm-password">
          							</div>
          						</div>

          						<div class="form-group">
          							<div class="col-md-6 col-md-offset-4">
          								<button type="submit" class="btn btn-primary">Create Student</button>
          							</div>
          						</div>
          					</form>
          				</div>
          			</div>
          		</div>
          </div>

          <div class="row">
          		<div class="col-md-8 col-md-offset-2">
          			<div class="panel panel-default">
          				<div class="panel-heading">Edit Student</div>
          				<div class="panel-body">
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

          					<form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/updateuser') }}">
          						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <?php $user = App\User::find(8);
                         $user_name = $user->login;
                         $user_name = str_replace(Config::get('efront.LoginPrefix'),"",$user_name);
                         if(!is_numeric($user_name)){
                           $user_name = $user->login;
                         }
                      ?>
                      <div class="form-group">
          							<label class="col-md-4 control-label">Payroll Number</label>
          							<div class="col-md-6">
          								<input type="text" class="form-control" name="login" value="{{ $user_name }}">
          							</div>
          						</div>
                      <input type="hidden" name="user_id" value="{{$user->id}}">

                      <div class="form-group">
          							<label class="col-md-4 control-label">Firstname</label>
          							<div class="col-md-6">
          								<input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}">
          							</div>
          						</div>

                      <div class="form-group">
          							<label class="col-md-4 control-label">Lastname</label>
          							<div class="col-md-6">
          								<input type="text" class="form-control" name="lastname" value="{{ $user->lastname }}">
          							</div>
          						</div>


          						<div class="form-group">
          							<label class="col-md-4 control-label">E-Mail Address</label>
          							<div class="col-md-6">
          								<input type="email" class="form-control" name="email" value="{{ $user->email }}">
          							</div>
          						</div>


                      <div class="form-group">
          							<label class="col-md-4 control-label">Location</label>
          							<div class="col-md-6">
                          <select class="form-control" name="location_id" value="{{$user->location_id}}">
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

          <div class="row">
              <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                  <div class="panel-heading">Create Location</div>
                  <div class="panel-body">
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

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/createlocation') }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-group">
                        <label class="col-md-4 control-label">Location Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control" name="location_name" value="">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                          <button type="submit" class="btn btn-primary">Create Branch</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-default">
                    <div class="panel-heading">Assign user to Group</div>
                    <div class="panel-body">
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

                      <form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/assignusertogroup') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                          <label class="col-md-4 control-label">User Id</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="user_id" value="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-4 control-label">Group Id</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="group_id" value="">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Assign user to Group</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-default">
                    <div class="panel-heading">Remove user from Group</div>
                    <div class="panel-body">
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

                      <form class="form-horizontal" role="form" method="POST" action="{{ url('/superadmin/removeuserfromgroup') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                          <label class="col-md-4 control-label">User Id</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="user_id" value="">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-4 control-label">Group Id</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="group_id" value="">
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Remove user from Group</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
    </div>
<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <script type="text/javascript">
      $(function(){
        $('.edit-student').hide();
        $('.editStudent').on('click',function(){
          $('.edit-student').show();
          $('.create-student').hide();
        });

        $('.createStudent').on('click',function(){
          $('.edit-student').hide();
          $('.create-student').show();
        });


      });
    </script>
  </body>
</html>
