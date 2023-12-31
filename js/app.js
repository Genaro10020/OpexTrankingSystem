
let sumandoExcelenciaValor = 0;
let sumandoExcelenciaSustentable = 0;


const AltaProyectos = {
  data() {
    return {
      /*/////////////////////////////////////////////////////////////////////////////////VARIBLES USUARIOS Y DEPARTAMENTOS INICIO*/
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
      proyectoSumas: [],
      /*Alta Proyectos */
      fecha_alta: '',
      nombre_proyecto: '',
      nombre_fuente: '',
      fuentes: [],
      departamentos: [],
      metodologias: [],
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
      tons_co2: '',
      ahorro_duro: '$.00',
      ahorro_suave: '$.00',
      numero_index: 0,
      respondio: true,//utilizo para cambiar el css si no repondio en altas
      objetivo_estrategico: false,
      existeImagenSeleccionada: false,
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
      /*SEGUIMIENTO DE PORYECTO*/
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
      anio_select: 2023,
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
      /*GENERANDO VALOR*/
      select_anio_generando_valor:'',
      sumaClienteValor:'',
      sumaClienteSustentable:'',

      sumaExcelenciaValor:'',
      sumaExcelenciaSustentable:'',

      sumaCapitalHumanoValor:'',
      sumaCapitalHumanoSustentable:'',

      sumaInvestigacionDesarrolloValor:'',
      sumaInvestigacionDesarrolloSustentable:'',

      sumaGeneralValor:'',
      sumaGeneralSustentable:'',
      //Calendario
      select_anio_calendario:2023,
      proyectosDatosCalendario:[]

    }
  },
  mounted() {
    //  this.consultarUsuarios()
    this.consultarProyectos()
    this.consultarSumaProyectos()
  },
  methods: {
    toggleDiv() {
      this.showDiv = !this.showDiv;
      console.log(this.showDiv);
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS*/
    consultarProyectos() {
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
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
     /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS*/
     consultarCalendarioProyectos() {
      axios.get('proyectosController.php', {
        params: {
          accion: 'calendario',
          anio:this.select_anio_calendario
        }
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          this.proyectosDatosCalendario = response.data[0][0]
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
                if (i === 0) {
                  // Inicializar la suma en la primera iteración
                  sumas['suma' + j] = parseFloat(valor);
                } else {
                  // Sumar en las iteraciones siguientes
                  sumas['suma' + j] += parseFloat(valor);
                }
              }

            }

            // Redondear al mostrar o almacenar para que no aparecans numero con msa de dos decimas .00
            for (let i in sumas) {
              sumas[i] = parseFloat(sumas[i]).toFixed(2);  // Convertir a número antes de usar toFixed
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
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR OBJETIVOS*/
    consultarImpactoAmbiental() {
      axios.get('impactoAmbientalController.php', {
      }).then(response => {
        console.log(response.data[0])
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.impactoAmbiental = response.data[0][0]
          } else {
            this.impactoAmbiental = []
          }
        } else {
          alert("La consulta Objetivos, no se realizo correctamente.")
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
      var nuevo = this.nombre
      if (this.nuevoResponsable == true && this.nombre != '' && this.numero_nomina != '' && this.correo != '' && this.telefono != '') {
        axios.post('responsablesController.php', {
          nombre: this.nombre,
          numero_nomina: this.numero_nomina,
          correo: this.correo,
          telefono: this.telefono,
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.consultarResponsables()
            this.selectResponsable = ''
            this.nombre = ''
            this.numero_nomina = ''
            this.correo = ''
            this.telefono = ''
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
        id: this.id
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
    eliminarProyecto(id) {
      if (confirm("¿Desea eliminar el Proyecto?")) {
        axios.delete('proyectosController.php', {
          data: {
            id: id
          }
        }).then(response => {
          console.log(response.data)
          if (response.data[0] == true) {
            this.consultarProyectos();
            this.id = ''
            alert("Se elimino Correctamente.")
          } else {
            alert("No se elimino al Responsable.")
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
    abrirModal(modal, tipo, accion) {
      //this.nombre_proyecto = ''
      this.respondio = true;
      this.nueva = ''
      this.tipo = tipo
      this.accion = accion
      if (modal == "Alta") {
        this.myModal = new bootstrap.Modal(document.getElementById("modal-alta-proyecto"))
        this.myModal.show()
        this.consultarPlantas()
        this.consultarAreas()
        this.consultarDepartamentos()
        this.consultarMetodologias()
        this.consultarResponsables()
        //this.consultarObjetivos()
        //this.consultarPilares()
        this.consultarImpactoAmbiental()
        this.consultarMisiones()
        this.consultarFuentes()
        this.buscarDocumentos()

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
    buscarDocumentos() {
      this.imagenes = []
      axios.post("buscar_documentos.php", {
      })
        .then(response => {
          this.imagenes = response.data
          if (this.imagenes.length > 0) {
            console.log(this.imagenes + "Archivos encontrados.")
          } else {
            console.log(this.imagenes + "Sin imagen encontrada.")
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    uploadFile() {
      this.login = true
      //this.mensaje_boton = "Espere, estamos subiendo su archivo...."
      let formData = new FormData();
      var files = this.$refs.ref_imagen.files;
      var totalfiles = this.$refs.ref_imagen.files.length;

      for (var index = 0; index < totalfiles; index++) {
        formData.append("files[]", files[index]);//arreglo de documentos
      }
      /*formData.append("subarea", this.subarea);
      formData.append("nombre_ayuda_visual", this.nombre_ayuda_visual);
      formData.append("id_concentrado", this.id_concentrado);*/
      axios.post("subir_imagen.php", formData,
        {
          headers: { "Content-Type": "multipart/form-data" }
        })
        .then(response => {

          console.log(response.data);
          this.imagenes = response.data;
          if (this.imagenes.length > 0) {
            document.getElementById("input_file_subir").value = ""
            this.existeImagenSeleccionada = false;
            this.random = Math.random()
          } else {
            this.login = false
            alert("Verifique la extension del archivo o Intente nuevamente.")
          }
        })
        .catch(error => {
          this.login = false
          console.log(error);
        }).finally(() => {
          setTimeout(() => {
            this.login = false
          }, 3000)
        });
    },
    verificarAltaProyecto() {

      //Comprobando fecha
      if (this.fecha_alta == '') { this.respondio = false; alert("Coloque una fecha"); }

      //nombre del proyecto
      else if (this.nombre_proyecto == '') { this.respondio = false; alert("Agregue un nombre al proyecto"); }
      //Planta
      else if (this.selectFuente == '') { this.respondio = false; alert("Seleccione una Fuente"); }
      //Planta
      else if (this.selectPlanta == '') { this.respondio = false; alert("Seleccione una Planta"); }
      //Area
      else if (this.selectArea == '') { this.respondio = false; alert("Seleccione una Área") }
      //Departamento
      else if (this.selectDepartamento == '') { this.respondio = false; alert("Seleccione el Departamento") }
      //Metodologia
      else if (this.selectMetodologia == '') { this.respondio = false; alert("Seleccione la Metodología") }
      //Responsable
      else if (this.selectResponsable == '') { this.respondio = false; alert("Seleccione un Responsable") }
      //Misiones
      else if (this.checkMisiones.length <= 0) { this.respondio = false; alert("Seleccione minimo una Misión") }
      //Pilares
      else if (this.checkPilares.length <= 0) { this.respondio = false; alert("Seleccione Pilar, para visualizarlos seleccione Mision") }
      //verificar si existe minimo un directo en Pilar
      /*else if (!this.selectPilar.includes("directo")) { this.respondio = false; alert("Minimo un Pilar tiene que ser 'Directo'") }*/
      //Objetivos
      else if (this.checkObjetivos.length <= 0) { this.respondio = false; alert("Seleccione Objetivo, para visualizarlos, seleccione Mision y Objetivo") }
      //verificar si existe minimo un directo en Pilar
      else if (!this.selectObjetivo.includes("directo")) { this.respondio = false; alert("Minimo un Objetivo tiene que ser 'Directo'") }
      //Impacto Ambiental
      /*else if (this.checkImpactoAmbiental.length <= 0) { this.respondio = false; alert("Seleccione minimo una Impacto Ambiental") }*/
      //Ahorros
      else if ((this.tons_co2 == "0" || this.tons_co2 == "" || this.tons_co2 == "0.00") && this.ahorro_duro == "$.00" && this.ahorro_suave == "$.00" && (this.objetivo_estrategico == false || this.objetivo_estrategico == true)) { this.respondio = false; alert("Minimo uno debe ser distinto a 0") }
      //Si algo no se a contestado
      else {
        this.respondio = true
      }

      if (this.respondio === true) {
        this.guardarAltaProyecto()
      }

    },
    guardarAltaProyecto() {

      const separandoFuente = this.selectFuente.split('<->');//separando
      var fuente = separandoFuente[1];
      var siglasFuente = separandoFuente[2];
      var fuenteConSiglas = fuente + siglasFuente;

      const separandoPlanta = this.selectPlanta.split('<->');//separando
      var planta = separandoPlanta[1];
      var siglasPlanta = separandoPlanta[2];

      const separandoArea = this.selectArea.split('<->');//separando const */
      var area = separandoArea[1];
      var siglasArea = separandoArea[2];

      const separandoMetodologia = this.selectMetodologia.split('<->');//separando */
      var metodologia = separandoMetodologia[1];

      const separandoDepartamento = this.selectDepartamento.split('<->');//separando*/;
      var departamento = separandoDepartamento[1];
      var siglasDepartamento = separandoDepartamento[2];

      const separandoResponsable = this.selectResponsable.split('<->');
      var responsable_id = separandoResponsable[0];

      //Utilizo para tomar todos los nombres.
      console.log(this.checkMisiones)
      var misiones_nombres = [];
      for (let i = 0; i < this.checkMisiones.length; i++) {
        var mision_nom = this.checkMisiones[i].split('<->')[1];
        misiones_nombres.push(mision_nom);
      }
      console.log(misiones_nombres)

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
      console.log(pilares_nombres);
      console.log(pilarOrden);

      //Utilizo para tomar todos los nombres.
      console.log(this.checkObjetivos)
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
      console.log(objetivos_nombres)

      /*var pilaresDirectosIndirectos = [];
      for (let i = 0; i < this.selectPilar.length; i++) {//insertando directo e indirectos de selectPilares
        if (this.selectPilar[i] != "") {
          pilaresDirectosIndirectos.push(this.selectPilar[i]);//nuevo arreglo eliminado los "" del arreglo anterior1
        }
      }
      console.log("Pilares Directo e Indirectos")
      console.log(pilaresDirectosIndirectos);

      var combinadoPilar = [];
      if (pilares_nombres.length == pilaresDirectosIndirectos.length) {
        for (let i = 0; i < pilares_nombres.length; i++) {
          combinadoPilar.push(pilares_nombres[i] + "->" + pilaresDirectosIndirectos[i]);
        }
        console.log("Combinado Pilares")
        console.log(combinadoPilar)
      } else {
        console.log("los nombres del pilar y directos e indirecto de pilar no tienen el mismo tamaño")
      }*/

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
        console.log("Combinado Objetivos")
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

      console.log(impacto_ambiental_nombres)
      //Folio proyecto

      var folio = siglasPlanta + "-" + siglasArea + '-' + siglasDepartamento + '-P' + siglasPilaresConcatenado + '-O' + siglasObjetivosConcatenado;
      console.log(fuenteConSiglas);

      axios.post("proyectosController.php", {
        folio: folio,
        fecha_alta: this.fecha_alta,
        nombre_proyecto: this.nombre_proyecto,
        fuente: fuenteConSiglas,
        select_planta: planta,
        select_area: area,
        select_departamento: departamento,
        select_metodologia: metodologia,
        responsable_id: responsable_id,
        misiones: misiones_nombres,
        pilares: pilares_nombres,
        objetivos: combinadoObjetivo,
        impacto_ambiental: impacto_ambiental_nombres,
        tons_co2: this.tons_co2,
        ahorro_duro: this.ahorro_duro,
        ahorro_suave: this.ahorro_suave
      }).then(response => {
        console.log(response.data)
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
            this.checkMisiones = []
            this.checkPilares = []
            this.selectPilar = []
            this.checkObjetivos = []
            this.selectObjetivo = []
            this.checkImpactoAmbiental = []
            this.tons_co2 = ""
            this.ahorro_duro = "$.00"
            this.ahorro_suave = "$.00"
            this.objetivo_estrategico = false
            this.nombre_proyecto = ''
          }
        } else {
          alert("No se dio de alta el proyecto.")
        }
      }).catch(error => {

      })
    },
    buscandoUltimoProyectoCreado(nombres) {
      //Buscar y comparar si es igual
      if (nombres === this.nombre_proyecto) {
        return true
      }
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
      // Obtener el valor actual del campo y eliminar caracteres no deseados
      var valorCampo = value.replace(/[^\d.]/g, '');
      let numeroFormateado = parseFloat(valorCampo).toFixed(2);//agregamos los decimales .00
      return numeroFormateado
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
      console.log(this.inputImpactoAmbientalInicial)
      axios.post('seguimientoAmbientalProyectoController.php', {
        id_proyecto: this.id_proyecto,
        mes: this.mes_select,
        anio: this.anio_select,//revisando voy aqui
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
                alert("Se inserto con éxito")
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
      //alert("Esta seccion esta en proceso de subir")

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
            alert("Se actualizo con éxito")
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
    guardarStatus() {
      //console.log(this.seguimiento_status + this.id_proyecto);
      var status = ''
      if (this.seguimiento_status === true) {
        status = 'Siguiendo'
      } else {
        status = 'Cerrado'
      }

      axios.put('proyectosController.php', {
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
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS*/
    consultarSeguimientos() {
      this.sumarSoloUnaVez = 0
      axios.get('seguimientoAmbientalProyectoController.php', {
        params:{
          anio:this.select_anio_generando_valor
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
                  var sumaValorExcelecia =0
                  var sumaSustentableExcelecia =0

                  var sumaValorCliente =0
                  var sumaSustentableCliente =0

                  var sumaValorCapitalHumano =0
                  var sumaSustentableCapitalHumano =0

                  var sumaValorInvestigacionDesarrollo =0
                  var sumaSustentableInvestigacionDesarrollo =0

                  var sumaGeneralV =0
                  var sumaGeneralS =0
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

                      if(elemento.pilar.includes("Cliente")){
                         sumaValorCliente += parseFloat(elemento.valor.replace(/[^\d.-]/g, ''));
                         sumaSustentableCliente += parseFloat(elemento.sustentable.replace(/[^\d.-]/g, ''));
                      }
                      if(elemento.pilar.includes("Capital Humano")){
                        sumaValorCapitalHumano += parseFloat(elemento.valor.replace(/[^\d.-]/g, ''));
                        sumaSustentableCapitalHumano += parseFloat(elemento.sustentable.replace(/[^\d.-]/g, ''));

                      }
                      if(elemento.pilar.includes("Excelencia Operativa")){
                            sumaValorExcelecia += parseFloat(elemento.valor.replace(/[^\d.-]/g, ''));
                            sumaSustentableExcelecia += parseFloat(elemento.sustentable.replace(/[^\d.-]/g, ''));
                       }
                      if(elemento.pilar.includes("Investigación y Desarrollo")){
                        sumaValorInvestigacionDesarrollo += parseFloat(elemento.valor.replace(/[^\d.-]/g, ''));
                        sumaSustentableInvestigacionDesarrollo += parseFloat(elemento.sustentable.replace(/[^\d.-]/g, ''));
                      }
                      
                      
                      

                    }
                  }

                this.sumaClienteValor = "$"+parseFloat(sumaValorCliente).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaClienteSustentable = parseFloat(sumaSustentableCliente).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

                this.sumaCapitalHumanoValor = "$"+parseFloat(sumaValorCapitalHumano).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaCapitalHumanoSustentable = parseFloat(sumaSustentableCapitalHumano).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

                this.sumaExcelenciaValor = "$"+parseFloat(sumaValorExcelecia).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaExcelenciaSustentable = parseFloat(sumaSustentableExcelecia).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

                this.sumaInvestigacionDesarrolloValor = "$"+parseFloat(sumaValorInvestigacionDesarrollo).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaInvestigacionDesarrolloSustentable = parseFloat(sumaSustentableInvestigacionDesarrollo).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });

                sumaGeneralV = sumaValorCliente + sumaValorCapitalHumano +sumaValorExcelecia + sumaValorInvestigacionDesarrollo;
                sumaGeneralS = sumaSustentableCliente + sumaSustentableCapitalHumano + sumaSustentableExcelecia + sumaSustentableInvestigacionDesarrollo;

                this.sumaGeneralValor = "$"+parseFloat(sumaGeneralV).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
                this.sumaGeneralSustentable = parseFloat(sumaGeneralS).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });


                } else {
                  console.log("this.sumasGenerandoValor no está definido o es nulo.");
                }
                //SumaExcelenciaValor:'',
               // SumaExcelenciaSustentable:'',
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
    }, buscarCoincidencias(objetivo_con_siglas) {
      //console.log("El resultado que llego"+valor1)
      for (let key in this.sumasGenerandoValor) {
        if (key === objetivo_con_siglas) {
          return true
        }
      }
      return false
    },
    /*sumaExcelenciaValor(valor) {
      console.log("Sumando Valor")
      console.log(valor)
      if (this.sumarSoloUnaVez == 0) {
        this.SumaValorEx = '$0.00';
        if(valor==0 || valor=='0'){
          valor = "0.00";
        }
        var dato = this.formatoSoloNumeros(valor);
        dato = parseFloat(dato);
        sumandoExcelenciaValor += dato;
        var valorExcelencia = parseFloat(sumandoExcelenciaValor).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
        setTimeout(() => {
          //document.getElementById("total_valor_ex").textContent = "$" + valorExcelencia;
          //document.getElementById("valor_global").textContent = "$" + valorExcelencia;
          this.SumaValorEx = '$' + valorExcelencia;
          sumandoExcelenciaValor = 0
          valorExcelencia = 0
          dato = 0
          this.sumarSoloUnaVez = 1;
        }, 5);
      }
    },
    sumaExcelenciaSustentable(valor) {
      console.log("Sumando Sustentable")
      console.log(valor)
      if (this.sumarSoloUnaVez == 0) {
        this.SumaSustentableEx = '0.00';
        if(valor==0 || valor=='0'){
          valor = "0.00";
        }
        var dato = this.formatoSoloNumeros(valor);
        dato = parseFloat(dato);
        sumandoExcelenciaSustentable += dato;
        var sustentableExcelencia = parseFloat(sumandoExcelenciaSustentable).toLocaleString("es-MX", { minimumFractionDigits: 2, maximumFractionDigits: 2, });
     
          //document.getElementById("total_sustentable_ex").textContent = sustentableExcelencia;
          //document.getElementById("sustentable_global").textContent = sustentableExcelencia;
          this.SumaSustentableEx = sustentableExcelencia
          sumandoExcelenciaSustentable = 0
          sustentableExcelencia = 0
          this.sumarSoloUnaVez = 1;

      }
    },*/
  }
};

const altaProyectos = Vue.createApp(AltaProyectos);

altaProyectos.mount("#alta-proyectos");