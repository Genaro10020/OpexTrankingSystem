<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>

<body>

    <header>
        <?php include('header.php'); ?>
    </header>
    <div id="app" class="container-fluid ">

        <div class="container-fluid d-flex align-items-stretch" style="min-height: 80vh;">
            <div class="row">
                <div class="col-12 col-lg-4 d-flex  justify-content-center   align-items-center">
                    <!-- Centra vertical y horizontalmente el contenido -->
                    <div class="form-login  mt-5 mt-lg-0  rounded shadow-sm p-3" style="width:300px; height:300px;">
                        <!-- Agrega la clase "rounded" para bordes redondeados y "shadow-lg" para sombra -->
                        <h6 class="text-center label-session "><b>Iniciar Sesión</b></h6>
                        <form @submit.prevent="submitForm" action="procesar_login.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label label-session">Usuario:</label>
                                <input type="text" class="form-control" id="usuario" v-model="usuario" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label label-session ">Contraseña:</label>
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
                <div class="col-12 col-lg-6 my-auto">
                    <div>
                        <img class="imagen-index" :src="'imagenes/imagen.jpg'+'?'+random" alt="No existe imagen para mostrar">
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="js/login.js"></script>

</body>

</html>