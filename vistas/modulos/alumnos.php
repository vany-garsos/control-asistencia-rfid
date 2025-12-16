                      <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Administrar Alumnos</h1>
                    <button class="btn btn-primary mb-3" data-toggle="modal"
                        data-target="#modalAgregarAlumnos">
                        Agregar Alumnos
                    </button>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de Alumnos</h6>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>UID tarjeta</th>
                                            <th>Grupo</th>
                                            <th>Token del padre</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>UID tarjeta</th>
                                            <th>Grupo</th>
                                            <th>Token del padre</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $item = null;
                                        $campo = null;

                                        $alumnos = ControladorAlumnos::ctrMostrarAlumnos($item, $campo);
                                        foreach ($alumnos as $alumno):
                                        ?>
                                            <tr>
                                                <td><?= $alumno->id ?></td>
                                                <td><?= $alumno->nombre ?></td>
                                                <td><?= $alumno->rfid ?></td>
                                                <td><?= $alumno->grupo ?></td>
                                                <td><?= $alumno->padre_token ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->


                <!-- INICIAN LOS MODALES -->

                <!-- MODAL AGREGAR ALUMNOS -->

                <div class="modal fade" id="modalAgregarAlumnos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form class="user" method="post">
                                <!-- CABEZA MODAL -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Agregar Alumno</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <!-- TERMINA CABEZA MODAL -->

                                <!-- CUERPO MODAL -->
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <!-- ENTRADA DEL NOMBRE -->
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" name="nombre"
                                            placeholder="Nombre">
                                           
                                        </div>

                                        <!-- ENTRADA DEL GRUPO -->
                                        <div class="col-sm-6 mb-3 mb-sm-0 mt-2">                   
                                                <select name="grupo" class="form-control">
                                                    <option value="Ingenieria en Desarrollo y Gestion de Software">Ingenieria en Desarrollo y Gestion de Software</option>
                                                    <option value="Ingenieria en Desarrollo Sustentable">Ingenieria en Desarrollo Sustentable</option>
                                                    <option value="Ingenieria Mecanica">Ingenieria Mecanica</option>
                                                    <option value="Licenciatura en Gastronomia">Licenciatura en Gastronomia</option>
                                                    <option value="Licenciatura en Administracion de Negocios">Licenciatura en Administracion de Negocios</option>
                                                </select> 
                                        </div>
                                        <!-- ENTRADA DEL RFID -->
                                        <div class="col-sm-12 mb-3 mb-sm-0 mt-3">
                                            
                                                <h6 class="mb-4">Escanea la tarjeta para obtener tu uid</h6>
                                                <input type="text" id="rfid" name="rfid" class="form-control form-control-user" readonly>
                                                <div class="text-center mt-2">
                                                <img src="vistas/img/escanearrfid.png" alt="imagen escanear" width="70px">
                                                </div>
                                            
                                        </div>
                                        <!-- ENTRADA DEL PADRE TOKEN -->
                                        <div class="col-sm-12 mb-3 mb-sm-0 mt-3">
                                            
                                                <h6 class="mb-4">Instala la app en tu celular para obtener el token</h6>
                                                <input type="text" id="padre_token" name="padre_token" class="form-control form-control-user" readonly>
                                                <div class="text-center mt-2">
                                                <img src="vistas/img/token.png" alt="app instalar" width="70px">
                                                </div>
                                        
                                        </div>



                                    </div>
                                </div>
                                <!-- TERMINA CUERPO DEL MODAL -->

                                <!-- PIE DEL MODAL -->
                                <div class="modal-footer">
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Salir</button>
                                    <button class="btn btn-success" type="submit">Guardar Alumno</button>
                                </div>
                                <!-- TERMINA PIE DEL MODAL -->
                            </form>
                            <?php
                            $crearAlumno = new ControladorAlumnos();
                            $crearAlumno->ctrCrearAlumnos();

                            ?>
                        </div>
                    </div>
                </div>
                <!-- TEMINA MODAL AGREGAR ALUMNOS -->
