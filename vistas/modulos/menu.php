        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="inicio">
               
                <div class="sidebar-brand-text mx-3">Asistencia UTTC</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="inicio">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span></a>
            </li>


            <!-- Nav Item - Charts -->
            <?php
            if (isset($_SESSION['tipo'])) {
                if ($_SESSION['tipo'] == 'Administrador') { ?>
                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Usuarios
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="usuarios">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Mostrar Usuarios</span></a>
                    </li>


                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Alumnos
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="alumnos">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Mostrar Alumnos</span></a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Asistencias
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="asistencias">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Mostrar Asistencias</span></a>
                    </li>
            <?php
                } else { ?>
                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Asistencias
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="asistencias">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Mostrar Asistencias</span></a>
                    </li>
                    
              <?php  }
            }
            ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->