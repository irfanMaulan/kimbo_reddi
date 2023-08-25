<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light"><strong><center>ADMIN CMS</center></strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ json_encode(session()->get('role')) }}</a>
        </div>
      </div>
    <!-- json_encode(session()->get('name')) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item {{ Request::segment(1) == 'data-reedem-hadiah-besar' || Request::segment(1) == 'data-reedem-hadiah-kecil' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Data Reedem
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/data-reedem-hadiah-besar') }}" class="nav-link {{ Request::segment(1) == 'data-reedem-hadiah-besar' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hadiah Besar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/data-reedem-hadiah-kecil') }}" class="nav-link {{ Request::segment(1) == 'data-reedem-hadiah-kecil' ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hadiah Kecil & Blank</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ url('/list-download') }}" class="nav-link {{ Request::segment(1) == 'list-download' ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                List Download
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/ringkasan-hadiah') }}" class="nav-link {{ Request::segment(1) == 'ringkasan-hadiah' ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Ringkasan Stok Hadiah
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/program') }}" class="nav-link {{ Request::segment(1) == 'program' ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Program Manajemen
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/kode-unik') }}" class="nav-link {{ Request::segment(1) == 'kode-unik' ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Kode Unik
              </p>
            </a>
          </li>
        @if(session()->get('role') == "superadmin")
          <li class="nav-item">
            <a href="{{ url('/user-management') }}" class="nav-link {{ Request::segment(1) == 'user-management' ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                User Management
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/uniq-code-generate') }}" class="nav-link {{ Request::segment(1) == 'uniq-code-generate' ? 'active' : '' }}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Generate Code Uniq
              </p>
            </a>
          </li>
        @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
