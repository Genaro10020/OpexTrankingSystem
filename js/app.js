const AltaProyectos = {
  data() {
    return {
      /*/////////////////////////////////////////////////////////////////////////////////VARIBLES USUARIOS Y DEPARTAMENTOS INICIO*/
      ventana: 'Altas',
      myModal: '',
      myModalCRUD: '',
      tipo: '',
      accion: '',
      selectPlanta: '',
      selectArea: '',
      selectDepartamento: '',
      selectMetodologia: '',
      selectResponsable: '',
      responsables: [],
      plantas: [],
      areas: [],
      /*Alta Proyectos */
      fecha_alta: '',
      nombre_proyecto: '',
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
      tons_co2: '$.00',
      ahorro_duro: '$.00',
      ahorro_suave: '$.00',
      numero_index: 0,
      respondio: true,//utilizo para cambiar el css si no repondio en altas
      objetivo_estrategico: false,
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

      /*Impacto Ambiental */
      //general
      id: '',// utilizado y reseteado despues de usar.
      /*Variabes Estandares co2*/
      estandares: [],
      cantidad: '',
      unidadMedida: '',
      /*ACTUALIZAR MISIONES LIGADAS A PILARES */
      misionLigada: '',
      n_mision: '',
      id_mision_ligada: '',
      pilar: '',
      objetivos_ligados: '',
      /*SEGUIMIENTO DE PORYECTO*/
      id_proyecto: '',
      arregloID: []
    }
  },
  mounted() {
    //  this.consultarUsuarios()
    this.consultarProyectos()
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
          }
        } else {
          alert("La consulta de proyectos no se realizo correctamente.")
        }
      }).catch(error => {
        console.log('Erro :-(' + error)
      }).finally(() => {

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS POR ID PARA QUE TRAEGA DATOS DE CADA PROYECTO*/
    consultarProyectoID(){
      axios.post('proyectosController.php', {
          id_proyecto: this.id_proyecto //ID PROYECTO
      }).then(response => {
        console.log(response.data)
        if (response.data[0][1] == true) {
          if (response.data[0][0].length > 0) {
            this.arregloID = response.data[0][0];
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
        this.objetivos = ''
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
            this.objetivos = response.data[0][0]
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
      if (this.nueva !== '' && this.cantidad !== '' && this.unidadMedida !== '') {
        axios.post('estandaresCO2Controller.php', {
          nueva: this.nueva,
          cantidad: this.cantidad,
          unidadMedida: this.unidadMedida
        }).then(response => {
          this.nueva = ''
          this.cantidad = ''
          this.unidadMedida = ''
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
            this.consultarObjetivosRelacional()
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
            this.consultarObjetivos()
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
            this.consultarObjetivosRelacional()
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
    verificarAltaProyecto() {

      //Comprobando fecha
      if (this.fecha_alta == '') { this.respondio = false; alert("Coloque una fecha"); }

      //nombre del proyecto
      else if (this.nombre_proyecto == '') { this.respondio = false; alert("Agregue un nombre al proyecto"); }
      //Planta
      else if (this.selectPlanta == '') { this.respondio = false; alert("Seleccione un Planta"); }
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
      else if (!this.selectPilar.includes("directo")) { this.respondio = false; alert("Minimo un Pilar tiene que ser 'Directo'") }
      //Objetivos
      else if (this.checkObjetivos.length <= 0) { this.respondio = false; alert("Seleccione Objetivo, para visualizarlos, seleccione Mision y Objetivo") }
      //verificar si existe minimo un directo en Pilar
      else if (!this.selectObjetivo.includes("directo")) { this.respondio = false; alert("Minimo un Objetivo tiene que ser 'Directo'") }
      //Impacto Ambiental
      else if (this.checkImpactoAmbiental.length <= 0) { this.respondio = false; alert("Seleccione minimo una Impacto Ambiental") }
      //Ahorros
      else if (this.tons_co2 == 0 && this.ahorro_duro == 0 && this.ahorro_suave == 0 && (this.objetivo_estrategico == false || this.objetivo_estrategico == true)) { this.respondio = false; alert("Minimo uno debe ser distinto a 0") }
      //Si algo no se a contestado
      else {
        this.respondio = true
      }

      if (this.respondio === true) {
        this.guardarAltaProyecto()
      }

    },
    guardarAltaProyecto() {
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
      for (let i = 0; i < this.checkPilares.length; i++) {
        var pilar_nom = this.checkPilares[i].split('<->')[1];
        var orden = this.checkPilares[i].split('<->')[3];
        pilares_nombres.push(pilar_nom)
        pilarOrden += orden;

      }
      console.log(pilares_nombres);
      console.log(pilarOrden);

      //Utilizo para tomar todos los nombres.
      console.log(this.checkObjetivos)
      var objetivos_nombres = [];
      var objetivoOrden = '';
      for (var i = 0; i < this.checkObjetivos.length; i++) {
        var nombre_objetivo = this.checkObjetivos[i].split('<->')[1];//tomo el nombre
        objetivos_nombres.push(nombre_objetivo);
        var orden = this.checkObjetivos[i].split('<->')[4];
        objetivoOrden += orden;

      }
      console.log(objetivos_nombres)

      var pilaresDirectosIndirectos = [];
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
      }

      var objetivosDirectosIndirectos = [];
      for (let i = 0; i < this.selectObjetivo.length; i++) {//insertando directo e indirectos de selectPilares
        if (this.selectObjetivo[i] != "") {
          objetivosDirectosIndirectos.push(this.selectObjetivo[i]);//nuevo arreglo eliminado los "" del arreglo anterior1
        }
      }


      var combinadoObjetivo = [];
      if (objetivos_nombres.length == objetivosDirectosIndirectos.length) {
        for (let i = 0; i < objetivos_nombres.length; i++) {
          combinadoObjetivo.push(objetivos_nombres[i] + "->" + objetivosDirectosIndirectos[i]);
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
      console.log(impacto_ambiental_nombres)
      //Folio proyecto

      var folio = siglasPlanta + "-" + siglasArea + '-' + siglasDepartamento + '-P' + pilarOrden + '-OB' + objetivoOrden;
      console.log(folio);

      axios.post("proyectosController.php", {
        folio: folio,
        fecha_alta: this.fecha_alta,
        nombre_proyecto: this.nombre_proyecto,
        select_planta: planta,
        select_area: area,
        select_departamento: departamento,
        select_metodologia: metodologia,
        responsable_id: responsable_id,
        misiones: misiones_nombres,
        pilares: combinadoPilar,
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
          }
        } else {
          alert("No se dio de alta el proyecto.")
        }
      }).catch(error => {

      })
    },

    folioAnteriorSinNumeral(nombre, index) {
      // Compara el nombre actual con el anterior y asigna un color diferente si es diferente
      if (index > 0 && this.obtenerPrefijo(nombre) !== this.obtenerPrefijo(this.proyectos[index - 1].folio)) {
        return this.obtenerPrefijo(nombre) != this.obtenerPrefijo(this.proyectos[index - 1].folio);// Cambia el color según tus preferencias
      }
    },
    /*formatoNumero(queInput, event) {
       var valor;
       var puntoLugar;
       var valorCampo = "";
 
 
       if (queInput === 'tons_co2') {
 
         cursorPos = document.getElementById('tons_co2').selectionStart;
         dom = document.getElementById('tons_co2');
 
 
         if (event.key === 'Backspace') {
           return console.log('retrososo'); // No ejecutar la función si la tecla no es un dígito
         }
 
         var contieneLetras = /[a-zA-Z]/.test(this.tons_co2);
         const isDigitKey = event.key === 'click' || contieneLetras === false // Verifica si es click o si la tecla es un dígito
 
         if (!isDigitKey) {
           return console.log('sin ejecutar'); // No ejecutar la función si la tecla no es un dígito
         }
 
         if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
           return; // No ejecutar el código adicional
         }
         valor = document.getElementById('tons_co2').value;
         if (this.tons_co2 == 0 || this.tons_co2 == '0' || this.tons_co2 == '') {
           this.tons_co2 = "$.00";
         } else {
           const options2 = { style: 'currency', currency: 'USD', minimumFractionDigits: 2 };
           const numberFormat2 = new Intl.NumberFormat('en-US', options2);
           valorCampo = valor.replace(/[^\d.]/g, '');
           let numeroFormateado = parseFloat(valorCampo).toFixed(2);
           valor = numberFormat2.format(numeroFormateado);
           this.tons_co2 = valor;
         }
 
         var stringIzquiedaDelPunto = valorCampo.substring(0, this.tons_co2.indexOf(".") - 1);
         console.log(valor);
         puntoLugar = valor.indexOf('.');
         console.log(puntoLugar);
         console.log("campo tiene" + valorCampo);
         console.log("campo largo" + valorCampo.length);
         console.log("stringIzquiedaDelPunto" + stringIzquiedaDelPunto);
         console.log("stringIzquiedaDelPunto largo" + stringIzquiedaDelPunto.length);
 
         if (this.tons_co2 == 0 || this.tons_co2 == '0' || this.tons_co2 == '') {
           dom.setSelectionRange(puntoLugar, puntoLugar);
         }
 
         if (stringIzquiedaDelPunto.length > 3) {
           if (stringIzquiedaDelPunto.length % 4 === 0) {
             console.log("multiplo");
             dom.setSelectionRange(puntoLugar + 1, puntoLugar + 1);
           } else {
             dom.setSelectionRange(puntoLugar, puntoLugar);
           }
         }
 
 
       } else if (queInput == 'ahorro_duro') {
 
       } else if (queInput == 'ahorro_suave') {
 
       } else {
         console.log("No existe ese input para formater numero")
       }
 
     },*/
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
        } else {
          alert("No existe ese tipo en actualizars")
        }
      }
    }
  }
};

const altaProyectos = Vue.createApp(AltaProyectos);

altaProyectos.mount("#alta-proyectos");