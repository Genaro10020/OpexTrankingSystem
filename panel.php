<?php session_start();
if (isset($_SESSION['nombre'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php 
        include('head.php'); ?>
    </head>

    <body class="container-fluid d-flex flex-column body-principal" style="min-height: 100vh;">
        <div id="alta-proyectos">
            <!--Encabezado-->
            <div :class="{ 'visible': mostrarHeader, 'oculto': !mostrarHeader }">
                <?php include('header.php'); ?>
            </div>
            <!--Cinta-->
            <div class="cinta row d-flex align-items-center" style="min-height:5vh; ">
                <!--Bóton Crear misiones/pilares/Objetivos-->
                <!--Bóton-->
                <div class="text-center">
                    <?php if ($_SESSION['acceso'] == 'Admin') { ?>
                        <button class="btn-menu " @click="ventana='Crear',consultarMisionesRelacional(),consultarObjetivosRelacional(),consultarMisiones(),consultarImpactoAmbiental(),consultarEstandaresCO2(),consultarFuentes(),mostrarHeader=true,sumarSoloUnaVez=0,buscarDocumentos('Documento CO2'),sumaImpactoAmbiental()">
                            <i class="bi bi-plus-circle"></i> Crear Catálogos
                        </button>
                    <?php } ?>
                    <button class="btn-menu me-0  mx-sm-3 mt-sm-3" @click="ventana='Altas',mostrarHeader=true,sumarSoloUnaVez=0">
                        <i class="bi bi-plus-circle"></i> Proyectos Creados
                    </button>

                    <button class="btn-menu mb-sm-3 mt-sm-3" @click="ventana='Seguimiento',mostrarHeader=true,sumarSoloUnaVez=0,buscarDocumentos('Documento CO2')">
                        <i class="bi bi-plus-circle"></i> Seguimiento
                    </button>
                    <button class="btn-menu me-sm-3 ms-sm-3 mb-sm-3" @click="ventana='Generar Valor',consultarObjetivosRelacional(),mostrarHeader=false,consultarSeguimientos()">
                        <i class="bi bi-plus-circle"></i> Generando Valor Sustentable
                    </button>
                    <!--<button class="btn-menu" @click="ventana='Reportes'">
                        <i class="bi bi-plus-circle"></i> Reportes
                    </button>-->
                    <?php if ($_SESSION['acceso'] == 'Admin' || $_SESSION['acceso'] == 'Financiero') { ?>
                    <button class="btn-menu mb-sm-3 " @click="ventana='Calendario',mostrarHeader=true, consultarCalendarioProyectos()">
                        <i class="bi bi-plus-circle"></i> Estatus Captura
                    </button>
                    <?php } ?>
                    <!--Modal Alta Proyectos-->
                    <div id="modal-alta-proyecto" class="modal text-start" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"> Alta Proyecto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex col-12">
                                        <div class="col-9 "><!--bloque imagen-->
                                            <!--Formulario Alta Proyecto-->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25">Fecha</span>
                                                <input type="date" class="w-50" v-model="fecha_alta" :class="{'nocontestado': respondio === false && fecha_alta === '', '': fecha_alta !== ''}">
                                                <div v-show="fecha_alta !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25">Nombre Proyecto</span>
                                                <input type="text" class="w-50" v-model="nombre_proyecto" :class="{'nocontestado': respondio === false && nombre_proyecto === '', '':nombre_proyecto !== ''}">
                                                <div v-if="nombre_proyecto !==''" class=" text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25">Fuente</span>
                                                <select v-model="selectFuente" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectFuente === '', '': selectFuente !== ''}">
                                                    <option value="" selected disabled>Seleccione..</option>
                                                    <option v-for="fuente in fuentes" :value="fuente.id +'<->'+ fuente.nombre+'<->'+fuente.siglas">{{fuente.nombre}} ({{fuente.siglas}})</option>
                                                </select>
                                            </div>

                                            <!---Planta-->
                                            <div class="input-group mb-3 ">
                                                <span class="input-group-text w-25">Planta</span>
                                                <select v-model="selectPlanta" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectPlanta === '', '': selectPlanta !== ''}">
                                                    <option value="" selected disabled>Seleccione..</option>
                                                    <option v-for="planta in plantas" :value="planta.id +'<->'+ planta.nombre+'<->'+planta.siglas">{{planta.nombre}} ({{planta.siglas}})</option>
                                                </select>
                                                <div class="flex-column">
                                                    <div class="col-12"><button class="btn-anadir" title="Crear " @click="abrirModal('CRUD','Planta','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Planta','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarPlanta()"><i class="bi bi-x-circle"></i></button></div>
                                                </div>
                                                <div v-if="selectPlanta !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>

                                            <!---Área-->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25">Área</span>
                                                <select v-model="selectArea" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectArea === '', '': selectArea !== ''}">
                                                    <option selected disabled>Seleccione..</option>
                                                    <option v-for="area in areas" :value="area.id +'<->'+ area.nombre+'<->'+ area.siglas">{{area.nombre}} ({{area.siglas}})</option>
                                                </select>
                                                <div>
                                                    <div class="col-12"><button class="btn-anadir" title="Crear" @click="abrirModal('CRUD','Área','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Área','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarArea()"><i class="bi bi-x-circle"></i></button></div>
                                                </div>
                                                <div v-if="selectArea !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>

                                            <!---Departamentos-->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25">Departamento</span>
                                                <select v-model="selectDepartamento" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectDepartamento === '', '': selectDepartamento !== ''}">
                                                    <option selected disabled>Seleccione..</option>
                                                    <option v-for="departamento in departamentos" :value="departamento.id+'<->'+departamento.nombre+'<->'+departamento.siglas">{{departamento.nombre}} ({{departamento.siglas}})</option>
                                                </select>
                                                <div>
                                                    <div class="col-12"><button class="btn-anadir" title="Crear" @click="abrirModal('CRUD','Departamento','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Departamento','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarDepartamento()"><i class="bi bi-x-circle"></i></button></div>
                                                </div>
                                                <div v-if="selectDepartamento !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>
                                            <!---Metodologías-->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25">Metodología</span>
                                                <select v-model="selectMetodologia" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectMetodologia === '', '': selectMetodologia !== ''}">
                                                    <option selected disabled>Seleccione..</option>
                                                    <option v-for="metodologia in metodologias" :value="metodologia.id+'<->'+metodologia.nombre">{{metodologia.nombre}}</option>
                                                </select>
                                                <div>
                                                    <div class="col-12"><button class="btn-anadir" title="Crear " @click="abrirModal('CRUD','Metodología','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Metodología','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarMetodologia()"><i class="bi bi-x-circle"></i></button></div>
                                                </div>
                                                <div v-if="selectMetodologia !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>
                                            <!---Responsables-->
                                            <div class="d-flex d-flex-row justify-content-center">
                                                <div><button class="btn-anadir" title="Crear " @click="crearResponsable()"><i class="bi bi-plus-circle"></i></button></div>
                                                <div><button class="btn-up" title="Actualizar" @click="consultarResponsableID()"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                <div><button class="btn-delete" title="Eliminar" @click="eliminarResponsable()"><i class="bi bi-x-circle"></i></button></div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25">Responsable</span>
                                                <select v-model="selectResponsable" class="w-50" :class="{'nocontestado': respondio === false && selectResponsable === '', '': selectResponsable !== ''}">
                                                    <option value="" disabled selected>Seleccione..</option>
                                                    <option v-for="responsable in responsables" :value="responsable.id+'<->'+responsable.nombre">{{responsable.nombre}}</option>
                                                </select>
                                                <div v-if="selectResponsable !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>
                                            <!--Campos Responsable-->
                                            <div class="row pt-2 mt-3" :class="{'mostrar nuevo_responsable': nuevoResponsable ===true && actualizarResponsable === false , 'ocultar':nuevoResponsable ===false && actualizarResponsable === false, 'mostrar actualizar_responsable': actualizarResponsable === true}">
                                                <div class="col-10">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text w-25">Nombre</span>
                                                        <input type="text" v-model="nombre" class="w-75" :disabled="!nuevoResponsable">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text w-25">No. de Nómina</span>
                                                        <input type="text" v-model="numero_nomina" class="w-75">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text w-25">Correo</span>
                                                        <input type="text" v-model="correo" class="w-75" :disabled="!nuevoResponsable">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text w-25">Teléfono</span>
                                                        <input type="text" v-model="telefono" class="w-75" :disabled="!nuevoResponsable">
                                                    </div>
                                                    <!--<div class="mb-3">
                                                        <label class="me-2 text-center">¿Es usuario de finanzas?</label>
                                                        <input type="checkbox" v-model="financiero" :disabled="!nuevoResponsable">
                                                    </div>-->
                                                </div>
                                                <div class="col-2 my-auto text-center">
                                                    <button type="button" v-if="nuevoResponsable==true && actualizarResponsable==false" class="btn-nuevo-responsable" @click="insertarResponsable()">Crear</button>
                                                    <button type="button" v-if="actualizarResponsable" class="btn-actualizar-responsable" @click="actualizandoResponsable()">Actualiazar</button>
                                                    <button type="button" class="btn-cancelar-responsable mt-3" @click="cancelar()">Cancelar</button>
                                                </div>
                                            </div>
                                            <!--Observadores-->
                                            <div class="input-group">
                                            <span class="input-group-text w-25">Observador (Opcional)</span>
                                                <div class="scroll w-50">
                                                    <div class="form-check border border-1 mt-1" v-for="(responsable, index) in responsables" :key="index">
                                                        <input class="form-check-input" type="checkbox" :value="responsable.nombre+'<->'+responsable.numero_nomina" v-model="checkObservadores">
                                                        <label class="form-check-label">
                                                            {{ responsable.nombre }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--Misiones-->

                                            <div class="input-group mb-3 mt-3 ">
                                                <span class="input-group-text w-25 text-start">Misión </span>
                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && checkMisiones.length<=0, '': checkMisiones.length>0}">
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
                                                <span class="input-group-text w-25 text-start">Pilares <br>Estratégicos </span>
                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && checkPilares.length<=0, '': checkPilares.length>0}">
                                                    <div class="form-check border border-1 mt-1" v-for="(pilar, index) in pilares" :key="index">
                                                        <input class="form-check-input" type="checkbox" :value="pilar.id+'<->'+pilar.nombre+'<->'+pilar.siglas+'<->'+(index+1)" v-model="checkPilares" @change="consultarObjetivosXpilaresSeleccionados()">
                                                        <label class="form-check-label w-75">
                                                            {{ pilar.nombre }} ({{pilar.siglas}})
                                                        </label>
                                                        <!--<label class="w-25" v-if="idsPilares.includes(pilar.id) && checkPilares.length>0">
                                                                <select v-model="selectPilar[index]" @change="verificarCantidadDirectosPilares()">
                                                                    <option v-if="idsPilares.includes(pilar.id)" value="" disabled selected>Seleccione...</option>
                                                                    <option value="directo">Directo</option>
                                                                    <option value="indirecto">Indirecto</option>
                                                                </select>
                                                            </label>-->
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
                                                <span class="input-group-text w-25 text-start">Objetivos <br>Estratégicos</span>
                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && checkObjetivos.length<=0, '': checkObjetivos.length>0}">
                                                    <div v-for="(objetivo, index) in objetivos" class="form-check border border-1 mt-1" :key="index">
                                                        <input class="form-check-input" v-model="checkObjetivos" type="checkbox" id="checkbox1" :value="objetivo.id+'<->'+objetivo.nombre+'<->'+objetivo.id_pilares+'<->'+objetivo.siglas+'<->'+(index+1)" @change="checkeandoObjetivos()">
                                                        <label class="form-check-label w-75" for="checkbox1">
                                                            {{objetivo.nombre}} ({{objetivo.siglas}})
                                                        </label>
                                                        <label class="w-25" v-if="idsObjetivos.includes(objetivo.id) && checkPilares.length>0">
                                                            <select v-model="selectObjetivo[index]" @change="verificarCantidadDirectosObjetivos()">
                                                                <option value="" disabled selected>Seleccione...</option>
                                                                <option value="directo">Directo</option>
                                                                <option value="indirecto">Indirecto</option>
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
                                                <span class="input-group-text w-50">Tons CO2 por Evitar (Proyectado)</span>
                                                <input id="tons_co2" type="text" v-model="tons_co2" min="0" class="w-25" :class="{'nocontestado': respondio === false && (tons_co2 == 0 || tons_co2 == '' ), '': tons_co2 !== 0 && tons_co2 !== ''}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputSinPesos('tons_co2')">
                                                <div v-if="tons_co2 !== '' && tons_co2 !== '0'" class="text-center my-auto ms-3">
                                                    <i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i>
                                                </div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-50">Ahorro Duro $MXN/Año (Proyectado )</span>
                                                <input id="ahorro_duro" type="text" v-model="ahorro_duro" min="0" class="w-25" :class="{'nocontestado': respondio === false && ahorro_duro==='$.00', '': ahorro_duro!==0 && ahorro_duro!==''}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('ahorro_duro')">
                                                <div v-if="ahorro_duro!=='' && ahorro_duro !== '$0.00' && ahorro_duro !== '$.00' && ahorro_duro !== '$.0' && ahorro_duro !== '$.'  && ahorro_duro !== '$'" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>
                                            <!--@click="colocarCursor('ahorro_duro')" @blur="asignarValor('ahorro_duro')" @keyUp=" formatoNumero('ahorro_duro', $event)"-->

                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-50">Ahorro Suave $MXN/Año (Proyectado)</span>
                                                <input id="ahorro_suave" type="text" v-model="ahorro_suave" min="0" class="w-25" :class="{'nocontestado': respondio === false && ahorro_suave==='$.00', '': ahorro_suave!==0 && ahorro_suave!==''}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('ahorro_suave')">
                                                <div v-if="ahorro_suave!=='' && ahorro_suave !== '$0.00' && ahorro_suave !== '$.00' && ahorro_suave !== '$.0' && ahorro_suave !== '$.'  && ahorro_suave !== '$'" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25 me-2">Objetivo Estrategico</span>
                                                <input type="checkbox" v-model="objetivo_estrategico">
                                            </div>
                                        </div>
                                        <div class="col-3 my-auto mx-auto "><!--bloque imagen Alta Proyecto-->
                                            <form @submit.prevent="uploadFile('Alta Proyecto')">
                                                <div class="row mx-auto">
                                                    <input type="file" id="input_file_subir" @change="varificandoSelecion()" ref="ref_imagen" accept="*.jpg/*.png" class="btn-success py-1" required />
                                                </div>
                                                <div v-if="imagenes.length>0" class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <img :src="imagenes[0]+'?'+random" style=" width:250px; height:200px;" alt="No existe imagen, para mostrar"></img>
                                                    </div>
                                                </div>
                                                <div v-if="existeImagenSeleccionada==true && login!=true" class="row mx-auto">
                                                    <input class="btn-success" type="submit" value="Subir" />
                                                </div>
                                                <div v-if="login==true" class="d-flex justify-content-center">
                                                    <div>
                                                        <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
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
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nueva" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                    </div>
                                    <!--CRUD Planta Actualizar-->
                                    <div v-if="tipo=='Planta' && accion=='Actualizar'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nuevoNombre" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                    </div>
                                    <!--ÁREAS-->
                                    <!--CRUD Área Crear-->
                                    <div v-if="tipo=='Área' && accion=='Crear'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nueva" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                    </div>
                                    <!--CRUD Área Actualizar-->
                                    <div v-if="tipo=='Área' && accion=='Actualizar'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nuevoNombre" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                    </div>
                                    <!--DEPARTAMENTOS-->
                                    <!--CRUD Departamento Crear-->
                                    <div v-if="tipo=='Departamento' && accion=='Crear'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nueva" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                    </div>
                                    <!--CRUD Departamento Actualizar-->
                                    <div v-if="tipo=='Departamento' && accion=='Actualizar'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nuevoNombre" class="w-50">
                                        </div>
                                    </div>
                                    <div v-if="tipo=='Departamento' && accion=='Actualizar'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                    </div>
                                    <!--METODOLOGÍA-->
                                    <!--CRUD metodologia Crear-->
                                    <div v-if="tipo=='Metodología' && accion=='Crear'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nueva" class="w-50">
                                        </div>
                                    </div>
                                    <!--CRUD Metodologia Actualizar-->
                                    <div v-if="tipo=='Metodología' && accion=='Actualizar'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nuevoNombre" class="w-50">
                                        </div>
                                    </div>
                                    <!--OBJETIVOS-->
                                    <!--CRUD Objetivo Crear-->
                                    <div v-if="tipo=='Objetivo' && accion=='Crear'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nueva" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Seleccione Pilar:</span>
                                            <select v-model="select_pilar" class="w-50">
                                                <option value="" disabled selected> Seleccione.... </option>
                                                <option v-for="pilar in allPilares" :value="pilar.id">{{pilar.nombre}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--CRUD Objetivo Actualizar-->
                                    <div v-if="tipo=='Objetivo' && accion=='Actualizar'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nuevoNombre" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Seleccione Pilar:</span>
                                            <select v-model="select_pilar" class="w-50">
                                                <option value="" disabled selected> Seleccione.... </option>
                                                <option v-for="pilar in allPilares" :value="pilar.id">{{pilar.nombre}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--PILARES-->
                                    <!--CRUD Pilares Crear-->
                                    <div v-if="tipo=='Pilar' && accion=='Crear'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nueva" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Seleccione Mision:</span>
                                            <select v-model="select_mision" class="w-50">
                                                <option value="" disabled selected> Seleccione.... </option>
                                                <option v-for="mision in allMisiones" :value="mision.id">{{mision.nombre}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--CRUD Pilares Actualizar-->
                                    <div v-if="tipo=='Pilar' && accion=='Actualizar'">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Nombre:</span>
                                            <input type="text" v-model="nuevoNombre" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Siglas:</span>
                                            <input type="text" v-model="siglas" class="w-50">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text w-50">Seleccione Pilar:</span>
                                            <select v-model="select_pilar" class="w-50">
                                                <option value="" disabled selected> Seleccione.... </option>
                                                <option v-for="pilar in allPilares" :value="pilar.id">{{pilar.nombre}}</option>
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
                                    <button type="button" class="boton-actualizar" v-if="tipo=='Pilar' && accion=='Actualizar'" @click="actualizarPilares()">Actualizar</button>
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
            <div :class="{ 'cuerpoNormal': mostrarHeader, 'cuerpoAlto': !mostrarHeader }">
                <!--AQUI TRABAJA //ALTA DE PROYECTOS-->
                <div class="text-center mt-3" v-if="ventana=='Altas'">
                    <?php if ($_SESSION['acceso'] == 'Admin') { ?>
                        <button class="btn-menu align-items-center my-2" style=" background:#519f3c; "  @click="abrirModal('Alta')">
                            <i class="bi bi-plus-circle"></i> Alta Proyecto
                        </button>
                    <?php } ?>
                    <div class="scroll-dos px-2">
                        <table class="mx-auto  mb-5 tabla-proyectos">
                            <thead class="sticky-top">
                                <th>Fecha</th>
                                <th>Folio</th>
                                <th>Fuente</th>
                                <th>Nombre Proyecto</th>
                                <th>Planta</th>
                                <th>Área</th>
                                <th>Departamento</th>
                                <th>Metodología</th>
                                <th>Responsable</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Pilare(s) Estratégico(s)</th>
                                <th>Objetivo(s) Estratégico(s)</th>
                                <th>Impacto Ambiental</th>
                                <th>Tons CO2 por Evitar <br>(Proyectado)</th>
                                <th>Ahorro Duro $MXN/Año <br>(Proyectado )</th>
                                <th>Ahorro Suave $MXN/Año <br>(Proyectado)</th>
                                <th>Estatus</th>
                                <?php if ($_SESSION['acceso'] == 'Admin') { ?>
                                    <th>Eliminar</th>
                                    <!--<th>Actualizar</th>-->
                                <?php } ?>
                            </thead>
                            <tbody class=" border:1px solid black" style="text-align: center">
                                <template v-for="(proyecto,index) in proyectos">
                                    <tr v-if="folioAnteriorSinNumeral(proyecto.folio, index)" :class="{ 'divisor-tr-creados': folioAnteriorSinNumeral(proyecto.folio, index)==true}"><!--ES DIFERENTE--->
                                        <td colspan="20" v-if="index>0"></td>
                                    </tr>
                                    <tr class="cuerpo-tabla-creados border border-secondary" style="vertical-align: middle;" :class="{ 'fila-ultimo-proyecto': buscandoUltimoProyectoCreado(proyecto.nombre_proyecto) }">
                                        <td class="border border-secondary">{{proyecto.fecha}}</td>
                                        <td class="border border-secondary" style="min-width:150px;">{{proyecto.folio}}</td>
                                        <td class="border border-secondary">{{proyecto.fuente}}</td>
                                        <td class="border border-secondary">{{proyecto.nombre_proyecto}}</td>
                                        <td class="border border-secondary">{{proyecto.planta}}</td>
                                        <td class="border border-secondary">{{proyecto.area}}</td>
                                        <td class="border border-secondary">{{proyecto.departamento}}</td>
                                        <td class="border border-secondary">{{proyecto.metodologia}}</td>
                                        <td class="border border-secondary">{{proyecto.responsable}}</td>
                                        <td class="border border-secondary">{{proyecto.correo}}</td>
                                        <td class="border border-secondary">{{proyecto.telefono}}</td>
                                        <td class="border border-secondary text-start">
                                            <ul>
                                                <li v-for="pilar in JSON.parse(proyecto.pilares)">{{pilar}}</li>
                                            </ul>
                                        </td>
                                        <td class="border border-secondary text-start">
                                            <ul>
                                                <li v-for="objetivo in JSON.parse(proyecto.objetivos)">{{objetivo}}</li>
                                            </ul>
                                        </td>
                                        <td class="border border-secondary text-start">
                                            <ul>
                                                <li v-for="impacto in JSON.parse(proyecto.impacto_ambiental)">{{impacto}}</li>
                                            </ul>
                                        </td>
                                        <td class="border border-secondary">{{proyecto.tons_co2}}<br> <label class="text-success" v-if="proyectoSumas[proyecto.id]"><b>{{proyectoSumas[proyecto.id].sumaTons}}<b><label></td>
                                        <td class="border border-secondary">{{proyecto.ahorro_duro}}<br> <label class="text-primary" v-if="proyectoSumas[proyecto.id]"><b>{{proyectoSumas[proyecto.id].sumaDuro}}<b><label></td>
                                        <td class="border border-secondary">{{proyecto.ahorro_suave}}<br> <label class="text-primary" v-if="proyectoSumas[proyecto.id]"><b>{{proyectoSumas[proyecto.id].sumaSuave}}<b><label></td>
                                        <td class="border border-secondary"><b><label v-if="proyecto.status_seguimiento!='Cerrado'" class="text-success">Siguiendo</label><label v-else="proyecto.status_seguimiento!='Cerrado'" class="text-danger">{{proyecto.status_seguimiento}}<label></b></td>
                                        <?php if ($_SESSION['acceso'] == 'Admin') { ?>
                                            <td class="border border-secondary"> <button class="rounded-circle bg-danger border border-secondary btn shadow-sm" @click="eliminarProyecto(proyecto.id,proyecto.nombre_proyecto)"><i class="bi bi-trash3-fill text-white"></i></button></td>
                                            <!--<td><button type="button" class=" btn boton_actualizar mx-2" @Click="">Actualizar</button></td>-->
                                        <?php } ?>
                                    </tr>
                                </template>
                        </table>
                    </div>
                    <!---->
                </div>
                <!--------------------------CREAR PERFILES, PILARES OBJETIVOS---------------------------------->
                <div class="row" v-if="ventana=='Crear'">
                    <!-- <div class=" bg-secondary mt-3 text-white align-items-center ">
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
                            </div> -->
                    <!------------------------------TABLA DE LA MISION-------------------------->
                    <div class="col-12 col-lg-6 mt-3 mb-5">
                        <div class="col-12  text-center align-content">
                            <div class=" encabezadoTablas">
                                <div class="  d-flex justify-content-center align-items-center" style="font-size: 0.9em;">
                                    <div class="d-none d-lg-block col-lg-4"></div>
                                    <div class="col-6 col-lg-4 mt-2">Misiones</div>
                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                        <button type="button" class=" btn btn-menu w-50 " @Click="modalCatalogos('Crear','Mision')">Crear</button>
                                    </div>

                                </div>
                            </div>
                            <div class="scroll">
                                <table class=" table table-bordered table-striped  border border-3 border-secondary">
                                    <thead>
                                        <tr class="border border-3 border-secondary" style="font-size: 0.9em;">
                                            <th class=" sticky-top thmodal w-50">
                                                Nombre
                                            </th>
                                            <th class=" sticky-top thmodal w-20">
                                                Eliminar
                                            </th>
                                            <th class=" sticky-top thmodal w-20">
                                                Actualizar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="mision in misiones" style="font-size: 0.7em;">
                                            <td class="text-start">
                                                {{mision.nombre}}
                                            </td>
                                            <td>
                                                <button type="button" class="myButton" @click="eliminarMision(mision.id)"><i class="bi bi-trash3-fill"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="myButton2" @Click="modalCatalogos('Actualizar','Mision',mision.id,mision.nombre)"><i class="bi bi-pencil"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!---------------------------TABLA DE LA PILARES---------------------------->
                    <div class="col-12 col-lg-6 mt-3">
                        <div class="col-12 text-center align-content">
                            <div class=" encabezadoTablas">
                                <div class=" d-flex justify-content-center align-items-center" style="font-size: 0.9em;">
                                    <div class="d-none d-lg-block col-lg-4"></div>
                                    <div class="col-6 col-lg-4 mt-2">Pilares Estrategicos</div>
                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                        <button type="button" class=" btn btn-menu w-50" @Click="modalCatalogos('Crear','Pilar')">Crear</button>
                                    </div>

                                </div>
                            </div>
                            <div class="scroll mb-5">
                                <table class="table table-bordered table-striped border border-3 border-secondary">
                                    <thead>
                                        <tr class="border border-3 border-secondary" style="font-size: 0.9em;">
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
                                            <th class=" sticky-top thmodal ">
                                                Actualizar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="pilar in pilaresRelacion" style="font-size: 0.7em;">
                                            <td class="text-start">
                                                {{pilar.nombre}}
                                            </td>
                                            <td>
                                                {{pilar.siglas}}
                                            </td>
                                            <td>
                                                {{pilar.nombre_mision}}
                                            </td>
                                            <td>
                                                <button type="button" class="myButton" @click="eliminarPilar(pilar.id)"><i class="bi bi-trash3-fill"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="myButton2" @Click="modalCatalogos('Actualizar','Pilar',pilar.id,pilar.nombre,'',pilar.siglas,'',pilar.id_misiones,pilar.nombre_mision,pilar.mision_id)"><i class="bi bi-pencil"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--TABLA DE LA OBJETIVOS-->
                    <div class="col-12 col-lg-6">
                        <div class="col-12 text-center align-content">
                            <div class=" encabezadoTablas">
                                <div class=" d-flex justify-content-center align-items-center" style="font-size: 0.9em;">
                                    <div class="d-none d-lg-block col-lg-4"></div>
                                    <div class="col-6 col-lg-4 mt-2">Objetivos Estrategicos</div>
                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                        <button type="button" class=" btn btn-menu w-50" @Click="modalCatalogos('Crear','Objetivo')">Crear</button>
                                    </div>

                                </div>
                            </div>
                            <div class="scroll mb-5">
                                <table class="table table-bordered table-striped border border-3 border-secondary">
                                    <thead>
                                        <tr class="border border-3 border-secondary" style="font-size: 0.9em;">
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
                                            <th class=" sticky-top thmodal">
                                                Actualizar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="objetivo in objetivos_ligados" style="font-size: 0.7em;">
                                            <td class="text-start">
                                                {{objetivo.nombre_objetivos}}
                                            </td>
                                            <td>
                                                {{objetivo.siglas}}
                                            </td>
                                            <td>
                                                {{objetivo.nombre_pilares}}
                                            </td>
                                            <td>
                                                <button type="button" class="myButton" @click="eliminarObjetivo(objetivo.id)"><i class="bi bi-trash3-fill"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="myButton2" @Click="modalCatalogos('Actualizar','Objetivo',objetivo.id,objetivo.nombre_objetivos,objetivo.id_pilares,objetivo.siglas,'','','','')"><i class="bi bi-pencil"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--TABLA DE IMPACTO AMBIENTAL-->
                    <div class="col-12 col-lg-6 ">
                        <div class="col-12  text-center ">
                            <div class=" encabezadoTablas">
                                <div class=" d-flex justify-content-center " style="font-size: 0.9em;">
                                    <div class="d-none d-lg-block col-lg-4"></div>
                                    <div class="col-6 col-lg-4 mt-2">Impacto Ambiental</div>
                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                        <button type="button" class=" btn btn-menu w-50" @Click="modalCatalogos('Crear','Impacto Ambiental')">Crear</button>
                                    </div>

                                </div>
                            </div>
                            <div class="scroll">
                                <table class=" table table-bordered table-striped border border-3 border-secondary">
                                    <thead>
                                        <tr class="border border-3 border-secondary" style="font-size: 0.9em;">
                                            <th class="sticky-top thmodal">
                                                Nombre
                                            </th>
                                            <th class="sticky-top thmodal">
                                                Suma
                                            </th>
                                            <th class="sticky-top thmodal">
                                                Eliminar
                                            </th>
                                            <th class="sticky-top thmodal">
                                                Actualizar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="impacto in impactoAmbiental" style="font-size: 0.7em;">
                                            <td class="text-start">
                                                {{impacto.nombre}}
                                            </td>
                                            <td>
                                                <template v-for="(suma,indexImpacto ) in sumasImpactoAmbiental">
                                                    <label v-if="indexImpacto==impacto.nombre" class="bg-success rounded-pill w-75 text-white ms-2 px-2 text-start">{{suma}}</label>
                                                </template>
                                            </td>
                                            <td>
                                                <button type="button" class="myButton" @click="eliminarImpactoAmbiental(impacto.id)"><i class="bi bi-trash3-fill"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="myButton2" @Click="modalCatalogos('Actualizar','Impacto Ambiental',impacto.id,impacto.nombre)"><i class="bi bi-pencil"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- INICIO TABLA ESTANDARES CO2 -->
                    <div class="col-12 col-lg-6 ">
                        <div class="col-12 text-center align-content">
                            <div class=" encabezadoTablas">
                                <div class=" d-flex justify-content-center align-items-center " style="font-size: 0.9em;">
                                    <div class="d-none d-lg-block col-lg-4"></div>
                                    <div class="col-6 col-lg-4 mt-2 ">
                                        Estandares de CO2
                                    </div>
                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                        <button type="button" class=" btn btn-menu w-50" @Click="modalCatalogos('Crear','Estandar')">Crear</button>
                                    </div>
                                </div>
                            </div>
                            <div class="scroll">
                                <table class="  table table-bordered border-secondary border border-3 border-secondary">
                                    <thead>
                                        <tr class="border border-3 border-secondary" style="font-size: 0.9em;">
                                            <th class=" sticky-top thmodal">
                                                Documentos
                                            </th>
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
                                            <th class=" sticky-top thmodal">
                                                Actualizar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(estandar,index) in estandares " style="font-size: 0.7em;">
                                            <td class="align-middle" v-if="index==0" :rowspan="estandares.length">
                                                <button v-if="documentos_co2.length>0" type="button" class="btn btn-success" title="Visualizar/Subir Archivos"  @click="modal_co2()" style="font-size:10px"><i class="bi bi-paperclip"></i>{{documentos_co2.length}} Archivos Encontrados</button>
                                                <button v-else type="button" class="btn btn-secondary" title="Visualizar/Subir Archivos"  @click="modal_co2()" style="font-size:10px"><i class="bi bi-paperclip"></i>{{documentos_co2.length}} Archivos Encontrados</button>    
                                            </td>
                                            <td class="text-start">
                                                {{estandar.nombre}}
                                            </td>
                                            <td>
                                                {{estandar.cantidad}}
                                            </td>
                                            <td>
                                                {{estandar.unidad_medida}}
                                            </td>
                                            <td>
                                                <button type="button" class="myButton" @click="eliminarEstandares(estandar.id)"><i class="bi bi-trash3-fill"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="myButton2" @Click="modalCatalogos('Actualizar','Estandares',estandar.id,estandar.nombre,estandar.cantidad,'',estandar.unidad_medida)"><i class="bi bi-pencil"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--TABLA DE FUENTES-->
                    <div class="col-12 col-lg-6">
                        <div class="col-12  text-center align-content">
                            <div class=" encabezadoTablas">
                                <div class=" d-flex justify-content-center align-items-center" style="font-size: 0.9em;">
                                    <div class="d-none d-lg-block col-lg-4"></div>
                                    <div class="col-6 col-lg-4 mt-2">Fuentes</div>
                                    <div class="col-6 me-4 me-lg-0 col-lg-4 mt-2">
                                        <button type="button" class=" btn btn-menu w-50" @Click="modalCatalogos('Crear','Fuente')">Crear</button>
                                    </div>

                                </div>
                            </div>
                            <div class="scroll">
                                <table class=" table table-bordered table-striped border border-3 border-secondary">
                                    <thead>
                                        <tr class="border border-3 border-secondary" style="font-size: 0.9em;">
                                            <th class="sticky-top thmodal">
                                                Nombre
                                            </th>
                                            <th class="sticky-top thmodal">
                                                Siglas
                                            </th>
                                            <th class="sticky-top thmodal">
                                                Eliminar
                                            </th>
                                            <th class="sticky-top thmodal">
                                                Actualizar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="fuente in fuentes " style="font-size: 0.7em;">
                                            <td class="text-start">
                                                {{fuente.nombre}}
                                            </td>
                                            <td>
                                                {{fuente.siglas}}
                                            </td>
                                            <td>
                                                <button type="button" class="myButton" @click="eliminarFuente(fuente.id)"><i class="bi bi-trash3-fill"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="myButton2" @Click="modalCatalogos('Actualizar','Fuente',fuente.id,fuente.nombre,'',fuente.siglas)"><i class="bi bi-pencil"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                                            <span class="input-group-text w-25 mt-3">Nombre:</span>
                                            <input type="text" class="w-75 mt-3" v-model="nueva">
                                        </div>
                                    </div>
                                    <!--Cuerpo de MODAL PILARES-->
                                    <div v-if="tipo=='Pilar'">
                                        <div class="modal-body input-group mb-3">
                                            <span class="input-group-text w-25 mt-3">Nombre:</span>
                                            <input type="text" class="w-75 mt-3" v-model="nueva">
                                            <span class="input-group-text w-25 mt-3">Siglas:</span>
                                            <input type="text" class="w-75 mt-3" v-model="siglas">
                                            <span class="input-group-text w-25 mt-3">Mision:</span>
                                            <select class="w-75 mt-3" v-model="select_mision">
                                                <option v-for="mision in misiones" :value="mision.id">{{mision.nombre}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--Cuerpo de MODAL OBJETIVO-->
                                    <div v-if="tipo=='Objetivo'">
                                        <div class="modal-body input-group mb-3">
                                            <span class="input-group-text w-25 mt-3">Nombre:</span>
                                            <input type="text" class="w-75 mt-3" v-model="nueva">
                                            <span class="input-group-text w-25 mt-3">Siglas:</span>
                                            <input type="text" class="w-75 mt-3" v-model="siglas">
                                            <span class="input-group-text w-25 mt-3">Pilar:</span>
                                            <select v-model="select_pilar" class="w-75 mt-3">
                                                <option v-for="pilar in pilaresRelacion" :value="pilar.id">{{pilar.nombre}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--Cuerpo de MODAL IMPACTO AMBIENTAL-->
                                    <div v-if="tipo=='Impacto Ambiental'">
                                        <div>
                                            <div class="modal-body input-group mb-3">
                                                <span class="input-group-text w-25 mt-3">Nombre:</span>
                                                <input v-model="nueva" type="text" class="w-75 mt-3">
                                            </div>
                                        </div>
                                    </div>

                                    <!--Cuerpo de MODAL ESTANDARES CO2 -->
                                    <div v-if="tipo=='Estandar'">
                                        <div>
                                            <div class="modal-body input-group mb-3">
                                                <span class="input-group-text w-25 mt-3">Nombre:</span>
                                                <input v-model="nueva" type="text" class="w-75 mt-3">
                                                <div class="d-flex input-group">
                                                    <span class="input-group-text w-25  mt-3">Cantidad</span>
                                                    <input v-model="cantidad" type="text" class="w-25 mt-3">
                                                    <span class="input-group-text w-25 mt-3">Descripcion</span>
                                                    <input v-model="descripcionCa" type="text" class="w-25 mt-3">
                                                </div>
                                                <span class="input-group-text w-25 mt-3">Unidad De Medida:</span>
                                                <input v-model="unidadMedida" type="text" class="w-75 mt-3">
                                            </div>
                                        </div>
                                    </div>

                                    <!--Cuerpo de MODAL FUENTE-->
                                    <div v-if="tipo=='Fuente'">
                                        <div>
                                            <div class="modal-body input-group mb-3">
                                                <span class="input-group-text w-25 mt-3">Nombre:</span>
                                                <input v-model="nueva" type="text" class="w-75 mt-3">
                                                <span class="input-group-text w-25 mt-3">Siglas:</span>
                                                <input type="text" class="w-75 mt-3" v-model="siglas">
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
                                                <span class="input-group-text w-25 mt-3">Nombre:</span>
                                                <input v-model="nuevoNombre" type="text" class="w-75 mt-3">
                                            </div>
                                        </div>
                                    </div>
                                    <!--cuerpo MODAL ACTUALIZAR Misiones-->
                                    <div v-if="tipo=='Mision'">
                                        <div>
                                            <div class="modal-body input-group mb-3">
                                                <span class="input-group-text w-25 mt-3">Nombre:</span>
                                                <input v-model="nueva" type="text" class="w-75 mt-3">
                                            </div>
                                        </div>
                                    </div>
                                    <!--CUERPO MODAL ACTUALIZAR PILARES-->
                                    <div v-if="tipo=='Pilar'">
                                        <div>
                                            <div class="modal-body input-group mb-3">

                                                <div class="input-group mb-3 mt-3">
                                                    <span class="input-group-text w-25">Nombre:</span>
                                                    <input v-model="nuevoNombre" type="text" class="w-75">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25">Siglas:</span>
                                                    <input v-model="siglas" type="text" class="w-75">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text w-25">Seleccione Mision:</span>
                                                    <select v-model="misionLigada" class="w-75" v-model="misionLigada">
                                                        <option v-for="mision in misiones" :value="mision.id">{{mision.nombre}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--CUERPO MODAL ACTUALIZAR OBJETIVOS-->
                                    <div v-if="tipo=='Objetivo'">
                                        <div>
                                            <div class="modal-body input-group mb-3">
                                                <span class="input-group-text w-25 mt-3">Nombre:</span>
                                                <input v-model="nuevoNombre" type="text" class="w-75 mt-3">
                                                <span class="input-group-text w-25 mt-3">Siglas:</span>
                                                <input v-model="siglas" type="text" class="w-75 mt-3">
                                                <span class="input-group-text w-25 mt-3">Pilar:</span>
                                                <select v-model="select_pilar" class="w-75 mt-3">
                                                    <option v-for="pilar in pilaresRelacion" :value="pilar.id">{{pilar.nombre}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--CUERPO MODAL ACTUALIZAR ESTANDARES CO2-->
                                    <div v-if="tipo=='Estandares'">
                                        <div>
                                            <div class="modal-body input-group mb-3">
                                                <span class="input-group-text w-25 mt-3">Nombre:</span>
                                                <input v-model="nuevoNombre" type="text" class="w-75 mt-3">
                                                <span class="input-group-text w-25 mt-3">Cantidad:</span>
                                                <input v-model="cantidad" type="number  " class="w-75 mt-3">
                                                <span class="input-group-text w-230 mt-3">Unidad De Medida:</span>
                                                <input v-model="unidadMedida" type="text" class="w-75 mt-3">
                                            </div>
                                        </div>
                                    </div>
                                    <!--CUERPO MODAL ACTUALIZAR FUENTE-->
                                    <div v-if="tipo=='Fuente'">
                                        <div>
                                            <div class="input-group mb-3 mt-3  px-3">
                                                <span class="input-group-text w-25">Nombre:</span>
                                                <input v-model="nuevoNombre" type="text" class="w-75">
                                            </div>
                                            <div class="input-group mb-3  px-3">
                                                <span class="input-group-text w-25">Siglas:</span>
                                                <input v-model="siglas" type="text" class="w-75">
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
                                    <button type="button" class="boton-aceptar" v-if="tipo=='Fuente'  && accion=='Crear'" @click="insertarFuente()">Crear</button>
                                    <!-- BOTON PARA ACTUALIZAR INFORMACION  -->
                                    <button type="button" class="boton-actualizar" v-if="tipo=='Impacto Ambiental' && accion=='Actualizar'" @click="actualizarImpactoAmbiental()">Actualizar</button>
                                    <button type="button" class="boton-actualizar" v-if="tipo=='Estandares' && accion=='Actualizar'" @click="actualizarEstandaresCO2()">Actualizar</button>
                                    <button type="button" class="boton-actualizar" v-if="tipo=='Pilar' && accion=='Actualizar'" @click="actualizarPilares()">Actualizar</button>
                                    <button type="button" class="boton-actualizar" v-if="tipo=='Objetivo' && accion=='Actualizar'" @click="actualizarObjetivos()">Actualizar</button>
                                    <button type="button" class="boton-actualizar" v-if="tipo=='Mision' && accion=='Actualizar'" @click="actualizarMision()">Actualizar</button>
                                    <button type="button" class="boton-actualizar" v-if="tipo=='Fuente' && accion=='Actualizar'" @click="actualizarFuente()">Actualizar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fin Modal-->
                    <!-- Modal Eliminar/Actualizar Documentos CO2-->
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel" >Subir documentos</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <div class="text-center">
                                                <form @submit.prevent="uploadFile('Documento CO2')">
                                                    <!--Subir Documento Sugerencia-->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="custom-file mt-5 mb-3"> 
                                                            <input type="file" id="input_file_co2" @change="verificandoSelecionCO2()" ref="ref_co2" multiple accept="*.jpg/*.png/*.pdf/*.doc/*.docx/*.ppt/*.pptx/*.xls/*.xlsx" class="btn btn-secondary  ms-2 p-0" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-12" v-if="existeImagenSeleccionadaCO2 && login!=true" >
                                                            <button  type="submit" name="upload" class="btn btn-primary">Subir Archivos </button>
                                                        </div>
                                                        <div v-if="login==true" class="d-flex justify-content-center">
                                                            <div>
                                                                <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                          <!-- Mostrando los archivos cargados -->
                                                        <div v-show="documentos_co2.length>0" >
                                                        <hr>
                                                                <div class="col-12" v-for= "(archivos,index) in documentos_co2">
                                                                    <div class="row">
                                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                                            <div class="mt-1">
                                                                                <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;">Eliminar</button>
                                                                            </div>
                                                                    </div>
                                                                   <!--Mostar los JPG y PNG-->
                                                                   <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                                        <img  :src="documentos_co2[index]" style="width:50%" class="mb-5"></img>
                                                                    </div>
                                                                     <!--Mostrar PDF-->
                                                                     <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'"  class="col-12 text-center">
                                                                     {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                                            <iframe  :src="documentos_co2[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
                                                                    </div>
                                                                    <!--Mostrar Word-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                                <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                    <!--Mostrar Excel-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                                <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                    <!--Mostrar Power Point -->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                            <img  src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </form>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                                </div>
                            </div>
                    </div>
                <!--Fin Modal Documento C02-->
                </div>
                <!---------------------------VENTANA DE SEGUIMIENTO DE PROYECTO------------------------------->
                <div v-if="ventana=='Seguimiento'">
                          <div class="col-12">                     
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                                <div class="input-group mt-3 mx-2 mb-2 ">
                                                    <span class="input-group-text w-5">Seleccione Proyecto</span>
                                                    <select class="w-50" @keydown.up="cancelarEvento" @keydown.down="cancelarEvento" @keydown.left="cancelarEvento" @keydown.right="cancelarEvento" @change="consultarImpactoAmbieltalXProyectoID()" v-model="id_proyecto">
                                                        <option value="" disabled>Seleccione...</option>
                                                        <option v-for="proyecto in proyectos" :value="proyecto.id" style="font-size:15px;">{{proyecto.nombre_proyecto}}</option>
                                                    </select>
                                                    <button v-show="id_proyecto!=''" v-if="documentos_seguimiento.length>0" type="button" class="btn btn-success" title="Visualizar/Subir Archivos"  @click="modal_seguimiento()" style="font-size:10px"><i class="bi bi-paperclip"></i>{{documentos_seguimiento.length}} Archivos Encontrados</button>
                                                    <button v-show="id_proyecto!=''" v-else type="button" class="btn btn-secondary" title="Visualizar/Subir Archivos"  @click="modal_seguimiento()" style="font-size:10px"><i class="bi bi-paperclip"></i>{{documentos_seguimiento.length}} Archivos Encontrados</button>
                                                </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                                <div class="input-group mt-3 mx-2 mb-2 d-flex justify-content-start justify-content-lg-center">
                                                    <span class="input-group-text w-5">Documentos estandares CO<label style="font-size:8px" class="mt-1">2</label></span>
                                                    <button v-if="documentos_co2.length>0" type="button" class="btn btn-success" title="Visualizar"  @click="modal_co2()" style="font-size:10px"><i class="bi bi-file-earmark me-1"></i>{{documentos_co2.length}} Archivos Encontrados</button>
                                                    <button v-else type="button" class="btn btn-secondary" title="Visualizar/Subir Archivos"  @click="modal_co2()" style="font-size:10px"><i class="bi bi-file-earmark  me-1"></i>{{documentos_co2.length}} Archivos Encontrados</button>
                                                </div>
                                        </div>
                                    </div>
                            </div> 
                    <div class="scroll-dos">
                        <table class="mx-2 mb-5 table table-hover table-bordered table-striped text-center" style="font-size: 0.8em;">
                            <thead style="background: #848484; color:white;">
                                <tr>
                                <?php if($_SESSION['acceso']!="Financiero")  {?>
                                    <th v-if="seguimiento_status" style="background: #848484; color:white;">Actualizar</th>
                                <?php } ?>
                                    <th style="background: #848484; color:white;">Fecha</th>
                                    <th style="background: #848484; color:white;">Tons CO2 (Evitados) </th>
                                    <th style="background: #848484; color:white;" v-if="sinImpacto!='Sin Impacto'" v-for="(impacto,index) in columnaImpactoAmbiental" :key="index">{{impacto}}</th>
                                    <th style="background: #848484; color:white;">Ahorro Duro $MXN/Año</th>
                                    <th style="background: #848484; color:white;">Ahorro Suave $MXN/Año</th>
                                    <th style="background: #848484; color:white;">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-----------------------------------------------------------------------------CUANDO YA EXISTE MINIMO UN SEGUIMIENTO -->

                                <tr v-if="seguimientos>0" style="vertical-align: middle; font-size: 1.1em;" v-for="(proyecto,posicion) in arregloID" :key="posicion">
                                    <?php if($_SESSION['acceso']!="Financiero")  {?>
                                    <td v-if="seguimiento_status">
                                        <button v-if="actualizar==0 && actualizatabla == false" type="button" class="boton-actualizar" v-if="actualizatabla == false" @Click="asignarDatosActualizar(posicion)">Actualizar</button>
                                        <button v-if="actualizar==(posicion+1)" v-if="actualizatabla == true" class="boton-eliminar mx-2" @Click="actualizar = 0">Cancelar</button>
                                        <button v-if="actualizar==(posicion+1) && proyecto.id_registro " v-if="actualizatabla == true" class="boton-aceptar" @Click="actualizarSeguimiento(posicion)">Guardar</button><!--Guardar Actualizacion cuando existe minimo 1-->
                                    </td>
                                    <?php } ?>
                                    <td style="min-width: 351px;">
                                        <div v-if="actualizar==(posicion+1)">
                                            <label class="ms-1"> Mes: </label>
                                            <select v-model=" mes_select" class="me-3">
                                                <option v-for="(month,index) in months" :value="(index+1)">{{month}}</option>
                                            </select>
                                            <label class="ms-1 "> Año: </label>
                                            <select v-model="anio_select">
                                                <option v-for="(year,index) in years" :value="year">{{year}}</option>
                                            </select>
                                        </div>
                                        <div v-else>
                                            <label> {{mostrandoMes(proyecto.mes)}} <label>
                                                    <label> {{proyecto.anio}} <label>
                                        </div>
                                    </td>

                                    <td style="background: #bfe49b;">
                                        <input v-if="actualizar==(posicion+1)" type="text" v-model="input_tons_co2" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputSinPesos('input_tons_co2')"></input><!--:value="proyecto.tons_co2"-->
                                        <label v-else>{{proyecto.tons_co2}}</label>
                                    </td>
                                    <td v-if="sinImpacto!='Sin Impacto'" v-for="(cantidad,index) in columnaImpactoAmbiental.length" :key="index"><!--columa v-for"-->
                                        <input v-if="actualizar==(posicion+1)" type="text" v-model="inputImpactoAmbiental[posicion][index]" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputSinPesosImpactoAmbientalPosicion(posicion,index)"> </input>
                                        <label v-else>{{inputImpactoAmbiental[posicion][index]}}</label>
                                    </td>
                                    <td>
                                        <input v-if="actualizar==(posicion+1)" type="text" v-model="input_ahorro_duro" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('input_ahorro_duro')"></input> <!--:value="proyecto.ahorro_duro"-->
                                        <label v-else>{{proyecto.ahorro_duro}}</label>
                                    </td>
                                    <td>
                                        <input v-if="actualizar==(posicion+1)" type="text" v-model="input_ahorro_suave" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('input_ahorro_suave')"></input> <!--:value="proyecto.ahorro_suave"-->
                                        <label v-else>{{proyecto.ahorro_suave}}</label>
                                    </td>
                                    <td style="min-width:150px">
                                    <?php if($_SESSION['acceso']!="Financiero")  {?>
                                        <div v-if="posicion === (arregloID.length - 1)" class="form-check form-switch">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" v-model="seguimiento_status" @change="guardarStatus()" style=" background-color: #B3F09B; color:white">
                                                <label v-if="seguimiento_status" class="form-check-label" for="flexSwitchCheckDefault">Siguiendo</label>
                                                <label v-else class="form-check-label" for="flexSwitchCheckDefault">Cerrado</label>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr v-if="seguimientos>0" class="align-middle"> <!--Sumatoria y adjuntos-->
                                    <?php if($_SESSION['acceso']!="Financiero")  {?>
                                        <td v-if="seguimiento_status"></td><!--Se oculta esta columna cuando es cerrado-->
                                    <?php } ?>
                                    <td><b>Sumatoria:</b> </td>
                                    <td><b>{{sumaCO2}}</b></td>
                                    <td v-if="sinImpacto!='Sin Impacto'" v-for="(cantidad,index) in columnaImpactoAmbiental.length" :key="index"><!--columa v-for"-->
                                        <b>{{sumaColumnasImpacto['suma'+index]}}<b>
                                    </td>
                                    <td><b>{{sumaAhorroDuro}}</b></td>
                                    <td><b>{{sumaAhorroSuave}}<b></td>
                                    <td>
                                    </td>
                                </tr>
                                <!------------------------------------------------------------------------------PRIMER SEGUIMIETO --------------------------------------------------->
                                <tr v-if="id_proyecto!='' && seguimiento_status==true" style="vertical-align: middle; font-size: 1.1em;">
                                    <?php if($_SESSION['acceso']!="Financiero")  {?>
                                        <td v-if="seguimiento_status">
                                            <button v-if="actualizatabla == false && actualizar==0 " type="button" class="boton-aceptar" @Click="actualizatabla =!actualizatabla,nuevoLimpiarVariables()">Nuevo</button>
                                            <button v-if="actualizatabla == true" class="boton-eliminar mx-2" @Click="actualizatabla =!actualizatabla ">Cancelar</button>
                                            <button v-if="actualizatabla == true" class="boton-aceptar" @Click="guardarSeguimiento()">Guardar</button><!--Cundo no existe aun ningun registro-->
                                        </td>
                                    <?php } ?>
                                    <td style="min-width: 351px;">
                                        <label v-if="actualizatabla==true" class="ms-3"> Mes: </label>
                                        <select v-if="actualizatabla==true" v-model="mes_select">
                                            <option v-for="(month,index) in months" :value="(index+1)">{{month}}</option>
                                        </select>
                                        <label v-if="actualizatabla==true" class="ms-3"> Año: </label>
                                        <select v-if="actualizatabla==true" v-model="anio_select">
                                            <option v-for="(year,index) in years" :value="year">{{year}}</option>
                                        </select>
                                        <!--<input class="mx-1" v-if="actualizatabla==true" type="date" v-model="fecha_desde"></input>--><!--:value="proyecto.fecha_inicial"-->
                                    </td>
                                    <td style="background: #bfe49b;">
                                        <input v-if="actualizatabla==true" type="text" v-model="input_tons_co2" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputSinPesos('input_tons_co2')"></input><!--:value="proyecto.tons_co2"-->
                                        <label v-else></label>
                                    </td>
                                    <td v-if="sinImpacto!='Sin Impacto'" v-for="(cantidad,index) in columnaImpactoAmbiental.length" :key="index"><!--columa v-for"-->
                                        <input v-if="actualizatabla==true" type="text" v-model="inputImpactoAmbientalInicial[index]" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputSinPesosImpactoAmbiental(index)"> </input>
                                        <label v-else></label>
                                    </td>
                                    <td>
                                        <input v-if="actualizatabla==true" type="text" v-model="input_ahorro_duro" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('input_ahorro_duro')"></input> <!--:value="proyecto.ahorro_suave"-->
                                        <label v-else></label>
                                    </td>
                                    <td>
                                        <input v-if="actualizatabla==true" type="text" v-model="input_ahorro_suave" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('input_ahorro_suave')"></input> <!--:value="proyecto.ahorro_duro"-->
                                        <label v-else></label>
                                    </td>
                                    <td style="min-width:150px">

                                    </td>
                                </tr>
                            <tbody>
                        </table>
                    </div>

                    <!-- Modal Eliminar/Actualizar Seguimiento-->
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h6 v-if="cual_documento=='Seguimiento'" class="modal-title" id="exampleModalLabel" >Subir documentos</h6>
                                    <h6 v-if="cual_documento=='Documento CO2'" class="modal-title" id="exampleModalLabel" >Documentos CO2</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <div class="text-center">
                                                <form @submit.prevent="uploadFile('Seguimiento')">
                                                    <!--Subir Documento Sugerencia-->
                                                    <?php if($_SESSION['acceso']!="Financiero")  {?>
                                                        <div v-if="cual_documento=='Seguimiento'" class="row" >
                                                            <div class="col-12">
                                                                <div class="custom-file mt-5 mb-3"> 
                                                                <input type="file" id="input_file_seguimiento" @change="varificandoSelecionSeguimiento()" ref="ref_seguimiento" multiple accept="*.jpg/*.png/*.pdf/*.doc/*.docx/*.ppt/*.pptx/*.xls/*.xlsx" class="btn btn-secondary  ms-2 p-0" required />
                                                                </div>
                                                            </div>
                                                            <div class="col-12" v-if="existeImagenSeleccionadaSeguimiento && login!=true" >
                                                                <button  type="submit" name="upload" class="btn btn-primary">Subir Archivos </button>
                                                            </div>
                                                            <div v-if="login==true" class="d-flex justify-content-center">
                                                                <div>
                                                                    <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    <?php } ?>
                                                          <!-- Mostrando los archivos cargados SEGUIMIENTO-->
                                                        <div v-if="cual_documento=='Seguimiento'" v-show="documentos_seguimiento.length>0" >
                                                        <hr>
                                                                <div class="col-12" v-for= "(archivos,index) in documentos_seguimiento">
                                                                    
                                                                        <div class="row">
                                                                            <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                                            <?php if($_SESSION['acceso']!="Financiero")  {?>
                                                                                <div class="mt-1">
                                                                                    <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;" >Eliminar</button>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    
                                                                    <!--Mostar los JPG y PNG-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                                        <img  :src="documentos_seguimiento[index]" style="width:50%" class="mb-5"></img>
                                                                    </div>
                                                                     <!--Mostrar PDF-->
                                                                     <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'"  class="col-12 text-center">
                                                                     {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                                            <iframe  :src="documentos_seguimiento[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
                                                                    </div>
                                                                    <!--Mostrar Word-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                                <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                    <!--Mostrar Excel-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                                <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                    <!--Mostrar Power Point -->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                            <img  src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                </div>
                                                        </div>

                                                          <!-- Mostrando los archivos cargados CO2 -->
                                                          <div v-if="cual_documento=='Documento CO2'" v-show="documentos_co2.length>0" >
                                                        
                                                                <div class="col-12" v-for= "(archivos,index) in documentos_co2">

                                                                    <div class="row">
                                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                                    </div>

                                                                   <!--Mostar los JPG y PNG-->
                                                                   <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                                        <img  :src="documentos_co2[index]" style="width:50%" class="mb-5"></img>
                                                                    </div>
                                                                     <!--Mostrar PDF-->
                                                                     <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'"  class="col-12 text-center">
                                                                     {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                                            <iframe  :src="documentos_co2[index]" style="width:100%;height:500px;"  class="mb-5"></iframe>
                                                                    </div>
                                                                    <!--Mostrar Word-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                                <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                    <!--Mostrar Excel-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                                <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                    <!--Mostrar Power Point -->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                            <img  src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </form>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                                </div>
                            </div>
                    </div>
                <!--Fin Modal subir seguimiento-->
                </div>


                <!--/////////////////////////////////////////////////////////////GENERAR VALOR////////////////////////////////////////-->
                <div v-if="ventana=='Generar Valor'">
                <!--<div class="div-color">
                Pantalla 
                </div>-->
                       
                    <div class="scroll-bateria ">
                        <div class="m-0 " style=" min-width: 900px; width: 100%; height: 100%; position: relative;">
                            <div class="col-12 text-center" style="z-index: 1; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); ">
                                <img class="imgBateria" src="img/imagenBateriaFondoObscuro.jpg"></img>
                            </div>
                            <!--CONTENIDO BATERIA-->
                            <div class="row">
                                <div class="col-12 d-flex align-items-center text-center justify-content-center mx-auto " style="height: 75vh; position: absolute; z-index: 2;">
                                    <div class="ms-4 " style="min-width: 800px;">
                                   
                                    <div class="selector-anio col-12 input-group mx-2 mb-2 d-flex justify-content-center ">
                                        <span class="input-group-text w-5">Seleccione Año</span>
                                        <select v-model="select_anio_generando_valor" @change="consultarSeguimientos()">
                                            <option value="" selected>Todos los años..</option> 
                                            <option v-for="(year,index) in years" :value="year">{{year}}</option>
                                        </select>
                                    </div>
                                        <div class=" tablasBateryHead d-flex  mx-auto">
                                            <div class="col-9 mt-1 bg-success text-white text-center d-flex align-items-center justify-content-center">
                                                <h5 class="my-auto">Generando valor sustentable</h5>
                                            </div>
                                            <div class="col-3">
                                                <table class="mt-1 w-100 ">
                                                    <thead class="border border-dark">

                                                    </thead>
                                                    <tbody>
                                                        <tr scope="col">
                                                            <td class="border border-dark bg-secondary text-white">Valor (MXN)</td>
                                                            <td class="border border-dark text-primary bg-white"><b>{{sumaGeneralValor}}</b></td>
                                                        </tr>
                                                        <tr scope="row">
                                                            <td class="border border-dark bg-secondary text-white">Sustentable (t CO2)</td>
                                                            <td class="border border-dark text-success bg-white"><b>{{sumaGeneralSustentable}}</b></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center pt-1">
                                            <div class="tablasBatery col-3 px-1 px-lg-2">
                                                <div class="d-flex  text-center text-white pb-1">
                                                    <span class="col-6 subtitulo" style="margin-top:11px">Cliente</span>
                                                    <table class="col-6  mt-1  text-center  table-bordered border-dark  ">
                                                        <thead>

                                                        </thead>
                                                        <tbody class="bg-white text-dark">
                                                            <tr>
                                                                <td><b>Valor</b></td>
                                                                <td class="text-primary"><b>{{sumaClienteValor}}</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Sust.</b></td>
                                                                <td class="text-success"><b>{{sumaClienteSustentable}}</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </div>
                                                <table class=" text-center table table-bordered border-dark  ">
                                                    <thead class="align-middle">
                                                        <th>Objetivo Estrategíco</th>
                                                        <th>Valor <br>(MXN)</th>
                                                        <th>Sustentable <br>(t CO2)</th>
                                                    </thead>
                                                    <tbody class="bg-white">
                                                        <tr class="align-middle text-start" v-for="objetivos in objetivos_ligados">
                                                            <th scope="row" v-if="objetivos.nombre_pilares == 'Cliente'">{{objetivos.nombre_objetivos}}</th>
                                                            <td v-if="objetivos.nombre_pilares == 'Cliente'">
                                                                <label class="text-primary" v-if="buscarCoincidencias(objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')')">
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].valor}}</b>
                                                                </label>
                                                                <label class="text-primary" v-else>
                                                                    <b>$0.00</b>
                                                                </label>
                                                            </td>
                                                            <td v-if="objetivos.nombre_pilares == 'Cliente'">
                                                                <label class="text-success" v-if="buscarCoincidencias(objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')')">
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].sustentable}}</b>
                                                                </label>
                                                                <label class="text-success" v-else>
                                                                    <b> 0.00</b>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tablasBatery2 col-3 px-1 px-lg-2 border-start border-end border-3 border-dark">
                                                <div class="d-flex  text-white pb-1">
                                                    <span class="col-6 subtitulo" style="margin-top:11px">Capital humano</span>
                                                    <table class="col-6  mt-1  text-center  table-bordered border-dark  ">
                                                        <thead>

                                                        </thead>
                                                        <tbody class="bg-white text-dark">
                                                            <tr>
                                                                <td><b>Valor</b></td>
                                                                <td class="text-primary"><b>$0.0</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Sust.</b></td>
                                                                <td class="text-success"><b>0.00</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <table class=" text-center table table-bordered border-dark  ">
                                                    <thead class="align-middle">
                                                        <th>Objetivo Estrategíco</th>
                                                        <th>Valor <br>(MXN)</th>
                                                        <th>Sustentable <br>(t CO2)</th>
                                                    </thead>
                                                    <tbody class="bg-white">
                                                        <tr class="align-middle text-start" v-for="objetivos in objetivos_ligados">
                                                            <th scope="row" v-if="objetivos.nombre_pilares == 'Capital Humano'">{{objetivos.nombre_objetivos}}</th>
                                                            <td v-if="objetivos.nombre_pilares == 'Capital Humano'">
                                                                <label class="text-primary" v-if="buscarCoincidencias(objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')')">
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].valor}}</b>
                                                                </label>
                                                                <label class="text-primary" v-else>
                                                                    <b>$0.00</b>
                                                                </label>
                                                            </td>
                                                            <td v-if="objetivos.nombre_pilares == 'Capital Humano'">
                                                                <label class="text-success" v-if="buscarCoincidencias(objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')')">
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].sustentable}}</b>
                                                                </label>
                                                                <label class="text-success" v-else>
                                                                    <b> 0.00</b>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tablasBatery3 col-3 px-1 px-lg-2 border-end border-3 border-dark">
                                                <div class="d-flex text-center text-white pb-1">
                                                    <span class="col-6 subtitulo" style="margin-top:6px">Excelencia operativa</span>
                                                    <table class="col-6  mt-1  text-center  table-bordered border-dark  ">
                                                        <thead>

                                                        </thead>
                                                        <tbody class="bg-white text-dark">
                                                            <tr>
                                                                <td><b>Valor</b></td>
                                                                <!---<td class="text-primary"><b id="total_valor_ex">{{SumaValorEx}}</b></td>-->
                                                                <td class="text-primary"><b>{{sumaExcelenciaValor}}</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Sust.</b></td>
                                                                <!--<td class="text-success"><b id="total_sustentable_ex">{{SumaSustentableEx}}</b></td>-->
                                                                <td class="text-success"><b>{{sumaExcelenciaSustentable}}</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <table class=" text-center table table-bordered border-dark  ">
                                                    <thead class="align-middle">
                                                        <th>Objetivo Estrategíco</th>
                                                        <th>Valor <br>(MXN)</th>
                                                        <th>Sustentable <br>(t CO2)</th>
                                                    </thead>
                                                    <tbody class="bg-white">
                                                        <tr class="align-middle text-start" v-for="(objetivos,index) in objetivos_ligados">
                                                            <th scope="row" v-if="objetivos.nombre_pilares == 'Excelencia Operativa'">{{objetivos.nombre_objetivos}}</th>
                                                            <td v-if="objetivos.nombre_pilares == 'Excelencia Operativa'">
                                                                <label class="text-primary" v-if="buscarCoincidencias(objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')')">
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].valor}}</b><!--Imprimir el valor-->
                                                                   <!-- {{sumaExcelenciaValor(sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].valor)}}-->
                                                                </label>
                                                                <label class="text-primary" v-else>
                                                                    <b>$0.00</b>
                                                                </label>
                                                            </td>
                                                            <td v-if="objetivos.nombre_pilares == 'Excelencia Operativa'">
                                                                <label class="text-success" v-if="buscarCoincidencias(objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')')">
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].sustentable}}</b><!--Imprimir sustentable-->
                                                                    <!--{{sumaExcelenciaSustentable(sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].sustentable)}}-->
                                                                </label>
                                                                <label class="text-success" v-else>
                                                                    <b> 0.00</b>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tablasBatery4 col-3 px-1 px-lg-2">
                                                <div class="d-flex text-center text-white pb-1">
                                                    <span class="col-6 subtitulo" style="margin-top:6px">Investigacion y desarrollo</span>
                                                    <table class="col-6  mt-1  text-center  table-bordered border-dark  ">
                                                        <thead>

                                                        </thead>
                                                        <tbody class="bg-white text-dark">
                                                            <tr>
                                                                <td><b>Valor</b></td>
                                                                <td class="text-primary"><b>$0.0</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Sust.</b></td>
                                                                <td class="text-success"><b>0.00</b></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <table class=" table table-bordered border-dark ">
                                                    <thead class="align-middle">
                                                        <th>Objetivo Estrategíco</th>
                                                        <th>Valor <br>(MXN)</th>
                                                        <th>Sustentable <br>(t CO2)</th>
                                                    </thead>
                                                    <tbody class="bg-white">
                                                        <tr class="align-middle text-start" v-for="objetivos in objetivos_ligados">
                                                            <th scope="row" v-if="objetivos.nombre_pilares == 'Investigación y Desarrollo'">{{objetivos.nombre_objetivos}}</th>
                                                            <td v-if="objetivos.nombre_pilares == 'Investigación y Desarrollo'">
                                                                <label class="text-primary" v-if="buscarCoincidencias(objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')')">
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].valor}}</b>
                                                                </label>
                                                                <label class="text-primary" v-else>
                                                                    <b>$0.00</b>
                                                                </label>
                                                            </td>
                                                            <td v-if="objetivos.nombre_pilares == 'Investigación y Desarrollo'">
                                                                <label class="text-success" v-if="buscarCoincidencias(objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')')">
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].valor}}</b>
                                                                </label>
                                                                <label class="text-success" v-else>
                                                                    <b>0.00</b>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-1 text-white d-flex align-items-center pieBateriaFondo">
                                        <div class="col-3">
                                            <div class="d-flex align-content-start flex-wrap">
                                                <img src="img/EneryaLogo.png" style="width: 160px; height: 50px;">
                                            </div> 
                                            <div>
                                                <img src="img/RiasaLogo.png" style="width: 165px; height: 50px;">
                                            </div>
                                        </div>
                                        <div class="col-3 text-start">
                                            <div class="mb-2">
                                                <i class="bi bi-check-circle"></i> Calidad
                                            </div>
                                            <div class="lh-1">
                                                <i class="bi bi-check-circle"></i> Servicio y <br>orientación <br>al cliente
                                            </div>            
                                        </div>
                                        <div class="col-3 text-start ">
                                            <div class="mb-2">
                                                <i class="bi bi-check-circle"></i> Trabajo en equipo
                                            </div>
                                            <div class="mb-2">
                                                <i class="bi bi-check-circle"></i> Productividad
                                            </div>
                                            <div class="lh-1">
                                                <i class="bi bi-check-circle"></i> Desarrollo de <br> nuestra gente   
                                            </div>         
                                        </div>
                                        <div class="col-3 text-start">
                                            <div class="mb-2">
                                                <i class="bi bi-check-circle"></i> Compromiso
                                            </div>
                                            <div class="mb-2">
                                                <i class="bi bi-check-circle"></i> Integridad
                                            </div>
                                            <div>
                                            <i class="bi bi-check-circle"></i> Inovación
                                            </div>         
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!----------------------------------FIN CONTENIDO BATERIA--->
                        </div>
                    </div>
                  </div>
                </div>
            <div v-if="ventana == 'Reportes'">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Enero</th>
                            <th>Febrero</th>
                            <th>Marzo</th>
                            <th>Abril</th>
                            <th>Mayo</th>
                            <th>Junio</th>
                            <th>Julio</th>
                            <th>Agosto</th>
                            <th>Septiembre</th>
                            <th>Octubre</th>
                            <th>Noviembre</th>
                            <th>Diciembre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="objetivo in objetivos_ligados">
                            <th>{{objetivo.nombre_objetivos}}</th>
                            <td v-for="x in 12"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="ventana == 'Calendario'">
                    <div class="input-group mt-3 mb-2 ">
                        <span class="input-group-text">Seleccione año</span>
                        <select v-model="select_anio_calendario" @change=consultarCalendarioProyectos()>
                            <option v-for="(year,index) in years" :value="year">{{year}}</option>
                        </select>
                    </div>
                            <div class="scroll-dos">
                                    <table class="table table-bordered table-striped table-hover text-center">
                                        <thead>
                                            <tr  style="font-size:10px;">
                                                <th style="min-width:150px">Documento</th>
                                                <th style="min-width:250px">Nombre del Proyecto</th>
                                                <th>Estatus </th>
                                                <th>Enero</th>
                                                <th>Febrero</th>
                                                <th>Marzo</th>
                                                <th>Abril</th>
                                                <th>Mayo</th>
                                                <th>Junio</th>
                                                <th>Julio</th>
                                                <th>Agosto</th>
                                                <th>Septiembre</th>
                                                <th>Octubre</th>
                                                <th>Noviembre</th>
                                                <th>Diciembre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="proyectosXanioCalendario.length>0" v-for="(proyectosXanio,indexa) in proyectosXanioCalendario">
                                                <th>
                                                <template v-for ="cantidadArchivos in cantidadDocumentos"><!--Contine ID y Cantidad de documentos-->
                                                    <button v-if="cantidadArchivos.id==proyectosXanio.id && parseInt(cantidadArchivos.cantidad)>0" type="button" class="btn btn-success" title="Visualizar"  @click="modal_estatus(proyectosXanio.id)" style="font-size:10px"><i class="bi bi-file-earmark"></i><!--Si el ID es igual-->
                                                        {{cantidadArchivos.cantidad}} Archivo/s
                                                    </button>
                                                    <button v-if="cantidadArchivos.id==proyectosXanio.id && parseInt(cantidadArchivos.cantidad)<=0" type="button" class="btn btn-secondary" title="Sin Documentos" style="font-size:10px"><i class="bi bi-file-earmark"></i>
                                                        {{documentos_seguimiento_captura.length}} Archivo/s
                                                    </button>
                                                </template>
                                                </th>
                                                <td class="text-start" style="font-size:10px;">{{proyectosXanio.nombre_proyecto}}</td>
                                                <td>
                                                    <!--<span class="badge bg-dark" style=" font-size: 8px" v-if="cantidadMesesRegistrados[proyectosXanio.id]>11">Finalizado</span><br>-->
                                                    <span v-if="proyectosXanio.status_seguimiento=='Cerrado'" class="badge bg-dark" style="font-size: 8px">Finalizado</span> 
                                                    <span v-else class="badge bg-success" style=" font-size: 8px">Seguiendo</span>
                                                </td>
                                                <td v-for="x in 12">
                                                    <template v-for="proyectosDatosCalendario in proyectosDatosCalendario">
                                                        <div v-if="proyectosDatosCalendario.proyectoID==proyectosXanio.id && proyectosDatosCalendario.mes==x && proyectosDatosCalendario.anio==select_anio_calendario" >
                                                            <i class="bi bi-check2"></i>
                                                            <span class="badge rounded-pill alert-dark"  style=" font-size: 8px">Ahorro Duro:<br><label class="text-dark">{{proyectosDatosCalendario.ahorro_duro}}<label></span>
                                                            <span class="badge rounded-pill alert-warning"  style=" font-size: 8px">Ahorro Suave:<br>{{proyectosDatosCalendario.ahorro_suave}}</span>
                                                            <!--<span class="badge bg-dark" style=" font-size: 8px">Finalizado</span>-->
                                                        </div>
                                                    </template>
                                                </td>
                                            </tr>
                                            <tr v-else>
                                                <td colspan="14">
                                                    <label>No existe seguimiento de proyectos {{select_anio_calendario}}</label>
                                                </td>
                                            </tr>
                                            <tr><!--Fila Totales-->
                                                <td></td>
                                                <td></td>
                                                <td class="align-middle" style="font-size:10px">Totales</td>
                                                <td v-for="x in 12" style="font-size:12px" class="text-start"><!--Columna de Sumas X Anio-->
                                                        <div v-show="calendarioSumaXMesAnio.sumas_ahorro_duro && calendarioSumaXMesAnio.sumas_ahorro_duro[x.toString()]" class="alert alert-dark" role="alert" style="min-width:170px;">
                                                                <label>Ah. S.: </label>&nbsp;<label> {{ calendarioSumaXMesAnio.sumas_ahorro_suave && calendarioSumaXMesAnio.sumas_ahorro_suave[x.toString()]}}</label>
                                                        <hr>
                                                                <label>Ah. D.: </label>&nbsp;<label> {{ calendarioSumaXMesAnio.sumas_ahorro_duro && calendarioSumaXMesAnio.sumas_ahorro_duro[x.toString()]}}</label>
                                                        </div>
                                                        
                                                </td>
                                            </tr>
                                            <tr><!--Fila Total Real-->
                                                <td></td>
                                                <td><!--{{checkValidar}}--></td>
                                                <td class="align-middle" style="font-size:10px">Total Real: </td>
                                                <td v-for="(x,index) in 12" style="font-size:12px" class="text-start"><!--Columna de Sumas X Anio-->
                                                        <div class="text-center" v-show="calendarioSumaXMesAnio.sumas_ahorro_duro && calendarioSumaXMesAnio.sumas_ahorro_duro[x.toString()]">
                                                            <?php if ($_SESSION['acceso']=="Financiero"){ ?>
                                                                <input class="text-primary" type="text" v-model="inputTotalReal[index]" @blur="darFormatoInputValorReal(x)" :disabled="checkValidar[index]"></input><br><!--Input activado solo para financieros-->
                                                                <label>Validar</label>&nbsp;
                                                                <input class="form-check-input" type="checkbox" v-model="checkValidar[index]"  @change="guardarValidacionFinanciera(x)" >
                                                            <?php }else{ ?>
                                                                <input class="text-primary" type="text" v-model="inputTotalReal[index]" @blur="darFormatoInputValorReal(x)" disabled></input><!--Input siempre desactivado para todos los usuarios-->
                                                            <?php } ?>
                                                            <br><label>Representante Financiero</label>
                                                            <br> <div class="text-primary" v-if="datosFinancieros[x.toString()] && datosFinancieros[x.toString()].validado">
                                                                        <!-- Tu contenido aquí si la posición existe y es válida -->
                                                                        {{ datosFinancieros[x.toString()].nombre}}<br>
                                                                        <span  class="badge bg-success" style="font-size: 8px">Liberado</span>
                                                                 </div>
                                                                <div v-else class="text-primary"><span class="badge bg-secondary" style="font-size: 8px">Sin liberar</span></div>
                                                        </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>

                                                <!-- Modal Eliminar/Actualizar Seguimiento-->
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel" >Documento</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                        <div class="text-center">
                                                <form @submit.prevent="uploadFile('Seguimiento')">
                                                    <!--Subir Documento Sugerencia-->
                                                    <!--<div v-if="cual_documento=='Seguimiento'" class="row" >
                                                        <div class="col-12">
                                                            <div class="custom-file mt-5 mb-3"> 
                                                            <input type="file" id="input_file_seguimiento" @change="varificandoSelecionSeguimiento()" ref="ref_seguimiento" multiple accept="*.jpg/*.png/*.pdf/*.doc/*.docx/*.ppt/*.pptx/*.xls/*.xlsx" class="btn btn-secondary  ms-2 p-0" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-12" v-if="existeImagenSeleccionadaSeguimiento && login!=true" >
                                                            <button  type="submit" name="upload" class="btn btn-primary">Subir Archivos </button>
                                                        </div>
                                                        <div v-if="login==true" class="d-flex justify-content-center">
                                                            <div>
                                                                <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                          <!-- Mostrando los archivos cargados SEGUIMIENTO-->
                                                        <div v-if="cual_documento=='Seguimiento'" v-show="documentos_seguimiento_financiero.length>0" >
                                                        <hr>
                                                                <div class="col-12" v-for= "(archivos,index) in documentos_seguimiento_financiero">
                                                                    <div class="row">
                                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                                            <!--<div class="mt-1">
                                                                                <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;" >Eliminar</button>
                                                                            </div>-->
                                                                    </div>
                                                                    <!--Mostar los JPG y PNG-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                                        <img  :src="documentos_seguimiento_financiero[index]" style="width:50%" class="mb-5"></img>
                                                                    </div>
                                                                     <!--Mostrar PDF-->
                                                                     <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'"  class="col-12 text-center">
                                                                     {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                                            <iframe  :src="documentos_seguimiento_financiero[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
                                                                    </div>
                                                                    <!--Mostrar Word-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                                <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                    <!--Mostrar Excel-->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                                <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                    <!--Mostrar Power Point -->
                                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                                    {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                                            <a :href="archivos" :download="nombre_de_descarga">
                                                                            <img  src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
                                                                            </a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                </form>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                                </div>
                            </div>
                    </div>
                <!--Fin Modal subir seguimiento-->


                            
                </div> 
                <!--////////////////////////////////////////////// FIN DE COMPETENCIA -->
            </div><!--cuerpo-->

            <div class="footer row" style="min-height:10vh;"> <!--pie-->

            </div>
        </div><!--div motando js-->
        <script src="js/app.js?<?php echo time(); ?>"></script>

    </body>

    </html>

<?php
} else {
    header("Location:index.php");
} ?>