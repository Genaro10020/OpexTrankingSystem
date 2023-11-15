
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
                <button class="btn-menu me-3" @click="ventana='Crear',consultarMisiones(),consultarPilares(),consultarObjetivos(),consultarImpactoAmbiental(),consultarEstandaresCO2()"> 
                    <i class="bi bi-plus-circle" ></i> Crear Catalogos
                </button>

                <button class="btn-menu" @click="abrirModal('Alta'), ventana='Altas'"> 
                    <i class="bi bi-plus-circle" ></i> Alta Proyectos
                </button>

                <button class="btn-menu mx-3" @click="ventana='Seguimiento'"> 
                    <i class="bi bi-plus-circle" ></i> Seguimiento
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
                                                            <span class="input-group-text w-25">Fecha</span>
                                                            <input type="date" class="w-50" v-model="fecha_alta" :class="{'nocontestado': respondio === false && fecha_alta === '', '': fecha_alta !== ''}">
                                                            <div v-show="fecha_alta !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>
                                                        
                                               
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-25" >Nombre Proyecto</span>
                                                            <input type="text" class="w-50" v-model="nombre_proyecto" :class="{'nocontestado': respondio === false && nombre_proyecto === '', '':nombre_proyecto !== ''}"> 
                                                            <div v-if="nombre_proyecto !==''" class=" text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>

                                                        <!---Planta-->
                                                        <div class="input-group mb-3 ">
                                                            <span class="input-group-text w-25" >Planta</span>
                                                            <select v-model="selectPlanta" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectPlanta === '', '': selectPlanta !== ''}">
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
                                                            <select v-model="selectArea" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectArea === '', '': selectArea !== ''}"> 
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
                                                            <select v-model="selectDepartamento" size="3" class="w-50"  :class="{'nocontestado': respondio === false && selectDepartamento === '', '': selectDepartamento !== ''}">
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
                                                            <select v-model="selectMetodologia" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectMetodologia === '', '': selectMetodologia !== ''}"> 
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
                                                                <select  v-model="selectResponsable"  class="w-50" :class="{'nocontestado': respondio === false && selectResponsable === '', '': selectResponsable !== ''}">
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
                                                                <span class="input-group-text w-25 text-start">Misión </span>
                                                                <div class="div-mision-pilares-impacto"  :class="{'nocontestado': respondio === false && checkMisiones.length<=0, '': checkMisiones.length>0}">
                                                                    <div class="form-check border border-1 mt-1" v-for="(mision, index) in misiones" :key="index">
                                                                    <input class="form-check-input" type="checkbox" :value="mision.id+'<->'+mision.nombre" v-model="checkMisiones" @change="consultarPilaresXmisionSeleccionada()">
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
                                                                <span class="input-group-text w-25 text-start">Pilares <br>Estrategicos </span>
                                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && checkPilares.length<=0, '': checkPilares.length>0}">
                                                                    <div class="form-check border border-1 mt-1" v-for="(pilar, index) in pilares" :key="index">
                                                                        <input class="form-check-input" type="checkbox" :value="pilar.id+'<->'+pilar.nombre+'<->'+pilar.siglas+'<->'+(index+1)" v-model="checkPilares" @change="consultarObjetivosXpilaresSeleccionados()">
                                                                        <label class="form-check-label w-75">
                                                                            {{ pilar.nombre }}
                                                                        </label>
                                                                        <label class="w-25" v-if="idsPilares.includes(pilar.id) && checkPilares.length>0">
                                                                                <select v-model="selectPilar[index]" @change="verificarCantidadDirectosPilares()">
                                                                                    <option value="" disabled selected>Seleccione...</option>
                                                                                    <option value="directo">Directo</option>
                                                                                    <option value="inderecto">Indirecto</option>
                                                                                </select>
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
                                                                <div class="div-mision-pilares-impacto"  :class="{'nocontestado': respondio === false && checkObjetivos.length<=0, '': checkObjetivos.length>0}">
                                                                    <div v-for="(objetivo, index) in objetivos" class="form-check border border-1 mt-1" :key="index">
                                                                        <input class="form-check-input" v-model="checkObjetivos" type="checkbox" id="checkbox1" :value="objetivo.id+'<->'+objetivo.nombre+'<->'+objetivo.id_pilares+'<->'+objetivo.siglas+'<->'+(index+1)" @change="checkeandoObjetivos()">
                                                                        <label class="form-check-label w-75" for="checkbox1">
                                                                            {{objetivo.nombre}} ({{objetivo.siglas}})
                                                                        </label>
                                                                        <label class="w-25" v-if="idsObjetivos.includes(objetivo.id) && checkPilares.length>0">
                                                                                <select v-model="selectObjetivo[index]" @change="verificarCantidadDirectosObjetivos()">
                                                                                    <option value="" disabled selected>Seleccione...</option>
                                                                                    <option value="directo">Directo</option>
                                                                                    <option value="inderecto">Indirecto</option>
                                                                                </select>
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
                                                                <span class="input-group-text w-25 text-start">Impacto <br>Ambiental<br><label class="ms-5"><i class="bi bi-question-circle"></label></i></span>
                                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && checkImpactoAmbiental.length<=0, '': checkImpactoAmbiental.length>0}">
                                                                    <div v-for="impacto in impactoAmbiental" class="form-check border border-1  mt-1">
                                                                        <input class="form-check-input" type="checkbox" id="checkbox1" v-model="checkImpactoAmbiental" :value="impacto.id+'<->'+impacto.nombre">
                                                                        <label class="form-check-label" for="checkbox1">
                                                                            {{impacto.nombre}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <!--<div>
                                                                    <div class="col-12"><button class="btn-anadir" title="Crear "><i class="bi bi-plus-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-up" title="Actualizar"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                                    <div class="col-12"><button class="btn-delete" title="Eliminar"><i class="bi bi-x-circle"></i></button></div>
                                                                </div>-->
                                                                <div v-if="checkImpactoAmbiental.length>0" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>  
                                                               
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Tons CO2 por Evitar (Proyectado)</span>
                                                                <input type="number" v-model="tons_co2" min="0" class="w-25" :class="{'nocontestado': respondio === false && tons_co2===0, '': tons_co2!==0 && tons_co2!==''}">
                                                                <div v-if="tons_co2!==0 && tons_co2!==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Ahorro Duro $MXN/Año (Proyectado )</span>
                                                                <input type="number" v-model="ahorro_duro" min="0" class="w-25" :class="{'nocontestado': respondio === false && ahorro_duro===0, '': ahorro_duro!==0 && ahorro_duro!==''}">
                                                                <div v-if="ahorro_duro!==0 && ahorro_duro!==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text w-50" >Ahorro Suave $MXN/Año (Proyectado)</span>
                                                                <input type="number" v-model="ahorro_suave" min="0" class="w-25" :class="{'nocontestado': respondio === false && ahorro_suave===0, '': ahorro_suave!==0 && ahorro_suave!==''}">
                                                                <div v-if="ahorro_suave!==0 && ahorro_suave!==''"  class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                            </div>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text w-25 me-2" >Objetivo Estrategico</span>
                                                                <input type="checkbox" v-model="objetivo_estrategico">
                                                            </div>
                                                    <!--Fin Formulario Alta Proyecto--> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="boton-cancelar" data-bs-dismiss="modal">Salir</button>
                                                    <button type="button" class="boton-aceptar" @click="verificarAltaProyecto()">Crear</button>
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
                                        <table class="mx-2 mt-5  mb-5 table table-hover table-bordered border-dark text-center">
                                                                <thead class="  border:1px solid black">
                                                                    <tr>
                                                                        <th>Fecha</th>
                                                                        <th>Nombre De Proyecto</th>
                                                                        <th>Planta</th>
                                                                        <th>Área</th>
                                                                        <th>Departamento</th>
                                                                        <th>Metodología</th>
                                                                        <th>Responsable</th>
                                                                        <th>Correo</th>
                                                                        <th>Telefono</th>
                                                                        <th>Pilar Estrategico</th>
                                                                        <th>Impacto Ambiental</th>
                                                                        <th>Tons De CO2 Por Evitar</th>
                                                                        <th>Ahorro Duro</th>
                                                                        <th>Ahorro Suave</th>
                                                                </thead>
                                                                <tbody class=" border:1px solid black" style="text-align: center">
                                                                    <tr style="vertical-align: middle " v-for="proyecto in proyectos">
                                                                        <td>{{proyecto.fecha}}</td>
                                                                        <td>{{proyecto.nombre_proyecto}}</td>
                                                                        <td>{{proyecto.planta}}</td>
                                                                        <td>{{proyecto.area}}</td>
                                                                        <td>{{proyecto.departamento}}</td>
                                                                        <td>{{proyecto.metodologia}}</td>
                                                                        <td>{{proyecto.responsable}}</td>
                                                                        <td>{{proyecto.correo}}</td>
                                                                        <td>{{proyecto.telefono}}</td>
                                                                        <td>{{proyecto.pilares}}</td>
                                                                        <td>{{proyecto.impacto_ambiental}}</td>
                                                                        <td>{{proyecto.tons_co2}}</td>
                                                                        <td>{{proyecto.duro}}</td>
                                                                        <td>{{proyecto.ahorro_suave}}</td>
                                                                 </tr>       
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
                                    <table class=" mt-2 mx-2 table table-bordered border-dark">
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
                        <div class="col-12 col-lg-6 mb-5">
                                <div  class="col-12  text-center align-content">
                                        <div class=" encabezadoTablas">
                                            <div class="  d-flex justify-content-center align-items-center">
                                                    <div class="d-none d-lg-block col-lg-4"></div> 
                                                    <div class="col-6 col-lg-4 mt-2">Misiones</div>
                                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                                        <button type="button" class=" btn btn-menu " @Click="modalCatalogos('Crear','Mision')">Crear</button>
                                                    </div>
                                                        
                                                </div>
                                        </div>
                                        <div class="scroll">
                                            <table class=" table table-bordered table-striped border-dark">
                                                <thead>
                                                    <tr>
                                                        <th class=" sticky-top thmodal w-50">
                                                            Nombre  
                                                        </th>
                                                        <th class=" sticky-top thmodal w-50">
                                                        Eliminar
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="mision in misiones">
                                                        <td>
                                                        {{mision.nombre}}
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger" @click="eliminarMision(mision.id)">Eliminar</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                        </table>
                                        </div>
                                </div>
                            </div>
                                <!--TABLA DE LA PILARES-->
                            <div class="col-12 col-lg-6">
                                <div class= "col-12 text-center align-content">
                                        <div class=" encabezadoTablas">
                                            <div class=" d-flex justify-content-center align-items-center"  > 
                                                    <div class="d-none d-lg-block col-lg-4"></div>
                                                    <div class="col-6 col-lg-4 mt-2">Pilares Estrategicos</div>
                                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                                        <button type="button" class=" btn btn-menu " @Click="modalCatalogos('Crear','Pilar')">Crear</button>
                                                    </div>
                                                        
                                                </div>
                                        </div>
                                        <div class="scroll mb-5">
                                            <table class="table table-bordered table-striped border-dark">
                                                    <thead>
                                                        <tr>
                                                            <th class=" sticky-top thmodal">
                                                                Nombre
                                                            </th>
                                                            <th class=" sticky-top thmodal">
                                                                Siglas 
                                                            </th>
                                                            <th class=" sticky-top thmodal">
                                                                Mision
                                                            </th>
                                                            <th class=" sticky-top thmodal">
                                                                Eliminar
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="pilar in pilares">
                                                            <td>
                                                                {{pilar.nombre}}
                                                            </td>
                                                            <td>
                                                                {{pilar.siglas}}
                                                            </td>
                                                            <td>
                                                                {{pilar.id_misiones}}
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger" @click="eliminarPilar(pilar.id)">Eliminar</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                </div>
                        </div>
                        <!--TABLA DE LA OBJETIVOS-->
                        <div class="col-6">
                                <div class= "col-12 text-center align-content">
                                        <div class=" encabezadoTablas">
                                            <div class=" d-flex justify-content-center align-items-center"  > 
                                                    <div class="d-none d-lg-block col-lg-4"></div>
                                                    <div class="col-6 col-lg-4 mt-2">Objetivos Estrategicos</div>
                                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                                        <button type="button" class=" btn btn-menu " @Click="modalCatalogos('Crear','Objetivo')">Crear</button>
                                                    </div>
                                                        
                                                </div>
                                        </div>
                                        <div class="scroll">
                                            <table class="table table-bordered table-striped border-dark">
                                                    <thead>
                                                        <tr>
                                                            <th class=" sticky-top thmodal">
                                                                Nombre
                                                            </th>
                                                            <th class=" sticky-top thmodal">
                                                                Siglas 
                                                            </th>
                                                            <th class=" sticky-top thmodal">
                                                                Pílar  
                                                            </th>
                                                            <th class=" sticky-top thmodal">
                                                                Eliminar  
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="objetivo in objetivos">
                                                            <td>
                                                                {{objetivo.nombre}}
                                                            </td>
                                                            <td>
                                                                {{objetivo.siglas}}
                                                            </td>
                                                            <td>
                                                                {{objetivo.id_pilares}}
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger" @click="eliminarObjetivo(objetivo.id)">Eliminar</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                </div>
                        </div>
                        <!--TABLA DE IMPACTO AMBIENTAL-->
                        <div class="col-12 col-lg-6">
                                <div class= "col-12  text-center align-content">
                                        <div class=" encabezadoTablas">
                                            <div class=" d-flex justify-content-center align-items-center"  > 
                                                    <div class="d-none d-lg-block col-lg-4"></div>
                                                    <div class="col-6 col-lg-4 mt-2">Impacto Ambiental</div>
                                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                                        <button type="button" class=" btn btn-menu " @Click="modalCatalogos('Crear','Impacto Ambiental')">Crear</button>
                                                    </div>
                                                        
                                                </div>
                                        </div>
                                        <div class="scroll">
                                            <table class=" table table-bordered table-striped border-dark">
                                                    <thead>
                                                        <tr>
                                                            <th class="sticky-top thmodal w-50">
                                                                Nombre
                                                            </th>
                                                            <th class="sticky-top thmodal w-50">
                                                                Eliminar
                                                            </th>
                                                            <th class="sticky-top thmodal w-50">
                                                                Actualizar
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="impacto in impactoAmbiental ">
                                                            <td>
                                                                {{impacto.nombre}}
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger" @click="eliminarImpactoAmbiental(impacto.id)">Eliminar</button>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-warning" @Click="modalCatalogos('Actualizar','Impacto Ambiental',impacto.nombre)">Actualizar</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                </div>
                        </div>
                        <!-- INICIO TABLA ESTANDARES CO2 -->
                        <div class= "col-12 col-xl-6 col-lg-6 offset-lg-3 offset-xl-3 text-center">
                            <div class=" encabezadoTablas">
                                   <div class=" d-flex justify-content-center align-items-center mt-5"  > 
                                        <div class="d-none d-lg-block col-lg-4"></div>
                                        <div class="col-6 col-lg-4 mt-2">Estandares de CO2</div>
                                        <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                            <button type="button" class=" btn btn-menu " @Click="modalCatalogos('Crear','Estandar')">Crear</button>
                                        </div>
                                            
                                    </div>
                            </div>
                           <table class="  table table-bordered border-dark">
                                <thead>
                                    <tr>
                                        <th class=" sticky-top thmodal">
                                            Nombre
                                        </th>
                                        <th class=" sticky-top thmodal">
                                            Cantidad
                                        </th>
                                        <th class=" sticky-top thmodal">
                                            unidad de medida  
                                        </th>
                                        <th class=" sticky-top thmodal">
                                            Eliminar  
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="estandar in estandares ">
                                        <td>
                                            {{estandar.nombre}}
                                        </td>
                                        <td>
                                            {{estandar.cantidad}}
                                        </td>
                                        <td>
                                            {{estandar.unidad_medida}}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" @click="eliminarEstandares(estandar.id)">Eliminar</button>
                                        </td>
                                    </tr>
                                </tbody>
                           </table>
                        </div>
                        <!--MODAL MISION-->
                        <div class="modal fade" id="modalCrearCatalogos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{accion}} {{tipo}}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                        <div v-if="accion=='Crear'">
                                            <!--Cuerpo de MODAL MISION-->
                                                <div v-if="tipo=='Mision'">
                                                    <div class="modal-body input-group mb-3">
                                                        <span class="input-group-text w-25 mt-3" >Nombre:</span>
                                                        <input type="text" class="w-75 mt-3" v-model="nueva">
                                                    </div>
                                                </div> 
                                                <!--Cuerpo de MODAL PILARES-->
                                                <div v-if="tipo=='Pilar'">
                                                    <div class="modal-body input-group mb-3">
                                                        <span class="input-group-text w-25 mt-3" >Nombre:</span>
                                                        <input type="text" class="w-75 mt-3"  v-model="nueva">
                                                        <span class="input-group-text w-25 mt-3" >Siglas:</span>
                                                        <input type="text" class="w-75 mt-3" v-model="siglas">
                                                        <span class="input-group-text w-25 mt-3" >Mision:</span>
                                                        <select class="w-75 mt-3" v-model="select_mision"><option v-for="mision in misiones" :value="mision.id">{{mision.nombre}}</option></select>
                                                    </div>
                                                </div> 
                                                <!--Cuerpo de MODAL OBJETIVO-->
                                                    <div v-if="tipo=='Objetivo'">
                                                        <div class="modal-body input-group mb-3">
                                                                <span class="input-group-text w-25 mt-3" >Nombre:</span>
                                                                <input type="text" class="w-75 mt-3" v-model="nueva" >
                                                                <span class="input-group-text w-25 mt-3" >Siglas:</span>
                                                                <input type="text" class="w-75 mt-3" v-model="siglas">
                                                                <span class="input-group-text w-25 mt-3" >Pilar:</span>
                                                                <select v-model="select_pilar" class="w-75 mt-3"><option v-for="pilar in pilares" :value="pilar.id">{{pilar.nombre}}</option></select>
                                                        </div>
                                                    </div>
                                                <!--Cuerpo de MODAL IMPACTO AMBIENTAL-->
                                                <div v-if="tipo=='Impacto Ambiental'">
                                                    <div>
                                                        <div class="modal-body input-group mb-3">
                                                                <span class="input-group-text w-25 mt-3" >Nombre:</span>
                                                                <input v-model="nueva" type="text" class="w-75 mt-3" >  
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--Cuerpo de MODAL ESTANDARES CO2 -->
                                                <div v-if="tipo=='Estandar'">
                                                    <div>
                                                        <div class="modal-body input-group mb-3">
                                                                <span class="input-group-text w-25 mt-3" >Nombre:</span>
                                                                <input v-model="nueva" type="text" class="w-75 mt-3" >
                                                                <span class="input-group-text w-25 mt-3" >Cantidad:</span>
                                                                <input v-model="cantidad" type="number" class="w-75 mt-3" >
                                                                <span class="input-group-text w-25 mt-3" >Unidad De Medida:</span>
                                                                <input v-model="unidadMedida" type="text" class="w-75 mt-3" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- MODAL ACTUALIZAR -->
                                            <div v-if="accion=='Actualizar'">
                                                 <!--Cuerpo de MODAL IMPACTO AMBIENTAL-->
                                                 <div v-if="tipo=='Impacto Ambiental'">
                                                    <div>
                                                        <div class="modal-body input-group mb-3">
                                                                <span class="input-group-text w-25 mt-3" >Nombre:</span>
                                                                <input v-model="nuevoNombre" type="text" class="w-75 mt-3" >  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!--BOTONES MODAL CREAR CATALOGO-->
                                        <div class="modal-footer">
                                        <button type="button" class="boton-cancelar" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="boton-aceptar" v-if="tipo=='Mision' && accion=='Crear'" @click="insertarMision()">Crear</button>
                                        <button type="button" class="boton-aceptar" v-if="tipo=='Pilar'  && accion=='Crear'" @click="insertarPilar()">Crear</button>
                                        <button type="button" class="boton-aceptar" v-if="tipo=='Objetivo'  && accion=='Crear'" @click="insertarObjetivo()">Crear</button>
                                        <button type="button" class="boton-aceptar" v-if="tipo=='Impacto Ambiental'  && accion=='Crear'" @click="insertarImpactoAmbiental()">Crear</button>
                                        <button type="button" class="boton-aceptar" v-if="tipo=='Estandar'  && accion=='Crear'" @click="insertarEstandaresCO2()">Crear</button>
                                        <button type="button" class="boton-actualizar" v-if="tipo=='Impacto Ambiental'  && accion=='Actualizar'">Actualizar</button>

                                       

                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <div v-if="ventana=='Seguimiento'">
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
                
       
    </div><!--cuerpo-->
  
    <div  class="footer row" style="min-height:10vh;">  <!--pie-->

    </div>    
</div><!--div motando js-->
    <script src="js/app.js"></script>
    
</body>
</html>

<?php
}else{
header("Location:index.php");
}?>
