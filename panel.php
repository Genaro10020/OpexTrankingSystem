
<?php session_start(); 
if(isset($_SESSION['nombre'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?> 
</head>
<body class="container-fluid d-flex flex-column" style="min-height: 100vh;">
       
        <!--Encabezado-->
        <?php include('header.php'); ?> 
         <!--Cinta-->
        <div class="cinta row d-flex align-items-center" style="min-height:5vh; ">
            <!--Bóton Alta Proyectoss-->
            <div id="alta-proyectos" class="text-center">
                <button class="btn-menu" @click="abrirModal('Alta')"> 
                    <i class="bi bi-plus-circle" ></i> Alta Proyectos
                </button>
                                <!--Modal Alta Proyectos-->
                                    <div id="modal-alta-proyecto" class="modal text-start"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" >
                                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Alta Proyecto</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                        <!--Formulario Alta Proyecto-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Fecha</span>
                                                            <input type="date" class="w-50" >
                                                        </div>
                                               
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Nombre Proyecto</span>
                                                            <input type="text" class="w-50">
                                                        </div>

                                                        <!---Planta-->
                                                        <div class="input-group mb-3 ">
                                                            <span class="input-group-text w-25" >Planta</span>
                                                            <select v-model="selectPlanta" size="3" class="w-50">
                                                                <option value="" selected>Seleccione..</option>
                                                                <option v-for="planta in plantas" :value="planta.id + '-' + planta.nombre">{{planta.nombre}}</option>
                                                            </select>
                                                            <div>
                                                                <div class="col-12"><button class="btn-anadir" title="Crear "  @click="abrirModal('CRUD','Planta','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar"  @click="abrirModal('CRUD','Planta','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar"  @click="eliminarPlanta()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!---Área-->
                                                         <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Área</span>
                                                            <select v-model="selectArea" size="3" class="w-50">
                                                                <option selected>Seleccione..</option>
                                                                <option v-for="area in areas" :value="area.id + '-' + area.nombre">{{area.nombre}}</option>
                                                            </select>
                                                            <div>
                                                                <div class="col-12"><button class="btn-anadir" title="Crear" @click="abrirModal('CRUD','Área','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Área','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar"  @click="eliminarArea()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                        </div>

                                                          <!---Departamentos-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Departamento</span>
                                                            <select v-model="selectDepartamento" size="3" class="w-50">
                                                                <option selected>Seleccione..</option>
                                                                <option v-for="departamento in departamentos" :value="departamento.id+'-'+departamento.nombre">{{departamento.nombre}}</option>
                                                            </select>
                                                            <div>
                                                                <div class="col-12"><button class="btn-anadir" title="Crear"  @click="abrirModal('CRUD','Departamento','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Departamento','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarDepartamento()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                        </div>
                                                         <!---Metodologías-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Metodología</span>
                                                            <select v-model="selectMetodologia" size="3" class="w-50">
                                                                <option selected>Seleccione..</option>
                                                                <option v-for="metodologia in metodologias" :value="metodologia.id+'-'+metodologia.nombre">{{metodologia.nombre}}</option>
                                                            </select>
                                                            <div>
                                                                <div class="col-12"><button class="btn-anadir" title="Crear " @click="abrirModal('CRUD','Metodología','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar"  @click="abrirModal('CRUD','Metodología','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarMetodologia()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                        </div>
                                                         <!---Responsables-->
                                                            <div class="d-flex d-flex-row justify-content-center">
                                                                <div ><button class="btn-anadir" title="Crear " @click="crearResponsable"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div><button class="btn-up" title="Actualizar"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div ><button class="btn-delete" title="Eliminar"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                            
                                                            <div class="input-group">
                                                                <span class="input-group-text w-25" >Responsable</span>
                                                                <select  model="selectResponsable"  class="w-50">
                                                                    <option value="" disabled selected>Seleccione..</option>
                                                                    <option v-for="responsable in responsables" :value="responsable.nombre">{{responsable.nombre}}</option>
                                                                </select>
                                                            </div>
                                                         
                                                            <div class="row nuevo_responsable pt-2 mt-3" v-if="nuevoResponsable">
                                                                    <div class="col-10">
                                                                            <div v-if="nuevoResponsable" class="input-group mb-3" >
                                                                                <span class="input-group-text w-25" >Nombre</span>
                                                                                <input type="text" v-model="nombre" class="w-75" :disabled="!nuevoResponsable">
                                                                            </div>
                                                                            <div v-if="nuevoResponsable" class="input-group mb-3" >
                                                                                <span class="input-group-text w-25" >No. de Nómina</span>
                                                                                <input type="text"  v-model="numero_nomina"  class="w-75" :disabled="!nuevoResponsable">
                                                                            </div>

                                                                            <div  v-if="nuevoResponsable" class="input-group mb-3">
                                                                                <span class="input-group-text w-25" >Correo</span>
                                                                                <input type="text"  v-model="correo"  class="w-75" :disabled="!nuevoResponsable">
                                                                            </div>

                                                                            <div  v-if="nuevoResponsable" class="input-group mb-3">
                                                                                <span class="input-group-text w-25" >Teléfono</span>
                                                                                <input type="text"  v-model="telefono"  class="w-75" :disabled="!nuevoResponsable">
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-2 my-auto">
                                                                            <button type="button" class="btn-nuevo-responsable" @click="insertarResponsable()" >Crear</button>
                                                                    </div>
                                                            </div>
                                                        
                                                            <div class="input-group mb-3 mt-3">
                                                                <span class="input-group-text w-25 text-start">Pilares <br>Estrategicos</span>
                                                                <div class="w-50">
                                                                    <div class="form-check border border-1 mt-1" v-for="(pilar, index) in pilares" :key="index">
                                                                        <input class="form-check-input" type="checkbox" :value="pilar.nombre" v-model="selectPilar">
                                                                        <label class="form-check-label">
                                                                            {{ pilar.nombre }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="my-auto">
                                                                    <div class="col-12"><button class="btn-anadir" title="Crear "><i class="bi bi-plus-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-up" title="Actualizar"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-delete" title="Eliminar"><i class="bi bi-x-circle"></i></button></div>
                                                                </div>
                                                            </div>
                                                      

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25 text-start">Objetivo <br>Estrategicos</span>
                                                            <div class="w-50">
                                                                <div class="form-check border border-1 mt-1">
                                                                    <input class="form-check-input" type="checkbox" id="checkbox1">
                                                                    <label class="form-check-label" for="checkbox1">
                                                                        Uno
                                                                    </label>
                                                                </div>
                                                                <div class="form-check border border-1">
                                                                    <input class="form-check-input" type="checkbox" id="checkbox2">
                                                                    <label class="form-check-label" for="checkbox2">
                                                                        Dos
                                                                    </label>
                                                                </div>
                                                            </div>
                                                                <div>
                                                                    <div class="col-12"><button class="btn-anadir" title="Crear "><i class="bi bi-plus-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-up" title="Actualizar"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-delete" title="Eliminar"><i class="bi bi-x-circle"></i></button></div>
                                                                </div>
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25 text-start">Impacto <br>Ambiental</span>
                                                            <div class="w-50">
                                                                <div class="form-check border border-1  mt-1">
                                                                    <input class="form-check-input" type="checkbox" id="checkbox1">
                                                                    <label class="form-check-label" for="checkbox1">
                                                                        Uno
                                                                    </label>
                                                                </div>
                                                                <div class="form-check border border-1" >
                                                                    <input class="form-check-input" type="checkbox" id="checkbox2">
                                                                    <label class="form-check-label" for="checkbox2">
                                                                        Dos
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="col-12"><button class="btn-anadir" title="Crear "><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                        </div>


                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Tons CO2 por Evitar (Proyectado)</span>
                                                            <input type="text" class="w-25" >
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Ahorro Duro $MXN (Proyectado )</span>
                                                            <input type="text" class="w-25" >
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Ahorro Suave $MXN (Proyectado)</span>
                                                            <input type="text" class="w-25" >
                                                        </div>
                                                    <!--Fin Formulario Alta Proyecto--> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="boton-cancelar" data-bs-dismiss="modal">Salir</button>
                                                    <button type="button" class="boton-aceptar">Crear</button>
                                                </div>
                                                </div>
                                            </div>
                                    </div>
                                 <!--Fin Modal Alta Proyectos-->
                                  <!--Modal CRUD-->
                                  <div id="modal-alta-crud" class="modal text-start " tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title ">{{accion}} {{tipo}}</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <!--PLANTA-->
                                                    <!--CRUD Planta Crear-->
                                                    <div v-if="tipo=='Planta' && accion=='Crear'">

                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Nombre {{tipo}}:</span>
                                                            <input type="text" v-model="nueva" class="w-75" >
                                                        </div>
                                                    </div>
                                                     <!--CRUD Planta Actualizar-->
                                                     <div v-if="tipo=='Planta' && accion=='Actualizar'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-25" >Nombre{{tipo}}:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-75" >
                                                            </div>
                                                    </div>
                                                <!--ÁREAS-->    
                                                     <!--CRUD Planta Crear-->
                                                     <div v-if="tipo=='Área' && accion=='Crear'">
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Nombre {{tipo}}:</span>
                                                            <input type="text" v-model="nueva" class="w-75" >
                                                        </div>
                                                    </div>
                                                     <!--CRUD Planta Actualizar-->
                                                     <div v-if="tipo=='Área' && accion=='Actualizar'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-25" >Nombre {{tipo}}:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-75" >
                                                            </div>
                                                    </div>
                                                <!--DEPARTAMENTOS-->    
                                                     <!--CRUD Departamento Crear-->
                                                     <div v-if="tipo=='Departamento' && accion=='Crear'">
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Nombre {{tipo}}:</span>
                                                            <input type="text" v-model="nueva" class="w-50" >
                                                        </div>
                                                    </div>
                                                     <!--CRUD Departamento Actualizar-->
                                                     <div v-if="tipo=='Departamento' && accion=='Actualizar'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Nombre {{tipo}}:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-50" >
                                                            </div>
                                                    </div>
                                                      <!--METODOLOGÍA-->    
                                                     <!--CRUD metodologia Crear-->
                                                     <div v-if="tipo=='Metodología' && accion=='Crear'">
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Nombre {{tipo}}:</span>
                                                            <input type="text" v-model="nueva" class="w-50" >
                                                        </div>
                                                    </div>
                                                     <!--CRUD Metodologia Actualizar-->
                                                     <div v-if="tipo=='Metodología' && accion=='Actualizar'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Nombre {{tipo}}:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-50" >
                                                            </div>
                                                    </div>
                                                <!--Fin Formulario Alta Proyecto CRUD--> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="boton-cancelar" data-bs-dismiss="modal">Salir</button>
                                                    <button type="button" class="boton-aceptar" v-if="tipo=='Planta' && accion=='Crear'" @click="insertarPlanta()">Crear</button>
                                                    <button type="button" class="boton-aceptar" v-if="tipo=='Área' && accion=='Crear'" @click="insertarArea()">Crear</button>
                                                    <button type="button" class="boton-aceptar" v-if="tipo=='Departamento' && accion=='Crear'" @click="insertarDepartamento()">Crear</button>
                                                    <button type="button" class="boton-aceptar" v-if="tipo=='Metodología' && accion=='Crear'" @click="insertarMetodologia()">Crear</button>
                                                    <button type="button" class="boton-actualizar" v-if="tipo=='Planta' && accion=='Actualizar'" @click="actualizarPlanta()">Actualizar</button>
                                                    <button type="button" class="boton-actualizar" v-if="tipo=='Área' && accion=='Actualizar'" @click="actualizarArea()">Actualizar</button>
                                                    <button type="button" class="boton-actualizar" v-if="tipo=='Departamento' && accion=='Actualizar'" @click="actualizarDepartamento()">Actualizar</button>
                                                    <button type="button" class="boton-actualizar" v-if="tipo=='Metodología' && accion=='Actualizar'" @click="actualizarMetodologia()">Actualizar</button>
                                                </div>
                                                </div>
                                            </div>
                                    </div>
                                    <!--Fin CRUD-->
                                 <!--Fin Modal Alta Proyectos-->

            </div>
             <!--Fin Bóton Alta Proyectoss-->
        </div>
         <!--Cuerpo-->
        <div id="app" class="row flex-grow-1" style="min-height: 80vh;">
        
         </div>
         <!--pie-->
         <div  class="footer row" style="min-height:5vh;">

        </div>    

    <script src="js/panel.js"></script>
    <script src="js/altaProyectos.js"></script>
    
</body>
</html>

<?php
}else{
header("Location:index.php");
}?>
