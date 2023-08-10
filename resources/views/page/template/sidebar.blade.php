<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

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
                  <p>Hadiah Kecil</p>
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
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
