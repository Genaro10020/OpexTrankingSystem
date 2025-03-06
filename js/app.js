
let sumandoExcelenciaValor = 0;
let sumandoExcelenciaSustentable = 0;


const AltaProyectos = {
  data() {
    return {
      /*/////////////////////////////////////////////////////////////////////////////////VARIBLES USUARIOS Y DEPARTAMENTOS INICIO*/
      opcion: 2,
      ventana: 'Altas',
      myModal: '',
      myModalCRUD: '',
      tipo: '',
      accion: '',
      selectFuente: '',
      selectPlanta: '',
      selectArea: '',
      selectDepartamento: '',
      selectMetodologia: '',
      selectResponsable: '',
      responsables: [],
      plantas: [],
      areas: [],
      cual_documento: '',
      proyectoSumas: [],
      documentos_co2: [],
      /*Alta Proyectos */
      id_actualizar: '',
      titulo_nombre_proyecto: '',
      titulo_modal: '',
      fecha_alta: '',
      nombre_proyecto: '',
      nombre_fuente: '',
      fuentes: [],
      departamentos: [],
      metodologias: [],
      checkObservadores: [],
      pilares: [],
      pilaresRelacion: [],
      allPilares: [],
      siglas: '',
      objetivos: [],
      checkMisiones: [],
      checkPilares: [],
      checkObjetivos: [],
      checkImpactoAmbiental: [],
      impactoAmbiental: [],
      valores: [],
      valoresCheck: [],
      sumasImpactoAmbiental: [],
      selectImpactoAmbiental: '',
      misiones: [],
      allMisiones: [],
      idsPilares: [],
      idsObjetivos: [],
      proyectos: [],
      indexs_pilares: [],
      selectPilar: [],
      selectObjetivo: [],
      select_pilar: '',
      select_mision: '',
      imagenes: [],
      documentos_seguimiento: [],
      documentos_seguimiento_captura: [],
      documentos_seguimiento_financiero: [],
      documentos_co2: [],
      tons_co2: '',
      ahorro_duro: '$.00',
      ahorro_suave: '$.00',
      numero_index: 0,
      respondio: true,//utilizo para cambiar el css si no repondio en altas
      objetivo_estrategico: false,
      existeImagenSeleccionada: false,
      existeImagenSeleccionadaSeguimiento: false,
      existeImagenSeleccionadaCO2: false,
      actualizar_proyecto: false,
      idsCheckImpacto: [],
      selectEmisiones: [],
      impactosConDatos: [],
      new_proyect_anio: '',
      mesDinamico: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
      cantidadMeses: 0,
      idsPlanMesual: [],
      AnioXMes: [],
      MesXAnio: [],
      select_anios_por_mes: '',
      inputValorMensualCO: [],
      inputValorMensualAD: [],
      inputValorMensualAS: [],
      flagEditCOMes: '',
      flagEditAhorroDuroMes: '',
      flagEditAhorroSuaveMes: '',

      /*Planta*/ /*Área*/ /*Departamento*/
      nueva: '',
      nuevoNombre: '',
      eliminar: '',
      /*Responsable*/
      nuevoResponsable: false,
      actualizarResponsable: false,
      nombre: '',
      numero_nomina: '',
      correo: '',
      telefono: '',
      financiero: false,
      responsableID: [],
      random: '',
      /*Impacto Ambiental */
      //general
      id: '',// utilizado y reseteado despues de usar.
      /*Variabes Estandares co2*/
      estandares: [],
      cantidad: '',
      unidadMedida: '',
      descripcionCa: '',
      descripcionUM: '',
      /*ACTUALIZAR MISIONES LIGADAS A PILARES */
      misionLigada: '',
      n_mision: '',
      id_mision_ligada: '',
      pilar: '',
      objetivos_ligados: '',
      /*SEGUIMIENTO DE PROYECTO*/
      id_proyecto: '',
      arregloID: [],
      columnaImpactoAmbiental: [],
      actualizatabla: false,
      fecha_desde: '',
      fecha_hasta: '',
      input_tons_co2: '',
      datos: [],
      input_ahorro_duro: '',
      input_ahorro_suave: '',
      actualizar: 0,
      inputImpactoAmbiental: [],
      inputImpactoAmbientalInicial: [],
      seguimientos: 0,
      idsInputImpactoAmbiental: [],
      login: false,
      months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      years: [2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030, 2031, 2032, 2033, 2034, 2035, 2036, 2037, 2038, 2039, 2040, 2041, 2042, 2043, 2044, 2045, 2046, 2047, 2048, 2049, 2050],
      mes_select: 1,
      anio_select: '',
      seguimiento_status: true,
      sinImpacto: '',
      sumaCO2: 0,
      sumaAhorroDuro: 0,
      sumaAhorroSuave: 0,
      sumaColumnasImpacto: [],
      todosSeguimientos: [],
      mostrarHeader: true,
      sumasGenerandoValor: [],
      sumarSoloUnaVez: 0,
      SumaValorEx: 0,
      SumaSustentableEx: 0,
      myModalSeguimiento: '',
      myModalCO2: '',
      myModalStatus: '',
      nombre_de_descarga: '',
      plan_actualizar: '',
      inputValorPlan: [],
      inputProyectosMes: [],
      valoresPlan: [],
      sumaPlan: 0,
      sumaProyectos: 0,
      sumaTotales: 0,
      meta: 0,
      metaPres: 0, //es para sacar el porcentaje del prestamos acumulado anual
      selleva: 0,
      sumaReales: "$0.00",
      SumNumReales: 0,
      nombre_del_proyecto: '',
      correo_proyecto: '',
      /*GENERANDO VALOR*/
      select_anio_generando_valor: '',
      sumaClienteValor: '',
      sumaClienteSustentable: '',

      sumaExcelenciaValor: '',
      sumaExcelenciaSustentable: '',

      sumaCapitalHumanoValor: '',
      sumaCapitalHumanoSustentable: '',

      sumaInvestigacionDesarrolloValor: '',
      sumaInvestigacionDesarrolloSustentable: '',

      sumaGeneralValor: '',
      sumaGeneralSustentable: '',
      sumaValoresGonher: '',
      //Calendario
      motivo_rechazo: '',
      select_anio_calendario: '',
      select_planta_calendario: '',
      proyectosDatosCalendario: [],
      proyectosXanioCalendario: [],
      cantidadMesesRegistrados: [],
      calendarioSumaXMesAnio: [],
      datosFinancieros: [],
      inputTotalReal: [],
      checkValidar: [],
      cantidadDocumentos: [],
      id_proyecto_rechazo: '',
      mes_rechazo: '',
      sumaPres: '',
      plan_mes_mes_por_proyecto: [],
    }
  },
  mounted() {
    //  this.consultarUsuarios()
    this.consultarProyectos()
    this.consultarSumaProyectos()
    this.tomarAnioActual()
  },
  methods: {
    toggleDiv() {
      this.showDiv = !this.showDiv;
      console.log(this.showDiv);
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS*/
    consultarProyectos() {
      plan_actualizar = ''; //solo la reseteo
      axios.get('proyectosController.php', {
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.proyectos = response.data[0][0];
          } else {
            this.proyectos = []
          }
        } else {
          alert("La consulta de proyectos no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Error :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS*/
    consultarCalendarioProyectos() {
      this.plan_actualizar = ''
      this.documentos_seguimiento_financiero = []
      axios.get('proyectosController.php', {
        params: {
          accion: 'calendario',
          anio: this.select_anio_calendario, //añoooo
          planta: this.select_planta_calendario
        }
      }).then(response => {
        console.log('ProyectosCalendario', response.data)
        if (response.data[0][1] == true && response.data[0][3]) {
          this.proyectosDatosCalendario = response.data[0][0]
          this.proyectosXanioCalendario = response.data[0][2]
          this.cantidadMesesRegistrados = response.data[0][4]
          this.calendarioSumaXMesAnio = response.data[0][6]
          var suma = 0
          this.selleva = 0
          for (let i = 1; i <= 12; i++) {
            if (this.calendarioSumaXMesAnio.sumas_ahorro_duro[i]) {
              //console.log(this.calendarioSumaXMesAnio.sumas_ahorro_duro[i])
              suma += parseFloat(this.calendarioSumaXMesAnio.sumas_ahorro_duro[i].replace(/[$,]/g, ''))
            }
          }
          this.selleva = suma;
          //console.log("SE LLEVA",this.selleva)
          this.sumaTotales = "$" + suma.toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
          // this.sumaPres = "$"+parseFloat(suma).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

          // this.sumaPlan = "$"+parseFloat(suma).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
          //aquu

          this.consultarPlan();//Se consultara siempre
          if (this.select_anio_calendario >= 2025) {
            this.consultarPlanNuevoModalidad()
          }



          this.consultarValidacion();//Consutar la parte financiera
          this.cantidadDocumentos = []
          for (var i = 0; i < this.proyectosXanioCalendario.length; i++) {
            this.buscarDocumentos('Estatus', this.proyectosXanioCalendario[i].id);
          }
        } else {
          alert("En la consulta calendario total por proyecto, no se logro")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS*/
    consultarSumaProyectos() {
      axios.get('proyectosController.php', {
        params: {
          accion: 'suma'
        }
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          this.proyectoSumas = response.data[0][0]
        } else {
          alert("En la consulta sumar total por proyecto, no se logro")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS POR ID PARA QUE TRAEGA DATOS DE CADA PROYECTO*/
    tomarAnioActual() {
      var fechaActual = new Date();
      var dia = fechaActual.getDate().toString().padStart(2, '0');
      var mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0'); // Se suma 1 porque los meses van de 0 a 11
      var anio = fechaActual.getFullYear();
      this.select_anio_calendario = anio
      this.anio_select = anio
      this.select_anio_generando_valor = anio
      this.select_anios_por_mes = anio
    },
    consultarProyectoID() {
      axios.post('proyectosController.php', {
        id_proyecto: this.id_proyecto //ID PROYECTO
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.arregloID = response.data[0][0];
            this.columnaImpactoAmbiental = JSON.parse(response.data[0][0][0].impacto_ambiental);
            this.seguimientos = 0;
            this.seguimiento_status = true
            if (this.columnaImpactoAmbiental[0] == 'Sin Impacto') {
              this.inputImpactoAmbientalInicial = Array(1);
              this.inputImpactoAmbientalInicial[0] = '0.00';
              this.sinImpacto = 'Sin Impacto'
            } else {
              this.inputImpactoAmbientalInicial = Array(this.columnaImpactoAmbiental.length);
              this.sinImpacto = ''
            }

          }
        } else {
          alert("La consulta de proyectos no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    consultarImpactoAmbieltalXProyectoID() {

      this.actualizar = 0
      axios.post('impactoAmbientalProyectoController.php', {
        id_proyecto: this.id_proyecto //ID PROYECTO
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.arregloID = response.data[0][0];
            var comparandoImpactoInicial = "";
            var comparandoImpactoDos = "";
            this.seguimientos = response.data[0][0].length;
            var impactoAmbiental = [];
            var datos = [];
            for (let j = 0; j < response.data[0][2][0].length; j++) {
              impactoAmbiental.push(response.data[0][2][0][j].impacto_ambiental)
            }
            if (response.data[0][0][0].status_seguimiento === 'Cerrado') {
              this.seguimiento_status = false
            } else {
              this.seguimiento_status = true
            }

            var no_repetidos = new Set(impactoAmbiental);
            this.columnaImpactoAmbiental = Array.from(no_repetidos);;//tiene los nombres de impacto ambiental
            this.inputImpactoAmbientalInicial = Array(this.columnaImpactoAmbiental.length);


            if (this.columnaImpactoAmbiental[0] == 'Sin Impacto') {
              this.inputImpactoAmbientalInicial = Array(1);
              this.inputImpactoAmbientalInicial[0] = '0.00';
              this.sinImpacto = 'Sin Impacto'
            } else {
              this.inputImpactoAmbientalInicial = Array(this.columnaImpactoAmbiental.length);
              this.sinImpacto = ''
            }

            this.inputImpactoAmbiental = response.data[0][2].map(subArray => subArray.map(objeto => objeto.dato));
            this.idsInputImpactoAmbiental = response.data[0][2].map(subArray => subArray.map(objeto => objeto.id_registro));//los utilizare para actualizar

            //Sumando Columnas
            var sumaC02 = 0
            var sumaAhorroDuro = 0
            var sumaAhorroSuave = 0
            //suma CO2
            for (let i = 0; i < response.data[0][0].length; i++) {
              var valorC02 = response.data[0][0][i].tons_co2  //tomando los valores de C02
              var valorAhorroDuro = response.data[0][0][i].ahorro_duro  //tomando los valores de Ahorro Duro
              var valorAhorroSuave = response.data[0][0][i].ahorro_suave  //tomando los valores de Ahorro Duro
              valorAhorroDuro = this.formatoSoloNumeros(valorAhorroDuro); //Eliminando pesos 
              valorAhorroSuave = this.formatoSoloNumeros(valorAhorroSuave); //Eliminando pesos 
              sumaC02 = parseFloat(sumaC02) + parseFloat(valorC02)
              sumaAhorroDuro = parseFloat(sumaAhorroDuro) + parseFloat(valorAhorroDuro) // sumando Ahorro duro
              sumaAhorroSuave = parseFloat(sumaAhorroSuave) + parseFloat(valorAhorroSuave) // sumando Ahorro duro
            }
            this.sumaCO2 = sumaC02.toFixed(2);
            this.sumaAhorroDuro = this.formatoNumeroApesos(sumaAhorroDuro); //convietiendo a pesos
            this.sumaAhorroSuave = this.formatoNumeroApesos(sumaAhorroSuave); //convietiendo a pesos

            //Sumando Valores de Columna Impacto Ambiental
            var sumas = [];
            for (let i = 0; i < this.inputImpactoAmbiental.length; i++) {
              for (let j = 0; j < this.inputImpactoAmbiental[i].length; j++) {
                valor = this.inputImpactoAmbiental[i][j]
                valor = valor.replaceAll(',', '');//elimino la "," par que la suma sea correcta y dejo el "."
                if (i === 0) {
                  // Inicializar la suma en la primera iteración
                  sumas['suma' + j] = parseFloat(valor);
                  console.log(parseFloat(valor))
                } else {
                  // Sumar en las iteraciones siguientes
                  sumas['suma' + j] += parseFloat(valor);
                  console.log(parseFloat(valor))
                }
              }

            }

            // Redondear al mostrar o almacenar para que no aparecans numero con msa de dos decimas .00
            for (let i in sumas) {
              sumas[i] = parseFloat(sumas[i]).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });  // Convertir a número antes de usar toFixed
            }
            this.sumaColumnasImpacto = sumas;

            /*for (let i = 0; i <this.seguimientos[0][2].length; i++) {
                for (let j = 0; j < this.seguimientos[0][2][i].length; j++) {
                  var valor = this.seguimientos[0][2][i][j].dato;
                  // Utilizar una clave dinámica (suma1, suma2, etc.)
                  sumas['suma' + j] = (sumas['suma' + j]) + parseFloat(valor);
                  console.log(sumas['suma' + j] )
                     //sumando = parseFloat(sumando) + parseFloat(suma);
                      //this.seguimientos[0][2][i][j].push({['Sumado' + j]: sumando.toFixed(2) });
                }
            }*/


            this.buscarDocumentos('Seguimiento')
          } else {
            this.consultarProyectoID() // si no existe seguimientos consultara proyectos para insetarlos primeros registros
          }
        } else {
          alert("La consulta de proyectos no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS POR NOMBRE*/
    consultarProyectosPorNombre() {
      axios.get('proyectosController.php', {
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.proyectoNombre = response.data[0][0];
          }
        } else {
          alert("La consulta de proyectos no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR FUENTES*/
    consultarFuentes() {
      axios.get('fuentesController.php', {
      }).then(response => {
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.fuentes = response.data[0][0];
          } else {
            this.fuentes = []
          }
        } else {
          alert("La consulta de fuentes no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PLANTAS*/
    consultarPlantas() {
      axios.get('plantasController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (!response.data[0][1] == false) {
          if (response.data[0][0].length > 0) {
            this.plantas = response.data[0][0]
          }
        } else {
          alert("La consulta  plantas no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR AREAS*/
    consultarAreas() {
      axios.get('areasController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (!response.data[0][1] == false) {
          if (response.data[0][0].length > 0) {
            this.areas = response.data[0][0]
          }
        } else {
          alert("La consulta  plantas no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR DEPARTAMENTOS*/
    consultarDepartamentos() {
      axios.get('departamentosController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (!response.data[0][1] == false) {
          if (response.data[0][0].length > 0) {
            this.departamentos = response.data[0][0]
          }
        } else {
          alert("La consulta  departamentos no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR DEPARTAMENTOS*/
    consultarMetodologias() {
      axios.get('metodologiasController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (!response.data[0][1] == false) {
          if (response.data[0][0].length > 0) {
            this.metodologias = response.data[0][0]
          }
        } else {
          alert("La consulta  metodologias no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR RESPONSABLES ID*/
    consultarResponsableID() {
      if (this.selectResponsable != "") {
        var id_nombre_responsable = this.selectResponsable.split("-")
        this.id = id_nombre_responsable[0];
        axios.post('responsablesController.php', {
          id: this.id//id Responsable
        }).then(response => {
          console.log(response.data[0])
          if (response.data[0][1] == true) {
            if (response.data[0].length > 0) {
              this.nuevoResponsable = true
              this.actualizarResponsable = true
              this.responsableID = response.data[0][0];
              this.nombre = this.responsableID[0].nombre
              this.numero_nomina = this.responsableID[0].numero_nomina
              this.correo = this.responsableID[0].correo
              this.telefono = this.responsableID[0].telefono
              if (this.responsableID[0].tipo_usuario == "Financiero") { this.financiero = true; } else { this.financiero = false; }
            }
          } else {
            alert("La consulta responsables no se realizo correctamente.")
          }
        }).catch(error => {
          console.log('Erro :-(' + error)
        }).finally(() => {

        })

      } else {
        alert("Seleccione al responsable para Actualizar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR RESPONSABLES*/
    consultarResponsables() {
      axios.get('responsablesController.php', {
        params: {
          accion: "Consulta"//id Responsable
        }
      }).then(response => {
        console.log(response.data[0])
        if (!response.data[0][1] == false) {
          if (response.data[0][0].length > 0) {
            this.responsables = response.data[0][0]
          }
        } else {
          alert("La consulta responsables no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PILARES*/
    consultarPilaresXobjetivoSeleccionado() {
      /* if(this.checkObjetivos.length >0){
           const valoresAntesDelGuion = this.checkObjetivos.map(item => {
             const partes = item.split('<->'); // utilizo para separar por guion
             return partes[2]//todas las partes en posicion 2 contienen el id_pilar, que necesitaremos para la consulta
           });

           const valoresUnicos = [...new Set(valoresAntesDelGuion)];//Obtengo los numero no repetidos del arreglo 
           console.log(valoresUnicos);
           axios.post('pilaresController.php',{
               idsPilares:valoresUnicos
           }).then(response =>{
               console.log(response.data[0])
               if (response.data[0][1]==true){
                   if (response.data[0][0].length>0) {
                     this.pilares = response.data[0][0]
                     this.misiones = response.data[0][2]
                   }
               }else{
                   alert("La consulta Pilares por Objetivos Seleccionado, no se realizo correctamente.")
               }
           }).catch(error =>{
             console.log('Erro :-('+error)
           }).finally(() =>{
     
           })
     }else{
       this.pilares =''
       this.misiones=''
     }*/
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR OBJETIVOS POR PILARES SELECCIONADA*/
    consultarObjetivosXpilaresSeleccionados() {
      if (this.checkPilares.length > 0) {
        this.selectObjetivo = []
        this.checkObjetivos = []
        this.objetivos = []
        var ids_pilares = [];
        var indexs_pilar = [];
        console.log(this.checkPilares);

        //tomo los ids de los pilarese seleccionados y los inserto en arrelo ids.pilares y me mostrada los select correspondientes
        for (let i = 0; i < this.checkPilares.length; i++) {
          var id_pilar = this.checkPilares[i].split('<->')[0];
          var index = this.checkPilares[i].split('<->')[3]
          ids_pilares.push(id_pilar);
          indexs_pilar.push(index);
        }
        this.idsPilares = ids_pilares;
        console.log(indexs_pilar)

        //creo posiciones
        cantidad_pilares = [];
        for (let index = 0; index < this.pilares.length; index++) {
          cantidad_pilares[index] = (index + 1)
        }
        console.log(cantidad_pilares)

        //insertando indirecto check seleccionado por primera vez y que sean diferentes a Directo o Indirecto
        for (let i = 0; i < this.pilares.length; i++) {
          for (let j = 0; j < this.pilares.length; j++) {
            if (indexs_pilar[i] == (j + 1)) {
              if (this.selectPilar[j] == "") {
                this.selectPilar[j] = "indirecto";
              }
            }
          }
        }

        // Buscar los números faltantes
        let faltantes = cantidad_pilares.filter(elemento => !indexs_pilar.includes(String(elemento)));
        let separando = faltantes.map(Number);

        for (let i = 0; i < this.pilares.length; i++) {
          for (let j = 0; j < this.pilares.length; j++) {
            if (separando[i] == (j + 1)) {
              this.selectPilar[j] = "";
              //console.log("Reseteare"+(j+1)+"La posicion es i:"+i+"y la jota es:"+j)
            }
          }
        }

        if (indexs_pilar.length < this.selectPilar.length) {
          // Calcula la diferencia de longitud
          const diferencia = this.selectPilar.length - this.idsPilares.length;
          // Agrega elementos vacíos ("") al final de idsPilares
          for (let i = 0; i < diferencia; i++) {
            this.idsPilares.push("");
          }
        }

        axios.post('objetivosController.php', {
          idsPilares: ids_pilares
        }).then(response => {
          console.log(response.data[0])
          if (response.data[0][1] == true) {
            if (response.data[0][0].length > 0) {
              //this.pilares = response.data[0][0]
              this.objetivos = response.data[0][0]

              for (let i = 0; i < this.objetivos.length; i++) {
                this.selectObjetivo.push("")
              }

            }
            this.idsObjetivos = []
          } else {
            alert("La consulta Objetivos por Pilares Seleccionados, no se realizo correctamente.")
          }
        }).catch(error => {
          console.log('Erro :-(' + error)
        }).finally(() => {

        })
      } else {
        this.checkObjetivos = []
        this.selectObjetivo = []
        this.objetivos = []
        this.idsPilares = []
      }
    },
    /*VERIFICANDO OBJETIVOS AL CHECKERA */
    checkeandoObjetivos() {
      var ids_objetivos = [];
      var indexs_objetivos = [];
      for (let i = 0; i < this.checkObjetivos.length; i++) {
        var id_objetivo = this.checkObjetivos[i].split('<->')[0];
        var index_objetivo = this.checkObjetivos[i].split('<->')[4];
        ids_objetivos.push(id_objetivo);
        indexs_objetivos.push(index_objetivo);
      }
      this.idsObjetivos = ids_objetivos;

      posiciones_objetivos = [];
      for (let index = 0; index < this.objetivos.length; index++) {//introducciiendo posiciones 0 hasta tamanio
        posiciones_objetivos.push(index + 1);
      }

      //insertando indirecto check seleccionado por primera vez y que sean diferentes a Directo o Indirecto
      for (let i = 0; i < this.objetivos.length; i++) {
        for (let j = 0; j < this.objetivos.length; j++) {
          if (indexs_objetivos[i] == (j + 1)) {
            if (this.selectObjetivo[j] == "") {
              this.selectObjetivo[j] = "indirecto";
            }
          }
        }
      }


      var no_existen_posiciones = posiciones_objetivos.filter(items => !indexs_objetivos.includes(String(items)))//tomo los que no existen en indexs_objetivos.
      var entero_no_existen = no_existen_posiciones.map(Number);//los convierto a valor numerico
      console.log("Los que no existe son:")
      console.log(entero_no_existen)

      entero_no_existen.forEach(posicion => {
        if (posicion >= 0 && posicion < this.selectObjetivo.length + 1) {
          var num = (posicion - 1);
          this.selectObjetivo[num] = "";
          console.log("resetie:" + num);
        }
      });

      //let faltantes = cantidad_pilares.filter(elemento => !indexs_pilar.includes(String(elemento)));

      /*for (let i = 0; i < this.objetivos.length; i++) {// utlizo para que aparazca seleccion en selecObjetivos
       this.selectObjetivo.push("")
     }*/
    },
    checkeandoImpactoAmbiental(id_impacto) {
      console.log(this.idsCheckImpacto = this.checkImpactoAmbiental.map(elementos => elementos.split('<->')[0]))//tomando ids


      if (this.idsCheckImpacto.length <= 0) {
        this.selectEmisiones = this.selectEmisiones.map(() => '');// emiciones a vacio si no existe ningun impacto seleccionado
      }

      //Lo utilizo para limpiar
      const existe = this.idsCheckImpacto.includes(id_impacto)
      if (existe == true) {
        console.log('Existe el impacto ' + existe);
      } else {
        //Si no existe en idsCheckImpacto pero si el selectEmision limpiala
        const index = this.selectEmisiones.findIndex(elemento => elemento.startsWith(`${id_impacto}<->`));
        console.log("index" + index);
        if (index !== -1) {
          console.log("Se vacio la poscion " + index + "Se encontraba el id_impacto: " + id_impacto);
          this.selectEmisiones[index] = "";
        }
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR OBJETIVOS*/
    consultarObjetivos() {
      axios.get('objetivosController.php', {
        params: {
          relacional: 'objetivoNorelacionada'
        }
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.consultarObjetivosRelacional();
            // this.objetivos = response.data[0][0]
          }
        } else {
          alert("La consulta Objetivos, no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PILARES*/
    consultarPilares() {
      axios.get('pilaresController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (!response.data[0][1] == false) {
          if (response.data[0][0].length > 0) {
            this.pilares = response.data[0][0]
            this.allPilares = response.data[0][0]
            this.selectPilar = []  //reseteando
            this.idsPilares = []   //reseteando
            this.checkPilares = []  //reseteando
          }
        } else {
          alert("La consulta Pilares, no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PILARES POR MISION SELECCIONADA*/
    consultarPilaresXmisionSeleccionada() {
      if (this.checkMisiones.length > 0) {
        console.log(this.checkMisiones);

        var misiones_ids = [];
        var id_mision = "";
        for (var i = 0; i < this.checkMisiones.length; i++) {
          var id_mision = this.checkMisiones[i].split('<->')[0];
          misiones_ids.push(id_mision);
        }
        this.checkPilares = []
        this.checkObjetivos = []
        this.selectPilar = []
        axios.post('pilaresController.php', {
          idsMisiones: misiones_ids
        }).then(response => {
          console.log(response.data[0])
          if (response.data[0][1] == true) {
            if (response.data[0][0].length > 0) {
              this.pilares = response.data[0][0]
              //this.objetivos = response.data[0][2]
              /*inicializo selectPilar en Seleccione*/
              for (let i = 0; i < this.pilares.length; i++) {
                this.selectPilar.push("")
              }
            }
          } else {
            alert("La consulta Pilares por Misiones Seleccionadas, no se realizo correctamente.")
          }
        }).catch(error => {
          console.log('Erro :-(' + error)
        }).finally(() => {

        })
      } else {
        this.pilares = ''
        this.objetivos = ''
        this.checkPilares = []
        this.checkObjetivos = []
        this.selectPilar = []
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PILARES*/
    consultarMisiones() {
      axios.get('misionesController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (!response.data[0][1] == false) {
          if (response.data[0][0].length > 0) {
            this.misiones = response.data[0][0]
            this.allMisiones = response.data[0][0]
          } else {
            this.allMisiones = []
            this.misiones = []
          }
        } else {
          alert("La consulta Misiones, no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR MISIONES RELACIONADAS A PILARES*/
    consultarMisionesRelacional() {
      axios.get('misionesController.php', {
        params: {
          relacional: "relacionada"
        }
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          this.consultarPilares() //todas las acciones sobre pilar que me consulte nuevamente pilares
          if (response.data[0][0].length > 0) {
            this.pilaresRelacion = response.data[0][0]
          } else {
            this.pilaresRelacion = [];
          }
        } else {
          alert("La consulta Misiones, no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR OBJETIVOS RELACIONADOS A PILARES*/
    consultarObjetivosRelacional() {
      axios.get('objetivosController.php', {
        params: {
          relacional: "relacionada"
        }
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.objetivos_ligados = response.data[0][0]

          } else {
            this.objetivos_ligados = [];
          }
        } else {
          alert("La consulta de Objetivos relacionados, no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR IMPACTO AMBIENTAL*/
    consultarImpactoAmbiental() {
      axios.get('impactoAmbientalController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.impactoAmbiental = response.data[0][0]
            this.impactoAmbiental.forEach((elemento, index) => { this.selectEmisiones[index] = '' })
          } else {
            this.impactoAmbiental = []
          }
        } else {
          alert("La consulta impacto ambieltal, no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR VALORES*/
    consultarValores() {
      axios.get('valoresController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.valores = response.data[0][0]
          } else {
            this.valores = []
          }
        } else {
          alert("La consulta valores, no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR IMPACTO AMBIENTAL*/
    descargarExcel() {
      axios.post('descargar_excel.php', {
      }).then(response => {
        console.log(response.data)
        if (response.data.success) {
          // Crear un enlace temporal para descargar el archivo
          const link = document.createElement('a');
          link.href = 'reportes/' + response.data.archivo;
          link.download = response.data.archivo;

          // Agregar el enlace al DOM y hacer clic en él
          document.body.appendChild(link);
          link.click();

          // Eliminar el enlace del DOM después de la descarga
          document.body.removeChild(link);
        } else {
          alert("No se genero el archivo.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })

    },
    /*/////////////////////////////////////////////////////////////////////////////////SUMA IMPACTO AMBIENTAL*/
    sumaImpactoAmbiental() {
      axios.post('impactoAmbientalController.php', {
        suma: 'suma'
      }).then(response => {
        console.log("SUMAS")
        console.log(response.data)
        if (response.data[0][1] == true) {
          this.sumasImpactoAmbiental = response.data[0][0]
        } else {
          alert("La consulta sumaImpactoAmbiental, no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PLANTA*/
    insertarPlanta() {
      if (this.nueva != "" && this.siglas != "") {
        axios.post('plantasController.php', {
          nueva: this.nueva,
          siglas: this.siglas
        }).then(response => {
          this.nueva = ''
          this.siglas = ''
          console.log(response.data)
          if (!response.data[0] == false) {
            this.myModalCRUD.hide()
            this.consultarPlantas()
          } else {
            alert("La inserción de Planta, no se realizo correctamente.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Nombre y Siglas son requeridos")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR ESTANDARES CO2*/
    insertarEstandaresCO2() {
      if (this.nueva !== '' && this.cantidad !== '' && this.unidadMedida !== '' && this.descripcionCa !== '') { //&& this.descripcionUM !== ''
        axios.post('estandaresCO2Controller.php', {
          nueva: this.nueva,
          cantidad: this.cantidad + ' ' + this.descripcionCa,
          //unidadMedida: this.unidadMedida+' '+this.descripcionUM
          unidadMedida: this.unidadMedida
        }).then(response => {
          this.nueva = ''
          this.cantidad = ''
          this.unidadMedida = ''
          this.descripcionCa = ''
          this.descripcionUM = ''
          console.log(response.data)
          if (!response.data[0] == false) {
            // this.myModalCRUD.hide()
            this.consultarEstandaresCO2()
            alert('Alta exitosa..');
            this.myModal.hide();
          } else {
            alert("La inserción de Planta, no se realizo correctamente.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert('Todos los campos son obligatorios')
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PLANTAS*/
    consultarEstandaresCO2() {
      axios.get('estandaresCO2Controller.php', {
      }).then(response => {
        console.log(response.data[0])
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.estandares = response.data[0][0]
          } else {
            this.estandares = []
          }
        } else {
          alert("La consulta  plantas no se realizo correctamente.")
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR AREAS*/
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PLANTA*/
    insertarImpactoAmbiental() {
      if (this.nueva != '') {
        axios.post('impactoAmbientalController.php', {
          nueva: this.nueva
        }).then(response => {
          this.nueva = ''
          console.log(response.data)
          if (!response.data[0] == false) {
            // this.myModalCRUD.hide()
            this.consultarImpactoAmbiental()
            this.myModal.hide();
            alert('Alta exitosa..');
          } else {
            alert("La inserción de Planta, no se realizo correctamente.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert('Todos los campos son obligatorios')
      }
    },

    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR FUENTE*/
    insertarFuente() {
      if (this.nueva != '' && this.siglas != '') {
        axios.post('fuentesController.php', {
          nueva: this.nueva,
          siglas: this.siglas
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.nueva = ''
            this.siglas = ''
            // this.myModalCRUD.hide()
            this.consultarFuentes()
            this.myModal.hide();
            alert('Alta exitosa..');
          } else {
            alert("La inserción de Fuente, no se realizo correctamente.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert('Todos los campos son obligatorios')
      }
    },


    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR ÁREAS*/
    insertarArea() {
      axios.post('areasController.php', {
        nueva: this.nueva,
        siglas: this.siglas
      }).then(response => {
        console.log(response.data)
        if (!response.data[0] == false) {
          this.myModalCRUD.hide()
          this.consultarAreas()
        } else {
          alert("La inserción de Área, no se realizo correctamente.")
        }

      }).catch(error => {
        //console.log('Erro :-('+error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR DEPARTAMENTO*/
    insertarDepartamento() {
      if (this.nueva != "" && this.siglas != "") {
        axios.post('departamentosController.php', {
          nueva: this.nueva,
          siglas: this.siglas
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModalCRUD.hide()
            this.consultarDepartamentos()
            this.siglas = ''
          } else {
            alert("La inserción, no se realizo correctamente.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Nombre y Siglas son requeridos")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR METODOLOGIA*/
    insertarMetodologia() {
      axios.post('metodologiasController.php', {
        nueva: this.nueva
      }).then(response => {
        console.log(response.data)
        if (response.data[0] == true) {
          this.myModalCRUD.hide()
          this.consultarMetodologias()
        } else {
          alert("La inserción Metodologías, no se realizo correctamente.")
        }

      }).catch(error => {
        //console.log('Erro :-('+error)
      }).finally(() => {

      })
    },

    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR RESPONSABLE*/
    insertarResponsable() {
      if (this.nuevoResponsable == true && this.nombre != '' && this.numero_nomina != '' && this.correo != '' && this.telefono != '') {
        axios.post('responsablesController.php', {
          nombre: this.nombre,
          numero_nomina: this.numero_nomina,
          correo: this.correo,
          telefono: this.telefono,
          financiero: this.financiero
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.consultarResponsables()
            this.selectResponsable = ''
            this.nombre = ''
            this.numero_nomina = ''
            this.correo = ''
            this.telefono = ''
            this.financiero = false
            this.nuevoResponsable = false
          } else {
            alert("La inserción Responsable, no se realizo correctamente.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos de nuevo Responsable son obligatorios")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR OBJETIVO*/
    insertarObjetivo() {
      console.log(this.nueva)
      if (this.nueva != '' && this.siglas != '' && this.select_pilar != '') {
        axios.post('objetivosController.php', {
          nueva: this.nueva,
          siglas: this.siglas,
          id_pilar: this.select_pilar
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            // this.myModalCRUD.hide()
            this.consultarObjetivosRelacional();
            alert('Alta exitosa..');
            this.myModal.hide();
            this.siglas = ''
            this.nueva = ''
            this.select_pilar = ''
          } else {
            alert("La inserción, no se realizo correctamente.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PILAR*/
    insertarPilar() {
      if (this.nueva != '' && this.siglas != '' && this.select_mision != '') {
        axios.post('pilaresController.php', {
          nueva: this.nueva,
          siglas: this.siglas,
          id_mision: this.select_mision
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            //this.myModalCRUD.hide()
            this.consultarMisionesRelacional()

            alert('Alta exitosa..');
            this.myModal.hide();
            this.nueva = ''
            this.siglas = ''
            this.select_mision = ''
          } else {
            alert("La inserción Pilar, no se realizo correctamente.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PILAR*/
    insertarMision() {
      if (this.nueva != '') {
        axios.post('misionesController.php', {
          nueva: this.nueva,
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            //this.myModalCRUD.hide
            this.myModal.hide()
            alert("Alta exitosa..")
            this.consultarMisiones()
            this.nueva = ''
          } else {
            alert("La inserción Mision, no se realizo correctamente.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR PLANTA*/
    actualizarPlanta() {
      if (this.selectPlanta != "") {
        axios.put('plantasController.php', {
          idPlanta: this.id,
          nuevoNombre: this.nuevoNombre,
          siglas: this.siglas
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModalCRUD.hide()
            this.consultarPlantas()
            this.selectPlanta = '',
              this.id = '',
              this.nuevoNombre = ''
          } else {
            alert("No se actualizo.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR AREA*/
    actualizarArea() {
      if (this.selectArea != "") {
        axios.put('areasController.php', {
          id: this.id,
          nuevo: this.nuevoNombre,
          siglas: this.siglas
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModalCRUD.hide()
            this.consultarAreas()
            this.selectArea = '',
              this.id = '',
              this.nuevoNombre = ''
            this.siglas
          } else {
            alert("No se actualizo.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR DEPARTAMENTO*/
    actualizarDepartamento() {
      if (this.selectDepartamento != "") {
        axios.put('departamentosController.php', {
          id: this.id,
          nuevo: this.nuevoNombre,
          siglas: this.siglas
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModalCRUD.hide()
            this.consultarDepartamentos()
            this.selectDepartamento = '',
              this.id = '',
              this.nuevoNombre = ''
          } else {
            alert("No se actualizo.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR METODOLOGIA*/
    actualizarMetodologia() {
      if (this.selectMetodologia != "") {
        axios.put('metodologiasController.php', {
          id: this.id,
          nuevo: this.nuevoNombre
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModalCRUD.hide()
            this.consultarMetodologias()
            this.selectMetodologia = '',
              this.id = '',
              this.nuevoNombre = ''
          } else {
            alert("No se actualizó la Metodología.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Selecione la metodología a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR RESPONSABLE*/
    actualizandoResponsable() {
      axios.put('responsablesController.php', {
        nombre: this.nombre,
        numero_nomina: this.numero_nomina,
        correo: this.correo,
        telefono: this.telefono,
        financiero: this.financiero,
        id: this.id
      }).then(response => {
        console.log(response.data)
        if (response.data[0] == true) {
          this.consultarResponsables()
          this.nombre = ''
          this.numero_nomina = ''
          this.correo = ''
          this.telefono = ''
          this.financiero = false
          this.id = ''
          this.actualizarResponsable = false
          this.nuevoResponsable = false
          this.selectResponsable = ''
          alert("Se actualizo correctamente")
        } else {
          alert("No se actualizó la Metodología.")
        }
      }).catch(error => {
        //console.log('Erro :-('+error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR OBJETIVO*/
    actualizarObjetivo() {
      if (this.nuevoNombre != '' && this.siglas != '' && this.select_pilar != '') {
        axios.put('objetivosController.php', {
          id: this.id,
          nombre: this.nuevoNombre,
          siglas: this.siglas,
          id_pilar: this.select_pilar,
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModalCRUD.hide();
            this.consultarObjetivosRelacional();
            this.nuevoNombre = ''
            this.siglas = ''
            this.id = ''
            this.select_pilar = ''
            this.checkObjetivos = []
          } else {
            alert("No se actualizo el Objetivo.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos para poder actualizar.")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR IMPACTO AMBIENTAL*/
    actualizarImpactoAmbiental() {
      if (this.nuevoNombre != '') {
        axios.put('impactoAmbientalController.php', {
          id: this.id,
          nuevo: this.nuevoNombre
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModal.hide();
            this.consultarImpactoAmbiental()
            this.id = ''
            this.nuevoNombre = ''
            alert("Se actualizo correctamente.")
          } else {
            alert("No se actualizo el Objetivo.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos para poder actualizar.")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR IMPACTO AMBIENTAL*/
    actualizarFuente() {
      if (this.nuevoNombre != '' && this.siglas != '') {
        axios.put('fuentesController.php', {
          id: this.id,
          nuevo: this.nuevoNombre,
          siglas: this.siglas
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModal.hide();
            this.consultarFuentes()
            this.id = ''
            this.nuevoNombre = ''
            this.siglas = ''
            alert("Se actualizo correctamente.")
          } else {
            alert("No se actualizo la Fuente.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos para poder actualizar.")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR MISION*/
    actualizarMision() {
      if (this.nueva != '') {
        axios.put('misionesController.php', {
          id: this.id,
          nuevo: this.nueva
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModal.hide();
            this.consultarMisiones()
            this.consultarMisionesRelacional()
            this.id = ''
            this.nueva = ''
            alert("Se actualizo correctamente.")
          } else {
            alert("No se actualizo la Mision.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos para poder actualizar.")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR ESTANDARES*/
    actualizarEstandaresCO2() {
      if (this.nuevoNombre != '' && this.cantidad != '' && this.unidadMedida != '') {
        axios.put('estandaresCO2Controller.php', {
          id: this.id,
          nuevo: this.nuevoNombre,
          cantidad: this.cantidad,
          unidadMedida: this.unidadMedida
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModal.hide();
            this.consultarEstandaresCO2()
            this.id = ''
            this.nuevoNombre = ''
            this.cantidad = ''
            this.unidadMedida = ''
            alert("Se actualizo correctamente.")
          } else {
            alert("No se actualizo el Objetivo.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos para poder actualizar.")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR PILARES*/
    actualizarPilares() {
      if (this.nuevoNombre != '' && this.siglas != '' && this.misionLigada != '') {
        axios.put('pilaresController.php', {
          id: this.id,
          nuevo: this.nuevoNombre,
          siglas: this.siglas,
          misionLigada: this.misionLigada,
          n_mision: this.n_mision,
          id_mision_ligada: this.id_mision_ligada
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModal.hide();
            this.consultarObjetivosRelacional()
            this.consultarMisionesRelacional()
            this.id = ''
            this.nuevoNombre = ''
            this.misionLigada = ''
            this.siglas = ''
            this.n_mision = ''
            this.id_mision_ligada = ''

            alert("Se actualizo correctamente.")
          } else {
            alert("No se actualizo el Pilar.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos para poder actualizar.")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR PILARES*/
    actualizarObjetivos() {
      if (this.nuevoNombre != '' && this.siglas != '' && this.select_pilar != '') {
        // console.log("ID: "+this.id+"Nombre: "+this.nuevoNombre+"Siglas: "+this.siglas+"ID_Pilar"+this.select_pilar)
        axios.put('objetivosController.php', {
          id: this.id,
          nuevo: this.nuevoNombre,
          siglas: this.siglas,
          select_pilar: this.select_pilar
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.myModal.hide();
            this.consultarObjetivos()
            //this.consultarObjetivosRelacional()
            this.id = ''
            this.nuevoNombre = ''
            this.siglas = ''
            this.cantidad = ''
            alert("Se actualizo correctamente.")
          } else {
            alert("No se actualizo el Objetivo.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      } else {
        alert("Todos los campos son requeridos para poder actualizar.")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR PLANTA*/
    eliminarPlanta() {
      const id_nombre_planta = this.selectPlanta.split('<->');
      this.id = id_nombre_planta[0]
      var nombre_planta = id_nombre_planta[1]
      console.log(this.selectPlanta)
      if (this.selectPlanta != "") {
        if (confirm("¿Desea eliminar la planta " + nombre_planta + "?")) {
          axios.delete('plantasController.php', {
            data: {
              id: this.id
            }
          }).then(response => {
            console.log(response.data)
            if (response.data[0] == true) {
              this.selectPlanta = "";
              this.myModalCRUD.hide()
              this.consultarPlantas()
              this.id = ''
            } else {
              alert("No se elimino.")
            }

          }).catch(error => {
            //console.log('Erro :-('+error)
          }).finally(() => {

          })
        }
      } else {
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR PLANTA*/
    eliminarMision(id) {
      if (confirm("¿Desea eliminar la mision? \n Se eliminara pilares y objetivos ligados")) {
        axios.delete('misionesController.php', {
          data: {
            id: id
          }
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            // this.myModalCRUD.hide()
            console.log('se elimino correctamente')
            this.consultarMisiones();
            this.consultarMisionesRelacional();
            this.consultarObjetivosRelacional();
            this.id = ''
          } else {
            alert("No se elimino.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      }

    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR PLANTA*/
    eliminarPilar(id) {
      if (confirm("¿Desea eliminar el Pilar?")) {
        axios.delete('pilaresController.php', {
          data: {
            id: id
          }
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            // this.myModalCRUD.hide()
            this.consultarMisionesRelacional()
            this.consultarObjetivosRelacional()
            this.id = ''
          } else {
            alert("No se elimino.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR AREA*/
    eliminarArea() {
      const id_nombre_area = this.selectArea.split('<->');
      this.id = id_nombre_area[0]
      var nombre = id_nombre_area[1]
      console.log(this.selectArea)
      if (this.selectArea != "") {
        if (confirm("¿Desea eliminar la área " + nombre + "?")) {
          axios.delete('areasController.php', {
            data: {
              id: this.id
            }
          }).then(response => {
            console.log(response.data)
            if (response.data[0] == true) {
              this.selectArea = "";
              this.myModalCRUD.hide()
              this.consultarAreas()
              this.id = ''
            } else {
              alert("No se elimino.")
            }

          }).catch(error => {
            //console.log('Erro :-('+error)
          }).finally(() => {

          })
        }
      } else {
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR DEPARTAMENTOS*/
    eliminarDepartamento() {
      const id_nombre_area = this.selectDepartamento.split('<->');
      this.id = id_nombre_area[0]
      var nombre = id_nombre_area[1]
      console.log(this.selectDepartamento)
      if (this.selectDepartamento != "") {
        if (confirm("¿Desea eliminar Departamento: " + nombre + "?")) {
          axios.delete('departamentosController.php', {
            data: {
              id: this.id
            }
          }).then(response => {
            console.log(response.data)
            if (response.data[0] == true) {
              this.selectDepartamento = "";
              this.myModalCRUD.hide()
              this.consultarDepartamentos()
              this.id = ''
            } else {
              alert("No se elimino.")
            }

          }).catch(error => {
            //console.log('Erro :-('+error)
          }).finally(() => {

          })
        }
      } else {
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR METODOLOGIAS*/
    eliminarMetodologia() {
      const id_nombre_area = this.selectMetodologia.split('<->');
      this.id = id_nombre_area[0]
      var nombre = id_nombre_area[1]
      console.log(this.selectMetodologia)
      if (this.selectMetodologia != "") {
        if (confirm("¿Desea eliminar la Metodología: " + nombre + "?")) {
          axios.delete('metodologiasController.php', {
            data: {
              id: this.id
            }
          }).then(response => {
            console.log(response.data)
            if (response.data[0] == true) {
              this.selectMetodologia = "";
              this.myModalCRUD.hide()
              this.consultarMetodologias()
              this.id = ''
            } else {
              alert("No se elimino la Metodología.")
            }

          }).catch(error => {
            //console.log('Erro :-('+error)
          }).finally(() => {

          })
        }
      } else {
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR FUENTE*/
    eliminarFuente(id) {
      if (confirm("¿Desea eliminar la fuente?")) {
        axios.delete('fuentesController.php', {
          data: {
            id: id
          }
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.consultarFuentes()
          } else {
            alert("No se elimino.")
          }

        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
    eliminarResponsable() {
      const id_nombre_responsable = this.selectResponsable.split('<->');
      this.id = id_nombre_responsable[0]
      var nombre = id_nombre_responsable[1]
      console.log(this.selectResponsable)
      if (this.selectResponsable != "") {
        if (confirm("¿Desea eliminar al Responsable: " + nombre + "?")) {
          axios.delete('responsablesController.php', {
            data: {
              idResponsable: this.id
            }
          }).then(response => {
            console.log(response.data)
            if (response.data[0] == true) {
              this.consultarResponsables()
              this.nombre = ''
              this.numero_nomina = ''
              this.correo = ''
              this.telefono = ''
              this.id = ''
              this.actualizarResponsable = false
              this.nuevoResponsable = false
              this.selectResponsable = ''
            } else {
              alert("No se elimino al Responsable.")
            }
          }).catch(error => {
            //console.log('Erro :-('+error)
          }).finally(() => {

          })
        }
      } else {
        alert("Selecione la planta a eliminar")
      }
    },

    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
    eliminarObjetivo(id) {
      if (confirm("¿Desea eliminar el Objetivo?")) {
        axios.delete('objetivosController.php', {
          data: {
            id: id
          }
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.consultarObjetivosRelacional();
            this.id = ''
          } else {
            alert("No se elimino al Responsable.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
    eliminarImpactoAmbiental(id) {
      if (confirm("¿Desea eliminar el Impacto Ambiental?")) {
        axios.delete('impactoAmbientalController.php', {
          data: {
            id: id
          }
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.consultarImpactoAmbiental()
            this.id = ''
            this.nuevoNombre = ''
          } else {
            alert("No se elimino al Responsable.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
    eliminarEstandares(id) {
      if (confirm("¿Desea eliminar el Estandar ?")) {
        axios.delete('estandaresCO2Controller.php', {
          data: {
            id: id
          }
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.consultarEstandaresCO2()
            this.id = ''
          } else {
            alert("No se elimino al Responsable.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      }
    },
    eliminarProyecto(id, nombre_proyecto) {
      if (confirm("¿Desea eliminar el Proyecto '" + nombre_proyecto + "'?")) {
        axios.delete('proyectosController.php', {
          data: {
            id: id
          }
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.consultarProyectos();
            this.id = ''
            alert("Se elimino Correctamente el proyecto '" + nombre_proyecto + "'.")
          } else {
            alert("No se elimino el proyecto '" + nombre_proyecto + "'.")
          }
        }).catch(error => {
          //console.log('Erro :-('+error)
        }).finally(() => {

        })
      }
    },
    verificarCantidadDirectosPilares() {
      const directoIndices = [];
      // Encuentra los índices de los elementos 'directo'
      this.selectPilar.forEach((item, index) => {
        if (item === 'directo') {
          directoIndices.push(index);
        }
      });

      if (directoIndices.length > 1) {
        // Si hay más de un 'directo', deseleccionar el último 'directo'
        const lastIndex = directoIndices.pop();
        this.selectPilar[lastIndex] = 'indirecto';
        alert("No puedo tener dos Pilares Directos, solo uno");
      }
    },
    verificarCantidadDirectosObjetivos() {
      const directoIndices = [];
      // Encuentra los índices de los elementos 'directo'
      this.selectObjetivo.forEach((item, index) => {
        if (item === 'directo') {
          directoIndices.push(index);
        }
      });

      if (directoIndices.length > 1) {
        // Si hay más de un 'directo', deseleccionar el último 'directo'
        const lastIndex = directoIndices.pop();
        this.selectObjetivo[lastIndex] = 'indirecto';
        alert("No puedo tener dos Objetivos Directos, solo uno");
      }
    },
    /*////////////////////////////////////////////////////////////////////////////////////////////////*/
    crearResponsable() {
      this.nuevoResponsable = true;
      this.actualizarResponsable = false;
      this.nombre = ''
      this.numero_nomina = ''
      this.correo = ''
      this.telefono = ''
    },
    consultaImpactosAmbientalesConDatos(id) {
      axios.get("impactoAmbientalController.php", {
        params: {
          accion: 'impactos con datos',
          id_proyecto: id
        }
      }).then(response => {
        if (response.data[0] === true) {
          this.impactosConDatos = response.data[1].map(elementos => elementos.id + '<->' + elementos.nombre)
          //console.log(this.impactosConDatos)
        } else {
          console.log("No se realizo la consulta Impactos Ambientales con datos", response.data)
        }
      }).catch(error => {
        console.log("Error en consultaImpactosAmbientalesConDatos: " + error)
      })
    },
    consultaProyectoIDActualizar(id) {
      axios.post('proyectosController.php', {
        id_proyecto: id //ID PROYECTO
      }).then(response => {
        if (response.data[0][1] == true) {
          this.idsCheckImpacto = []
          this.checkImpactoAmbiental = []
          let impactosAmbientaslesBD = this.impactoAmbiental

          let proyecto = response.data[0][0][0]

          let checkImpacto = this.checkImpactoAmbiental
          let valores = JSON.parse(proyecto.valores)
          this.valoresCheck = valores //asignando los valores checkeados

          impacto_ambientales = JSON.parse(proyecto.impacto_ambiental)//conviertiendo a arreglo impacto y alcance (si es que tiene)
          impacto_ambiental = impacto_ambientales.map(impactos => impactos.split('->')[0]) //si existe alcance solo tomar el impacto


          if (!impacto_ambientales.some(sinImpacto => sinImpacto == "Sin Impacto")) {// Si no hay impacto no hacer nada
            console.log("Ejecutando")
            impactos_con_id = impacto_ambiental.flatMap(impactos => {//busco los impactos para encontrar su id
              return impactosAmbientaslesBD.find(elementos => elementos.nombre == impactos);
            })

            checkImpacto = impactos_con_id.map(impacto => impacto.id + '<->' + impacto.nombre)//para que se checkend
            this.idsCheckImpacto = checkImpacto.map(impactoids => impactoids.split('<->')[0])//asigno los ids
            this.checkImpactoAmbiental = checkImpacto

            let resultado = []
            impactosAmbientaslesBD.forEach((elementos, index) => {
              resultado[index] = ""
              if (impacto_ambientales.some(impactoProyecto => impactoProyecto.split('->')[1]) && impacto_ambientales.some(impactoProyecto => impactoProyecto.split('->')[0] == elementos.nombre)) {
                resultado[index] = elementos.id + "<->" + elementos.nombre + "->" + impacto_ambientales.filter(impactoProyecto => impactoProyecto.split('->')[0] == elementos.nombre).map(imp => imp.split('->')[1]);
              }
            })

            if (impacto_ambientales.some(verificando => verificando.split('->')[1])) {//solo verifico que exista minimo un impacto ambietal con "->"
              this.selectEmisiones = resultado;
            }
          }


        } else {
          alert("La consulta de proyectos no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Error consultaProyectoIDActualizar :-(' + error)
      });
    },
    verificarImpacto(impacto) {
      let impactosConDatos = this.impactosConDatos;
      return impactosConDatos.includes(impacto)
    },
    //this.impactosConDatos
    abrirModal(modal, tipo, accion, id, nombre_proyecto) {
      //this.nombre_proyecto = ''
      this.tipo = tipo
      this.accion = accion

      //resetando variables
      this.titulo_modal = ''
      this.nueva = ''
      this.respondio = true;
      if (modal == "Alta") {
        this.actualizar_proyecto = false
        this.titulo_modal = "Alta Proyecto"
        this.myModal = new bootstrap.Modal(document.getElementById("modal-alta-proyecto"))
        this.myModal.show()
        this.consultarPlantas()
        this.consultarAreas()
        this.consultarDepartamentos()
        this.consultarMetodologias()
        this.consultarResponsables()
        this.consultarImpactoAmbiental()
        this.consultarMisiones()
        this.consultarFuentes()
        this.consultarValores()
        this.buscarDocumentos('Alta Proyecto')
        this.incrementarMeses();
        this.inicializarArreglosPlanMensual();


      } else if (modal == "Actualizar Proyecto") {
        this.valoresCheck = [] //la limpio
        this.titulo_nombre_proyecto = nombre_proyecto
        this.id_actualizar = id
        this.actualizar_proyecto = true
        this.titulo_modal = "Actualizar Proyecto"
        this.myModal = new bootstrap.Modal(document.getElementById("modal-alta-proyecto"))
        this.myModal.show()

        //lo usos para verificar si el impacto ya contiene datos y evitar que puedan manipularlos al actualizar el proyecto
        this.consultaImpactosAmbientalesConDatos(id)
        this.consultarPlantas()
        this.consultarAreas()
        this.consultarDepartamentos()
        this.consultarMetodologias()
        this.consultarResponsables()
        this.consultarImpactoAmbiental()
        this.consultarMisiones()
        this.consultarFuentes()
        this.consultarValores()
        this.consultarPlanMensualProyecto(id);
        setTimeout(() => {
          this.consultaProyectoIDActualizar(id)
        }, 200)


      } else if (modal == "CRUD") {
        this.myModalCRUD = new bootstrap.Modal(document.getElementById("modal-alta-crud"))
        if (accion == "Crear") {
          this.select_pilar = '';
          this.siglas = '';
          this.myModalCRUD.show()
        } else if (accion == "Actualizar") {
          if (tipo == "Planta") {
            if (this.selectPlanta != "") {
              this.myModalCRUD.show()
              const id_nombre_planta = this.selectPlanta.split('<->');//separando
              this.id = id_nombre_planta[0]//recuperando nombre planta
              this.nuevoNombre = id_nombre_planta[1]//recuperando nombre planta
              this.siglas = this.siglas = id_nombre_planta[2]
            } else {
              alert("Favor de seleccionar la Planta que actualizará")
            }
          }
          if (tipo == "Área") {
            console.log(this.selectArea)
            if (this.selectArea != "") {
              this.myModalCRUD.show()
              const id_nombre_area = this.selectArea.split('<->');//separando
              this.id = id_nombre_area[0]//recuperando ID
              this.nuevoNombre = id_nombre_area[1]//recuperando Nombre  
              this.siglas = id_nombre_area[2]//recuperando Siglas
            } else {
              alert("Favor de seleccionar la Área que actualizará")
            }
          }
          if (tipo == "Departamento") {
            console.log(this.selectDepartamento)
            if (this.selectDepartamento != "") {
              this.myModalCRUD.show()
              const id_nombre = this.selectDepartamento.split('<->');//separando 
              this.id = id_nombre[0]//recuperando nombre planta
              this.nuevoNombre = id_nombre[1]//recuperando nombre planta
              this.siglas = id_nombre[2]//recuperando siglas de departamento
            } else {
              alert("Favor de seleccionar la Departamento que actualizará")
            }
          }
          if (tipo == "Metodología") {
            console.log(this.selectMetodologia)
            if (this.selectMetodologia != "") {
              this.myModalCRUD.show()
              const id_nombre = this.selectMetodologia.split('<->');//separando 
              this.id = id_nombre[0]//recuperando nombre planta
              this.nuevoNombre = id_nombre[1]//recuperando nombre planta
            } else {
              alert("Favor de seleccionar la Departamento que actualizará")
            }
          }
          if (tipo == "Objetivo") {
            console.log(this.checkObjetivos)
            if (this.checkObjetivos != "") {
              if (this.checkObjetivos.length == 1) {
                this.myModalCRUD.show()
                const id_nombre_idpilar_siglas = this.checkObjetivos[0].split('<->');//separando
                this.id = id_nombre_idpilar_siglas[0]//recuperando nombre planta
                this.nuevoNombre = id_nombre_idpilar_siglas[1]//recuperando nombre planta*/
                this.select_pilar = id_nombre_idpilar_siglas[2]
                this.siglas = id_nombre_idpilar_siglas[3]//recuperando nombre planta*/
              } else {
                alert("Seleccione solo un Objetivo para actualizar")
              }
            } else {
              alert("Favor de seleccionar el Objetivo que actualizará")
            }
          }
        }
      } else {
        alert("No encontramos esa modal")
      }
    },
    consultarPlanMensualProyecto(id) {
      axios.get("planMensualController.php", {
        params: {
          id: id
        }
      }).then(response => {
        if (response.data[1] === true) {
          if (response.data[0].length > 0) {
            console.log("Response", response.data[0].length)
            console.log("Response", response.data[0])
            this.idsPlanMesual = response.data[0].map(items => items.id)
            this.AnioXMes = response.data[0].map(items => items.anio)
            this.MesXAnio = response.data[0].map(items => items.mes)
            this.inputValorMensualCO = response.data[0].map(items => items.ahorro_co)
            this.inputValorMensualAD = response.data[0].map(items => items.ahorro_d)
            this.inputValorMensualAS = response.data[0].map(items => items.ahorro_s)

          } else {
            this.inicializarArreglosPlanMensual()//Si no existen datos inicializarlos
          }
        } else {
          alert("No se consulto lo proyectado mes con mes");
        }
      }).catch(error => {
        console.log("Error :-(", error);
      })
    },
    cerrarModal() {
      this.myModal.hide()
    },
    cancelar() {
      this.nuevoResponsable = false;
      this.actualizarResponsable = false;
    },
    varificandoSelecion() {
      var imagen_seleccion = document.getElementById('input_file_subir').value;
      if (imagen_seleccion != null) {
        this.existeImagenSeleccionada = true;
      }
    },
    varificandoSelecionSeguimiento() {
      var imagen_seleccion = document.getElementById('input_file_seguimiento').value;
      if (imagen_seleccion != null) {
        this.existeImagenSeleccionadaSeguimiento = true;
      }
    },
    verificandoSelecionCO2() {
      var imagen_seleccion = document.getElementById('input_file_co2').value;
      if (imagen_seleccion != null) {
        this.existeImagenSeleccionadaCO2 = true;

      }
    },
    buscarDocumentos(cual_documento, ids) {
      this.imagenes = []
      axios.post("buscar_documentos.php", {
        documento: cual_documento,
        id: this.id_proyecto,
        ids: ids
      })
        .then(response => {
          if (cual_documento == "Alta Proyecto") {
            this.imagenes = response.data
            if (this.imagenes.length > 0) {
              console.log(this.imagenes + "Archivos encontrados.")
              this.random = Math.random()
            } else {
              console.log(this.imagenes + "Sin imagen encontrada.")
            }
          }
          if (cual_documento == "Seguimiento") {
            this.documentos_seguimiento = response.data
            if (this.documentos_seguimiento.length > 0) {
              console.log(this.documentos_seguimiento + "Archivos encontrados.")
              this.random = Math.random()
            } else {
              console.log(this.documentos_seguimiento + "Sin imagen encontrada.")
            }
          }
          if (cual_documento == "Documento CO2") {
            this.documentos_co2 = response.data
            if (this.documentos_co2.length > 0) {
              console.log(this.documentos_co2 + "Archivos encontrados.")
              this.random = Math.random()
            } else {
              console.log(this.documentos_co2 + "Sin imagen encontrada.")
            }
          }
          if (cual_documento == "Estatus") {
            var objeto = { "id": ids, "cantidad": response.data.length }
            this.cantidadDocumentos.push(objeto)
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    buscarDocumentosEnFinancieros(cual_documento, id) {
      this.imagenes = []
      axios.post("buscar_documentos.php", {
        documento: cual_documento,
        id: id
      })
        .then(response => {
          if (cual_documento == "Seguimiento") {
            this.documentos_seguimiento_financiero = response.data
            if (this.documentos_seguimiento_financiero.length > 0) {
              console.log(this.documentos_seguimiento_financiero + "Archivos encontrados.")
              this.random = Math.random()
            } else {
              console.log(this.documentos_seguimiento_financiero + "Sin imagen encontrada.")
            }
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    uploadFile(cual_documento) {
      this.login = true
      let formData = new FormData();
      if (cual_documento == 'Alta Proyecto') {
        var files = this.$refs.ref_imagen.files;
        var totalfiles = this.$refs.ref_imagen.files.length;
      }

      if (cual_documento == 'Seguimiento') {
        var files = this.$refs.ref_seguimiento.files;
        var totalfiles = this.$refs.ref_seguimiento.files.length;
      }

      if (cual_documento == 'Documento CO2') {
        var files = this.$refs.ref_co2.files;
        var totalfiles = this.$refs.ref_co2.files.length;
      }

      for (var index = 0; index < totalfiles; index++) {
        formData.append("files[]", files[index]);//arreglo de documentos_seguimiento
      }
      formData.append("id", this.id_proyecto);
      formData.append("cual_documento", cual_documento);
      axios.post("subir_imagen.php", formData,
        {
          headers: { "Content-Type": "multipart/form-data" }
        })
        .then(response => {
          console.log(response.data);
          if (response.data.length > 0) {
            if (cual_documento == "Alta Proyecto") {
              this.imagenes = response.data;
              if (this.imagenes.length > 0) {
                document.getElementById("input_file_subir").value = ""
                this.existeImagenSeleccionada = false;
                this.random = Math.random()
              }
            }
            if (cual_documento == "Seguimiento") {
              if (response.data.length > 0) {
                document.getElementById("input_file_seguimiento").value = ""
                this.existeImagenSeleccionadaSeguimiento = false;
                this.random = Math.random()
                alert("Se agregaron con Éxito")
                this.buscarDocumentos('Seguimiento')
              }
            }
            if (cual_documento == "Documento CO2") {
              if (response.data.length > 0) {
                document.getElementById("input_file_co2").value = ""
                this.existeImagenSeleccionadaCO2 = false;
                this.random = Math.random()
                alert("Se agregaron con Éxito")
                this.buscarDocumentos('Documento CO2')
              }
            }
          } else {
            this.login = false
            alert("Verifique la extension del archivo o Intente nuevamente.")
          }
        })
        .catch(error => {
          this.login = false
          console.log(error);
        }).finally(() => {
          this.login = false
          /*setTimeout(() => {
            this.login = false
          }, 3000)*/
        });
    },
    eliminarDocumento(ruta) {
      axios.post("eliminar_documento.php", {
        ruta_eliminar: ruta
      }).then(reponse => {
        console.log(reponse)
        if (reponse.data == "Archivo Eliminado") {

          if (this.cual_documento == "Seguimiento") {
            console.log("eline a seguimiento")
            this.buscarDocumentos('Seguimiento')
          }
          if (this.cual_documento == "Documento CO2") {
            console.log("se elimino DOCUMENTO CO2")
            this.buscarDocumentos('Documento CO2')
          }
          alert("Archivo/Documento Eliminado con Éxito")

        } else if (reponse.data == "No Eliminado") {
          alert("Algo no salio bien no se logro Eliminar.")
        } else {
          alert("Error al eliminar el Documento.")
        }
      }).catch(error => {
        console.log("Error :-(" + error)
      })
    },
    modal_seguimiento() {
      this.myModalSeguimiento = new bootstrap.Modal(document.getElementById('modal'))
      this.myModalSeguimiento.show()
      this.cual_documento = "Seguimiento"
      //this.buscarDocumentos('Seguimiento')

    },
    modal_co2() {
      this.myModalCO2 = new bootstrap.Modal(document.getElementById('modal'))
      this.myModalCO2.show()
      this.cual_documento = "Documento CO2"
      //this.buscarDocumentos('Documento CO2')

    },
    modal_estatus(id) {
      this.documentos_seguimiento_financiero = []
      this.cual_documento = "Seguimiento"
      this.myModalEstatus = new bootstrap.Modal(document.getElementById('modal'))
      this.myModalEstatus.show()
      this.buscarDocumentosEnFinancieros('Seguimiento', id)//Financieros
    },
    incrementarMeses() {
      this.cantidadMeses += 1
    },
    quitarMeses() {
      this.cantidadMeses -= 1
    },
    verificarAltaProyecto() {


      //Comprobando fecha
      if (this.fecha_alta == '') {
        this.respondio = false;
        //alert("Coloque una fecha");
        Swal.fire({
          title: "Seleccione Fecha",
          text: "Favor de seleccionar una fecha",
          icon: "warning"
        });
      }
      //nombre del proyecto
      else if (this.nombre_proyecto == '') {
        this.respondio = false;
        Swal.fire({
          title: "Nombre del proyecto",
          text: "Agregue un nombre al proyecto",
          icon: "warning"
        });
      }
      //Planta
      else if (this.selectFuente == '') {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione Fuente",
          text: "Favor de seleccionar una Fuente",
          icon: "warning"
        });
      }
      //Planta
      else if (this.selectPlanta == '') {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione Planta",
          text: "Favor de seleccionar una Planta",
          icon: "warning"
        });
      }
      //Area
      else if (this.selectArea == '') {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione Área",
          text: "Favor de seleccionar una Área",
          icon: "warning"
        });
      }
      //Departamento
      else if (this.selectDepartamento == '') {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione Departamento",
          text: "Seleccione el Departamento",
          icon: "warning"
        });
      }
      //Metodologia
      else if (this.selectMetodologia == '') {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione la Metodología",
          text: "Seleccione la Metodología para continuar",
          icon: "warning"
        });
      }
      //Responsable
      else if (this.selectResponsable == '') {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione un Responsable",
          text: "Seleccione un Responsable para continuar",
          icon: "warning"
        });
      }
      //Misiones
      else if (this.checkMisiones.length <= 0) {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione una misión",
          text: "Seleccione minimo una misión",
          icon: "warning"
        });
      }
      //Pilares
      else if (this.checkPilares.length <= 0) {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione un Pilar",
          text: "para visualizarlos los pilares seleccione una Misión",
          icon: "warning"
        });
      }
      //verificar si existe minimo un directo en Pilar
      /*else if (!this.selectPilar.includes("directo")) { this.respondio = false; alert("Minimo un Pilar tiene que ser 'Directo'") }*/
      //Objetivos
      else if (this.checkObjetivos.length <= 0) {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione un Objetivo",
          text: "Seleccione Objetivo, para visualizarlos, seleccione Misión y Objetivo",
          icon: "warning"
        });
      }
      //verificar si existe minimo un directo en Pilar
      else if (!this.selectObjetivo.includes("directo")) {
        this.respondio = false;
        Swal.fire({
          title: "Objetivo Directo",
          text: "Minimo un Objetivo tiene que ser 'Directo'",
          icon: "warning"
        });
      }
      //Impacto Ambiental
      /*else if (this.checkImpactoAmbiental.length <= 0) { this.respondio = false; alert("Seleccione minimo una Impacto Ambiental") }*/
      //Impacto Ambiental Comprobando tamanio de Impacto seleccionados y tamanio de emisiones seleccionadas
      else if (this.selectEmisiones.length > 0 && this.checkImpactoAmbiental.length > 0 && this.checkImpactoAmbiental.filter(elemento => elemento != '').length != this.selectEmisiones.filter(elemento => elemento != '').length) {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione un Enlace (Emisión)",
          text: "Seleccione Enlace (Emisión) del Impacto Ambiental selecionado",
          icon: "warning"
        });
      }
      else if (this.valoresCheck.length <= 0) {
        this.respondio = false;
        Swal.fire({
          title: "Seleccione un Valor Gonher",
          text: "Seleccione minimo un Valor Gonher",
          icon: "warning"
        });
      } else {
        this.respondio = true
      }
      //Ahorros
      /*else if ((this.tons_co2 == "0" || this.tons_co2 == "" || this.tons_co2 == "0.00") && this.ahorro_duro == "$.00" && this.ahorro_suave == "$.00" && (this.objetivo_estrategico == false || this.objetivo_estrategico == true)) { this.respondio = false; 
        Swal.fire({
          title: "Minimo uno debe ser distinto a 0",
          text: "Verifique los campos",
          icon: "warning"
        });}
      //Si algo no se a contestado
      else {
        this.respondio = true
      }*/

      if (this.respondio === true) {
        this.guardarAltaProyecto("Alta Proyecto")
      }

    },
    guardarAltaProyecto(insertar_o_actualizar) {

      var fuente = ''
      var siglasFuente = ''
      var fuenteConSiglas = ''
      if (this.selectFuente.length >= 3) {
        const separandoFuente = this.selectFuente.split('<->');//separando
        fuente = separandoFuente[1];
        siglasFuente = separandoFuente[2];
        fuenteConSiglas = fuente + siglasFuente;
      }

      var planta = ''
      var siglasPlanta = ''
      if (this.selectPlanta.length >= 3) {
        const separandoPlanta = this.selectPlanta.split('<->');//separando
        planta = separandoPlanta[1];
        siglasPlanta = separandoPlanta[2];
      }

      var area = '';
      var siglasArea = '';
      if (this.selectArea.length >= 3) {
        const separandoArea = this.selectArea.split('<->');//separando const */
        area = separandoArea[1];
        siglasArea = separandoArea[2];
      }

      var metodologia = '';
      if (this.selectMetodologia.length >= 2) {
        const separandoMetodologia = this.selectMetodologia.split('<->');//separando */
        metodologia = separandoMetodologia[1];
      }

      var departamento = '';
      var siglasDepartamento = '';
      if (this.selectDepartamento.length >= 3) {
        const separandoDepartamento = this.selectDepartamento.split('<->');//separando*/;
        departamento = separandoDepartamento[1];
        siglasDepartamento = separandoDepartamento[2];
      }

      var responsable_id = '';
      if (this.selectResponsable.length >= 1) {
        const separandoResponsable = this.selectResponsable.split('<->');
        var responsable_id = separandoResponsable[0];
      }


      //Observador 
      var arreglo_observador = [];
      for (let i = 0; i < this.checkObservadores.length; i++) {
        var observador = this.checkObservadores[i].split('<->')[1];
        arreglo_observador.push(observador);
      }

      if (arreglo_observador.length <= 0) {
        arreglo_observador.push('');
      }


      //Utilizo para tomar todos los nombres.
      console.log(this.checkMisiones)
      var misiones_nombres = [];
      for (let i = 0; i < this.checkMisiones.length; i++) {
        var mision_nom = this.checkMisiones[i].split('<->')[1];
        misiones_nombres.push(mision_nom);
      }
      //console.log(misiones_nombres)

      //Utilizo para tomar todos los nombres.
      console.log(this.checkPilares)
      var pilares_nombres = [];
      var pilarOrden = '';
      var siglasPilaresConcatenado = '';
      for (let i = 0; i < this.checkPilares.length; i++) {
        var pilar_nom = this.checkPilares[i].split('<->')[1];
        var siglas = this.checkPilares[i].split('<->')[2];
        var orden = this.checkPilares[i].split('<->')[3];
        pilares_nombres.push(pilar_nom + ' (' + siglas + ')')
        pilarOrden += orden
        siglasPilaresConcatenado += '-' + siglas
      }
      // console.log(pilares_nombres);
      //console.log(pilarOrden);

      //Utilizo para tomar todos los nombres.
      //console.log(this.checkObjetivos)
      var objetivos_nombres = [];
      var objetivoOrden = '';
      var siglasObjetivosConcatenado = ""
      for (var i = 0; i < this.checkObjetivos.length; i++) {
        var nombre_objetivo = this.checkObjetivos[i].split('<->')[1];//tomo el nombre 
        var siglas = this.checkObjetivos[i].split('<->')[3];
        var orden = this.checkObjetivos[i].split('<->')[4];
        objetivos_nombres.push(nombre_objetivo + ' (' + siglas + ')');
        objetivoOrden += orden;
        siglasObjetivosConcatenado += '-' + siglas
      }
      //console.log(objetivos_nombres)

      var objetivosDirectosIndirectos = [];
      for (let i = 0; i < this.selectObjetivo.length; i++) {//insertando directo e indirectos de selectPilares
        if (this.selectObjetivo[i] != "") {
          objetivosDirectosIndirectos.push(this.selectObjetivo[i]);//nuevo arreglo eliminado los "" del arreglo anterior1
        }
      }


      var combinadoObjetivo = [];
      if (objetivos_nombres.length == objetivosDirectosIndirectos.length) {
        for (let i = 0; i < objetivos_nombres.length; i++) {
          if (objetivosDirectosIndirectos[i] == "directo") {
            combinadoObjetivo.push(objetivos_nombres[i] + "->" + objetivosDirectosIndirectos[i]);// solo insertar el que es directo
          } else {
            combinadoObjetivo.push(objetivos_nombres[i]);// si son indirecto no agregar indirecto 
          }
        }
        //console.log("Combinado Objetivos")
        console.log(combinadoObjetivo)
      } else {
        console.log("los nombres del pilar y directos e indirecto de pilar no tienen el mismo tamaño")
      }

      //Utilizo para tomar todos los nombres.
      console.log(this.checkImpactoAmbiental)
      var impacto_ambiental_nombres = [];
      for (let i = 0; i < this.checkImpactoAmbiental.length; i++) {
        var nombre_impacto = this.checkImpactoAmbiental[i].split('<->')[1];
        impacto_ambiental_nombres.push(nombre_impacto)
      }

      if (impacto_ambiental_nombres.length <= 0) {
        impacto_ambiental_nombres.push('Sin Impacto')
      }
      //console.log("impacto ambienta nombres", impacto_ambiental_nombres)

      let idsImpacto = this.checkImpactoAmbiental.map(element => element.split('<->')[0]);
      console.log("Ids", idsImpacto)

      var impacto_ambiental_emisiones = this.selectEmisiones
      //ordeno las emisiones como el arreglo de impacto ambieltal
      let emisiones_ordenadas = idsImpacto.flatMap(element =>
        impacto_ambiental_emisiones.filter(ids => element == ids.split('<->')[0]).map(elementos => elementos.split('<->')[1])//primero reviso que sea igual al id y des tomo el restp
      )

      if (emisiones_ordenadas.length <= 0) {//Si no hay impactos tambien colocarlo sin impacto
        emisiones_ordenadas.push('Sin Impacto')
      }

      console.log("Ya acomodados", emisiones_ordenadas)

      var valores = [];
      for (let index = 0; index < this.valoresCheck.length; index++) {
        if (this.valoresCheck[index] != "") {
          var valor = this.valoresCheck[index]
          valores.push(valor)
        }
      }
      //Folio proyecto
      var folio = siglasPlanta + "-" + siglasArea + '-' + siglasDepartamento + '-P' + siglasPilaresConcatenado + '-O' + siglasObjetivosConcatenado;



      axios.post("proyectosController.php", {
        id_actualizar: this.id_actualizar,
        accion: insertar_o_actualizar,
        folio: folio,
        fecha_alta: this.fecha_alta,
        nombre_proyecto: this.nombre_proyecto,
        fuente: fuenteConSiglas,
        select_planta: planta,
        select_area: area,
        select_departamento: departamento,
        select_metodologia: metodologia,
        responsable_id: responsable_id,
        observador: arreglo_observador,
        misiones: misiones_nombres,
        pilares: pilares_nombres,
        objetivos: combinadoObjetivo,
        impacto_ambiental: impacto_ambiental_nombres, // utilizada para insertar en tabla impactos ambientales
        impacto_ambiental_emisiones: emisiones_ordenadas, // utilizada para insertar en tabla proyectos creados
        valores: valores,
        tons_co2: this.tons_co2,
        ahorro_duro: this.ahorro_duro,
        ahorro_suave: this.ahorro_suave,
        anioXmes: this.AnioXMes,
        mesXAnio: this.MesXAnio,
        valoresMensualCO: this.inputValorMensualCO,
        valoresMensualAD: this.inputValorMensualAD,
        valoresMensualAS: this.inputValorMensualAS,
        idsPlanMesual: this.idsPlanMesual
      }).then(response => {
        console.log("Alta resultado", response.data)
        if (insertar_o_actualizar == "Alta Proyecto") {
          if (response.data[0][0] == true) {
            if (response.data[0][1] == true) {
              this.myModal.hide()
              this.consultarProyectos()
              alert("El proyecto '" + this.nombre_proyecto + "' se creó con éxito..")
              this.fecha_alta = ''
              this.selectFuente = ''
              this.selectPlanta = ''
              this.selectArea = ''
              this.selectDepartamento = ''
              this.selectMetodologia = ''
              this.selectResponsable = ''
              this.checkObservadores = []
              this.checkMisiones = []
              this.checkPilares = []
              this.selectPilar = []
              this.checkObjetivos = []
              this.selectObjetivo = []
              this.idsCheckImpacto = []
              this.checkImpactoAmbiental = []
              this.impactoAmbiental = []
              this.selectEmisiones = []
              this.valoresCheck = []
              this.tons_co2 = ""
              this.ahorro_duro = "$.00"
              this.ahorro_suave = "$.00"
              this.objetivo_estrategico = false
              setTimeout(() => {
                this.nombre_proyecto = ''
              }, 4000)
            }
          } else {
            alert("No se dio de alta el proyecto.")
          }
        } else if (insertar_o_actualizar == "Actualizar Proyecto") {
          if (response.data[0] == true) {
            this.reiniciarVariables()
            this.consultarProyectos()
            this.myModal.hide()
            alert("Actualizado con éxito.")
          }
        } else {
          console.log("No es ni insertar ni actualizar")
        }
      }).catch(error => {
        console.log("Error :-( ", error)
      })
    },
    editarCOMes(numero) {
      this.flagEditCOMes = numero
      this.flagEditAhorroDuroMes = ''
      this.flagEditAhorroSuaveMes = ''
    },
    editarADMes(numero) {
      this.flagEditCOMes = ''
      this.flagEditAhorroDuroMes = numero
      this.flagEditAhorroSuaveMes = ''
    },
    editarASMes(numero) {
      this.flagEditCOMes = ''
      this.flagEditAhorroDuroMes = ''
      this.flagEditAhorroSuaveMes = numero
    },
    inicializarArreglosPlanMensual() {
      for (let i = 0; i < 12; i++) {
        this.inputValorMensualCO[i] = "";
        this.inputValorMensualAD[i] = "";
        this.inputValorMensualAS[i] = "";
        this.AnioXMes[i] = this.select_anios_por_mes
        this.MesXAnio[i] = (i + 1) //Asigno del 1 al 12 para los meses
      }
    },
    darFormatoInputValorMensual(index, WhoIsIt) {
      if (WhoIsIt === 'CO') {
        /*if(this.inputValorMensualCO[index]!==undefined){
           this.inputValorMensualCO[index]=this.formatMonedaPesos(this.inputValorMensualCO[index])
         }*/
      } else if (WhoIsIt === 'AD') {
        if (this.inputValorMensualAD[index] !== '') {
          this.inputValorMensualAD[index] = this.formatMonedaPesos(this.inputValorMensualAD[index])
        }
      } else if (WhoIsIt === 'AS') {
        if (this.inputValorMensualAS[index] !== '') {
          this.inputValorMensualAS[index] = this.formatMonedaPesos(this.inputValorMensualAS[index])
        }
      } else {
        console.log("No se encontro QUIEN")
      }
      this.flagEditCOMes = ''
      this.flagEditAhorroDuroMes = ''
      this.flagEditAhorroSuaveMes = ''
    },
    reiniciarVariables() {
      this.idsCheckImpacto = []
      this.checkImpactoAmbiental = []
      this.impactoAmbiental = []
      this.selectEmisiones = []
      this.valoresCheck = []
    },
    verificarSiEsActualizar() {
      if (this.actualizar_proyecto == true) {
        this.reiniciarVariables()
      }
    },
    buscandoUltimoProyectoCreado(nombres) {
      //Buscar y comparar si es igual
      if (nombres === this.nombre_proyecto) {
        return true
      }
    },
    actualizarProyecto(id) {
      axios.post('proyectosController.php', {
        accion: 'Actualizar Proyecto',
        id: id,
      }).then(response => {
        console.log(response.data)
        if (response.data[0] == true) {
          this.consultarProyectos()
        } else {
          alert("La actualización, no se realizo correctamente.")
        }
      }).catch(error => {
        //console.log('Erro :-('+error)
      }).finally(() => {

      })

    },
    folioAnteriorSinNumeral(nombre, index) {
      // Compara el nombre actual con el anterior y asigna un color diferente si es diferente
      if (index > 0 && this.obtenerPrefijo(nombre) !== this.obtenerPrefijo(this.proyectos[index - 1].folio)) {
        return this.obtenerPrefijo(nombre) != this.obtenerPrefijo(this.proyectos[index - 1].folio);// Cambia el color según tus preferencias
      }
    },
    colocarCursor(input) {

      var val = document.getElementById('tons_co2').value;
      var val2 = document.getElementById('ahorro_duro').value;
      var val3 = document.getElementById('ahorro_suave').value;
      if (input == 'tons_co2') {
        if (val == '$0.00' || val == '$.00') {
          cursorPos = document.getElementById('tons_co2').selectionStart;
          var dom1 = document.getElementById('tons_co2');
          dom1.setSelectionRange(cursorPos - 3, cursorPos - 3);
        }
      } else if (input == 'ahorro_duro') {
        if (val2 == '$0.00' || val2 == '$.00') {
          cursorPos = document.getElementById('ahorro_duro').selectionStart;
          var dom2 = document.getElementById('ahorro_duro');
          dom2.setSelectionRange(cursorPos - 3, cursorPos - 3);
        }
      } else if (input == 'ahorro_suave') {
        if (val3 == '$0.00' || val3 == '$.00') {
          cursorPos = document.getElementById('ahorro_suave').selectionStart;
          var dom3 = document.getElementById('ahorro_suave');
          dom3.setSelectionRange(cursorPos - 3, cursorPos - 3);
        }

      }
    },
    formatoNumero(queInput, event) {//tons
      var cursorPos;
      var valor;
      var input;

      if (queInput == "tons_co2") {
        valor = this[queInput].toString();  // Usa el modelo de datos de Vue.js para acceder al valor
        input = document.getElementById(queInput);
        cursorPos = input.selectionStart;
        console.log("VALOR" + valor);
      }

      if (queInput == "ahorro_duro") {
        valor = document.getElementById('ahorro_duro').value;
        input = document.getElementById('ahorro_duro');
        cursorPos = document.getElementById('ahorro_duro').selectionStart;
      }

      if (queInput == "ahorro_suave") {
        valor = document.getElementById('ahorro_suave').value;
        input = document.getElementById('ahorro_suave');
        cursorPos = document.getElementById('ahorro_suave').selectionStart;
      }


      if (event.key === 'Backspace' && (valor === null || valor === '' || valor === '0' || valor === 0 || valor === '$' || valor === '$.00')) {
        valor = input.value = "$.00";

      } else if (event.key !== 'Backspace' && valor !== null && valor !== '' && event.key !== 'ArrowUp' && event.key !== 'ArrowDown' && event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
        const options2 = { style: 'currency', currency: 'USD', minimumFractionDigits: 2 };
        const numberFormat2 = new Intl.NumberFormat('en-US', options2);
        // Obtener el valor actual del campo y eliminar caracteres no deseados
        var valorCampo = valor.replace(/[^\d.]/g, '');
        var stringIzquiedaDelPunto = valorCampo.substring(0, valor.indexOf(".") - 1);
        // Formatear el valor como un número
        let numeroFormateado = parseFloat(valorCampo).toFixed(2);
        // Aplicar el formato de número
        input.value = numberFormat2.format(numeroFormateado);
        // Si la longitud de la parte izquierda del punto es un múltiplo de 3 más 1, restar 1 al cursor
        // Restaurar la posición del cursor
        if (valorCampo.length > 3) {
          if (stringIzquiedaDelPunto.length % 4 === 0) {
            console.log("multiplo");
            input.setSelectionRange(cursorPos + 1, cursorPos + 1);
          } else {
            console.log("no es multiplo de 4");
            input.setSelectionRange(cursorPos, cursorPos);
          }
        } else if (valorCampo.length <= 0) {
          valor = input.value = "$.00";
          input.setSelectionRange(cursorPos, cursorPos);
        } else {
          if (valorCampo === "0" || valorCampo === 0) {
            console.log("es igual a cero");
            valor = input.value = "$.00";
            input.setSelectionRange(cursorPos, cursorPos);
          } else if (valorCampo === "1" || valorCampo === 1) {
            console.log("es igual a uno");
            input.setSelectionRange(cursorPos, cursorPos);
          }
        }
      }
    },
    asignarValor(input) {//asigno el formato a las varitnles
      if (input === "tons_co2") {
        this.tons_co2 = document.getElementById('tons_co2').value;
      } else if (input === "ahorro_duro") {
        this.ahorro_duro = document.getElementById('ahorro_duro').value;
      } else if (input === "ahorro_suave") {
        this.ahorro_suave = document.getElementById('ahorro_suave').value;
      }
    },
    obtenerPrefijo(folioCompleto) {
      var posicionUltimoGuion = folioCompleto.lastIndexOf("-");
      return folioCompleto.substring(0, posicionUltimoGuion);
    },
    formatInputPesos(varvue) {
      // Llama a la función formatMoneda y actualiza input_tons_co2 con el valor formateado
      // Llama a la función formatMoneda y actualiza la variable con el valor formateado
      this[varvue] = this.formatMonedaPesos(this[varvue])
    },
    formatMonedaPesos(value) {
      const options2 = { style: 'currency', currency: 'USD', minimumFractionDigits: 2 };
      const numberFormat2 = new Intl.NumberFormat('en-US', options2);
      // Obtener el valor actual del campo y eliminar caracteres no deseados

      var valorCampo = value.replace(/[^\d.]/g, '');
      if (valorCampo == '') { valorCampo = 0 }
      // Formatear el valor como un número
      let numeroFormateado = parseFloat(valorCampo).toFixed(2);
      // Aplicar el formato de número
      return numberFormat2.format(numeroFormateado);
    },
    formatInputSinPesos(varvue) {
      this[varvue] = this.formatMonedaSinPesos(this[varvue]);
    },
    formatInputSinPesosCO(index) {
      if (this.inputValorMensualCO[index] !== '') {
        let valor = this.inputValorMensualCO[index];
        this.inputValorMensualCO[index] = this.formatMonedaSinPesos(valor);
      }
    },
    formatMonedaSinPesos(value) {
      // Obtener el valor actual del campo y eliminar caracteres no deseados
      if (value == '' || value == undefined) { value = '0' }
      var valorCampo = value.replace(/[^\d.]/g, '');
      if (valorCampo == '') { valorCampo = 0 }
      // Formatear el valor como un número
      let numeroFormateado = parseFloat(valorCampo).toFixed(2); // Se ajusta para tener dos decimales
      // Devolver el valor formateado sin el signo de dólar
      return numeroFormateado.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    formatInputSinPesosImpactoAmbiental(index) {//Primer y Nuevo Registro
      this.inputImpactoAmbientalInicial[index] = this.formatMonedaSinPesos(this.inputImpactoAmbientalInicial[index]);
    },
    formatInputSinPesosImpactoAmbientalPosicion(posicion, index) {//Actualizacion
      this.inputImpactoAmbiental[posicion][index] = this.formatMonedaSinPesos(this.inputImpactoAmbiental[posicion][index]);
    },
    formatoSoloNumeros(value) {//formato de pesos limpiar a solo numeros
      if (value != undefined) {
        // Obtener el valor actual del campo y eliminar caracteres no deseados
        var valorCampo = value.replace(/[^\d.]/g, '');
        let numeroFormateado = parseFloat(valorCampo).toFixed(2);//agregamos los decimales .00
        return numeroFormateado
      }

    },
    formatoNumeroApesos(value) {
      const options2 = { style: 'currency', currency: 'USD', minimumFractionDigits: 2 };
      const numberFormat2 = new Intl.NumberFormat('en-US', options2);
      // Obtener el valor actual del campo y eliminar caracteres no deseados
      return numberFormat2.format(value);
    },
    modalCatalogos(accion, tipo, id, nombre, cantidad, siglas, unidadMedida, misionLigada, n_mision, id_mision_ligada) {//accion: es CREAR, ACTUALIZAR, ELIMINAR y tipo: es Pilares, Misiones, Objetivos.
      this.id = ''
      this.accion = accion
      this.tipo = tipo
      this.nueva = '';
      this.myModal = new bootstrap.Modal(document.getElementById("modalCrearCatalogos"))
      this.myModal.show()

      if (accion == 'Actualizar') {
        if (tipo == 'Impacto Ambiental') {
          this.nuevoNombre = nombre;
          this.id = id;
        } else if (tipo == 'Estandares') {
          this.id = id;
          this.nuevoNombre = nombre;
          this.cantidad = cantidad;
          this.unidadMedida = unidadMedida;
        } else if (tipo == 'Pilar') {
          this.id = id;
          this.nuevoNombre = nombre;
          this.siglas = siglas;
          this.misionLigada = misionLigada;
          this.n_mision = n_mision;
          this.id_mision_ligada = id_mision_ligada;
          console.log(n_mision);

        } else if (tipo == 'Objetivo') {
          this.nuevoNombre = nombre;
          this.siglas = siglas;
          this.id = id;
          this.select_pilar = cantidad;

        } else if (tipo == 'Mision') {
          this.id = id;
          this.nueva = nombre;
        } else if (tipo == 'Fuente') {
          this.nuevoNombre = nombre;
          this.siglas = siglas;
          this.id = id;
        } else {
          alert("No existe ese tipo en actualizars")
        }
      }
    },
    cancelarEvento(e) {
      e.preventDefault();
    },
    asignacion(valor) {
      alert(valor);
      this.fecha_desde = valor;
    },

    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PLANTA*/
    guardarSeguimiento() {
      console.log()
      console.log(this.input_tons_co2)
      console.log(this.inputImpactoAmbientalInicial)
      console.log(this.input_ahorro_suave)
      console.log(this.input_ahorro_duro)
      if (this.input_tons_co2 !== '') {
        let sumaVacias = 0;
        for (let i = 0; i < this.inputImpactoAmbientalInicial.length; i++) {
          if (!this.inputImpactoAmbientalInicial[i]) {
            sumaVacias++;
          }
        }
        console.log("posiciones vacias", sumaVacias)
        if (sumaVacias > 0) {
          alert("Ningún impacto ambiental tiene que estar vacio, minimo 0")
        } else {
          if (this.input_ahorro_suave !== '') {
            if (this.input_ahorro_duro !== '') {

              axios.post('seguimientoAmbientalProyectoController.php', {
                id_proyecto: this.id_proyecto,
                mes: this.mes_select,
                anio: this.anio_select,
                input_tons_co2: this.input_tons_co2,
                inputImpactoAmbiental: this.inputImpactoAmbientalInicial,
                input_ahorro_suave: this.input_ahorro_suave,
                input_ahorro_duro: this.input_ahorro_duro,
              }).then(response => {
                console.log(response.data)
                if (response.data[0][3] == true) {
                  alert("Ya existe esa fecha, favor de cambiarla")
                } else {
                  if (response.data[0][0] == true) {
                    if (response.data[0][1] == true) {
                      if (response.data[0][2] == true) {
                        this.actualizar = 0
                        this.actualizatabla = false
                        this.consultarImpactoAmbieltalXProyectoID()
                        this.consultarSumaProyectos()
                        this.alertaSweet()
                      } else {
                        alert("Verifique que los campos no esten vacios, valor minimo 0 ")
                      }
                    } else {
                      alert("No se realizo correctamente la consulta Relacionada")
                    }
                  } else {
                    alert("No se econtro el ID del Proyecto")
                  }
                }
              }).catch(error => {
                console.log('Erro :-(' + error)
              }).finally(() => {

              })

            } else {
              alert("Ahorro duro minimo 0, no debe estar vacio.")
            }
          } else {
            alert("Ahorro suave minimo 0, no debe estar vacio.")
          }
        }
      } else {
        alert('Debes ingresar el impacto ambiental, minimo 0')
      }




    },
    actualizarSeguimiento(posicion) {

      //console.log("id Proyecto" + this.id_proyecto + "Desde: " + this.fecha_desde + " Hasta: " + this.fecha_hasta + " Toneladas:" + this.input_tons_co2 + "Impacto Ambielta: " + this.inputImpactoAmbiental[(posicion)] + " Ahorro Duro: " + this.input_ahorro_suave + " Ahorra: " + this.input_ahorro_duro);

      axios.put('seguimientoAmbientalProyectoController.php', {
        id_proyecto: this.id_proyecto,
        mes: this.mes_select,
        anio: this.anio_select,
        input_tons_co2: this.input_tons_co2,
        inputImpactoAmbiental: this.inputImpactoAmbiental[posicion],
        idsInputImpactoAmbiental: this.idsInputImpactoAmbiental[posicion],
        input_ahorro_suave: this.input_ahorro_suave,
        input_ahorro_duro: this.input_ahorro_duro,
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          alert("Ese mes ya existe.")
        } else {
          if (response.data[0][0] == true) {
            this.actualizar = 0
            this.consultarImpactoAmbieltalXProyectoID()
            this.consultarSumaProyectos()
            this.alertaSweet()
            //this.consultarImpactoAmbieltalXProyectoID()
          } else {
            alert("La actualizacion, no se realizo correctamente.")
          }
        }

      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    alertaSweet() {
      Swal.fire({
        icon: "success",
        title: "Se guardo con éxito",
        width: 800,
        html: `
          <b>Nota:</b>
          <div class="text-start" style="font-size:0.7em">
          <br> <b>1.-</b> Subir solo un archivo por mes, según corresponda.<br>
          <br> <b>2.-</b> El responsable de cada proyecto, deberá efectuar una revisión exhaustiva, verificando que los datos de su proyecto son confiables y fidedignos.<br>
          <br> <b>3.-</b> Este archivo deberá contener la información completa, con la información que soporte y justifique el importe y/o el monto del ahorro según corresponda.<br>
          <br> <b>4.-</b> Anexar al archivo las pantallas de la transacción MB51 (Si aplica), en las cuales se puede identificar el MATERIAL-CENTRO-ALMACEN-CLASE DE MOV. Y FECHA DE CONT. P.D.<br>
          <br> <b>5.-</b> La información mencionada en el punto 4, deberá ser exportada a excel.<br>
          </div>
        `,
        customClass: {
          confirmButton: "btn alert-sweet"
        },
        buttonsStyling: false
      });
    },
    guardarStatus() {
      //console.log(this.seguimiento_status + this.id_proyecto);
      var status = ''
      if (this.seguimiento_status === true) {
        status = 'Siguiendo'
      } else {
        status = 'Cerrado'
      }

      axios.put('proyectosController.php', {
        accion: 'Guardar Estatus',
        id_proyecto: this.id_proyecto,
        status: status,
      }).then(response => {
        console.log(response.data)
        if (response.data[0] == true) {
          if (status == 'Cerrado') {
            alert("El proyecto se ha cerrado.")
          } else if (status == 'Siguiendo') {
            alert("Siguiendo proyecto")
          }
          this.consultarProyectos()
        } else {
          alert("La inserción de Status, no se realizo correctamente.")
        }

      }).catch(error => {
        //console.log('Erro :-('+error)
      }).finally(() => {

      })

    },
    mostrandoMes(mes) {
      return this.months[(mes - 1)];//mes es 1 -12 y le resto 1 paratomar la poscion del mes
    },
    nuevoLimpiarVariables() {
      this.fecha_desde = ''
      this.fecha_hasta = ''
      this.input_tons_co2 = ''
      this.input_ahorro_duro = ''
      this.input_ahorro_suave = ''
      this.tomarAnioActual()
    },
    asignarDatosActualizar(posicion) {
      this.actualizar = 0
      this.actualizar = (posicion + 1)
      this.mes_select = this.arregloID[posicion].mes
      this.anio_select = this.arregloID[posicion].anio
      this.input_tons_co2 = this.arregloID[posicion].tons_co2
      this.input_ahorro_duro = this.arregloID[posicion].ahorro_duro
      this.input_ahorro_suave = this.arregloID[posicion].ahorro_suave
    },
    /*/////////////////////////////////////////////////////////////////////////////////CALENDARIO*/
    modalMotivoRechazo(id_proyecto, mes, nombre_proyecto, correo_proyecto) {
      this.myModal = new bootstrap.Modal(document.getElementById("modal-motivo-rechazo"))
      this.myModal.show()
      this.motivo_rechazo = ""
      this.id_proyecto_rechazo = id_proyecto
      this.mes_rechazo = mes
      this.nombre_del_proyecto = nombre_proyecto
      this.correo_proyecto = correo_proyecto
    },
    guardarRechazo(status_rechazo, mes, id_proyecto, anio_rechazo, motivo_rechazo, nombre, correo) {
      var enviar_a = correo;
      var anio;
      var nombre_proyecto;

      if (status_rechazo == 'Rechazada') {
        enviar_a = this.correo_proyecto //desde la modal
        this.motivo_rechazo = document.getElementById("motivo_rechazo").value;
        var texto = this.motivo_rechazo
        this.motivo_rechazo = texto.trim();// Si existen unicamente espacio en blanco los elinará y la cadena será vacia, me ayuda a verificar
        if (this.motivo_rechazo == "") { return alert("Digite un texto") }
        this.motivo_rechazo = texto.replace(/\s+/g, ' ').trim();// Eliminar espacios en blanco en exceso y despues vuelvo a eliminar los expacio de alado y reacciono
        anio = this.select_anio_calendario

      } else if (status_rechazo == 'Aceptada') {
        if (!confirm("Esta seguro que desea aceptar la evidencia del proyecto: " + nombre)) { return }
        this.nombre_del_proyecto = nombre
        this.motivo_rechazo = ''
        this.mes_rechazo = mes
        this.id_proyecto_rechazo = id_proyecto
        anio = this.select_anio_calendario
      } else if (status_rechazo == 'Corregida') {

        if (!confirm("¿Ya corrigió su evidencia del mes (" + mes + ") y año (" + anio_rechazo + ")?")) { return }
        this.motivo_rechazo = ''
        this.mes_rechazo = mes
        this.id_proyecto_rechazo = this.id_proyecto
        var id_proyecto_seleccionado = this.id_proyecto
        var proyectoEncontrado = this.proyectos.find(function (proyecto) {
          return proyecto.id === id_proyecto_seleccionado;
        });
        this.nombre_del_proyecto = proyectoEncontrado.nombre_proyecto
        anio = anio_rechazo
        this.motivo_rechazo = motivo_rechazo
      }

      console.log("id_proyecto: " + this.id_proyecto_rechazo + "mes: " + this.mes_rechazo + "status_rechazo: " + status_rechazo + "Año calendario: " + anio)
      axios.put('proyectosController.php', {
        accion: 'Guardar Rechazo',
        id_proyecto: this.id_proyecto_rechazo,
        status_rechazo: status_rechazo,
        motivo: this.motivo_rechazo,
        mes: this.mes_rechazo,
        anio: anio
      }).then(response => {
        console.log(response.data)
        if (response.data[0] == true) {
          if (this.myModal) { this.myModal.hide() }

          alert("Respuesta guardada con éxito")
          if (status_rechazo == 'Corregida') {
            this.consultarImpactoAmbieltalXProyectoID();
          } else {
            this.consultarCalendarioProyectos();
            this.consultarImpactoAmbieltalXProyectoID();
          }
          this.enviarCorreoRechazo(anio, status_rechazo, enviar_a)
        } else {
          alert("La inserción de Rechazo, no se realizó correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    enviarCorreoRechazo(anio, status_rechazo, enviar_a) {
      axios.post('enviarCorreoRechazo.php', {
        correo: enviar_a,
        nombre_proyecto: this.nombre_del_proyecto,
        status: status_rechazo,
        motivo: this.motivo_rechazo,
        mes: this.mes_rechazo,
        anio: anio
      }).then(response => {
        console.log(response.data)
        if (response.data == true) {
          console.log("SI, envió el correo")
        } else {
          console.log("NO, se envió el corre.")
        }
      }).catch(error => {
        console.log("Error en axios" + error)
      }).finally(() => {

      })
    },
    consultarSeguimientos() {
      this.sumarSoloUnaVez = 0
      axios.get('seguimientoAmbientalProyectoController.php', {
        params: {
          anio: this.select_anio_generando_valor
        }
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          if (response.data[0][2] == true) {
            if (response.data[0][0].length > 0) {
              console.log("Seguimientos")
              this.todosSeguimientos = response.data[0][0];
              console.log(this.todosSeguimientos)
              this.sumasGenerandoValor = response.data[0][4];

              //******************************** */
              if (this.sumasGenerandoValor) {
                var sumaValorExcelecia = 0
                var sumaSustentableExcelecia = 0

                var sumaValorCliente = 0
                var sumaSustentableCliente = 0

                var sumaValorCapitalHumano = 0
                var sumaSustentableCapitalHumano = 0

                var sumaValorInvestigacionDesarrollo = 0
                var sumaSustentableInvestigacionDesarrollo = 0

                var sumaGeneralV = 0
                var sumaGeneralS = 0
                // Recorro cada propiedad en this.sumasGenerandoValor
                for (const key in this.sumasGenerandoValor) {
                  if (this.sumasGenerandoValor.hasOwnProperty(key)) {//verifico que exista
                    const elemento = this.sumasGenerandoValor[key];
                    /* // Imprimo las propiedades del objeto
                     console.log("Nombre:", key);
                    console.log("Valor:", elemento.valor);
                    console.log("Sustentable:", elemento.sustentable);
                    console.log("Pilar:", elemento.pilar);
                    console.log("-------------------------");*/

                    if (elemento.pilar.includes("Cliente")) {
                      sumaValorCliente += parseFloat(elemento.valor.replace(/[^\d.-]/g, ''));
                      sumaSustentableCliente += parseFloat(elemento.sustentable.replace(/[^\d.-]/g, ''));
                    }
                    if (elemento.pilar.includes("Capital Humano")) {
                      sumaValorCapitalHumano += parseFloat(elemento.valor.replace(/[^\d.-]/g, ''));
                      sumaSustentableCapitalHumano += parseFloat(elemento.sustentable.replace(/[^\d.-]/g, ''));

                    }
                    if (elemento.pilar.includes("Excelencia Operativa")) {
                      sumaValorExcelecia += parseFloat(elemento.valor.replace(/[^\d.-]/g, ''));
                      sumaSustentableExcelecia += parseFloat(elemento.sustentable.replace(/[^\d.-]/g, ''));
                    }
                    if (elemento.pilar.includes("Investigación y Desarrollo")) {
                      sumaValorInvestigacionDesarrollo += parseFloat(elemento.valor.replace(/[^\d.-]/g, ''));
                      sumaSustentableInvestigacionDesarrollo += parseFloat(elemento.sustentable.replace(/[^\d.-]/g, ''));
                    }


                  }
                }

                this.sumaClienteValor = "$" + parseFloat(sumaValorCliente).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaClienteSustentable = parseFloat(sumaSustentableCliente).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

                this.sumaCapitalHumanoValor = "$" + parseFloat(sumaValorCapitalHumano).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaCapitalHumanoSustentable = parseFloat(sumaSustentableCapitalHumano).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

                this.sumaExcelenciaValor = "$" + parseFloat(sumaValorExcelecia).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaExcelenciaSustentable = parseFloat(sumaSustentableExcelecia).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

                this.sumaInvestigacionDesarrolloValor = "$" + parseFloat(sumaValorInvestigacionDesarrollo).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaInvestigacionDesarrolloSustentable = parseFloat(sumaSustentableInvestigacionDesarrollo).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

                sumaGeneralV = sumaValorCliente + sumaValorCapitalHumano + sumaValorExcelecia + sumaValorInvestigacionDesarrollo;
                sumaGeneralS = sumaSustentableCliente + sumaSustentableCapitalHumano + sumaSustentableExcelecia + sumaSustentableInvestigacionDesarrollo;

                this.sumaGeneralValor = "$" + parseFloat(sumaGeneralV).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaGeneralSustentable = parseFloat(sumaGeneralS).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });


              } else {
                console.log("this.sumasGenerandoValor no está definido o es nulo.");
              }

              /****************************/


            } else {
              this.todosSeguimientos = []
            }
          } else { alert("consulta proyectos en consultarSeguimiento, no se realizo correctamente") }
        } else { alert("La consulta de pilares, no se realizo correctamente.") }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    buscarCoincidencias(objetivo_con_siglas) {
      //console.log("El resultado que llego"+valor1)
      for (let key in this.sumasGenerandoValor) {
        if (key === objetivo_con_siglas) {
          return true
        }
      }
      return false
    },
    valoresProyectos(grafica) {
      axios.get("proyectosController.php", {
        params: {
          accion: 'sumar valores'
        }
      }).then(response => {
        console.log("Suma de Valores Gonher", response.data)
        if (response.data[0][1]) {
          this.sumaValoresGonher = response.data[0][0]
          if (grafica == 'grafica') {
            this.tablaGraficas() //llamo la grafica solo si es la ventana Valores Gonher, esto para llenar primero sumaValoresGonher y despues crear la tabla.
          }
        } else {
          alert("Existe un problema con la consulta sumaValoresGonher")
        }

      }).catch(error => {
        console.log("Error en valoresProyectos " + error)
      })
    },
    validarProyecto(id_proyecto, mes, validacion, ahorro_duro_validado) {
      var dato;
      if (validacion === "Validado") {
        dato = "";
      } else {
        dato = "Validado"
      }
      axios.put("validacionFinancieraController.php", {
        id: id_proyecto,
        anio: this.select_anio_calendario,
        mes: mes,
        validacion: dato,
        ahorro_duro: ahorro_duro_validado
      }).then(response => {
        console.log(response.data);
        this.consultarCalendarioProyectos();
      }).catch(error => {
        console.log('Error en axios.')
      }).finally(() => {

      })
      console.log("ID:" + id_proyecto + "Anio:" + this.select_anio_calendario + "Mes:" + mes);
    },
    consultarValidacion() {
      axios.get("validacionFinancieraController.php", {
        params: {
          anio: this.select_anio_calendario
        }
      }).then(response => {
        console.log("validacion")
        console.log(response.data)
        if (response.data[0][1] == true) {
          var datosValidacion = [];
          datosValidacion.push(response.data[0][0])
          this.datosFinancieros = response.data[0][0]
          var suma = 0;
          if (datosValidacion.length > 0) {
            for (let i = 1; i <= 12; i++) {
              const nombreIndex = i.toString();  // Convertir el número a cadena para acceder a la propiedad
              if (datosValidacion[0][nombreIndex]) {
                this.checkValidar[i - 1] = datosValidacion[0][nombreIndex].validado;
                this.inputTotalReal[i - 1] = datosValidacion[0][nombreIndex].real_duro;
                suma += parseFloat(this.formatoSoloNumeros(datosValidacion[0][nombreIndex].real_duro))
              } else {
                // Puedes asignar un valor predeterminado o manejar el caso de que la propiedad no exista
                this.checkValidar[i - 1] = null;
                this.inputTotalReal[i - 1] = '$0.00';
              }
            }
          } else {
            this.checkValidar = []
          }
          this.SumNumReales = suma
          this.sumaReales = this.formatoNumeroApesos(suma);
        } else {
          alert("Error en la consulta");
        }
      }).catch(error => {
        console.log("Fallo el metodo consultarValidacion" + error);
      })
    },
    guardarValidacionFinanciera(mes) {//guardar y actualizar
      id = "";
      if (this.datosFinancieros[mes.toString()] !== undefined) {
        id = this.datosFinancieros[mes.toString()].id
      }
      var suave = this.calendarioSumaXMesAnio.sumas_ahorro_suave[mes.toString()]
      var duro = this.calendarioSumaXMesAnio.sumas_ahorro_duro[mes.toString()]
      var real_duro = this.inputTotalReal[mes - 1];
      var validar = this.checkValidar[mes - 1];
      axios.post('validacionFinancieraController.php', {
        mes: mes,
        anio: this.select_anio_calendario,
        suave: suave,
        duro: duro,
        real_duro: real_duro,
        validar: validar,
        id: id
      }).then(response => {
        console.log(response.data)
        if (response.data[0] == true) {
          if (validar == true) {
            alert("Validación guardada con éxito.")
          } else {
            alert("Validación desactivada con éxito.")
          }
          this.consultarValidacion();
        } else {
          alert("La insercion no se realizo con éxito");
        }
      }).catch(error => {
        console.log("Error en guardarValidacionFinanciera" + error)
      }).finally(() => {

      })
    },
    buscarEstatusSeguimiento(id_proyecto) {
      console.log("ID: " + id_proyecto)
    },
    darFormatoInputValorReal(mes_o_index) {
      this.inputTotalReal[mes_o_index - 1] = this.formatMonedaPesos(this.inputTotalReal[mes_o_index - 1])
    },

    consultarPlan() {
      if (this.select_anio_calendario < 2025) {// es para que no se me resitie la actualizar despues del 2025 en planeado
        this.meta = 0;
      }
      axios.get("planController.php", {
        params: {
          anio: this.select_anio_calendario,
          planta: this.select_planta_calendario
        }
      }).then(response => {
        console.log('Consulta Plan', response.data)
        if (response.data[0][1] == true) {
          this.valoresPlan = response.data[0][0]//lo utilizo para extrar datos.
          var valores = []
          valores.push(response.data[0][0])

          if (valores.length > 0) {
            var suma = 0;
            var sumaP = 0;
            for (let index = 1; index <= 12; index++) {
              if (valores[0][index]) {
                suma += parseFloat(valores[0][index].plan.replace(/[$,]/g, ''));

                this.inputValorPlan[index - 1] = valores[0][index].plan

              } else {

                this.inputValorPlan[index - 1] = "$0.00";
              }
              this.sumaPres = "$" + parseFloat(suma).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

            }
            //console.log('el total de los valores es:',this.sumaPres);
            console.log("Presentado modalidad >=2025", this.inputValorPlan)

            //console.log("META",this.meta)
            if (this.select_anio_calendario < 2025) {
              this.meta = suma
              this.sumaPlan = "$" + parseFloat(suma).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
            } else {
              this.metaPres = suma;
              //   console.log('meta es:',this.metaPres)
            }
            //1904371
          }
        } else {
          alert("Error en la consulta consultarPlan");
        }
      }).catch(error => {
        console.log("Fallo el metodo consultarValidacion" + error);
      })
    },

    consultarPlanNuevoModalidad() {
      this.inputProyectosMes = []
      axios.get("planMensualController.php", {
        params: {
          accion: "consultar x Anio",
          anio: this.select_anio_calendario,
          planta: this.select_planta_calendario
        }
      }).then(response => {
        console.log("Plan nueva modalidad", response.data)
        let valores = [];
        let nuevoArreglo = [];

        for (let i = 0; i < 12; i++) {//inicializando
          this.inputProyectosMes[i] = "$0.00";
        }

        valores = response.data[0];
        const result = valores.reduce((acc, item) => {
          const mes = item.mes;
          const ahorroD = parseFloat(item.ahorro_d.replace(/[$,]/g, '')) || 0;
          if (!acc[mes]) {// si no exist el mes lo creo e inicializo
            acc[mes] = 0;
          }
          acc[mes] += ahorroD; //voy sumando los del mismo mes
          return acc;
        }, {});

        //tomo el ID de cada proyecto.
        let arregloSoloIDs = this.proyectosXanioCalendario.map(items => items.id);
        console.log(arregloSoloIDs)


        //ESTOS AHORROS SE AGREGAN CUANDO SE CREA EL PROYECTO y aqui consulto cada ahorro por ID de proyecto y sus meses 
        let arregloIDconPosiciones = [];
        for (let index = 0; index < arregloSoloIDs.length; index++) {
          // Inicializa un nuevo arreglo para cada id_proyecto
          let ahorroProyectoMes = Array(12).fill(null); // Suponiendo que hay 12 meses
          // Busca el objeto que coincida con el id_proyecto
          const items = response.data[0].filter(intems => intems.id_proyecto === arregloSoloIDs[index]);
          // Si se encuentra el objeto, extrae el ahorro_d

          // Recorre los elementos encontrados y asigna el ahorro_d a la posición correspondiente
          items.forEach(item => {
            const mes = item.mes; // Asegúrate de que 'mes' sea un índice válido (0-11)
            ahorroProyectoMes[mes - 1] = item.ahorro_d; // Asigna el valor de ahorro_d a la posición correspondiente
          });
          // Si no hay ahorros, ya está inicializado con null
          // Agrega el resultado al arreglo
          arregloIDconPosiciones.push({
            'id': arregloSoloIDs[index],
            'ahorro_proyecto_mes': ahorroProyectoMes
          });
        }
        console.log("IDs con ahorro por proyecto por mes:", arregloIDconPosiciones);
        this.plan_mes_mes_por_proyecto = arregloIDconPosiciones;



        nuevoArreglo = Object.values(result);//objeto arreglo plan 2025
        //console.log("Planeado 2025", nuevoArreglo)
        var suma = 0;
        for (let f = 0; f < nuevoArreglo.length; f++) {
          suma += parseFloat(nuevoArreglo[f])
          this.inputProyectosMes[f] = "$" + parseFloat(nuevoArreglo[f]).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
        }

        if (this.select_anio_calendario >= 2025) {
          this.meta = suma
          this.sumaPlan = "$" + parseFloat(suma).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
        }
      }).catch(error => {
        console.log("Error :-(", error);
      })
    },
    mesAmesProyecto(id_nesecito, posicion) {
      const proyecto = this.plan_mes_mes_por_proyecto.find(item => item.id === id_nesecito);
      // Verificar si se encontró el proyecto
      if (proyecto) {
        const valor = proyecto.ahorro_proyecto_mes[posicion - 1]; // Accede al valor en la posición especificad
        // Verificar si el valor existe y no es una cadena vacía
        if (valor) {
          return "Plan mes: " + valor; // Retorna el valor en la posición especificada
        } else {
          return "Sin plan"; // Retorna "No hay nada" si el valor es undefined, null o una cadena vacía
        }
      } else {
        return ""; // Retorna "No hay nada" si no se encuentra el proyecto
      }
    },
    guardarPlanMes(mes) {
      var valor = this.inputValorPlan[mes - 1]
      var id = ''
      if (this.valoresPlan[mes]) {
        id = this.valoresPlan[mes].id
      }
      axios.post('planController.php', {
        mes: mes,
        anio: this.select_anio_calendario,
        valor: valor,
        id: id
      }).then(response => {
        if (response.data[0] == true) {
          this.plan_actualizar = ''
          alert("Plan guardado con éxito.")
          this.consultarPlan()
        } else {
          alert("La del plan no se realizo.");
        }
      }).catch(error => {
        console.log("Error en guardarPlanMes" + error)
      }).finally(() => {

      })
    },

    editarPlanMes(mes) {
      this.plan_actualizar = mes
    },
    darFormatoInputValorPlan(index) {
      this.inputValorPlan[index] = this.formatMonedaPesos(this.inputValorPlan[index])
    },
    calcularPorcentaje() {
      if (this.select_anio_calendario >= 2025) {
        // console.log('meta:',this.metaPres,'se lleva:',this.selleva)
        //  console.log('pres:',parseFloat((this.selleva/this.metaPres)*100).toFixed(2))
        return this.metaPres === 0 || this.selleva === 0 ? 0 : parseFloat((this.selleva / this.metaPres) * 100).toFixed(2)

      } else {
        return this.meta === 0 || this.selleva === 0 ? 0 : parseFloat((this.selleva / this.meta) * 100).toFixed(2)
      }
    },

    calcularPorcentajeRealAnual() {
      return this.meta === 0 || this.SumNumReales === 0 ? 0 : parseFloat((this.SumNumReales / this.meta) * 100).toFixed(2)
    },
    calcularPorcentajeMensualTeorico(mes) {
      if (this.calendarioSumaXMesAnio.sumas_ahorro_duro && this.calendarioSumaXMesAnio.sumas_ahorro_duro[mes.toString()] && this.inputValorPlan[mes - 1]) {
        if (this.select_anio_calendario >= 2025) {
          var plan = this.formatoSoloNumeros(this.inputProyectosMes[mes - 1])
        } else {
          var plan = this.formatoSoloNumeros(this.inputValorPlan[mes - 1])
        }


        if (plan != 0) {
          var ahorro_duro = this.formatoSoloNumeros(this.calendarioSumaXMesAnio.sumas_ahorro_duro[mes.toString()])
          return ((ahorro_duro / plan) * 100).toFixed(2)
        }
      }
      return 0
    },
    calcularPorcentajeMensualReal(mes) {
      if (typeof this.inputTotalReal !== 'undefined' && typeof this.inputValorPlan !== 'undefined' && this.inputTotalReal[mes - 1] && this.inputValorPlan[mes - 1]) {
        var real = this.inputTotalReal[mes - 1]
        var plan = this.inputValorPlan[mes - 1]
        real = this.formatoSoloNumeros(this.inputTotalReal[mes - 1])
        plan = this.formatoSoloNumeros(this.inputValorPlan[mes - 1])////AQUI ESTOY
        // return  "real: "+ real + "plan:" +plan;
        if (real != 0) {
          return ((real / plan) * 100).toFixed(2) ////AQUI ESTOY
        }
      }
      return 0
    },
    tablaGraficas() {
      const ctx = document.getElementById('myChart');
      if (!ctx) {
        console.error("No se pudo obtener la referencia al elemento canvas.");
        return;
      }

      const data = {
        labels: [
          'Excelencia (' + this.sumaValoresGonher.Calidad + ')',
          'Colaboración (' + this.sumaValoresGonher.Trabajo + ')',
          'Compromiso  (' + this.sumaValoresGonher.Compromiso + ')',
          'Servicio  (' + this.sumaValoresGonher.Servicio + ')',
          'Desarrollo (' + this.sumaValoresGonher.Desarrollo + ')',
          'Integridad (' + this.sumaValoresGonher.Integridad + ')',
          'Innovación (' + this.sumaValoresGonher.Innovacion + ')',
          /*'Calidad - Productividad ('+this.sumaValoresGonher.Calidad+')',
          'Trabajo en Equipo ('+this.sumaValoresGonher.Trabajo+')',
          'Compromiso  ('+this.sumaValoresGonher.Compromiso+')',
          'Servicio y Orientación al Cliente  ('+this.sumaValoresGonher.Servicio+')',
          'Desarrollo de Nuestra Gente ('+this.sumaValoresGonher.Desarrollo+')',
          'Integridad ('+this.sumaValoresGonher.Integridad+')',
          'Innovación ('+this.sumaValoresGonher.Innovacion+')',*/
        ],
        datasets: [{
          label: 'Valores Gonher',
          data: [this.sumaValoresGonher.Calidad, this.sumaValoresGonher.Trabajo, this.sumaValoresGonher.Compromiso, this.sumaValoresGonher.Servicio, this.sumaValoresGonher.Desarrollo, this.sumaValoresGonher.Integridad, this.sumaValoresGonher.Innovacion],
          fill: true,
          backgroundColor: 'rgba( 24, 144, 16, 0.2)',
          borderColor: 'rgb(24, 144, 16)',
          pointBackgroundColor: ['#e43333', '#daa523', '#469c99', '#7fb55a', '#ebca74', '#99183f', '#65293b'],
          pointBorderColor: '#102590',
          pointHoverBackgroundColor: '#f102590',
          pointHoverBorderColor: 'rgb(255, 99, 132)',
          borderWidth: 1
        }],
      };

      new Chart(ctx, {
        type: 'radar',
        data: data,
        options: {
          plugins: {
            legend: {
              display: false,
            }
          },
          scales: {
            r: {
              min: 0, // Establecer el valor mínimo en el eje radial a 0
              pointLabels: {
                fontSize: 14,
                font: {
                  size: 14
                },
                color: ['#e43333', '#daa523', '#469c99', '#7fb55a', '#ebca74', '#99183f', '#65293b']
              }
            }
          }
        }
      });
    }
  }
};

const altaProyectos = Vue.createApp(AltaProyectos);

altaProyectos.mount("#alta-proyectos");