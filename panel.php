
<?php session_start(); 
if(isset($_SESSION['nombre'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?> 
</head>
<body class="container-fluid d-flex flex-column" style="min-height: 100vh;">
<div id="alta-proyectos">
        <!--Encabezado-->
        <?php include('header.php'); ?> 
         <!--Cinta-->
        <div class="cinta row d-flex align-items-center" style="min-height:5vh; ">
                 <!--Bóton Crear misiones/pilares/Objetivos-->
                
               
                 
            <!--Bóton-->
            <div  class="text-center">
                <button class="btn-menu me-3" @click="ventana='Crear'"> 
                    <i class="bi bi-plus-circle" ></i> Crear Catalogos
                </button>

                <button class="btn-menu" @click="abrirModal('Alta'), ventana='Altas'"> 
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
                                                        <div class="input-group mb-3" >
                                                            <span class="input-group-text w-25">Fecha</span>
                                                            <input type="date" class="w-50" v-model="fecha_alta">
                                                            <div v-if="fecha_alta !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>
                                                        
                                               
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Nombre Proyecto</span>
                                                            <input type="text" class="w-50" v-model="nombre_proyecto"> 
                                                            <div v-if="nombre_proyecto !==''" class=" text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>

                                                        <!---Planta-->
                                                        <div class="input-group mb-3 ">
                                                            <span class="input-group-text w-25" >Planta</span>
                                                            <select v-model="selectPlanta" size="3" class="w-50">
                                                                <option value="" selected disabled>Seleccione..</option>
                                                                <option v-for="planta in plantas" :value="planta.id +'<->'+ planta.nombre+'<->'+planta.siglas" >{{planta.nombre}} ({{planta.siglas}})</option>
                                                            </select>
                                                            <div class="flex-column">
                                                                <div class="col-12"><button class="btn-anadir" title="Crear "  @click="abrirModal('CRUD','Planta','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar"  @click="abrirModal('CRUD','Planta','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar"  @click="eliminarPlanta()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                            <div v-if="selectPlanta !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>
                                                        
                                                        <!---Área-->
                                                         <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Área</span>
                                                            <select v-model="selectArea" size="3" class="w-50" > 
                                                                <option selected disabled>Seleccione..</option>
                                                                <option v-for="area in areas" :value="area.id +'<->'+ area.nombre+'<->'+ area.siglas">{{area.nombre}}  ({{area.siglas}})</option>
                                                            </select>
                                                            <div>
                                                                <div class="col-12"><button class="btn-anadir" title="Crear" @click="abrirModal('CRUD','Área','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Área','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar"  @click="eliminarArea()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                            <div v-if="selectArea !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>

                                                          <!---Departamentos-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Departamento</span>
                                                            <select v-model="selectDepartamento" size="3" class="w-50">
                                                                <option selected disabled>Seleccione..</option>
                                                                <option v-for="departamento in departamentos" :value="departamento.id+'<->'+departamento.nombre+'<->'+departamento.siglas">{{departamento.nombre}} ({{departamento.siglas}})</option>
                                                            </select>
                                                            <div>
                                                                <div class="col-12"><button class="btn-anadir" title="Crear"  @click="abrirModal('CRUD','Departamento','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Departamento','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarDepartamento()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                            <div v-if="selectDepartamento !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>
                                                         <!---Metodologías-->
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Metodología</span>
                                                            <select v-model="selectMetodologia" size="3" class="w-50"> 
                                                                <option selected disabled>Seleccione..</option>
                                                                <option v-for="metodologia in metodologias" :value="metodologia.id+'<->'+metodologia.nombre">{{metodologia.nombre}}</option>
                                                            </select>
                                                            <div>
                                                                <div class="col-12"><button class="btn-anadir" title="Crear " @click="abrirModal('CRUD','Metodología','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-up" title="Actualizar"  @click="abrirModal('CRUD','Metodología','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarMetodologia()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                            <div v-if="selectMetodologia !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div> 
                                                         <!---Responsables-->
                                                            <div class="d-flex d-flex-row justify-content-center">
                                                                <div ><button class="btn-anadir" title="Crear " @click="crearResponsable()"><i class="bi bi-plus-circle"></i></button></div>
                                                                <div><button class="btn-up" title="Actualizar" @click="consultarResponsableID()"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                <div ><button class="btn-delete" title="Eliminar" @click="eliminarResponsable()"><i class="bi bi-x-circle"></i></button></div>
                                                            </div>
                                                            
                                                            <div class="input-group">
                                                                <span class="input-group-text w-25" >Responsable</span>
                                                                <select  v-model="selectResponsable"  class="w-50">
                                                                    <option value="" disabled selected>Seleccione..</option>
                                                                    <option v-for="responsable in responsables" :value="responsable.id+'<->'+responsable.nombre">{{responsable.nombre}}</option>
                                                                </select>
                                                                <div v-if="selectResponsable !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>
                                                            <!--Campos Responsable-->
                                                            <div class="row pt-2 mt-3 ocultar" :class="{'nuevo_responsable mostrar': nuevoResponsable, 'actualizar_responsable mostrar': actualizarResponsable}">
                                                                    <div class="col-10">
                                                                            <div  class="input-group mb-3" >
                                                                                <span class="input-group-text w-25" >Nombre</span>
                                                                                <input type="text" v-model="nombre" class="w-75" :disabled="!nuevoResponsable">
                                                                            </div>
                                                                            <div  class="input-group mb-3" >
                                                                                <span class="input-group-text w-25" >No. de Nómina</span>
                                                                                <input type="text"  v-model="numero_nomina"  class="w-75" >
                                                                            </div>
                                                                            <div   class="input-group mb-3">
                                                                                <span class="input-group-text w-25" >Correo</span>
                                                                                <input type="text"  v-model="correo"  class="w-75" :disabled="!nuevoResponsable">
                                                                            </div>
                                                                            <div class="input-group mb-3">
                                                                                <span class="input-group-text w-25" >Teléfono</span>
                                                                                <input type="text"  v-model="telefono"  class="w-75" :disabled="!nuevoResponsable">
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-2 my-auto text-center">
                                                                            <button type="button" v-if="nuevoResponsable==true && actualizarResponsable==false" class="btn-nuevo-responsable" @click="insertarResponsable()" >Crear</button>
                                                                            <button type="button" v-if="actualizarResponsable" class="btn-actualizar-responsable" @click="actualizandoResponsable()" >Actualiazar</button>
                                                                            <button type="button" class="btn-cancelar-responsable mt-3" @click="cancelar()" >Cancelar</button>
                                                                    </div>
                                                                    
                                                            </div>

                                                             <!--Misiones-->
                                                            <div  class="input-group mb-3 mt-3 ">  
                                                                <span class="input-group-text w-25 text-start">Misiones </span>
                                                                <div class="w-50">
                                                                    <div class="form-check border border-1 mt-1" v-for="(mision, index) in misiones" :key="index">
                                                                    <input class="form-check-input" type="checkbox" :value="mision.id" v-model="checkMisiones" @change="consultarPilaresXmisionSeleccionada()">
                                                                        <label class="form-check-label">
                                                                            {{ mision.nombre }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <!--<div class="my-auto">
                                                                    <div class="col-12"><button class="btn-anadir" title="Crear "><i class="bi bi-plus-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-up" title="Actualizar"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-delete" title="Eliminar"><i class="bi bi-x-circle"></i></button></div>
                                                                </div>-->
                                                                <div v-if="checkMisiones.length>0" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>

                                                            
                                                            <!--Pilares-->
                                                            <div id="div_pilares" class="input-group mb-3 " :class="{'mostrar':checkMisiones.length>0, 'ocultar': checkMisiones.length <= 0}">
                                                                <span class="input-group-text w-25 text-start">Pilares <br>Estrategicos</span>
                                                                <div class="w-50">
                                                                    <div class="form-check border border-1 mt-1" v-for="(pilar, index) in pilares" :key="index">
                                                                        <input class="form-check-input" type="checkbox" :value="pilar.id" v-model="checkPilares" @change="consultarObjetivosXpilaresSeleccionados()">
                                                                        <label class="form-check-label">
                                                                            {{ pilar.nombre }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <!--<div class="my-auto">
                                                                    <div class="col-12"><button class="btn-anadir" title="Crear " @click="abrirModal('CRUD','Pilar','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Pilar','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarPilar()"><i class="bi bi-x-circle"></i></button></div>
                                                                </div>-->
                                                                <div v-if="checkPilares.length>0" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>

                                                             <!--Objetivos-->
                                                            <div v-if="checkPilares.length>0" class="input-group mb-3 " :class="{'mostrar':checkPilares.length>0, 'ocultar': checkPilares.length <= 0}">
                                                                <span class="input-group-text w-25 text-start">Objetivos <br>Estrategicos</span>
                                                                <div class="w-50">
                                                                    <div v-for="objetivo in objetivos"class="form-check border border-1 mt-1">
                                                                        <input class="form-check-input" v-model="checkObjetivos" type="checkbox" id="checkbox1" :value="objetivo.id+'<->'+objetivo.nombre+'<->'+objetivo.id_pilares+'<->'+objetivo.siglas">
                                                                        <label class="form-check-label" for="checkbox1">
                                                                            {{objetivo.nombre}} ({{objetivo.siglas}})
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                               
                                                                <!--<div>
                                                                    <div class="col-12"><button class="btn-anadir" title="Crear" @click="abrirModal('CRUD','Objetivo','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Objetivo','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-delete" title="Eliminar"  @click="eliminarObjetivo()"><i class="bi bi-x-circle"></i></button></div>
                                                                </div>-->
                                                                <div v-if="checkObjetivos.length>0" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>

                                                            

                                                           
                                                            <!--Impacto Ambiental-->
                                                            <div class="input-group mb-3"> 
                                                                <span class="input-group-text w-25 text-start">Impacto <br>Ambiental{{checkImpactoAmbiental}}</span>
                                                                <div class="w-50">
                                                                    <div v-for="impacto in impactoAmbiental" class="form-check border border-1  mt-1">
                                                                        <input class="form-check-input" type="checkbox" id="checkbox1" :value="impacto.id+'<->'+impacto.nombre">
                                                                        <label class="form-check-label" for="checkbox1">
                                                                        {{impacto.nombre}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="col-12"><button class="btn-anadir" title="Crear "><i class="bi bi-plus-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-up" title="Actualizar"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-delete" title="Eliminar"><i class="bi bi-x-circle"></i></button></div>
                                                                </div>
                                                                <div v-if="checkImpactoAmbiental.length>0" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>  
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Tons CO2 por Evitar (Proyectado)</span>
                                                                <input type="text" v-model="tons_co2" class="w-25" >
                                                                <div v-if="tons_co2!==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Ahorro Duro $MXN (Proyectado )</span>
                                                                <input type="text" v-model="ahorro_duro" class="w-25" >
                                                                <div v-if="ahorro_duro!==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Ahorro Suave $MXN (Proyectado)</span>
                                                                <input type="text" v-model="ahorro_suave" class="w-25" >
                                                                <div v-if="ahorro_suave!==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
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
                                                            <span class="input-group-text w-50" >Nombre:</span>
                                                            <input type="text" v-model="nueva" class="w-50" >
                                                        </div>
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Siglas:</span>
                                                            <input type="text" v-model="siglas" class="w-50" >
                                                        </div>
                                                    </div>
                                                     <!--CRUD Planta Actualizar-->
                                                     <div v-if="tipo=='Planta' && accion=='Actualizar'">
                                                        <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Nombre:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-50" >
                                                        </div>
                                                        <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Siglas:</span>
                                                                <input type="text" v-model="siglas" class="w-50" >
                                                        </div>
                                                    </div>
                                                <!--ÁREAS-->    
                                                     <!--CRUD Área Crear-->
                                                     <div v-if="tipo=='Área' && accion=='Crear'">
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Nombre:</span>
                                                            <input type="text" v-model="nueva" class="w-50" >
                                                        </div>
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Siglas:</span>
                                                            <input type="text" v-model="siglas" class="w-50" >
                                                        </div>
                                                    </div>
                                                     <!--CRUD Área Actualizar-->
                                                     <div v-if="tipo=='Área' && accion=='Actualizar'">
                                                        <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Nombre:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-50" >
                                                        </div>
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Siglas:</span>
                                                            <input type="text" v-model="siglas" class="w-50" >
                                                        </div>
                                                    </div>
                                                <!--DEPARTAMENTOS-->    
                                                     <!--CRUD Departamento Crear-->
                                                     <div v-if="tipo=='Departamento' && accion=='Crear'">
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Nombre:</span>
                                                            <input type="text" v-model="nueva" class="w-50" >
                                                        </div>
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Siglas:</span>
                                                            <input type="text" v-model="siglas" class="w-50" >
                                                        </div>
                                                    </div>
                                                     <!--CRUD Departamento Actualizar-->
                                                     <div v-if="tipo=='Departamento' && accion=='Actualizar'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Nombre:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-50" >
                                                            </div>
                                                    </div>
                                                    <div v-if="tipo=='Departamento' && accion=='Actualizar'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Siglas:</span>
                                                                <input type="text" v-model="siglas" class="w-50" >
                                                            </div>
                                                    </div>
                                                <!--METODOLOGÍA-->    
                                                     <!--CRUD metodologia Crear-->
                                                     <div v-if="tipo=='Metodología' && accion=='Crear'">
                                                        <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Nombre:</span>
                                                            <input type="text" v-model="nueva" class="w-50" >
                                                        </div>
                                                    </div>
                                                     <!--CRUD Metodologia Actualizar-->
                                                     <div v-if="tipo=='Metodología' && accion=='Actualizar'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Nombre:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-50" >
                                                            </div>
                                                    </div>
                                                <!--OBJETIVOS-->    
                                                     <!--CRUD Objetivo Crear-->
                                                        <div v-if="tipo=='Objetivo' && accion=='Crear'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Nombre:</span>
                                                                <input type="text" v-model="nueva" class="w-50" >
                                                            </div>
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Siglas:</span>
                                                                <input type="text" v-model="siglas" class="w-50" >
                                                            </div>
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Seleccione Pilar:</span>
                                                            <select v-model="select_pilar" class="w-50" >
                                                                    <option value="" disabled selected> Seleccione.... </option>
                                                                    <option v-for="pilar in allPilares" :value="pilar.id" >{{pilar.nombre}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                     <!--CRUD Objetivo Actualizar-->
                                                        <div v-if="tipo=='Objetivo' && accion=='Actualizar'">
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50">Nombre:</span>
                                                                <input type="text" v-model="nuevoNombre" class="w-50" >
                                                            </div>
                                                            <div  class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Siglas:</span>
                                                                <input type="text" v-model="siglas" class="w-50" >
                                                            </div>
                                                            <div  class="input-group mb-3">
                                                            <span class="input-group-text w-50" >Seleccione Pilar:</span>
                                                                <select v-model="select_pilar" class="w-50" >
                                                                    <option value="" disabled selected> Seleccione.... </option>
                                                                    <option v-for="pilar in allPilares" :value="pilar.id" >{{pilar.nombre}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                         <!--PILARES-->    
                                                           <!--CRUD Pilares Crear-->
                                                                <div v-if="tipo=='Pilar' && accion=='Crear'">
                                                                    <div  class="input-group mb-3">
                                                                        <span class="input-group-text w-50" >Nombre:</span>
                                                                        <input type="text" v-model="nueva" class="w-50" >
                                                                    </div>
                                                                    <div  class="input-group mb-3">
                                                                        <span class="input-group-text w-50" >Siglas:</span>
                                                                        <input type="text" v-model="siglas" class="w-50" >
                                                                    </div>
                                                                    <div  class="input-group mb-3">
                                                                        <span class="input-group-text w-50" >Seleccione Mision:</span>
                                                                    <select v-model="select_mision" class="w-50" >
                                                                            <option value="" disabled selected> Seleccione.... </option>
                                                                            <option v-for="mision in allMisiones" :value="mision.id" >{{mision.nombre}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            <!--CRUD Pilares Actualizar-->
                                                                <div v-if="tipo=='Pilar' && accion=='Actualizar'">
                                                                    <div  class="input-group mb-3">
                                                                        <span class="input-group-text w-50">Nombre:</span>
                                                                        <input type="text" v-model="nuevoNombre" class="w-50" >
                                                                    </div>
                                                                    <div  class="input-group mb-3">
                                                                        <span class="input-group-text w-50" >Siglas:</span>
                                                                        <input type="text" v-model="siglas" class="w-50" >
                                                                    </div>
                                                                    <div  class="input-group mb-3">
                                                                    <span class="input-group-text w-50" >Seleccione Pilar:</span>
                                                                        <select v-model="select_pilar" class="w-50" >
                                                                            <option value="" disabled selected> Seleccione.... </option>
                                                                            <option v-for="pilar in allPilares" :value="pilar.id" >{{pilar.nombre}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                <!--Fin Formulario Alta Proyecto CRUD--> 
                                                </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="boton-cancelar" data-bs-dismiss="modal">Salir</button>
                                                            <!--botones crear-->
                                                        <button type="button" class="boton-aceptar" v-if="tipo=='Planta' && accion=='Crear'" @click="insertarPlanta()">Crear</button>
                                                        <button type="button" class="boton-aceptar" v-if="tipo=='Área' && accion=='Crear'" @click="insertarArea()">Crear</button>
                                                        <button type="button" class="boton-aceptar" v-if="tipo=='Departamento' && accion=='Crear'" @click="insertarDepartamento()">Crear</button>
                                                        <button type="button" class="boton-aceptar" v-if="tipo=='Metodología' && accion=='Crear'" @click="insertarMetodologia()">Crear</button>
                                                        <button type="button" class="boton-aceptar" v-if="tipo=='Objetivo' && accion=='Crear'" @click="insertarObjetivo()">Crear</button>
                                                        <button type="button" class="boton-aceptar" v-if="tipo=='Pilar' && accion=='Crear'" @click="insertarPilar()">Crear</button>
                                                            <!--botones actualizar-->
                                                        <button type="button" class="boton-actualizar" v-if="tipo=='Planta' && accion=='Actualizar'" @click="actualizarPlanta()">Actualizar</button>
                                                        <button type="button" class="boton-actualizar" v-if="tipo=='Área' && accion=='Actualizar'" @click="actualizarArea()">Actualizar</button>
                                                        <button type="button" class="boton-actualizar" v-if="tipo=='Departamento' && accion=='Actualizar'" @click="actualizarDepartamento()">Actualizar</button>
                                                        <button type="button" class="boton-actualizar" v-if="tipo=='Metodología' && accion=='Actualizar'" @click="actualizarMetodologia()">Actualizar</button>
                                                        <button type="button" class="boton-actualizar" v-if="tipo=='Objetivo' && accion=='Actualizar'" @click="actualizarObjetivo()">Actualizar</button>
                                                        <button type="button" class="boton-actualizar" v-if="tipo=='Pilar' && accion=='Actualizar'" @click="actualizarObjetivo()">Actualizar</button>
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
        <div style="min-height: 80vh">
                    <!--AQUI TRABAJA //ALTA DE PROYECTOS-->
                    <div v-if="ventana=='Altas'">
                                            <div class="input-group mt-5 mx-2 ">
                                                <span class="input-group-text w-5" >Seleccione Proyecto</span>
                                                <select class="w-5">
                                                    <option value="" disabled selected>Seleccione..</option>
                                                    <option>Proyecto 1</option>
                                                    <option>Proyecto 2</option>
                                                </select>
                                            </div>

                                        <table class="mx-2 mt-5  mb-5 table table-hover table-bordered border-dark text-center">
                                                                <thead class="  border:1px solid black">
                                                                    <tr>
                                                                        <th>Fecha</th>
                                                                        <th>Consumo de Electricidad</th>
                                                                        <th>Consumo de Agua</th>
                                                                        <th>Tons de CO2 por Evitar</th>
                                                                        <th>Ahorro Duro</th>
                                                                        <th>Ahorro Suave </th>
                                                                        <th>Estatus</th>
                                                                        
                                                                </thead>
                                                                <tbody class=" border:1px solid black" style="text-align: center">
                                                                    <tr style="vertical-align: middle ">
                                                                        <td>
                                                                            <input type="date" >
                                                                            </input>
                                                                        </td>
                                                                        <td>kwh</td>
                                                                        <td>Metros cubicos</td>
                                                                        <td>Tons de CO2 por Evitar</td>
                                                                        <td>Ahorro Duro (Proyectado)</td>
                                                                        <td>Ahorro Suave (Proyectado)</td>
                                                                        <td>Estatus</td>
                                                                            
                                                        </table>
                                        <!---->
                    </div>
                      <!--CREAR PERFILES, PILARES OBJETIVOS-->
                     <div class="row" v-if="ventana=='Crear'">
                        <div class=" bg-secondary mt-3 text-white align-items-center ">
                            <div class=" text-center">
                                RELACIONES
                            </div>
                        </div>
                            <div class=" row align-items-center">
                                <div class="col-12  col-lg-6 offset-lg-3 text-center align-content">
                                    <table class="mt-2 mx-2 table table-bordered border-dark">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Mision
                                                </th>
                                                <th>
                                                    Pilar
                                                </th>
                                                <th>
                                                    Objetivo
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Nombre Mision
                                                </td>
                                                <td>
                                                    Nombre Pilar
                                                </td>
                                                <td>
                                                    Nombre Objetivo
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <!--TABLA DE LA MISION-->
                        <div class= "col-12  col-lg-6 offset-lg-3 col-xl-6 offset-xl-3 text-center align-content">
                            <button type="button" class=" btn btn-menu mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Mision</button>
                           <table class="mt-2 mx-2 table table-bordered border-dark">
                                <thead>
                                    <tr>
                                        <th>
                                            Mision 
                                        </th>
                                        <th>
                                            Siglas 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Mision 1
                                        </td>
                                        <td>
                                            M1
                                        </td>
                                    </tr>
                                </tbody>
                           </table>
                        </div>
                        <!--TABLA DE LA PILARES-->
                        <div class= "col-12 col-xl-6 col-lg-6 offset-lg-3 offset-xl-3 text-center align-content">
                        <button type="button" class=" btn btn-menu mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Pilares</button>
                           <table class="mt-2 mx-2 table table-bordered border-dark">
                                <thead>
                                    <tr>
                                        <th>
                                            Pilares 
                                        </th>
                                        <th>
                                            Siglas 
                                        </th>
                                        <th>
                                            Mision
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Pilar 1
                                        </td>
                                        <td>
                                            P1
                                        </td>
                                        <td>
                                            Mision Relacion
                                        </td>
                                    </tr>
                                </tbody>
                           </table>
                        </div>
                        <!--TABLA DE LA OBJETIVOS-->
                        <div class= "col-12 col-xl-6 col-lg-6 offset-lg-3 offset-xl-3 text-center align-content">
                        <button type="button" class=" btn btn-menu mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal" >Crear Objetivo</button>
                           <table class="mt-2 mx-2 table table-bordered border-dark">
                                <thead>
                                    <tr>
                                        <th>
                                            Objetivo 1
                                        </th>
                                        <th>
                                            Siglas 
                                        </th>
                                        <th>
                                            Pílar  
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Objetivo 1
                                        </td>
                                        <td>
                                            O1
                                        </td>
                                        <td>
                                            Pilar Relacionado
                                        </td>
                                    </tr>
                                </tbody>
                           </table>
                        </div>
                        <!--TABLA DE IMPACTO AMBIENTAL-->
                        <div class= "col-12  col-lg-6 offset-lg-3 col-xl-6 offset-xl-3 text-center align-content">
                            <button type="button" class=" btn btn-menu mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Crear Impacto ambiental</button>
                           <table class="mt-2 mx-2 table table-bordered border-dark">
                                <thead>
                                    <tr>
                                        <th>
                                            Impacto ambiental  
                                        </th>
                                        <th>
                                            Siglas 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Nombre 1
                                        </td>
                                        <td>
                                            N1
                                        </td>
                                    </tr>
                                </tbody>
                           </table>
                        </div>
                        <div class= "col-12 col-xl-6 col-lg-6 offset-lg-3 offset-xl-3 text-center align-content">
                        <button type="button" class=" btn btn-menu mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal" >Crear Estandares CO2</button>
                           <table class="mt-2 mx-2 table table-bordered border-dark">
                                <thead>
                                    <tr>
                                        <th>
                                            Objetivo 1
                                        </th>
                                        <th>
                                            Siglas 
                                        </th>
                                        <th>
                                            unidad de medida  
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Objetivo 1
                                        </td>
                                        <td>
                                            O1
                                        </td>
                                        <td>
                                            unidad de medida
                                        </td>
                                    </tr>
                                </tbody>
                           </table>
                        </div>
                        <!--TABLA DE ESTANDARES DE C02-->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Crear</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body input-group mb-3">
                                        <span class="input-group-text w-25 mt-3" >Nombre:</span>
                                        <input type="text" class="w-75 mt-3" >
                                        <span class="input-group-text w-25 mt-3" >Siglas:</span>
                                        <input type="text" class="w-75 mt-3" >
                                        <span class="input-group-text w-25 mt-3" >Pilar:</span>
                                        <input type="text" class="w-75 mt-3" >
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="boton-cancelar">Cerrar</button>
                                        <button type="button" class="boton-aceptar">Crear</button>
                                    </div>
                                </div>
                            </div>
                        </div>
         </div>
       
    </div><!--cuerpo-->
  
    <div  class="footer row" style="min-height:10vh;">  <!--pie-->

    </div>    
</div><!--div motando js-->
    <script src="js/altaProyectos.js"></script>
    
</body>
</html>

<?php
}else{
header("Location:index.php");
}?>
