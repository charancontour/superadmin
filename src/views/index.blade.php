
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

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
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
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="row">
          		<div class="col-md-8 col-md-offset-2">
          			<div class="panel panel-default">
          				<div class="panel-heading">Create User</div>
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

        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
