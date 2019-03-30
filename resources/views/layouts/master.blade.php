
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Open gen | Starter</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
</head>
<body class="hold-transition sidebar-mini" >
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    
    </ul>

    <!-- SEARCH FORM -->
    
      <div class="col-md-3 input-group input-group-sm">
        <input class="form-control form-control-navbar" @keyup="searchhit" v-model="search" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchhit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
  

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
       
      <li class="nav-item">
        
            <a class="nav-link" href="{{ route('logout') }}"  onclick="event.preventDefault();   document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off red"></i>
                        {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
   <a href="/" class="brand-link">
      <img src="{{url('/img/logo.png')}}"  alt="Open Gen Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Open Gen</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('/img/boy.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <router-link to="/profile" class="d-block">  
                  {{ Auth::user()->name }}   
            </router-link> 
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt blue"></i>
              <p>
              
                Dashboard 
              </p>
            </router-link>
          </li>
          @can('isAdminOrVendor1')
           <li class="nav-item">
            <router-link to="/developer" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Developer 
              </p>
            </router-link>
          </li>
          @endcan
          
          @can('isAdminOrVendor')
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">  
              <i class="nav-icon fas fa-list-ul orange"></i>
              <p>
                Catalog
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <router-link to="/category" class="nav-link ">
                  <i class="nav-icon fas fa-grip-lines"></i>
                  <p>Categories</p>
                </router-link>
              </li>
              <li class="nav-item">
                  <router-link to="/customers" class="nav-link "> 
                    <i class="nav-icon fas fa-user-tie"></i>
                    <p>Customers</p>
                  </router-link>
                </li>
              <li class="nav-item">
                  <router-link to="/stores" class="nav-link ">
                    <i class="nav-icon fas fa-store"></i>
                    <p>Stores</p>
                  </router-link>
              </li>

              <li class="nav-item">
                  <router-link to="/products" class="nav-link ">
                    <i class="nav-icon fab fa-product-hunt"></i>
                    <p>Products</p>
                  </router-link>
                </li>
                 
            </ul>
          </li>
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link "> 
                <i class="nav-icon fas fa-shopping-cart green"></i>
                <p>
                  Sales
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/orders" class="nav-link ">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    <p>Orders</p>
                  </router-link>
                </li> 
              </ul>
            </li>
          @endcan
           
          @can('isAdmin')
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link "> 
              <i class="nav-icon fas fa-cog purple"></i>
              <p>
                Managment
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/users" class="nav-link ">
                      <i class="fas fa-users nav-icon"></i>
                      <p>Users</p>
                    </router-link>
                  </li>
             
              <li class="nav-item">
                  <router-link to="/currency" class="nav-link "> 
                    <i class="nav-icon fas fa-euro-sign"></i>
                    <p>Currencies</p>
                  </router-link>
              </li>
              <li class="nav-item">
                  <router-link to="/language" class="nav-link ">  
                    <i class="nav-icon fas fa-language"></i>
                    <p>Languages</p>
                  </router-link>
              </li>
             
              <li class="nav-item">
                  <router-link to="/countries" class="nav-link ">   
                    <i class="nav-icon fas fa-globe-americas"></i>
                    <p>Countries</p>
                  </router-link>
              </li>
              <li class="nav-item">
                  <router-link to="/zones" class="nav-link ">   
                    <i class="nav-icon fas fa-globe-americas"></i>
                    <p>Zones</p>
                  </router-link>
              </li>
              <li class="nav-item">
                  <router-link to="/weightclass" class="nav-link ">    
                    <i class="nav-icon fas fa-weight"></i>
                    <p>Weight Classes </p>
                  </router-link>
              </li>
              <li class="nav-item">
                  <router-link to="/lengthclass" class="nav-link ">     
                    <i class="nav-icon fas fa-ruler-combined"></i>
                    <p>Length Classes </p>
                  </router-link>
              </li>
              <li class="nav-item">
                  <router-link to="/taxrate" class="nav-link ">      
                    <i class="nav-icon fas fa-yen-sign"></i>
                    
                    <p>Taxes rates</p>
                  </router-link>
              </li>

              
               
            </ul>
          </li>
          @endcan
           
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        All rights reserved.
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018-2019 <a href="https://open-gen.com">Open-gen.com</a>.</strong> 
  </footer>
</div>
<!-- ./wrapper -->
@auth
<script>
 window.user=@json(auth()->user());  

 </script> 
@endauth
<!-- REQUIRED SCRIPTS -->
<script src="/js/ckeditor/ckeditor.js"></script>
<script src="/js/app.js"></script>
 
</body>
</html>
