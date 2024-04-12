      <!-- Main Sidebar Container -->
<!--<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">-->
<aside class="main-sidebar sidebar-bg-light sidebar-color-primary shadow">
  <div class="brand-container">
    <a href="javascript:;" class="brand-link">
      <img src="<?= base_url('asset/img/patitas.png') ?>" alt="patitas" class="brand-image opacity-80 shadow">
      <span class="brand-text fw-light">Veterinaria Patitas</span>
    </a>
    <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i class="fas fa-angle-double-left"></i></a>
  </div>
  <!-- Sidebar -->
  <div class="sidebar">
    <nav class="mt-2">
      <!-- Sidebar Menu -->
      <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        <li class="nav-item menu-open">
          <a href="javascript:;" class="nav-link active">
            <i class="nav-icon fas fa-circle"></i>
            <p>
              Datos
              <i class="end fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('/public/dueno/')?>" class="nav-link active">
                <i class="nav-icon far fa-circle"></i>
                <p>Clientes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('/public/mascota/')?>" class="nav-link ">
                <i class="nav-icon far fa-circle"></i>
                <p>Mascotas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('/public/medico/')?>" class="nav-link ">
                <i class="nav-icon far fa-circle"></i>
                <p>Doctores</p>
              </a>
            </li>
        </li>
        <li class="nav-item">
              <a href="<?= base_url('/public/visita/')?>" class="nav-link ">
                <i class="nav-icon far fa-circle"></i>
                <p>Citas</p>
              </a>
            </li>
        </li>
        <li class="nav-item">
              <a href="<?= base_url('/public/receta/')?>" class="nav-link ">
                <i class="nav-icon far fa-circle"></i>
                <p>Recetas</p>
              </a>
            </li>
          </ul>
        </li>
        <!--
        <li class="nav-item ">
          <a href="javascript:;" class="nav-link ">
            <i class="nav-icon fas fa-circle"></i>
            <p>
              Recetas
              <i class="end fas fa-angle-left"></i>
            </p>
          </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="./pages/widgets/small-box.html" class="nav-link ">
                <i class="nav-icon far fa-circle"></i>
                <p>Small Box</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/widgets/info-box.html" class="nav-link ">
                <i class="nav-icon far fa-circle"></i>
                <p>info Box</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./pages/widgets/cards.html" class="nav-link ">
                <i class="nav-icon far fa-circle"></i>
                <p>Cards</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item ">
          <a href="javascript:;" class="nav-link ">
            <i class="nav-icon fas fa-circle"></i>
            <p>
              Layout Options
              <span class="badge bg-info float-end me-3">6</span>
              <i class="end fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="./pages/layout/fixed-sidebar.html" class="nav-link ">
                <i class="nav-icon far fa-circle"></i>
                <p>Fixed Sidebar</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">MULTI LEVEL EXAMPLE</li>
        <li class="nav-item">
          <a href="javascript:;" class="nav-link">
            <i class="nav-icon fas fa-circle"></i>
            <p>Level 1</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="javascript:;" class="nav-link">
            <i class="nav-icon fas fa-circle"></i>
            <p>
              Level 1
              <i class="end fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="javascript:;" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Level 2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="javascript:;" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>
                  Level 2
                  <i class="end fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="javascript:;" class="nav-link">
                    <i class="nav-icon far fa-dot-circle"></i>
                    <p>Level 3</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="javascript:;" class="nav-link">
                    <i class="nav-icon far fa-dot-circle"></i>
                    <p>Level 3</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="javascript:;" class="nav-link">
                    <i class="nav-icon far fa-dot-circle"></i>
                    <p>Level 3</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="javascript:;" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Level 2</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="javascript:;" class="nav-link">
            <i class="nav-icon fas fa-circle"></i>
            <p>Level 1</p>
          </a>
        </li>
        -->
        <li class="nav-header">Etiquetas</li>
        <li class="nav-item">
          <a href="javascript:;" class="nav-link">
            <i class="nav-icon far fa-circle text-danger"></i>
            <p class="text">Importante</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="javascript:;" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p>Avisos</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="javascript:;" class="nav-link">
            <i class="nav-icon far fa-circle text-info"></i>
            <p>Cuidados extras</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
  <!-- /.sidebar -->
</aside>