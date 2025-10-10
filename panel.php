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
                        <button class="btn-menu " @click="ventana='Crear',opcion=1,consultarMisionesRelacional(),consultarObjetivosRelacional(),consultarMisiones(),consultarImpactoAmbientalConDocumentos(),consultarEstandaresCO2(),consultarFuentes(),mostrarHeader=true,sumarSoloUnaVez=0,sumaImpactoAmbiental()"
                            :class="{'btn-menu-activo': opcion===1,'btn-menu': opcion !== 1}"><!--buscarDocumentos('Documento CO2')-->
                            <i class="bi bi-plus-circle"></i> Crear Catálogos
                        </button>
                    <?php } ?>
                    <button class="btn-menu me-0  mx-sm-3 mt-sm-3" @click="ventana='Altas',opcion=2,mostrarHeader=true,sumarSoloUnaVez=0"
                        :class="{'btn-menu-activo': opcion===2,'btn-menu': opcion !== 2}">
                        <i class="bi bi-plus-circle"></i> Proyectos Creados
                    </button>

                    <button class="btn-menu mb-sm-3 mt-sm-3" @click="ventana='Seguimiento',mostrarHeader=true,opcion=3,sumarSoloUnaVez=0,opcion=3"
                        :class="{'btn-menu-activo': opcion===3,'btn-menu': opcion !== 3}"><!--buscarDocumentos('Documento CO2')-->
                        <i class="bi bi-plus-circle"></i> Seguimiento
                    </button>

                    <?php if ($_SESSION['acceso'] == 'Admin' || $_SESSION['acceso'] == 'Financiero') { ?>
                        <button class="btn-menu ms-sm-3 mb-sm-3" @click="ventana='Calendario',opcion=5,mostrarHeader=true,consultarPlantas(),  consultarCalendarioProyectos()"
                            :class="{'btn-menu-activo': opcion===5,'btn-menu': opcion !== 5}">
                            <i class="bi bi-plus-circle"></i> Estatus Captura
                        </button>
                    <?php } ?>

                    <button class="btn-menu mb-sm-3 ms-sm-3  " @click="ventana='Generar Valor',opcion=4,consultarObjetivosRelacional(),mostrarHeader=false,consultarSeguimientos(),valoresProyectos('')"
                        :class="{'btn-menu-activo': opcion===4,'btn-menu': opcion !== 4}">
                        <i class="bi bi-plus-circle"></i> Generando Valor Sustentable
                    </button>

                    <button class="btn-menu mb-sm-3 ms-sm-3  " @click="ventana='Valores Gonher',opcion=6,valoresProyectos('grafica')"
                        :class="{'btn-menu-activo': opcion===6,'btn-menu': opcion !== 6}">
                        <i class="bi bi-plus-circle"></i> Valores Gonher
                    </button>
                    <!--<button class="btn-menu" @click="ventana='Reportes'">
                        <i class="bi bi-plus-circle"></i> Reportes
                    </button>-->


                    <!--Modal Alta Proyectos-->
                    <div id="modal-alta-proyecto" class="modal text-start" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title me-5"> {{titulo_modal}}</h6><label style="font-size: 16px; color: #ec9826; text-shadow: 0px 1px #fff;" v-show="actualizar_proyecto">{{titulo_nombre_proyecto}}</label>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="verificarSiEsActualizar()"></button>
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
                                                <div v-if="selectFuente !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>

                                            <!---Planta-->
                                            <div class="input-group mb-3 ">
                                                <span class="input-group-text w-25">Planta</span>
                                                <select v-model="selectPlanta" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectPlanta === '', '': selectPlanta !== ''}">
                                                    <option value="" selected disabled>Seleccione..</option>
                                                    <option v-for="planta in plantas" :value="planta.id +'<->'+ planta.nombre+'<->'+planta.siglas">{{planta.nombre}} ({{planta.siglas}})</option>
                                                </select>
                                                <div v-show="actualizar_proyecto==false" class="flex-column">
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
                                                <div v-show="actualizar_proyecto==false">
                                                    <div class="col-12"><button class="btn-anadir" title="Crear" @click="abrirModal('CRUD','Área','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Área','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarArea()"><i class="bi bi-x-circle"></i></button></div>
                                                </div>
                                                <div v-if="selectArea !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>

                                            <!---Departamentos-->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25">Gerencia</span>
                                                <select v-model="selectDepartamento" size="3" class="w-50" :class="{'nocontestado': respondio === false && selectDepartamento === '', '': selectDepartamento !== ''}">
                                                    <option selected disabled>Seleccione..</option>
                                                    <option v-for="departamento in departamentos" :value="departamento.id+'<->'+departamento.nombre+'<->'+departamento.siglas">{{departamento.nombre}} ({{departamento.siglas}})</option>
                                                </select>
                                                <div v-show="actualizar_proyecto==false">
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
                                                <div v-show="actualizar_proyecto==false">
                                                    <div class="col-12"><button class="btn-anadir" title="Crear " @click="abrirModal('CRUD','Metodología','Crear')"><i class="bi bi-plus-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-up" title="Actualizar" @click="abrirModal('CRUD','Metodología','Actualizar')"><i class="bi bi-arrow-up-circle"></i></button></div>
                                                    <div class="col-12"><button class="btn-delete" title="Eliminar" @click="eliminarMetodologia()"><i class="bi bi-x-circle"></i></button></div>
                                                </div>
                                                <div v-if="selectMetodologia !==''" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>
                                            <!---Responsables-->
                                            <div v-if="actualizar_proyecto==false" class="d-flex d-flex-row justify-content-center">
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
                                                    <button type="button" v-if="actualizarResponsable" class="btn-actualizar-responsable" @click="actualizandoResponsable()">Actualizar</button>
                                                    <button type="button" class="btn-cancelar-responsable mt-3" @click="cancelar()">Cancelar</button>
                                                </div>
                                            </div>
                                            <!--Observadores-->
                                            <div class="input-group">
                                                <span class="input-group-text w-25">Observador (Opcional)</span>
                                                <div class="scroll w-50">
                                                    <div class="form-check border border-1 mt-1" v-for="(responsable, index) in responsables" :key="index">
                                                        <input class="form-check-input" type="checkbox" :value="responsable.nombre+'<->'+responsable.numero_nomina" v-model="checkObservadores">
                                                        <label :class="{'text-danger  fw-bold':responsable.numero_nomina=='Pte'}" class="form-check-label ">
                                                            {{ responsable.nombre }} <span v-show="responsable.numero_nomina=='Pte'" class="badge bg-danger text-white ">(Sin Nómina)</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>



                                            <!--Misiones-->

                                            <div class="input-group mb-3 mt-3 ">
                                                <span class="input-group-text w-25 text-start">Misión </span>
                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && checkMisiones.length<=0, '': checkMisiones.length>0}">
                                                    <div class="form-check border border-1 mt-1" v-for="(mision, index) in misiones" :key="index">
                                                        <input class="form-check-input" type="checkbox" :value="mision.id+'<->'+mision.nombre" v-model="checkMisiones" @change="consultarPilaresXmisionSeleccionada()" :disabled="actualizar_proyecto">
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
                                                        <input class="form-check-input" type="checkbox" :value="pilar.id+'<->'+pilar.nombre+'<->'+pilar.siglas+'<->'+(index+1)" v-model="checkPilares" @change="consultarObjetivosXpilaresSeleccionados()" :disabled="actualizar_proyecto">
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
                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && checkObjetivos.length<=0 || respondio === false && selectObjetivo.length>0 && !selectObjetivo.includes('directo'), '': checkObjetivos.length>0}">
                                                    <div v-for="(objetivo, index) in objetivos" class="form-check border border-1 mt-1" :key="index">
                                                        <input class="form-check-input" v-model="checkObjetivos" type="checkbox" id="checkbox1" :value="objetivo.id+'<->'+objetivo.nombre+'<->'+objetivo.id_pilares+'<->'+objetivo.siglas+'<->'+(index+1)" @change="checkeandoObjetivos()" :disabled="actualizar_proyecto">
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
                                                <span class="input-group-text w-25 text-start">Impacto <br>Ambiental<br><label class=""><i class="bi bi-question-circle"></label></i></span>
                                                
                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && checkImpactoAmbiental.length<=0 || respondio === false && checkImpactoAmbiental.length>0 && checkImpactoAmbiental.filter(elemento => elemento !='').length != selectEmisiones.filter(elemento => elemento !='').length, '': checkImpactoAmbiental.length>0}">
                                                    <div v-for="(impacto,index) in impactoAmbiental" class="form-check border border-1  mt-1">
                                                        <input class="form-check-input" type="checkbox" id="checkbox1" v-model="checkImpactoAmbiental" :value="impacto.id+'<->'+impacto.nombre" @change="checkeandoImpactoAmbiental(impacto.id,impacto.nombre)" :disabled="verificarImpacto(impacto.id+'<->'+impacto.nombre)" />
                                                        <label class="form-check-label w-75" for="checkbox1">
                                                            {{impacto.nombre}}
                                                        </label>
                                                        <label class="w-25" v-if="idsCheckImpacto.includes(impacto.id) && checkImpactoAmbiental.length>0">
                                                            <select v-model="selectEmisiones[index]" class="w-100">
                                                                <option v-show="!selectEmisiones[index]" value="" selected disabled>Seleccione...</option>
                                                                <option :value="impacto.id+'<->'+impacto.nombre+'-> Alcance 1'" title="Emisiones directas de GEI">Alcance 1</option>
                                                                <option :value="impacto.id+'<->'+impacto.nombre+'-> Alcance 2'" title="Emisiones indirectas de GEI asociadas a la electricidad">Alcance 2</option>
                                                                <option :value="impacto.id+'<->'+impacto.nombre+'-> Alcance 3'" title="Otras emisiones indirectas de GEI">Alcance 3</option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div v-if="checkImpactoAmbiental.length>0" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>

                                            <!--Valores Gonher-->
                                            <div class="input-group mb-3 mt-3 ">
                                                <span class="input-group-text w-25">Valores</span>
                                                <div class="div-mision-pilares-impacto" :class="{'nocontestado': respondio === false && valoresCheck.length<=0, '': valoresCheck.length>0}">
                                                    <div class="form-check border border-1 mt-1" v-for="(valor, index) in valores" :key="index">
                                                        <input class="form-check-input" type="checkbox" :value="valor.valor" v-model="valoresCheck">
                                                        <label class="form-check-label" :class="{'valor-calidad':'Excelencia'==valor.valor,'valor-trabajo':'Colaboración'==valor.valor, 'valor-compromiso':'Compromiso'==valor.valor,'valor-servicio':'Servicio'==valor.valor, 'valor-desarrollo':'Desarollo'==valor.valor,'valor-integridad':'Integridad'==valor.valor,'valor-innovacion':'Innovación'==valor.valor}">
                                                            {{ valor.valor }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div v-if="valoresCheck.length>0" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                            </div>
                                            <!-- <div v-if="actualizar_proyecto==true">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-50">Tons CO2 por Evitar (Proyectado)</span>
                                                            <input id="tons_co2" type="text" v-model="tons_co2" min="0" class="w-25" :class="{'nocontestado': respondio === false && (tons_co2 == 0 || tons_co2 == '' ), '': respondio !== false && tons_co2 !== 0 && tons_co2 !== ''}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputSinPesos('tons_co2')"
                                                            :disabled="actualizar_proyecto">
                                                            <div v-if="tons_co2 !== '' && tons_co2 !== '0'" class="text-center my-auto ms-3">
                                                                <i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i>
                                                            </div>
                                                        </div>

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-50">Ahorro Duro $MXN/Año (Proyectado )</span>
                                                            <input id="ahorro_duro" type="text" v-model="ahorro_duro" min="0" class="w-25" :class="{'nocontestado': respondio === false && ahorro_duro==='$.00', '': respondio !== false && ahorro_duro!==0 && ahorro_duro!==''}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('ahorro_duro')"
                                                            :disabled="actualizar_proyecto">
                                                            <div v-if="ahorro_duro!=='' && ahorro_duro !== '$0.00' && ahorro_duro !== '$.00' && ahorro_duro !== '$.0' && ahorro_duro !== '$.'  && ahorro_duro !== '$'" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>
                                                
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text w-50">Ahorro Suave $MXN/Año (Proyectado)</span>
                                                            <input id="ahorro_suave" type="text" v-model="ahorro_suave" min="0" class="w-25" :class="{'nocontestado': respondio === false && ahorro_suave==='$.00', '': respondio === false && ahorro_suave!==0 && ahorro_suave!==''}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('ahorro_suave')"
                                                            :disabled="actualizar_proyecto">
                                                            <div v-if="ahorro_suave!=='' && ahorro_suave !== '$0.00' && ahorro_suave !== '$.00' && ahorro_suave !== '$.0' && ahorro_suave !== '$.'  && ahorro_suave !== '$'" class="text-center my-auto ms-3"><i class="bi bi-check-circle text-light rounded-circle px-1 py-1 bg-success"></i></div>
                                                        </div>
                                                </div>-->
                                            <!--bloque1-->
                                            <!--<div class="col-12 d-flex ">
                                                    <div class="text-center d-flex align-items-center pb-3">
                                                        <div class="rounded-circle bg-success mx-2 text-white d-flex justify-content-center align-items-center btn-menu" @click="incrementarMeses()"  style=" width: 40px;height:40px; font-weight:bold; cursor: pointer;">   
                                                                <i class="bi bi-plus"></i>
                                                        </div>
                                                        <span class="badge alert-info">
                                                            Presione la cántidad de meses que desea agregar. {{cantidadMeses}} {{anio_select}}
                                                        </span>
                                                    </div>
                                                </div>-->

                                            <!--<div class="row border border-1 mx-1 mb-1 div-color-cajas" v-for="(item, index) in cantidadMeses" :key="index">
                                                        <span class="badge alert-secondary mb-2 mx-auto">
                                                            Mes {{index+1}}
                                                        </span>
                                                                    <div class="col-3 mb-3">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text w-50">Anio</span>
                                                                            <select :value="anio_select" class="w-50 bg-white">
                                                                                <option v-for="year in years" :value="year">{{year}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3 mb-3">
                                                                        <div class="input-group">
                                                                            <span class="input-group-text w-50">Mes</span>
                                                                            <select v-model="mesDinamico[index]" class="w-50 bg-white">
                                                                                <option v-for="(month, monthIndex) in months" :value="(monthIndex + 1)">{{month}}</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-8">
                                                                            <div class="input-group mb-3">
                                                                            <span class="input-group-text w-50">Tons CO2 por Evitar (Proyectado)</span>
                                                                            <input type="text" min="0" class="w-25" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputSinPesos('tons_co2')"
                                                                            :disabled="actualizar_proyecto">
                                                                            </div>

                                                                            <div class="input-group mb-3">
                                                                            <span class="input-group-text w-50">Ahorro Duro $MXN/Año (Proyectado )</span>
                                                                            <input  type="text" min="0" class="w-25" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('ahorro_duro')"
                                                                            :disabled="actualizar_proyecto">
                                                                            </div>

                                                                            <div class="input-group mb-3">
                                                                                <span class="input-group-text w-50">Ahorro Suave $MXN/Año (Proyectado)</span>
                                                                                <input  type="text" min="0" class="w-25" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44)" @blur="formatInputPesos('ahorro_suave')"
                                                                                :disabled="actualizar_proyecto">
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-4 text-center">
                                                                            <div class="rounded-circle bg-danger mx-2 text-white d-flex justify-content-center align-items-center btn-menu" @click="quitarMeses()"  style=" width: 40px;height:40px; font-weight:bold; cursor: pointer;">   
                                                                                <i class="bi bi-dash"></i>
                                                                            </div>
                                                                    </div>
                                                    </div>
                                                </div>-->
                                            <!--Finbloque-->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text w-25 me-2">Objetivo Estrategico</span>
                                                <input type="checkbox" v-model="objetivo_estrategico" :disabled="actualizar_proyecto">

                                                <div class="d-flex align-items-center ps-5">
                                                    <div class="form-check form-switch">
                                                       <!--  <label class="form-check-label" for="switchCheckDefault">Presupuestado</label> -->
                                                        <input :style="{ backgroundColor: colorPresupuestado ? '#f4ca31ff' : '#B3F09B'}" class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault" v-model="presupuestado" @change="proyectoSIoNOpresupuestado()" >
                                                        <label class="fw-light text-sm">
                                                            <strong>{{ presupuestado ? 'Presupuestado' : 'No presupuestado' }}</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 my-auto mx-auto "><!--bloque imagen Alta Proyecto-->
                                            <form @submit.prevent="uploadFile('Alta Proyecto')">
                                                <div class="row mx-auto">
                                                    <input type="file" id="input_file_subir" @change="varificandoSelecion()" ref="ref_imagen" accept="*.jpg/*.png" class="btn-success py-1" required :disabled="actualizar_proyecto" />
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
                                    <div class="col-12 pb-2">
                                        <table class="table table-striped table-bordered">
                                            <thead class="text-center">
                                                <tr class="sin-fondo">
                                                    <th>Ahorro</th> 
                                                    <th scope="col" v-for="(numero, index) in 12"> 
                                                        <div style="display: flex; justify-content: center; align-items: center">
                                                            <div class="form-check form-switch"> 
                                                                <input :style="{ backgroundColor: mesesPresupuestados[index] ? '#f4ca31ff' : '#B3F09B'}" v-model="mesesPresupuestados[index]" class="form-check-input" type="checkbox" role="switch" :id="'switch' + index">
                                                            </div>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Año</th>
                                                    <th scope="col" v-for="(numero,index) in 12">
                                                        <select v-model="AnioXMes[numero-1]" style="width:70px" @change="cambiandoMes(MesXAnio[0], AnioXMes[0])" :disabled="index!=0 || hayDatos==true">
                                                            <option v-for="(year,index) in years.slice().reverse()" :value="year">{{year}}</option><!--asi los anio me aparecen del menor al mayor-->
                                                        </select>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Mes</th>
                                                    <th scope="col" v-for="(valor, index) in 12">
                                                        <select v-model="MesXAnio[index]" style="width:70px" :disabled="index!=0 || hayDatos==true" @change="cambiandoMes(MesXAnio[0], AnioXMes[0]) ">
                                                            <option v-for="(month,index) in months" :value="index+1">{{month}}</option>
                                                        </select>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="align-middle">
                                                    <td scope="row" style="font-size: 0.9em;">Tons CO2 x Evitar</td>
                                                    <td v-for="numero in 12">
                                                        <!--<div v-if="flagEditCOMes!==numero" class="d-flex flex-column">
                                                                        <button class="w-100" style="border-style: outset; border-width: 1.5px; height: 24px;"  @click="editarCOMes(numero)"><i class="bi bi-pencil-fill"></i></button>
                                                                        <input class="w-100" type="text" :value="inputValorMensualCO[numero-1]" disabled> </input>
                                                                    </div>  
                                                                    <div v-else class="d-flex flex-column">-->
                                                        <!--<button class="w-100"  style="border-style: outset; border-width: 1.5px; height: 24px; background:#bae3a3; color:9cc783" ><i class="bi bi-floppy-fill"></i></button>    @click="guardarPlanMes(x)"-->
                                                        <input class="w-100" v-model="inputValorMensualCO[numero-1]" type="text" @blur="formatInputSinPesosCO(numero-1)"> </input>
                                                        <!--</div>-->
                                                    </td>
                                                </tr>
                                                <tr class="align-middle">
                                                    <td scope="row" style="font-size: 0.9em;">Ahorro Duro $MXN</td>
                                                    <td v-for="numero in 12">
                                                        <!--<div v-if="flagEditAhorroDuroMes!==numero" class="d-flex flex-column">
                                                                        <button class="w-100" style="border-style: outset; border-width: 1.5px; height: 24px;"  @click="editarADMes(numero)"><i class="bi bi-pencil-fill"></i></button>
                                                                        <input class="w-100" type="text" :value="inputValorMensualAD[numero-1]" disabled> </input>
                                                                    </div>  
                                                                    <div v-else class="d-flex flex-column">
                                                                        <button class="w-100"  style="border-style: outset; border-width: 1.5px; height: 24px; background:#bae3a3; color:9cc783" ><i class="bi bi-floppy-fill"></i></button>--> <!-- @click="guardarPlanMes(x)"-->
                                                        <input class="w-100" v-model="inputValorMensualAD[numero-1]" type="text" @blur="darFormatoInputValorMensual(numero-1,'AD')"> </input>
                                                        <!--</div>-->
                                                    </td>
                                                </tr>
                                                <tr class="align-middle">
                                                    <td scope="row" style="font-size: 0.9em;">Ahorro Suave $MXN</td>
                                                    <td v-for="numero in 12">
                                                        <!--<div v-if="flagEditAhorroSuaveMes!==numero" class="d-flex flex-column">
                                                                        <button class="w-100" style="border-style: outset; border-width: 1.5px; height: 24px;"  @click="editarASMes(numero)"><i class="bi bi-pencil-fill"></i></button>
                                                                        <input class="w-100" type="text" :value="inputValorMensualAS[numero-1]" disabled> </input>
                                                                    </div>  
                                                                    <div v-else class="d-flex flex-column">
                                                                        <button class="w-100"  style="border-style: outset; border-width: 1.5px; height: 24px; background:#bae3a3; color:9cc783" ><i class="bi bi-floppy-fill"></i></button>--> <!-- @click="guardarPlanMes(x)"-->
                                                        <input class="w-100" v-model="inputValorMensualAS[numero-1]" type="text" @blur="darFormatoInputValorMensual(numero-1,'AS')"> </input>
                                                        <!--</div>-->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="boton-cancelar" data-bs-dismiss="modal" @click="reiniciarVariables()">Salir</button>
                                    <button v-if="actualizar_proyecto==false" type="button" class="boton-aceptar" @click="verificarAltaProyecto()">Crear</button>
                                    <button v-if="actualizar_proyecto==true" type="button" class="boton-actualizar" @click="guardarAltaProyecto('Actualizar Proyecto')">Actualizar</button>
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
                <div class="text-center mt-2" v-if="ventana=='Altas'">
                    <div class="col-12" >
                        <div class= "row">
                            <!-- Select de los nombre de los proyectos -->
                            <div class="col-4">
                                <div class="input-group mt-3 mx-2 mb-2 ">
                                    <span class="input-group-text w-5">Seleccione Proyecto</span>
                                    <select class="w-50"  @keydown.up="cancelarEvento" @keydown.down="cancelarEvento" @keydown.left="cancelarEvento" @keydown.right="cancelarEvento" @change= "proyectoSeleccionado()" v-model="id_proyecto">
                                        <option value="" default>Todos...</option>
                                        <option  style="font-size:15px;" v-for="proyecto in proyectoSelect" :key="proyecto.id" :value="proyecto.id">{{ proyecto.nombre_proyecto }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- BOTÓN ALTA PROYECTOS -->
                            <div class="col-4">
                                <?php if ($_SESSION['acceso'] == 'Admin') { ?>
                                <button class="btn btn-menu bg-primary align-items-center mb-2" style=" background:#519f3c; " @click="abrirModal('Alta')">
                                    <i class="bi bi-plus-circle"></i> Alta Proyecto
                                </button>
                            <?php } ?></div>
                        </div>
                    </div>
                    

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
                                <!--<th>Teléfono</th>-->
                                <th>Pilare(s) Estratégico(s)</th>
                                <th style="min-width:230px;">Objetivo(s) Estratégico(s)</th>
                                <th style="min-width:230px;">Impacto Ambiental</th>
                                <th style="min-width:230px;">Valores</th>
                                <th>Presupuestado</th>
                                <th>Tons CO2 por Evitar <br>(Proyectado)</th>
                                <th>Ahorro Duro $MXN/Año <br>(Proyectado )</th>
                                <th>Ahorro Suave $MXN/Año <br>(Proyectado)</th>
                                <th>Estatus</th>
                                <?php if ($_SESSION['acceso'] == 'Admin') { ?>
                                    <th>Eliminar</th>
                                    <th>Actualizar</th>
                                <?php } ?>
                            </thead>
                            <tbody class=" border:1px solid black" style="text-align: center">
                                <template v-for="(proyecto,index) in proyectos">
                                    <tr v-if="folioAnteriorSinNumeral(proyecto.folio, index)" :class="{ 'divisor-tr-creados': folioAnteriorSinNumeral(proyecto.folio, index)==true}">
                                        <td colspan="21" v-if="index>0"></td>
                                    </tr><!-- Pero como como puedo hacer que se pinte el index actual u el siguiente que ees con el que se esta comparando??? -->
                                    <tr class="cuerpo-tabla-creados border border-secondary" style="vertical-align: middle;" :class="{ 'AzulFuerte': proyecto.colorcito=='Amarillo'  ,'AzulClaro': proyecto.colorcito=='Roja'}"><!--:class="{'azul1': index % 2 === 0,'azul2': index % 2 !== 0, 'fila-ultimo-proyecto': buscandoUltimoProyectoCreado(proyecto.nombre_proyecto)}"-->
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
                                        <!--<td class="border border-secondary">{{proyecto.telefono}}</td>-->
                                        <td class="border border-secondary text-start">
                                            <ul v-if="proyecto.pilares">
                                                <li v-for="pilar in JSON.parse(proyecto.pilares)">{{pilar}}</li>
                                            </ul>
                                        </td>
                                        <td class="border border-secondary text-start">
                                            <ul v-if="proyecto.objetivos">
                                                <li v-for="objetivo in JSON.parse(proyecto.objetivos)">{{objetivo}}</li>
                                            </ul>
                                        </td>
                                        <td class="border border-secondary text-start">
                                            <ul v-if="proyecto.impacto_ambiental">
                                                <li v-for="impacto in JSON.parse(proyecto.impacto_ambiental)">{{impacto}}</li>
                                            </ul>
                                        </td>
                                        <td class="border border-secondary text-start">
                                            <ul v-if="proyecto.valores">
                                                <li v-for="(valor in JSON.parse(proyecto.valores)">
                                                    <label :class="{'valor-calidad':'Excelencia'===valor,'valor-trabajo':'Colaboración'===valor, 'valor-compromiso':'Compromiso'===valor,'valor-servicio':'Servicio'===valor, 'valor-desarrollo':'Desarollo'===valor,'valor-integridad':'Integridad'===valor,'valor-innovacion':'Innovación'===valor}">
                                                        {{valor}}
                                                        <label>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="border border-secondary text-center">
                                            {{proyecto.presupuestado}}
                                        </td>
                                        <td class="border border-secondary">{{proyecto.tons_co2}}<br> <label class="text-success" v-if="proyectoSumas[proyecto.id]"><b>{{proyectoSumas[proyecto.id].sumaTons}}<b><label></td>
                                        <td class="border border-secondary">{{proyecto.ahorro_duro}}<br> <label class="text-primary" v-if="proyectoSumas[proyecto.id]"><b>{{proyectoSumas[proyecto.id].sumaDuro}}<b><label></td>
                                        <td class="border border-secondary">{{proyecto.ahorro_suave}}<br> <label class="text-primary" v-if="proyectoSumas[proyecto.id]"><b>{{proyectoSumas[proyecto.id].sumaSuave}}<b><label></td>
                                        <td class="border border-secondary"><b><label v-if="proyecto.status_seguimiento!='Cerrado'" class="text-success">Siguiendo</label><label v-else="proyecto.status_seguimiento!='Cerrado'" class="text-danger">{{proyecto.status_seguimiento}}<label></b></td>
                                        <?php if ($_SESSION['acceso'] == 'Admin') { ?>
                                            <td class="border border-secondary"> <button class="rounded-circle bg-danger border border-secondary btn shadow-sm" @click="eliminarProyecto(proyecto.id,proyecto.nombre_proyecto)"><i class="bi bi-trash3-fill text-white"></i></button></td>
                                            <td><button type="button" class=" btn boton_actualizar mx-2" @Click="abrirModal('Actualizar Proyecto','','',proyecto.id,proyecto.nombre_proyecto)">Actualizar</button></td>
                                        <?php } ?>
                                    </tr>
                                </template>
                        </table>
                    </div>
                    <!---->
                </div>
                <!--------------------------CREAR PERFILES, PILARES OBJETIVOS---------------------------------->
                <div class="row" v-if="ventana=='Crear'">
                    <div class="d-flex justify-content-evenly">
                        <div>
                            <button type="button" class="btn btn-menu w-50 bg-primary mt-1" style="min-width:180px;" @click="descargarExcel()" title="Descargar">
                                <i class="bi bi-file-earmark-arrow-down"></i>Descargar Reporte</button>
                        </div>
                        <!--<div>
                            <button type="button" class="btn btn-menu w-100 bg-primary  mt-1 " style="min-width:180px;" @click="descargarExcelValores()" title="Descargar">
                            <i class="bi bi-file-earmark-arrow-down"></i>Descargar Reporte Valores</button>
                        </div>-->
                    </div>
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
                                    <div class="col-6 col-lg-4 mt-2">Pilares Estratégicos</div>
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
                                    <div class="col-6 col-lg-4 mt-2">Objetivos Estratégicos</div>
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

                    <!--TABLA DE IMPACTO AMBIENTAL-->
                    <div class="col-12 col-lg-12">
                        <div class="col-12  text-center ">
                            <div class=" encabezadoTablas">
                                <div class=" d-flex justify-content-center align-items-baseline " style="font-size: 0.9em;">
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
                                                Cántidad
                                            </th>
                                            <th class="sticky-top thmodal">
                                                Suma
                                            </th>
                                            <th class="sticky-top thmodal">
                                                Unidad Medida
                                            </th>
                                             <th class="sticky-top thmodal">
                                                Documentos
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
                                            <td class="text-start">
                                                {{impacto.cantidad}}
                                            </td>
                                            <td lass="text-start">
                                                <template v-for="(suma,indexImpacto ) in sumasImpactoAmbiental">
                                                    <label v-if="indexImpacto==impacto.nombre" class="bg-success rounded-pill w-100 text-white ps-2  text-start">{{suma}}</label>
                                                </template>
                                            </td>
                                             <td class="text-start">
                                                {{impacto.unidad_medida}}
                                            </td>
                                            <td>
                                            <button v-if="impacto.documentos<=0"  type="button" class="btn btn-secondary" title="Subir archivos" @click="modal_impactoAmbiental(impacto.id,impacto.nombre)" style="font-size:10px"><i class="bi bi-paperclip"></i>{{impacto.documentos}} Archivos Encontrados</button>
                                            <button v-else type="button"  class="btn btn-success " title="Visualizar/Subir Archivos" @click="modal_impactoAmbiental(impacto.id,impacto.nombre)" style="font-size:10px"><i class="bi bi-paperclip"></i>{{impacto.documentos}} Archivos Encontrados</button>
                                            </td>
                                            
                                            <td>
                                                <button type="button" class="myButton" @click="eliminarImpactoAmbiental(impacto.id)"><i class="bi bi-trash3-fill"></i></button>
                                            </td>
                                            <td>
                                                <button type="button" class="myButton2" @Click="modalCatalogos('Actualizar','Impacto Ambiental',impacto.id,impacto.nombre,impacto.cantidad,'',impacto.unidad_medida)"><i class="bi bi-pencil"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- INICIO TABLA ESTANDARES CO2 -->
                    <!--<div class="col-12 col-lg-6 ">
                        <div class="col-12 text-center align-content">
                            <div class=" encabezadoTablas">
                                <div class=" d-flex justify-content-center align-items-center " style="font-size: 0.9em;">
                                    <div class="d-none d-lg-block col-lg-4"></div>
                                    <div class="col-6 col-lg-4 mt-2 ">
                                        Estándares de CO2
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
                                                <button v-if="documentos_co2.length>0" type="button" class="btn btn-success" title="Visualizar/Subir Archivos" @click="modal_co2()" style="font-size:10px"><i class="bi bi-paperclip"></i>{{documentos_co2.length}} Archivos Encontrados</button>
                                                <button v-else type="button" class="btn btn-secondary" title="Visualizar/Subir Archivos" @click="modal_co2()" style="font-size:10px"><i class="bi bi-paperclip"></i>{{documentos_co2.length}} Archivos Encontrados</button>
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
                    </div>-->
                  
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
                                                <span class="input-group-text w-25 mt-3">Cántidad:</span>
                                                <input type="text" v-model="cantidad" class="w-75 mt-3">
                                                <span class="input-group-text w-25 mt-3">Unidad Medida:</span>
                                                <input type="text" v-model="unidadMedida" class="w-75 mt-3">
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
                                                <span class="input-group-text w-25 mt-3">Cántidad:</span>
                                                <input type="text" v-model="cantidad" class="w-75 mt-3">
                                                <span class="input-group-text w-25 mt-3">Unidad Medida:</span>
                                                <input type="text" v-model="unidadMedida" class="w-75 mt-3">
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
                    <div class="modal fade" id="modalImpactoAmbiental" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel">Subir documento/s <b>{{cual_impacto_nombre}}</b></h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <form @submit.prevent="uploadFile('Impacto Ambiental')" enctype="multipart/form-data">
                                            <!--Subir Documento Sugerencia-->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="custom-file mt-5 mb-3">
                                                        <input type="file" id="input_file_impactoAmbiental" @change="verificandoSelecionImpactoAmbiental()" ref="ref_impAmb" multiple accept="*.jpg/*.png/*.pdf/*.doc/*.docx/*.ppt/*.pptx/*.xls/*.xlsx" class="btn btn-secondary  ms-2 p-0" required />
                                                    </div>
                                                </div>
                                               
                                                <div class="col-12" v-if="existeDocumentoSeleccionadoImpacto && login!=true">
                                                    <button type="submit" name="upload" class="btn btn-primary">Subir Archivos </button>
                                                </div>
                                                <div v-if="login==true" class="d-flex justify-content-center">
                                                    <div>
                                                        <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Mostrando los archivos cargados -->
                                            <div v-show="documentos_impactoAmbiental.length>0">
                                                <hr>
                                                <div class="col-12" v-for="(archivos,index) in documentos_impactoAmbiental">
                                                    
                                                    <div class="row">
                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                        <div class="mt-1">
                                                            <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;">Eliminar</button>
                                                        </div>
                                                    </div>
                                                    <!--Mostar los JPG y PNG-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                       <!--  {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> -->
                                                        <img :src="documentos_impactoAmbiental[index]" style="width:50%" class="mb-5"></img>
                                                    </div>
                                                    <!--Mostrar PDF-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'" class="col-12 text-center">
                                                        <!-- {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> -->
                                                        <iframe :src="documentos_impactoAmbiental[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
                                                    </div>
                                                    <!--Mostrar Word-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Excel-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Power Point -->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
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

                    <!-- Modal Eliminar/Actualizar Documentos CO2-->
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel">Subir documentos</h6>
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
                                                <div class="col-12" v-if="existeImagenSeleccionadaCO2 && login!=true">
                                                    <button type="submit" name="upload" class="btn btn-primary">Subir Archivos </button>
                                                </div>
                                                <div v-if="login==true" class="d-flex justify-content-center">
                                                    <div>
                                                        <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Mostrando los archivos cargados -->
                                            <div v-show="documentos_co2.length>0">
                                                <hr>
                                                <div class="col-12" v-for="(archivos,index) in documentos_co2">
                                                    <div class="row">
                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                        <div class="mt-1">
                                                            <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;">Eliminar</button>
                                                        </div>
                                                    </div>
                                                    <!--Mostar los JPG y PNG-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                        <img :src="documentos_co2[index]" style="width:50%" class="mb-5"></img>
                                                    </div>
                                                    <!--Mostrar PDF-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                        <iframe :src="documentos_co2[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
                                                    </div>
                                                    <!--Mostrar Word-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Excel-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Power Point -->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
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
                                    <select class="w-50" @keydown.up="cancelarEvento" @keydown.down="cancelarEvento" @keydown.left="cancelarEvento" @keydown.right="cancelarEvento" @change="consultarImpactoAmbieltalXProyectoID(); verProyecto() " v-model="id_proyecto">
                                        <option value="" disabled>Seleccione...</option>
                                        <option v-for="proyecto in proyectos.sort((a, b) => a.nombre_proyecto.localeCompare(b.nombre_proyecto))" :value="proyecto.id" style="font-size:15px;">{{proyecto.nombre_proyecto}}</option>
                                    </select>
                                    <button v-show="id_proyecto!=''" v-if="documentos_seguimiento.length>0" type="button" class="btn btn-success" title="Visualizar/Subir Archivos" @click="modal_seguimiento()" style="font-size:12px"><i class="bi bi-paperclip">{{documentos_seguimiento.length}} Evidencias Encontrados</i></button>
                                    <button v-show="id_proyecto!=''" v-else type="button" class="btn btn-secondary" title="Visualizar/Subir Archivos" @click="modal_seguimiento()" style="font-size:12px"><i class="bi bi-paperclip">{{documentos_seguimiento.length}} Evidencias Encontrados</i></button>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div v-for="impacto in impactoAmbientalConID" class="input-group mt-3 mx-2 mb-2 d-flex justify-content-start justify-content-lg-center">
                                    <span class="input-group-text w-5">Documentos estandares CO
                                        <label style="font-size:8px" class="mt-1">2</label><br>
                                    </span> 
                                    <button v-if="impacto.documentos>0" type="button" class="btn btn-success text-start" title="Visualizar" @click="modal_impactoAmbiental(impacto.id,impacto.nombre)" style="font-size:12px; width: 300px"><i class="bi bi-file-earmark me-1">({{impacto.documentos}})</i>{{impacto.nombre}}</button>
                                    <button v-else type="button" class="btn btn-secondary text-start" title="Sin archivos de apoyo" style="font-size:12px; width: 300px"><i class="bi bi-file-earmark  me-1">({{impacto.documentos}})</i>{{impacto.nombre}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="scroll-dos">
                        <table class="mx-2 mb-5 table table-hover table-bordered table-striped text-center" style="font-size: 0.8em;">
                            <thead style="background: #848484; color:white;">
                                <tr>
                                    <?php if ($_SESSION['acceso'] != "Financiero") { ?>
                                        <th v-if="seguimiento_status" style="background: #848484; color:white;">Actualizar</th>
                                    <?php } ?>
                                    <th style="background: #848484; color:white;">Fecha</th>
                                    <th style="background: #848484; color:white;">Tons CO2 (Evitados) </th>
                                    <th style="background: #848484; color:white;" v-if="sinImpacto!='Sin Impacto'" v-for="(impacto,index) in columnaImpactoAmbiental" :key="index">{{impacto.split('->')[0]}}</th>
                                    <th style="background: #848484; color:white;">Ahorro Duro $MXN</th>
                                    <th style="background: #848484; color:white;">Ahorro Suave $MXN</th>
                                    <th style="background: #848484; color:white;">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-----------------------------------------------------------------------------CUANDO YA EXISTE MINIMO UN SEGUIMIENTO -->
                                <tr v-if="seguimientos>0" style="vertical-align: middle; font-size: 1.1em;" v-for="(proyecto,posicion) in arregloID" :key="posicion">
                                    <?php if ($_SESSION['acceso'] != "Financiero") { ?>
                                        <td v-if="seguimiento_status">
                                            <button v-if="actualizar==0 && actualizatabla == false && proyecto.validado!='Validado'" type="button" class="boton-actualizar" v-if="actualizatabla == false" @Click="asignarDatosActualizar(posicion)">Actualizar</button>
                                            <span v-if="actualizar==0 && actualizatabla == false && proyecto.validado=='Validado'" class="badge bg-primary" style="font-size:0.8em;">Mes validado x finanzas</span>
                                            <button v-if="actualizar==(posicion+1)" v-if="actualizatabla == true" class="boton-eliminar mx-2" @Click="actualizar = 0">Cancelar</button>
                                            <button v-if="actualizar==(posicion+1) && proyecto.id_registro " v-if="actualizatabla == true" class="boton-aceptar" @Click="actualizarSeguimiento(posicion)">Guardar</button><!--Guardar Actualizacion cuando existe minimo 1-->
                                        </td>
                                    <?php } ?>
                                    <td style="min-width: 351px;">
                                        <div v-if="actualizar==(posicion+1)">
                                           
                                            <label class="ms-1"> Mes: </label>
                                            <select v-model="mes_select" class="me-3" ><!--  @change="verMes" -->
                                               <option v-for="(month,index) in months" :value="(index+1)" >{{month}}</option><!-- :disabled="anio_select <= anioProyecto  && (index + 1) < mesProyecto"-->
                                            </select>
                                            <label class="ms-1 "> Año: </label>
                                            <select v-model="anio_select"><!-- @change="verAnio" -->
                                                <option v-for="(year,index) in years" :value="year" :disabled="(anioProyecto>year)">{{year}}</option>
                                            </select>
                                        </div>
                                        <div v-else>
                                            <label> {{mostrandoMes(proyecto.mes)}} <label>
                                            <label> {{proyecto.anio}} <label>
                                        </div>
                                    </td>

                                    <td style="background: #bfe49b;">
                                        <input v-if="actualizar==(posicion+1)" type="text" v-model="input_tons_co2" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44 || (event.target.selectionStart === 0 && event.charCode === 45))" @blur="formatInputSinPesos('input_tons_co2')"></input><!--:value="proyecto.tons_co2"-->
                                        <label v-else>{{proyecto.tons_co2}}</label>
                                    </td>
                                    <td v-if="sinImpacto!='Sin Impacto'" v-for="(cantidad,index) in columnaImpactoAmbiental.length" :key="index"><!--columa v-for"-->
                                        <input v-if="actualizar==(posicion+1)" type="text" v-model="inputImpactoAmbiental[posicion][index]" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44 || (event.target.selectionStart === 0 && event.charCode === 45))" @blur="formatInputSinPesosImpactoAmbientalPosicion(posicion,index)"> </input>
                                        <label v-else>{{inputImpactoAmbiental[posicion][index]}}</label>
                                    </td>
                                    <td>
                                        <input v-if="actualizar==(posicion+1)" type="text" v-model="input_ahorro_duro" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44 || (event.target.selectionStart === 0 && event.charCode === 45))" @blur="formatInputPesos('input_ahorro_duro')"></input> <!--:value="proyecto.ahorro_duro"-->
                                        <label v-else>{{proyecto.ahorro_duro}}</label>
                                    </td>
                                    <td>
                                        <input v-if="actualizar==(posicion+1)" type="text" v-model="input_ahorro_suave" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44 ||(event.target.selectionStart === 0 && event.charCode === 45))" @blur="formatInputPesos('input_ahorro_suave')"></input> <!--:value="proyecto.ahorro_suave"-->
                                        <label v-else>{{proyecto.ahorro_suave}}</label>
                                    </td>
                                    <td style="min-width:150px" class="align-middle">
                                        <span v-show="proyecto.status_rechazo=='Aceptada'" class="badge bg-success" style="font-size:0.8em;">Evidencia: <b>Aceptada</b></span>
                                        <span v-show="proyecto.status_rechazo=='Rechazada'" class="badge bg-danger" style="font-size:0.8em;">Evidencia: <b>Rechazada</b></span>
                                        <div v-if="proyecto.status_rechazo=='Rechazada'" class="col-12">
                                            <i class="bi bi-info-circle-fill text-danger"></i> {{proyecto.motivo_rechazo}}<br>
                                            <button type="button" class="btn btn-primary" style="font-size: 0.8em" @click="guardarRechazo('Corregida',proyecto.mes,proyecto.id,proyecto.anio,proyecto.motivo_rechazo,'','')">Listo, corregida!! </button>
                                        </div>
                                        <div v-if="proyecto.status_rechazo=='Corregida'" class="col-12">
                                            <span class="badge bg-warning text-dark" style="font-size:0.8em;"><b>El Financiero está revisando la corrección del rechazo. </b></span><br>
                                            <i class="bi bi-info-circle-fill text-warning"></i>{{proyecto.motivo_rechazo}} <label class="text-primary" style="font-size:0.7em;">(Favor de esperar la aceptación)</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="seguimientos>0" class="align-middle"> <!--Sumatoria y adjuntos-->
                                    <?php if ($_SESSION['acceso'] != "Financiero") { ?>
                                        <td v-if="seguimiento_status"></td><!--Se oculta esta columna cuando es cerrado-->
                                    <?php } ?>
                                    <td><b>Sumatoria:</b> </td>
                                    <td><b>{{sumaCO2}}</b></td>
                                    <td v-if="sinImpacto!='Sin Impacto'" v-for="(cantidad,index) in columnaImpactoAmbiental.length" :key="index"><!--columa v-for"-->
                                        <b>{{sumaColumnasImpacto['suma'+index]}}<b>
                                    </td>
                                    <td><b>{{ sumaAhorroDuro }}</b></td>
                                    <td><b>{{ sumaAhorroSuave }}</b></td>
                                    <td>
                                        <?php if ($_SESSION['acceso'] == "Admin") { ?>
                                            <div class="form-check form-switch">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" v-model="seguimiento_status" @change="guardarStatus()" style=" background-color: #B3F09B; color:white">
                                                    <label v-if="seguimiento_status" class="form-check-label" for="flexSwitchCheckDefault">Siguiendo</label>
                                                    <label v-else class="form-check-label" for="flexSwitchCheckDefault">Cerrado</label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <!------------------------------------------------------------------------------PRIMER SEGUIMIENTO --------------------------------------------------->
                                <tr v-if="id_proyecto!='' && seguimiento_status==true" style="vertical-align: middle; font-size: 1.1em;">
                                    <?php if ($_SESSION['acceso'] != "Financiero") { ?>
                                        <td v-if="seguimiento_status">
                                            <button v-if="actualizatabla == false && actualizar==0 " type="button" class="boton-aceptar" @Click="actualizatabla =!actualizatabla,nuevoLimpiarVariables()">Nuevo</button>
                                            <button v-if="actualizatabla == true" class="boton-eliminar mx-2" @Click="actualizatabla =!actualizatabla ">Cancelar</button>
                                            <button v-if="actualizatabla == true" class="boton-aceptar" @Click="guardarSeguimiento()">Guardar</button><!--Cuando no existe aun ningun registro-->
                                        </td>
                                    <?php } ?>
                                    <td style="min-width: 351px;">
                                        <label v-if="actualizatabla==true" class="ms-3"> Mes: </label>
                                        <select v-if="actualizatabla==true" v-model="mes_select">
                                            <option v-for="(month,index) in months" :value="(index+1)" >{{month}}</option><!-- :disabled=":disabled="anio_select <= anioProyecto  && (index + 1) < mesProyecto"-->
                                        </select>
                                        <label v-if="actualizatabla==true" class="ms-3"> Año: </label>
                                        <select v-if="actualizatabla==true" v-model="anio_select">
                                            <option v-for="(year,index) in years" :value="year" :disabled="(anioProyecto>year)">{{year}}</option>
                                        </select>
                                        <!--<input class="mx-1" v-if="actualizatabla==true" type="date" v-model="fecha_desde"></input>--><!--:value="proyecto.fecha_inicial"-->
                                    </td>
                                    <td style="background: #bfe49b;">
                                        <input v-if="actualizatabla==true" type="text" v-model="input_tons_co2" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44 || (event.target.selectionStart === 0 && event.charCode === 45))" @blur="formatInputSinPesos('input_tons_co2')"></input><!--:value="proyecto.tons_co2"-->
                                        <label v-else></label>
                                    </td>
                                    <td v-if="sinImpacto!='Sin Impacto'" v-for="(cantidad,index) in columnaImpactoAmbiental.length" :key="index"><!--columa v-for"-->
                                        <input v-if="actualizatabla==true" type="text" v-model="inputImpactoAmbientalInicial[index]" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44 || (event.target.selectionStart === 0 && event.charCode === 45))" @blur="formatInputSinPesosImpactoAmbiental(index)"> </input>
                                        <label v-else></label>
                                    </td>
                                    <td>
                                        <input v-if="actualizatabla==true" type="text" v-model="input_ahorro_duro" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44 || (event.target.selectionStart === 0 && event.charCode === 45))" @blur="formatInputPesos('input_ahorro_duro')"></input> <!--:value="proyecto.ahorro_suave"-->
                                        <label v-else></label>
                                    </td>
                                    <td>
                                        <input v-if="actualizatabla==true" type="text" v-model="input_ahorro_suave" onkeypress="return (event.charCode >= 48 && event.charCode <= 57 || event.charCode === 46 || event.charCode === 44 || (event.target.selectionStart === 0 && event.charCode === 45))" @blur="formatInputPesos('input_ahorro_suave')"></input> <!--:value="proyecto.ahorro_duro"-->
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
                                    <h6 v-if="cual_documento=='Seguimiento'" class="modal-title" id="exampleModalLabel">Subir documentos</h6>
                                    <h6 v-if="cual_documento=='Documento CO2'" class="modal-title" id="exampleModalLabel">Documentos CO2</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <form @submit.prevent="uploadFile('Seguimiento')">
                                            <!--Subir Documento Sugerencia-->
                                            <?php if ($_SESSION['acceso'] != "Financiero") { ?>
                                                <div v-if="cual_documento=='Seguimiento'" class="row">
                                                    <div class="col-12">
                                                        <div class="custom-file mt-5 mb-3">
                                                            <input type="file" id="input_file_seguimiento" @change="varificandoSelecionSeguimiento()" ref="ref_seguimiento" multiple accept="*.jpg/*.png/*.pdf/*.doc/*.docx/*.ppt/*.pptx/*.xls/*.xlsx/*.rar/*.zip" class="btn btn-secondary  ms-2 p-0" required />
                                                        </div>
                                                    </div>
                                                    <div class="col-12" v-if="existeImagenSeleccionadaSeguimiento && login!=true">
                                                        <button type="submit" name="upload" class="btn btn-primary">Subir Archivos </button>
                                                    </div>
                                                    <div v-if="login==true" class="d-flex justify-content-center">
                                                        <div>
                                                            <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <!-- Mostrando los archivos cargados SEGUIMIENTO-->
                                            <div v-if="cual_documento=='Seguimiento'" v-show="documentos_seguimiento.length>0">
                                                <hr>
                                                <div class="col-12" v-for="(archivos,index) in documentos_seguimiento">

                                                    <div class="row">
                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                        <?php if ($_SESSION['acceso'] != "Financiero") { ?>
                                                            <div class="mt-1">
                                                                <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;">Eliminar</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>

                                                    <!--Mostar los JPG y PNG-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                        <img :src="documentos_seguimiento[index]" style="width:50%" class="mb-5"></img>
                                                    </div>
                                                    <!--Mostrar PDF-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                        <iframe :src="documentos_seguimiento[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
                                                    </div>
                                                    <!--Mostrar Word-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Excel-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Power Point -->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar .RAR-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='rar'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/rar.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar .RAR-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='zip'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/zip.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Mostrando los archivos cargados CO2 -->
                                            <div v-if="cual_documento=='Documento CO2'" v-show="documentos_co2.length>0">

                                                <div class="col-12" v-for="(archivos,index) in documentos_co2">

                                                    <div class="row">
                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                    </div>

                                                    <!--Mostar los JPG y PNG-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                        {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                        <img :src="documentos_co2[index]" style="width:50%" class="mb-5"></img>
                                                    </div>
                                                    <!--Mostrar PDF-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'" class="col-12 text-center">
                                                        {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                        <iframe :src="documentos_co2[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
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
                                                            <img src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
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
                    
                    <!--MODAL IMPACTO AMBIENTAL-->
                    <!-- Modal Eliminar/Actualizar Documentos CO2-->
                    <div class="modal fade" id="modalImpactoAmbiental" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-fullscreen p-5">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel">Documento/s <b>{{cual_impacto_nombre}}</b></h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <form @submit.prevent="uploadFile('Impacto Ambiental')" enctype="multipart/form-data">
                                            <!--Subir Documento Sugerencia-->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="custom-file mt-5 mb-3">
                                                       <!--  <input type="file" id="input_file_impactoAmbiental" @change="verificandoSelecionImpactoAmbiental()" ref="ref_impAmb" multiple accept="*.jpg/*.png/*.pdf/*.doc/*.docx/*.ppt/*.pptx/*.xls/*.xlsx" class="btn btn-secondary  ms-2 p-0" required /> -->
                                                    </div>
                                                </div>
                                               
                                                <div class="col-12" v-if="existeDocumentoSeleccionadoImpacto && login!=true">
                                                    <button type="submit" name="upload" class="btn btn-primary">Subir Archivos </button>
                                                </div>
                                                <div v-if="login==true" class="d-flex justify-content-center">
                                                    <div>
                                                        <img class="mx-auto" style="width:50px;" src="img/loading.gif" /><label>Subiendo...</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Mostrando los archivos cargados -->
                                            <div v-show="documentos_impactoAmbiental.length>0">
                                                <hr>
                                                <div class="col-12" v-for="(archivos,index) in documentos_impactoAmbiental">
                                                    
                                                    <div class="row">
                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                        <!-- <div class="mt-1">
                                                            <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;">Eliminar</button>
                                                        </div> -->
                                                    </div>
                                                    <!--Mostar los JPG y PNG-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                       <!--  {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> -->
                                                        <img :src="documentos_impactoAmbiental[index]" style="width:50%" class="mb-5"></img>
                                                    </div>
                                                    <!--Mostrar PDF-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'" class="col-12 text-center">
                                                        <!-- {{nombre_de_descarga=archivos.slice(archivos.lastIndexOf('/')+1)}}<br> -->
                                                        <iframe :src="documentos_impactoAmbiental[index]" style="width:100%;height:800px;" class="mb-5"></iframe>
                                                    </div>
                                                    <!--Mostrar Word-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Excel-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Power Point -->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
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

                    <!--FIN MODAL IMPACTO AMBIENTAL-->
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
                                                    <span class="col-6 subtitulo" style="margin-top:6px">Investigación y desarrollo</span>
                                                    <table class="col-6  mt-1  text-center  table-bordered border-dark  ">
                                                        <thead>

                                                        </thead>
                                                        <tbody class="bg-white text-dark">
                                                            <tr>
                                                                <td><b>Valor</b></td>
                                                                <td class="text-primary"><b>{{sumaInvestigacionDesarrolloValor}}</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Sust.</b></td>
                                                                <td class="text-success"><b>{{sumaInvestigacionDesarrolloSustentable}}</b></td>
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
                                                                    <b>{{sumasGenerandoValor[objetivos.nombre_objetivos + ' (' + objetivos.siglas + ')'].sustentable}}</b>
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
                                                <!--<div class="mb-2 d-flex ">
                                                <div class="col-6"><i class="bi bi-check-circle"></i> Calidad</div>
                                                <div class="col-6"><span class="badge bg-light valor-calidad" style="min-width:30px;">{{sumaValoresGonher.Calidad}}</span></div>
                                            </div> -->
                                                <div class="mb-2 d-flex ">
                                                    <div class="col-8 lh-1"><i class="bi bi-check-circle"></i> Colaboración</div>
                                                    <div class="col-4"><span class="badge bg-light valor-trabajo" style="min-width:30px;">{{sumaValoresGonher.Trabajo}}</span></div>
                                                </div>
                                                <div class="mb-2 d-flex">
                                                    <div class="col-8 lh-1"><i class="bi bi-check-circle"></i> Servicio</div>
                                                    <div class="col-4"><span class="badge bg-light valor-servicio" style="min-width:30px;">{{sumaValoresGonher.Servicio}}</span></div>
                                                </div>

                                            </div>
                                            <div class="col-3 text-start ">


                                                <div class="mb-2 d-flex ">
                                                    <div class="col-8"><i class="bi bi-check-circle"></i> Excelencia</div>
                                                    <div class="col-4"><span class="badge bg-light valor-calidad" style="min-width:30px;">{{sumaValoresGonher.Calidad}}</span></div>
                                                </div>
                                                <div class="mb-2 d-flex ">
                                                    <div class="col-8 lh-1"><i class="bi bi-check-circle"></i> Desarrollo</div>
                                                    <div class="col-4"><span class="badge bg-light valor-desarrollo" style="min-width:30px;">{{sumaValoresGonher.Desarrollo}}</span></div>
                                                </div>
                                            </div>
                                            <div class="col-3 text-start">
                                                <div class="mb-2 d-flex">
                                                    <div class="col-8"><i class="bi bi-check-circle"></i> Compromiso</div>
                                                    <div class="col-4"><span class="badge bg-light valor-compromiso" style="min-width:30px;">{{sumaValoresGonher.Compromiso}}</span></div>
                                                </div>
                                                <div class="mb-2 d-flex">
                                                    <div class="col-8"><i class="bi bi-check-circle"></i> Integridad</div>
                                                    <div class="col-4"><span class="badge bg-light valor-integridad" style="min-width:30px;">{{sumaValoresGonher.Integridad}}</span></div>
                                                </div>
                                                <div class="mb-2 d-flex">
                                                    <div class="col-8"><i class="bi bi-check-circle"></i> Innovación</div>
                                                    <div class="col-4"><span class="badge bg-light valor-innovacion" style="min-width:30px;">{{sumaValoresGonher.Innovacion}}</span></div>
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
                    <div class="col-12">
                        <div class="row">
                            <div class="col-3" style="min-width:250px">
                                <div class="input-group mt-3 mb-2">
                                    <span class="input-group-text" style="width: 150px;">Seleccione año</span>
                                    <select style="width: 100px;" v-model="select_anio_calendario" @change="consultarCalendarioProyectos()">
                                        <option v-for="(year,index) in years" :value="year">{{year}}</option>
                                    </select>
                                </div>
                                <div class="input-group mt-3 mb-2">
                                    <span class="input-group-text" style="width: 150px; font-size:0.8em;">Seleccione Planta</span>
                                    <select style="width: 100px;" v-model="select_planta_calendario" @change=consultarCalendarioProyectos()>
                                        <option value="">Ver todos..</option>
                                        <option v-for="planta in plantas" :value="planta.nombre">{{planta.nombre.toUpperCase()}}</option>
                                    </select>
                                </div>
                            </div>
                            <!--ESTE DIV SE USA PARA AÑOS MENORES AL 2025 -->
                            <div v-if="select_anio_calendario < 2025" class="col-4 my-auto text-center" style="font-size:10px;min-width:350px">
                                <div class="row m-0 col-4 alert alert-primary p-0" style="font-size:10px;min-width:350px">
                                    <label class="text-dark">Teórico Acumulado Anual (Ahorro Duro / Plan)</label>
                                    <div class="col-4  text-start">
                                        Suma Planeada:<br>
                                        Suma Totales:
                                    </div>
                                    <div class="col-4 text-start">
                                        {{sumaPlan}}<br>
                                        {{sumaTotales}}
                                    </div>
                                    <div class="col-4 text-center my-auto">
                                        <div class="progress" style="height: 20px;">
                                            <div v-if="parseInt(calcularPorcentaje())>=100" class="progress-bar bg-success" role="progressbar" :style="'width:'+calcularPorcentaje()+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentaje()}} % </label></div>
                                            <div v-else class="progress-bar bg-primary" role="progressbar" :style="'width:'+calcularPorcentaje()+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentaje()}} % </label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--ESTE DIV SE USA DEL 2025 EN ADELANTE 1904371-->
                            <div v-if="select_anio_calendario >= 2025" class="col-4 my-auto text-center" style="font-size:10px;min-width:350px">
                                <div class="row m-0 col-4 alert alert-primary p-0" style="font-size:10px;min-width:350px">
                                    <label class="text-dark">Pres. Acumulado Anual (Pres. / Totales)</label>
                                    <div class="col-4  text-start">
                                        Suma Pres:<br>
                                        Suma Totales:
                                    </div>
                                    <div class="col-4 text-start">
                                        {{sumaPres}}<br>
                                        {{sumaTotales}}
                                    </div>
                                    <div class="col-4 text-center my-auto">
                                        <div class="progress" style="height: 20px;">
                                            <div v-if="parseInt(calcularPorcentaje())>=100" class="progress-bar bg-success" role="progressbar" :style="'width:'+calcularPorcentaje()+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentaje()}} % </label></div>
                                            <div v-else class="progress-bar bg-primary" role="progressbar" :style="'width:'+calcularPorcentaje()+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentaje()}} % </label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 my-auto text-center" style="font-size:10px;min-width:350px">
                                <div class="row m-0 col-4 alert alert-primary p-0" style="font-size:10px;min-width:350px">
                                    <label class="text-dark">Real Acumulado Anual (Real / Plan)</label>
                                    <div class="col-4  text-start">
                                        Suma Planeada:<br>
                                        Suma Reales:
                                    </div>
                                    <div class="col-4 text-start">
                                        {{sumaPlan}}<br>
                                        {{sumaReales}}
                                    </div>
                                    <div class="col-4 text-center my-auto">
                                        <div class="progress" style="height: 20px;">
                                            <div v-if="parseInt(calcularPorcentajeRealAnual())>=100" class="progress-bar bg-success" role="progressbar" :style="'width:'+calcularPorcentajeRealAnual()+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentajeRealAnual()}} % </label></div>
                                            <div v-else class="progress-bar bg-primary" role="progressbar" :style="'width:'+calcularPorcentajeRealAnual()+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentajeRealAnual()}} % </label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="scroll-dos">
                        <table class="table table-bordered table-striped table-hover tabla-proyectos text-center">
                            <thead>
                                <tr style="font-size:10px;">
                                    <th class="sticky1" style=" top: 0;min-width:150px; background:#808080; z-index:1">Documento</th>
                                    <th class="sticky2" style="top: 0; min-width:250px; background:#808080; z-index:1">Nombre del Proyecto</th>
                                    <th class="sticky3" style=" top: 0; background:#808080; z-index:1">Estatus </th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Enero</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Febrero</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Marzo</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Abril</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Mayo</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Junio</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Julio</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Agosto</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Septiembre</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Octubre</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Noviembre</th>
                                    <th style="position: sticky; top: 0; background:#808080; z-index:0">Diciembre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="proyectosXanioCalendario.length>0" v-for="(proyectosXanio,indexa) in proyectosXanioCalendario" class="tabla-filas" >
                                    <th class="sticky1" style="background:#f4f4f4">
                                        <template v-for="cantidadArchivos in cantidadDocumentos"><!--Contine ID y Cantidad de documentos-->
                                            <div v-if="cantidadArchivos.id==proyectosXanio.id && parseInt(cantidadArchivos.cantidad)>0">             
                                                <button type="button" class="btn btn-success" title="Visualizar" @click="modal_estatus(proyectosXanio.id)" style="font-size:10px"><i class="bi bi-file-earmark"></i><!--Si el ID es igual-->
                                                    {{cantidadArchivos.cantidad}} Archivo/s
                                                </button>
                                            </div>
                                            <div v-if="cantidadArchivos.id==proyectosXanio.id && parseInt(cantidadArchivos.cantidad)<=0">
                                                <button type="button" class="btn btn-secondary" title="Sin Documentos" style="font-size:10px"><i class="bi bi-file-earmark"></i>
                                                    {{documentos_seguimiento_captura.length}} Archivo/s
                                                </button>
                                            </div>
                                        </template>
                                    </th>
                                    <td class="sticky2 text-start" style="font-size:10px; background:#f4f4f4">
                                        <i class="bi bi-info-circle-fill me-2 text-primary" style="font-size: 1.3em" :title="' Responsable: '+proyectosXanio.responsable+'\n Correo: '+proyectosXanio.correo+'\n Teléfono: '+proyectosXanio.telefono"></i>
                                        {{proyectosXanio.nombre_proyecto}}<br>
                                        <span class="badge" style=" background:#0e989a; font-weight: lighter;">{{proyectosXanio.directo}}</span><br>
                                        <span class="badge text-black" style=" background:#F5C227; font-weight: lighter;">{{proyectosXanio.presupuestado}}</span>
                                    </td>
                                    <td class="sticky3" style="background:#f4f4f4">
                                        <!--<span class="badge bg-dark" style=" font-size: 8px" v-if="cantidadMesesRegistrados[proyectosXanio.id]>11">Finalizado</span><br>-->
                                        <span style="font-size: 8px"> {{retornandoMesesCapturados(proyectosXanio.id)}} </span><br>
                                        <span style="font-size: 8px">Suma actual Proyecto</span><br>
                                        <span class="badge text-white fw-normal" style="background:#4da255; font-size: 10px">{{retornandoSumaTotalCapturada(proyectosXanio.id)}}</span><br>
                                        <span v-if="proyectosXanio.status_seguimiento=='Cerrado'" class="badge bg-dark" style="font-size: 8px">Finalizado</span>
                                        <span v-else class="badge bg-success" style=" font-size: 8px">Siguiendo</span><br>
                                       

                                    </td>
                                    <td v-for="x in 12">
                                        <template v-for="proyectosDatosCalendario in proyectosDatosCalendario">
                                            <div v-if="proyectosDatosCalendario.proyectoID==proyectosXanio.id && proyectosDatosCalendario.mes==x && proyectosDatosCalendario.anio==select_anio_calendario">

                                                <span class=" badge rounded-pill alert-dark" style=" font-size: 8px">Ahorro Duro:<br><label class="text-dark">{{proyectosDatosCalendario.ahorro_duro}}<label></span>
                                                <span class="badge rounded-pill alert-warning" style=" font-size: 8px">Ahorro Suave:<br>{{proyectosDatosCalendario.ahorro_suave}}</span>

                                                <!--¡¡¡¡¡¡¡¡¡¡¡SERENA TE QUEDASTE AQUÍ,!!!!!!!!!!!-->
                                                <?php if ($_SESSION['acceso'] == "Financiero") { ?>
                                                <div v-if= "select_anio_calendario >= 2025" class = "input-group input-group-sm">
                                                    <!--<input :id="proyectosXanio.id+'-'+x" :value="buscarValor(proyectosXanio.id, x)" :key="indexa" type= "text" class ="form-control" style="height:20px; font-size: 8px;" placeholder="Ahorro por financiero" :disabled="editarMesFinanzas!=proyectosXanio.id+'_'+x"/>-->
                                                    <!--<button class ="btn btn-outline-secondary d-flex align-items-center justify-content-center p-1" type="button" style="height:20px; width: 25px">
                                                        <i class="bi bi-floppy" style="font-size: 0.9em;"></i>
                                                    </button>-->
                                                    <button type="button" v-if="editarMesFinanzas==proyectosXanio.id+'_'+x" class ="btn btn-outline-secondary d-flex align-items-center justify-content-center p-1"  style="height:20px; width: 25px" @click="guardarAhorro(proyectosXanio.id,x)">
                                                        <i class= "bi bi-floppy" style="font-size: 0.9em;"></i>
                                                    </button>
                                                    <button type="button" v-if="editarMesFinanzas!=proyectosXanio.id+'_'+x" class ="btn btn-outline-secondary d-flex align-items-center justify-content-center p-1"  style="height:20px; width: 25px" @click="editarAhorroF(proyectosXanio.id,x)">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </div>
                                                <?php }else{
                                                    ?>
                                                    <!--<input :id="proyectosXanio.id+'-'+x" :value="buscarValor(proyectosXanio.id, x)" :key="indexa" type= "text" class ="form-control" style="height:20px; font-size: 8px;" placeholder="Ahorro por financiero" @blur="guardarAhorro(proyectosXanio.id, x)" disabled="true"/>-->
                                                    <?php } ?>

                                                <div class="text-center">
                                                    <i v-if="proyectosDatosCalendario.validado=='Validado' && parseInt(proyectosDatosCalendario.mes)===x" class="bi bi-check2-all text-success"></i>
                                                    <i v-else class="bi bi-check2"></i>
                                                    <?php if ($_SESSION['acceso'] == "Financiero") { ?>
                                                        <button v-if="proyectosDatosCalendario.validado=='Validado' && parseInt(proyectosDatosCalendario.mes)===x" class="btn-liberado" @click="validarProyecto(proyectosXanio.id,x,proyectosDatosCalendario.validado,'')">Validado</button>
                                                        <button v-else class="btn-sin-liberar" @click="validarProyecto(proyectosXanio.id,x,proyectosDatosCalendario.validado,proyectosDatosCalendario.ahorro_duro)">Sin validar</button> <br>
                                                        <div class="row d-flex" style="font-size:0.6em">
                                                            <div class="col-6">
                                                                <span class="aceptar-doc rounded px-1 " :class="{'bg-success text-light': proyectosDatosCalendario.status_rechazo=='Aceptada' && parseInt(proyectosDatosCalendario.mes)===x}" @click="guardarRechazo('Aceptada',proyectosDatosCalendario.mes,proyectosDatosCalendario.id,'',proyectosDatosCalendario.motivo_rechazo,proyectosXanio.nombre_proyecto,proyectosXanio.correo)" style="cursor:pointer;"> <i class="bi bi-check-circle-fill"></i> Acept.</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <span class="rechazar-doc rounded px-1" :class="{'bg-danger text-light': proyectosDatosCalendario.status_rechazo=='Rechazada' && parseInt(proyectosDatosCalendario.mes)===x}" @click="modalMotivoRechazo(proyectosDatosCalendario.id,proyectosDatosCalendario.mes,proyectosDatosCalendario.nombre_proyecto,proyectosXanio.correo)" :title="'Motivo: '+proyectosDatosCalendario.motivo_rechazo" style="cursor:pointer"> <i class="bi bi-x-circle-fill"></i> Rech.</span>
                                                            </div>
                                                            <div class="col-12">
                                                                <span v-if="proyectosDatosCalendario.status_rechazo=='Corregida' && parseInt(proyectosDatosCalendario.mes)===x" :class="{'badge bg-warning text-dark': proyectosDatosCalendario.status_rechazo=='Corregida' && parseInt(proyectosDatosCalendario.mes)===x}" :title="'Motivo: '+proyectosDatosCalendario.motivo_rechazo" style="cursor:pointer">Estatus: <b>Corregida<b></span>
                                                                <span v-if="proyectosDatosCalendario.status_rechazo=='Pendiente' && parseInt(proyectosDatosCalendario.mes)===x || proyectosDatosCalendario.status_rechazo=='' && parseInt(proyectosDatosCalendario.mes)===x" :class="{'badge bg-secondary': proyectosDatosCalendario.status_rechazo=='Pendiente' && parseInt(proyectosDatosCalendario.mes)===x || proyectosDatosCalendario.status_rechazo=='' && parseInt(proyectosDatosCalendario.mes)===x}" style="cursor:pointer">Estatus: <b>Pendiente<b></span>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($_SESSION['acceso'] == "Admin") { ?>
                                                        <span class="badge alert-success py-1" style="font-size: 0.6em; display: block; width: 100%; padding: 0; margin: 0;"> tCO2 Evitado: {{proyectosDatosCalendario.tons_co2}}</span>
                                                        <span class="badge alert-primary py-1" style="font-size: 0.6em; display: block; width: 100%; padding: 0; margin: 0;"> {{mesAmesProyecto(proyectosDatosCalendario.proyectoID,x)}}</span>
                                                        <!--<span class="badge alert-success" style="font-size: 0.6em;width: 100%;"> {{mesAmesProyectoCO2(proyectosDatosCalendario.proyectoID,x)}}</span>-->
                                                    <?php } ?>
                                                </div>
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
                                <tr><!--Fila Plan y Totales-->
                                    <td></td>
                                    <td></td>

                                    <td style="font-size:10px; min-width:120px">
                                        <div class="p-2 pt-1 mt-2">tCO2 Evitado:</div> <!--desaparecer si es menor a 2025 -->
                                        <div v-if="select_anio_calendario >= 2025" class="p-2 pt-1">Pres:</div> <!--desaparecer si es menor a 2025 -->
                                        <div class="p-2 pt-1">Plan:</div>
                                        <div class="p-2 mt-1">Total:</div>
                                        <div v-if="select_anio_calendario >= 2025" class="p-2 mt-1">Cumplimiento Plan:</div>
                                    </td>
                                    <td class="align-middle" v-for="(x,index) in 12" style="font-size:12px"><!--Columna de Sumas X Anio-->

                                        <div>
                                            <span class="badge alert-success w-100" v-if="ahorro_co2_mes_mes[x-1]">{{ahorro_co2_mes_mes[x-1].suma}}</span>
                                            <label style="min-height:18px;"></label>
                                        </div>
                                        <div class="col d-flex"><!--Valor Plan-->
                                            <div>
                                                <?php if ($_SESSION['acceso'] == "Admin") { ?>
                                                    <input class="mt-2" v-if="plan_actualizar===x" v-model="inputValorPlan[index]" type="text" @blur="darFormatoInputValorPlan(index)"> </input><!--Mostrado en gerencia solo mostrar-->
                                                    <input class="mt-2" v-if="plan_actualizar!==x" type="text" :value="inputValorPlan[index]" disabled> </input>
                                                    <input  v-if="select_anio_calendario>=2025" v-model="inputProyectosMes[index]" type="text" @blur="darFormatoInputValorPlan(index)" disabled> </input><!--Apartir del 2025 presupuestado-->
                                                <?php } ?>
                                                <?php if ($_SESSION['acceso'] == "Financiero") { ?>
                                                    <input v-if="plan_actualizar!==x" type="text" :value="inputValorPlan[index]" disabled> </input>
                                                    <input v-if="select_anio_calendario>=2025" v-model="inputProyectosMes[index]" type="text" @blur="darFormatoInputValorPlan(index)" disabled> </input><!--Apartir del 2025 presupuestado-->
                                                <?php } ?>

                                            </div>

                                            <div>
                                                <?php if ($_SESSION['acceso'] == "Admin") { ?>
                                                    <button  v-if="plan_actualizar===x" style="border-style: outset; border-width: 1.5px; height: 24px;" @click="guardarPlanMes(x)"><i class="bi bi-floppy-fill"></i></button>
                                                    <button class="mt-2" v-else style="border-style: outset; border-width: 1.5px; height: 24px;" @click="editarPlanMes(x)"><i class="bi bi-pencil-fill"></i></button>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div v-show="calendarioSumaXMesAnio.sumas_ahorro_duro && calendarioSumaXMesAnio.sumas_ahorro_duro[x.toString()]" class="alert alert-dark lh-1 p-2 mb-0 d-flex flex-column mt-1" role="alert" style="min-width:170px;">
                                            <div class="d-flex align-items-center">
                                                <label>Ah. S.: </label>&nbsp;<label> {{ calendarioSumaXMesAnio.sumas_ahorro_suave && calendarioSumaXMesAnio.sumas_ahorro_suave[x.toString()]}}</label>
                                            </div>
                                            <hr style="height: 1px; margin: 2px;">
                                            <div class="d-flex align-items-center">
                                                <label>Ah. D.: </label>&nbsp;<label> {{ calendarioSumaXMesAnio.sumas_ahorro_duro && calendarioSumaXMesAnio.sumas_ahorro_duro[x.toString()]}}</label>
                                            </div>
                                        </div>
                                        <div><!--% Teórico Mensual-->
                                            <div class="text-start">
                                                <label style="font-size:8px">Teórico Mensual (Ahorro Duro/Plan)<label>
                                            </div>
                                            <div class="progress " style="height: 13px;">
                                                <div v-if="parseInt(calcularPorcentajeMensualTeorico(x))>=100" class="progress-bar bg-success" role="progressbar " :style="'width:'+calcularPorcentajeMensualTeorico(x)+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentajeMensualTeorico(x)}} % </label></div>
                                                <div v-else class="progress-bar" role="progressbar bg-primary" :style="'width:'+calcularPorcentajeMensualTeorico(x)+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentajeMensualTeorico(x)}} % </label></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr><!--Fila Total Real-->
                                    <td></td>
                                    <td><!--{{checkValidar}}--></td>
                                    <td style="font-size:10px" v-if="select_anio_calendario >= 2025">
                                        <div class="p-2 mt-1"> Cumplimiento Presupuesto:</div>
                                        <div class="p-2 mt-1">Total Real:</div>
                                    </td>
                                    <td v-else style="font-size:10px" class="align-middle"> Total Real </td>
                                    <td v-for="(x,index) in 12" style="font-size:12px" class="text-start"><!--Columna de Sumas X Anio-->
                                        <div class="text-center"><!--v-show="calendarioSumaXMesAnio.sumas_ahorro_duro && calendarioSumaXMesAnio.sumas_ahorro_duro[x.toString()]" Por el momento si presenta erro aqui colocarlo-->

                                            <div class="mb-2"><!--% Real Mensual-->
                                                <div class="text-start">
                                                    <label v-if="select_anio_calendario >= 2025" style="font-size:8px">Real Mensual (Real/Presupuesto)<label>
                                                            <label v-if="select_anio_calendario < 2025" style="font-size:8px">Real Mensual (Real/Plan)<label>
                                                                    <br>
                                                </div>
                                                <div class="progress" style="height: 13px;">
                                                    <div v-if="calcularPorcentajeMensualReal(x)>=100" class="progress-bar bg-success" role="progressbar" :style="'width:'+calcularPorcentajeMensualReal(x)+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentajeMensualReal(x)}} % </label></div>
                                                    <div v-else class="progress-bar bg-primary" role="progressbar" :style="'width:'+calcularPorcentajeMensualReal(x)+'%!important;'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><label style="font-size:10px">{{calcularPorcentajeMensualReal(x)}} % </label></div>
                                                </div>
                                            </div>

                                            <?php if ($_SESSION['acceso'] == "Financiero") { ?>
                                                <input class="text-primary" type="text" v-model="inputTotalReal[index]" @blur="darFormatoInputValorReal(x)" :disabled="checkValidar[index]"></input><br><!--Input activado solo para financieros-->
                                                <label>Validar</label>&nbsp;
                                                <input class="form-check-input" type="checkbox" v-model="checkValidar[index]" @change="guardarValidacionFinanciera(x)">
                                            <?php } else { ?>
                                                <input class="text-primary" type="text" v-model="inputTotalReal[index]" @blur="darFormatoInputValorReal(x)" disabled></input><!--Input siempre desactivado para todos los usuarios-->
                                            <?php } ?>
                                            <br><label>Representante Financiero</label>
                                            <br>
                                            <div class="text-primary" v-if="datosFinancieros[x.toString()] && datosFinancieros[x.toString()].validado">
                                                <!-- Tu contenido aquí si la posición existe y es válida -->
                                                {{ datosFinancieros[x.toString()].nombre}}<br>
                                                <span class="badge bg-success" style="font-size: 8px">Liberado</span>
                                            </div>
                                            <div v-else class="text-primary"><span class="badge bg-secondary" style="font-size: 8px">Sin liberar</span></div>


                                        </div>
                                    </td>
                                </tr>
                                <!--<tr class="align-middle">
                                                <td></td>
                                                <td></td>
                                                <td  style="font-size:10px">Cumplimiento:</td>
                                                <td colspan="12" class="align-middle text-start"> 
                                                </td>
                                            </tr>-->
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal Eliminar/Actualizar Seguimiento-->
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel">Documento</h6>
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
                                            <div v-if="cual_documento=='Seguimiento'" v-show="documentos_seguimiento_financiero.length>0">
                                                <hr>
                                                <div class="col-12" v-for="(archivos,index) in documentos_seguimiento_financiero">
                                                    <div class="row">
                                                        <span class="badge bg-secondary">Documento {{index+1}}</span><br>
                                                        <!--<div class="mt-1">
                                                                                <button type="button" class="btn btn-danger" @click="eliminarDocumento(archivos)" style="font-size:14px;" >Eliminar</button>
                                                                            </div>-->
                                                    </div>
                                                    <!--Mostar los JPG y PNG-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='png' || archivos.slice(archivos.lastIndexOf('.') + 1)=='jpg'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                        <img :src="documentos_seguimiento_financiero[index]" style="width:50%" class="mb-5"></img>
                                                    </div>
                                                    <!--Mostrar PDF-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='pdf'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br>
                                                        <iframe :src="documentos_seguimiento_financiero[index]" style="width:100%;height:500px;" class="mb-5"></iframe>
                                                    </div>
                                                    <!--Mostrar Word-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='doc' || archivos.slice(archivos.lastIndexOf('.') + 1)=='docx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/word.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Excel-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='xls' || archivos.slice(archivos.lastIndexOf('.') + 1)=='xlsx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br><!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/excel.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar Power Point -->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='ppt' || archivos.slice(archivos.lastIndexOf('.') + 1)=='pptx'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/powerpoint.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar .RAR-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='rar'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/rar.png" style="width:200px" class="mb-5"></img>
                                                        </a>
                                                    </div>
                                                    <!--Mostrar .RAR-->
                                                    <div v-if="archivos.slice(archivos.lastIndexOf('.') + 1)=='zip'" class="col-12 text-center">
                                                        {{archivos.slice(archivos.lastIndexOf('/')+1)}}<br> <!--obtengo el nombre del documento con extension-->
                                                        <a :href="archivos" :download="getFileName(archivos)">
                                                            <img src="img/zip.png" style="width:200px" class="mb-5"></img>
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

                    <!-- Modal Motivo Rechazo-->
                    <div class="modal fade" id="modal-motivo-rechazo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title text-danger" id="exampleModalLabel">Motivo Rechazo</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <textarea rows="5" id="motivo_rechazo" class="textarea w-100"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" @click="guardarRechazo('Rechazada')">Enviar rechazo</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fin Modal Motivo Rechazo-->

                </div>
                <!--////////////////////////////////////////////// FIN DE CALENDARIO -->
                <div v-if="ventana=='Valores Gonher'" v-cloak><!--BLOQUE GRAFICA VALORES GONHER-->
                    <div class="row">
                        <div class="col-1 col-sm-2 d-flex justify-content-center align-items-start align-items-lg-center ">
                            <img class="w-100 mt-2" src="img/enerya.png" style="max-width:150px"></img>
                        </div>
                        <div id="divCanvas" class="col-10 col-sm-8   d-flex justify-content-center" style="height:80vh;">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="col-1 col-sm-2 d-flex justify-content-center align-items-start align-items-lg-center">
                            <img class="w-100 mt-2" src="img/riasa.png" style="max-width:150px"></img>
                        </div>
                    </div>
                </div><!--Fin Valores Gonher-->
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