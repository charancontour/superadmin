<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>SuperAdmin</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width">
  <link rel="shortcut icon" href="/favicon.ico">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
  <!-- build:css({.tmp,app}) styles/app.min.css -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" type="text/css" href="{{asset('css/superadmin/dataTables.min.css')}}">
  <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="{{asset('css/superadmin/dashboard.css')}}">
</head>

<body>

  <div class="app layout-fixed-header">
    <!-- sidebar panel -->
    <div class="sidebar-panel offscreen-left">

      <div class="brand">

        <!-- logo -->
        <div class="brand-logo">
          <img src="{{asset('img/superadmin/logo.png')}}" height="20" alt="">
        </div>
        <!-- /logo -->

        <!-- toggle small sidebar menu -->
        <!-- <a href="javascript:;" class="toggle-sidebar hidden-xs hamburger-icon v3" data-toggle="layout-small-menu">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </a> -->
        <!-- /toggle small sidebar menu -->

      </div>

      <!-- main navigation -->
      <nav role="navigation">

      <ul class="nav">
    <li>
        <a href="/superadmin/users"> <i class="fa fa-flask"></i> <span>Dashboard</span> </a>
    </li>
    <li>
        <a href="/superadmin/locationlist"> <i class="fa fa-toggle-on"></i> <span>Locations</span> </a>
    </li>
    <li>
        <a href="/superadmin/usersgroup"> <i class="fa fa-tint"></i> <span>Groups</span> </a>
    </li>
    <li>
        <a href="/superadmin/users"> <i class="fa fa-tag"></i> <span>Users</span> </a>
    </li>
    <li>
        <a href="/superadmin/rolelist"> <i class="fa fa-users"></i> <span>Roles</span> </a>
    </li>
    <li>
        <a href="javascript:;"> <i class="fa fa-pie-chart"></i> <span>Graphs</span> </a>
    </li>
    <li class="menu-accordion">
        <a href="javascript:;"> <i class="fa fa-level-down"></i> <span>Menu Levels</span> </a>
        <ul class="sub-menu">
            <li class="menu-accordion">
                <a href="javascript:;"> <i class="toggle-accordion"></i> <span>Level 1</span> </a>
                <ul class="sub-menu">
                    <li class="menu-accordion">
                        <a href="javascript:;"> <i class="toggle-accordion"></i> <span>Level 2</span> </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="javascript:;"> <span>Level 3</span> </a>
                            </li>
                            <li>
                                <a href="javascript:;"> <span>Level 3.1</span> </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;"> <span>Level 2.1</span> </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"> <span>Level 1.1</span> </a>
            </li>
        </ul>
    </li>
</ul>  
        
      </nav>
      <!-- /main navigation -->
    </div>
    <!-- /sidebar panel -->

    <!-- content panel -->
    <div class="main-panel">

      <!-- top header -->
      <header class="header navbar">

        <div class="brand visible-xs">
          <!-- toggle offscreen menu -->
          <div class="toggle-offscreen">
            <a href="#" class="hamburger-icon visible-xs" data-toggle="offscreen" data-move="ltr">
              <span></span>
              <span></span>
              <span></span>
            </a>
          </div>
          <!-- /toggle offscreen menu -->

          <!-- logo -->
          <div class="brand-logo">
            <h3>SuperAdmin</h3>
          </div>
          <!-- /logo -->
        </div>

        <ul class="nav navbar-nav hidden-xs">
          <li>
            <p class="navbar-text">
              Dashboard
            </p>
          </li>
        </ul>

        <ul class="nav navbar-nav navbar-right hidden-xs">
           <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Proile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Account</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </li>
        </ul>
      </header>
      <!-- /top header -->

      <!-- main area -->
      <div class="main-content">
       @yield('content')
      </div>
      <!-- /main area -->
    </div>
    <!-- /content panel -->

    <!-- bottom footer -->
    <footer class="content-footer">
      <nav class="footer-left">
        <ul class="nav">
          <li>
            <a href="javascript:;">Copyright <i class="fa fa-copyright"></i> <span>SuperAdmin</span> 2015. All rights reserved</a>
          </li>
          <li>
            <a href="javascript:;">Careers</a>
          </li>
          <li>
            <a href="javascript:;">
                Privacy Policy
            </a>
          </li>
        </ul>
      </nav>
    </footer>
    <!-- /bottom footer -->
  </div>

  <!-- Script Tags  -->
  <!-- // <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
  <script src="{{asset('js/jquery.min.js')}}"></script>
  <!-- // <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script> -->
  <script src="{{asset('js/superadmin/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/superadmin/dataTables.js')}}"></script>
  <script src="{{asset('js/superadmin/bootstrap-dataTables.js')}}"></script>
  <script src="{{asset('js/superadmin/dashboard.js')}}"></script>
  <!-- // <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script> -->
  <!-- Page Level Scripts -->
  @if(Request::segment(2) == "users")
    <script src="{{asset('js/superadmin/user.js')}}"></script>
  @endif
  @if(Request::segment(2) == "usersgroup")
    <script src="{{asset('js/superadmin/groups.js')}}"></script>
  @endif
  @if(Request::segment(2) == "locationlist")
    <script src="{{asset('js/superadmin/location.js')}}"></script>
  @endif
  @if(Request::segment(2) == "rolelist")
    <script src="{{asset('js/superadmin/rolelist.js')}}"></script>
  @endif
</body>

</html>