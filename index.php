<?php 
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?> 
</head>
<body class="cuerpo-index">
                <header>
                      <?php include('header.php'); ?>
                </header>
                <div  id="app" class="container-fluid">
                   
                                    <div  class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
                                   
                                            <!-- Centra vertical y horizontalmente el contenido -->
                                            <div  class="form-login col-8 col-md-5 col-lg-4 col-xl-3 p-4 pb-2 pb-lg-4  rounded shadow-sm">
                                                <!-- Agrega la clase "rounded" para bordes redondeados y "shadow-lg" para sombra -->
                                                <h6 class="text-center label-session "><b>Iniciar Sesión</b></h6>
                                                <form @submit.prevent="submitForm" action="procesar_login.php" method="POST">
                                                    <div class="mb-3">
                                                        <label  class="form-label label-session">Usuario:</label>
                                                        <input type="text" class="form-control" id="usuario" v-model="usuario" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label  class="form-label label-session ">Contraseña:</label>
                                                        <input type="password" class="form-control" id="contrasena" v-model="contrasena" required>
                                                    </div>

                                                    <div class="text-center">
                                                        <button class="btn btn-danger" type="submit">Aceptar</button>
                                                    </div>
                                                </form>
                                                <div class="text-center">
                                                    <label class="text-danger mt-2" :style="{visibility: incorrecta == 1? 'visible':'hidden' }">La conctraseña es incorrecta</label>
                                                </div>
                                            </div>
                                        </div>
                                    
                    </div>
        <script src="js/login.js"></script>
</body>
</html>