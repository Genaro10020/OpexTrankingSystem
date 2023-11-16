const AltaProyectos = {
  data() {
    return{
       /*/////////////////////////////////////////////////////////////////////////////////VARIBLES USUARIOS Y DEPARTAMENTOS INICIO*/
      ventana:'Altas',
      myModal:'',
      myModalCRUD:'',
      tipo:'',
      accion:'',
      selectPlanta:'',
      selectArea:'',
      selectDepartamento:'',
      selectMetodologia:'',
      selectResponsable:'',
      responsables:[],
      plantas:[],
      areas:[],
      /*Alta Proyectos */
      fecha_alta:'',
      nombre_proyecto:'',
      departamentos:[],
      metodologias:[],
      pilares:[],
      allPilares:[],
      siglas:'',
      objetivos:[],
      checkMisiones:[],
      checkPilares:[],
      checkObjetivos:[],
      checkImpactoAmbiental:[],
      impactoAmbiental:[],
      selectImpactoAmbiental:'',
      misiones:[],
      allMisiones:[],
      idsPilares:[],
      idsObjetivos:[],
      proyectos:[],
      indexs_pilares:[],
      selectPilar:[],
      selectObjetivo:[],
      select_pilar:'',
      select_mision:'',
      tons_co2:0,
      ahorro_duro:0,
      ahorro_suave:0,
      numero_index:0,
      respondio: true,//utilizo para cambiar el css si no repondio en altas
      objetivo_estrategico:false,
      /*Planta*/ /*Área*/ /*Departamento*/
      nueva:'',
      nuevoNombre:'',
      eliminar:'',
     /*Responsable*/
      nuevoResponsable:false,
      actualizarResponsable:false,
      nombre:'',
      numero_nomina:'',
      correo:'',
      telefono:'',
      responsableID:[],

      /*Impacto Ambiental */
      //general
      id:'',// utilizado y reseteado despues de usar.
      /*Variabes Estandares co2*/
      estandares:[],
      cantidad:'',
      unidadMedida:''
    }
  },
  mounted(){
  //  this.consultarUsuarios()
  this.consultarProyectos()
  },
  methods: {
    toggleDiv(){
      this.showDiv = !this.showDiv;
      console.log(this.showDiv);
  },
        /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PROYECTOS*/
        consultarProyectos(){
          axios.get('proyectosController.php',{
          }).then(response =>{
              console.log(response.data[0])
              if (!response.data[0][1]==false){
                  if (response.data[0][0].length>0) {
                    this.proyectos = response.data[0][0]
                  }
              }else{
                alert("La consulta de proyectos no se realizo correctamente.")
              }
          }).catch(error =>{
            console.log('Erro :-('+error)
          }).finally(() =>{

          })
        },
        /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PLANTAS*/
        consultarPlantas(){
          axios.get('plantasController.php',{
          }).then(response =>{
              console.log(response.data[0])
              if (!response.data[0][1]==false){
                  if (response.data[0][0].length>0) {
                    this.plantas = response.data[0][0]
                  }
              }else{
                 alert("La consulta  plantas no se realizo correctamente.")
              }
      
          }).catch(error =>{
            console.log('Erro :-('+error)
          }).finally(() =>{

          })
        },
          consultarPlantas(){
          axios.get('plantasController.php',{
          }).then(response =>{
              console.log(response.data[0])
              if (!response.data[0][1]==false){
                  if (response.data[0][0].length>0) {
                    this.plantas = response.data[0][0]
                  }
              }else{
                 alert("La consulta  plantas no se realizo correctamente.")
              }
      
          }).catch(error =>{
            console.log('Erro :-('+error)
          }).finally(() =>{

          })
        },
        /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR AREAS*/
        consultarAreas(){
          axios.get('areasController.php',{
          }).then(response =>{
              console.log(response.data[0])
              if (!response.data[0][1]==false){
                  if (response.data[0][0].length>0) {
                    this.areas = response.data[0][0]
                  }
              }else{
                 alert("La consulta  plantas no se realizo correctamente.")
              }
          }).catch(error =>{
            console.log('Erro :-('+error)
          }).finally(() =>{

          })
        },
         /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR DEPARTAMENTOS*/
        consultarDepartamentos(){
          axios.get('departamentosController.php',{
          }).then(response =>{
              console.log(response.data[0])
              if (!response.data[0][1]==false){
                  if (response.data[0][0].length>0) {
                    this.departamentos = response.data[0][0]
                  }
              }else{
                 alert("La consulta  departamentos no se realizo correctamente.")
              }
      
          }).catch(error =>{
            console.log('Erro :-('+error)
          }).finally(() =>{

          })
        },
         /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR DEPARTAMENTOS*/
         consultarMetodologias(){
          axios.get('metodologiasController.php',{
          }).then(response =>{
              console.log(response.data[0])
              if (!response.data[0][1]==false){
                  if (response.data[0][0].length>0) {
                    this.metodologias = response.data[0][0]
                  }
              }else{
                 alert("La consulta  metodologias no se realizo correctamente.")
              }
      
          }).catch(error =>{
            console.log('Erro :-('+error)
          }).finally(() =>{

          })
        },
     /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR RESPONSABLES ID*/
    consultarResponsableID(){
      if(this.selectResponsable!=""){
       var id_nombre_responsable=this.selectResponsable.split("-")
       this.id=id_nombre_responsable[0];
            axios.post('responsablesController.php',{
                  id:this.id//id Responsable
            }).then(response =>{
                console.log(response.data[0])
                if (response.data[0][1]==true){
                    if(response.data[0].length>0) {
                      this.nuevoResponsable = true
                      this.actualizarResponsable = true
                      this.responsableID = response.data[0][0];
                      this.nombre=this.responsableID[0].nombre
                      this.numero_nomina=this.responsableID[0].numero_nomina
                      this.correo=this.responsableID[0].correo
                      this.telefono=this.responsableID[0].telefono
                    }
                }else{
                  alert("La consulta responsables no se realizo correctamente.")
                }
            }).catch(error =>{
              console.log('Erro :-('+error)
            }).finally(() =>{
                  
            })

      }else{
          alert("Seleccione al responsable para Actualizar")
      }
    },
     /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR RESPONSABLES*/
     consultarResponsables(){
      axios.get('responsablesController.php',{
        params:{
          accion:"Consulta"//id Responsable
        }
      }).then(response =>{
          console.log(response.data[0])
          if (!response.data[0][1]==false){
              if (response.data[0][0].length>0) {
                this.responsables = response.data[0][0]
              }
          }else{
             alert("La consulta responsables no se realizo correctamente.")
          }
      }).catch(error =>{
        console.log('Erro :-('+error)
      }).finally(() =>{
            
      })
    },
       /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PILARES*/
       consultarPilaresXobjetivoSeleccionado(){
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
   consultarObjetivosXpilaresSeleccionados(){
    if(this.checkPilares.length >0){
            this.selectObjetivo=[]
            this.checkObjetivos =[]
            var ids_pilares= [];
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

            //creo posiciones
            cantidad_pilares = [];
            for (let index = 0; index < this.pilares.length; index++) {
            cantidad_pilares[index] = (index+1)  
            }
            console.log(cantidad_pilares)

            // Buscar los números faltantes
            let faltantes = cantidad_pilares.filter(elemento => !indexs_pilar.includes(String(elemento)));
            let separando = faltantes.map(Number);
            
            for (let i = 0; i < this.pilares.length; i++){
                for (let j = 0; j < this.pilares.length; j++) {
                  if(separando[i]==(j+1)){
                    this.selectPilar[j] = "indirecto";
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

        axios.post('objetivosController.php',{
            idsPilares:ids_pilares
        }).then(response =>{
            console.log(response.data[0])
            if (response.data[0][1]==true){
                if (response.data[0][0].length>0) {
                  //this.pilares = response.data[0][0]
                  this.objetivos = response.data[0][0]

                  for (let i = 0; i < this.objetivos.length; i++) {
                    this.selectObjetivo.push("indirecto")
                  }

                }
                this.idsObjetivos=[]
            }else{
                alert("La consulta Objetivos por Pilares Seleccionados, no se realizo correctamente.")
            }
        }).catch(error =>{
          console.log('Erro :-('+error)
        }).finally(() =>{
  
        })
    }else{
      this.checkObjetivos =[]
      this.objetivos=''
      this.idsPilares=[]
      this.idsObjetivos=[]
      this.selectObjetivo=[]
    }
},
  /*VERIFICANDO OBJETIVOS AL CHECKERA */
  checkeandoObjetivos(){
    var ids_objetivos= [];
    var indexs_objetivos= [];
    for (let i = 0; i < this.checkObjetivos.length; i++) {
      var id_objetivo = this.checkObjetivos[i].split('<->')[0];
      var index_objetivo = this.checkObjetivos[i].split('<->')[4];
      ids_objetivos.push(id_objetivo);
      indexs_objetivos.push(index_objetivo);
     }
     this.idsObjetivos = ids_objetivos;

     posiciones_objetivos = [];
     for (let index = 0; index < this.objetivos.length; index++) {//introducciiendo posiciones 0 hasta tamanio
      posiciones_objetivos.push(index+1);
     }

     var no_existen_posiciones = posiciones_objetivos.filter(items => !indexs_objetivos.includes(String(items)))//tomo los que no existen en indexs_objetivos.
     var entero_no_existen = no_existen_posiciones.map(Number);//los convierto a valor numerico
     console.log("Los que no existe son:")
     console.log(entero_no_existen)

     entero_no_existen.forEach(posicion => {
      if (posicion >= 0 && posicion < this.selectObjetivo.length+1) {
        var num =(posicion-1);
        this.selectObjetivo[num] = "indirecto";
        console.log("resetie:"+num);
      }
    });

     //let faltantes = cantidad_pilares.filter(elemento => !indexs_pilar.includes(String(elemento)));

     /*for (let i = 0; i < this.objetivos.length; i++) {// utlizo para que aparazca seleccion en selecObjetivos
      this.selectObjetivo.push("")
    }*/
  },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR OBJETIVOS*/
    consultarObjetivos(){
      axios.get('objetivosController.php',{
      }).then(response =>{
          console.log(response.data)
          if (response.data[0][1]==true){
              if (response.data[0][0].length>0) {
                this.objetivos = response.data[0][0]
              }
          }else{
              alert("La consulta Objetivos, no se realizo correctamente.")
          }
      }).catch(error =>{
        console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
      /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PILARES*/
      consultarPilares(){
      axios.get('pilaresController.php',{
      }).then(response =>{
          console.log(response.data[0])
          if (!response.data[0][1]==false){
              if (response.data[0][0].length>0) {
                this.pilares = response.data[0][0]
                this.allPilares = response.data[0][0]
              }
          }else{
              alert("La consulta Pilares, no se realizo correctamente.")
          }
  
      }).catch(error =>{
        console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
     /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PILARES POR MISION SELECCIONADA*/
     consultarPilaresXmisionSeleccionada(){
      if(this.checkMisiones.length >0){
        console.log(this.checkMisiones);

        var misiones_ids = [];
        var id_mision = "";
        for (var i = 0; i <this.checkMisiones.length; i++) {
          var id_mision = this.checkMisiones[i].split('<->')[0];
          misiones_ids.push(id_mision);
       }
        this.checkPilares =[]
        this.checkObjetivos=[]
        this.selectPilar =[]
          axios.post('pilaresController.php',{
              idsMisiones:misiones_ids
          }).then(response =>{
              console.log(response.data[0])
              if (response.data[0][1]==true){
                  if (response.data[0][0].length>0) {
                    this.pilares = response.data[0][0]
                    //this.objetivos = response.data[0][2]
                    /*inicializo selectPilar en Seleccione*/
                    for (let i = 0; i < this.pilares.length; i++) {
                      this.selectPilar.push("indirecto")
                    }
                  }
              }else{
                  alert("La consulta Pilares por Misiones Seleccionadas, no se realizo correctamente.")
              }
          }).catch(error =>{
            console.log('Erro :-('+error)
          }).finally(() =>{
    
          })
    }else{
      this.pilares =''
      this.objetivos=''
      this.checkPilares =[]
      this.checkObjetivos=[]
      this.selectPilar =[]
    }
  },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PILARES*/
    consultarMisiones(){
      axios.get('misionesController.php',{
      }).then(response =>{
          console.log(response.data[0])
          if (!response.data[0][1]==false){
              if (response.data[0][0].length>0) {
                this.misiones = response.data[0][0]
                this.allMisiones = response.data[0][0]
              }
          }else{
              alert("La consulta Misiones, no se realizo correctamente.")
          }
  
      }).catch(error =>{
        console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR OBJETIVOS*/
    consultarImpactoAmbiental(){
      axios.get('impactoAmbientalController.php',{
      }).then(response =>{
          console.log(response.data[0])
          if (response.data[0][1]==true){
              if (response.data[0][0].length>0) {
                this.impactoAmbiental = response.data[0][0]
              }
          }else{
              alert("La consulta Objetivos, no se realizo correctamente.")
          }
  
      }).catch(error =>{
        console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
     /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PLANTA*/
     insertarPlanta(){
      axios.post('plantasController.php',{
        nueva:this.nueva,
        siglas:this.siglas
      }).then(response =>{
          this.nueva = ''
          this.siglas=''
          console.log(response.data)
          if (!response.data[0]==false){
            this.myModalCRUD.hide()
            this.consultarPlantas()
          }else{
              alert("La inserción de Planta, no se realizo correctamente.")
          }
  
      }).catch(error =>{
        //console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
     /*/////////////////////////////////////////////////////////////////////////////////INSERTAR ESTANDARES CO2*/
     insertarEstandaresCO2(){
      axios.post('estandaresCO2Controller.php',{
        nueva:this.nueva,
        cantidad:this.cantidad,
        unidadMedida:this.unidadMedida
      }).then(response =>{
          this.nueva = ''
          this.cantidad=''
          this.unidadMedida=''
          console.log(response.data)
          if (!response.data[0]==false){
            // this.myModalCRUD.hide()
            this.consultarEstandaresCO2()
          }else{
              alert("La inserción de Planta, no se realizo correctamente.")
          }
  
      }).catch(error =>{
        //console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
     /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR PLANTAS*/
     consultarEstandaresCO2(){
      axios.get('estandaresCO2Controller.php',{
      }).then(response =>{
          console.log(response.data[0])
          if (response.data[0][1]==true){
            console.log('soy true')
              if (response.data[0][0].length>0) {
                console.log('soy un arreglo')
                this.estandares = response.data[0][0]
              }
          }else{
             alert("La consulta  plantas no se realizo correctamente.")
          }
  
      }).catch(error =>{
        console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR AREAS*/
    /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PLANTA*/
    insertarImpactoAmbiental(){
      axios.post('impactoAmbientalController.php',{
        nueva:this.nueva
      }).then(response =>{
          this.nueva = ''
          console.log(response.data)
          if (!response.data[0]==false){
            // this.myModalCRUD.hide()
            this.consultarImpactoAmbiental()
          }else{
              alert("La inserción de Planta, no se realizo correctamente.")
          }
  
      }).catch(error =>{
        //console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },


     /*/////////////////////////////////////////////////////////////////////////////////INSERTAR ÁREAS*/
     insertarArea(){
      axios.post('areasController.php',{
        nueva:this.nueva,
        siglas:this.siglas
      }).then(response =>{
          console.log(response.data)
          if (!response.data[0]==false){
            this.myModalCRUD.hide()
            this.consultarAreas()
          }else{
              alert("La inserción de Área, no se realizo correctamente.")
          }
  
      }).catch(error =>{
        //console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
      /*/////////////////////////////////////////////////////////////////////////////////INSERTAR DEPARTAMENTO*/
      insertarDepartamento(){
        axios.post('departamentosController.php',{
          nueva:this.nueva,
          siglas:this.siglas
        }).then(response =>{
            console.log(response.data)
            if (response.data[0]==true){
              this.myModalCRUD.hide()
              this.consultarDepartamentos()
              this.siglas=''
            }else{
                alert("La inserción, no se realizo correctamente.")
            }
    
        }).catch(error =>{
          //console.log('Erro :-('+error)
        }).finally(() =>{
  
        })
      },
       /*/////////////////////////////////////////////////////////////////////////////////INSERTAR METODOLOGIA*/
       insertarMetodologia(){
        axios.post('metodologiasController.php',{
          nueva:this.nueva
        }).then(response =>{
            console.log(response.data)
            if (response.data[0]==true){
              this.myModalCRUD.hide()
              this.consultarMetodologias()
            }else{
                alert("La inserción Metodologías, no se realizo correctamente.")
            }
    
        }).catch(error =>{
          //console.log('Erro :-('+error)
        }).finally(() =>{
  
        })
      },
      
        /*/////////////////////////////////////////////////////////////////////////////////INSERTAR RESPONSABLE*/
        insertarResponsable(){
          var nuevo = this.nombre
            if(this.nuevoResponsable==true && this.nombre!='' && this.numero_nomina!='' && this.correo!='' && this.telefono!=''){
                  axios.post('responsablesController.php',{
                    nombre:this.nombre,
                    numero_nomina:this.numero_nomina,
                    correo:this.correo,
                    telefono:this.telefono,
                  }).then(response =>{
                      console.log(response.data)
                      if (response.data[0]==true){
                        this.consultarResponsables()
                        this.selectResponsable = ''
                        this.nombre=''
                        this.numero_nomina=''
                        this.correo=''
                        this.telefono=''
                        this.nuevoResponsable=false
                      }else{
                          alert("La inserción Responsable, no se realizo correctamente.")
                      }
                  }).catch(error =>{
                    //console.log('Erro :-('+error)
                  }).finally(() =>{

                  })
              }else{
                alert("Todos los campos de nuevo Responsable son obligatorios")
              }
        },
           /*/////////////////////////////////////////////////////////////////////////////////INSERTAR OBJETIVO*/
        insertarObjetivo(){
          console.log(this.nueva)
          if(this.nueva!='' && this.siglas!='' && this.select_pilar!=''){
              axios.post('objetivosController.php',{
                nueva:this.nueva,
                siglas:this.siglas, 
                id_pilar:this.select_pilar
              }).then(response =>{
                  console.log(response.data)
                  if (response.data[0]==true){
                    // this.myModalCRUD.hide()
                    this.consultarObjetivos()
                    this.siglas=''
                    this.nueva=''
                  }else{
                      alert("La inserción, no se realizo correctamente.")
                  }
          
              }).catch(error =>{
                //console.log('Erro :-('+error)
              }).finally(() =>{
        
              })
            }else{
              alert("Todos los campos son requeridos")
            }
      },
       /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PILAR*/
       insertarPilar(){
        if(this.nueva!='' && this.siglas!='' && this.select_mision!=''){
            axios.post('pilaresController.php',{
              nueva:this.nueva,
              siglas:this.siglas, 
              id_mision:this.select_mision
            }).then(response =>{
                console.log(response.data)
                if (response.data[0]==true){
                  //this.myModalCRUD.hide()
                  this.consultarPilares()
                  this.nueva = ''
                  this.siglas=''
                  this.select_mision=''
                }else{
                    alert("La inserción Pilar, no se realizo correctamente.")
                }
        
            }).catch(error =>{
              //console.log('Erro :-('+error)
            }).finally(() =>{
      
            })
          }else{
            alert("Todos los campos son requeridos")
          }
    },
       /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PILAR*/
       insertarMision(){
        if(this.nueva!=''){
            axios.post('misionesController.php',{
              nueva:this.nueva,
            }).then(response =>{
                console.log(response.data)
                if (response.data[0]==true){
                  //this.myModalCRUD.hide
                  this.myModal.hide()
                  alert("Alta exitosa..")
                  this.consultarMisiones()
                  this.nueva = ''
                }else{
                    alert("La inserción Mision, no se realizo correctamente.")
                }
        
            }).catch(error =>{
              //console.log('Erro :-('+error)
            }).finally(() =>{
      
            })
          }else{
            alert("Todos los campos son requeridos")
          }
      },
        /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR PLANTA*/
        actualizarPlanta(){
        if(this.selectPlanta!=""){
          axios.put('plantasController.php',{
            idPlanta:this.id,
            nuevoNombre:this.nuevoNombre,
            siglas:this.siglas
          }).then(response =>{
              console.log(response.data)
              if (response.data[0]==true){
                this.myModalCRUD.hide()
                this.consultarPlantas()
                this.selectPlanta='',
                this.id='',
                this.nuevoNombre=''
              }else{
                  alert("No se actualizo.")
              }
      
          }).catch(error =>{
            //console.log('Erro :-('+error)
          }).finally(() =>{

          })
        }else{ 
          alert("Selecione la planta a eliminar")
        }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR AREA*/
    actualizarArea(){
      if(this.selectArea!=""){
        axios.put('areasController.php',{
          id:this.id,
          nuevo:this.nuevoNombre,
          siglas:this.siglas
        }).then(response =>{
            console.log(response.data)
            if (response.data[0]==true){
              this.myModalCRUD.hide()
              this.consultarAreas()
              this.selectArea='',
              this.id='',
              this.nuevoNombre=''
              this.siglas
            }else{
                alert("No se actualizo.")
            }
    
        }).catch(error =>{
          //console.log('Erro :-('+error)
        }).finally(() =>{

        })
      }else{ 
        alert("Selecione la planta a eliminar")
      }
  },
   /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR DEPARTAMENTO*/
   actualizarDepartamento(){
    if(this.selectDepartamento!=""){
      axios.put('departamentosController.php',{
        id:this.id,
        nuevo:this.nuevoNombre,
        siglas:this.siglas
      }).then(response =>{
          console.log(response.data)
          if (response.data[0]==true){
            this.myModalCRUD.hide()
            this.consultarDepartamentos()
            this.selectDepartamento='',
            this.id='',
            this.nuevoNombre=''
          }else{
              alert("No se actualizo.")
          }
  
      }).catch(error =>{
        //console.log('Erro :-('+error)
      }).finally(() =>{

      })
    }else{ 
      alert("Selecione la planta a eliminar")
    }
},
  /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR METODOLOGIA*/
  actualizarMetodologia(){
    if(this.selectMetodologia!=""){
      axios.put('metodologiasController.php',{
        id:this.id,
        nuevo:this.nuevoNombre
      }).then(response =>{
          console.log(response.data)
          if (response.data[0]==true){
            this.myModalCRUD.hide()
            this.consultarMetodologias()
            this.selectMetodologia='',
            this.id='',
            this.nuevoNombre=''
          }else{
              alert("No se actualizó la Metodología.")
          }
      }).catch(error =>{
        //console.log('Erro :-('+error)
      }).finally(() =>{

      })
    }else{ 
      alert("Selecione la metodología a eliminar")
    }
},
/*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR RESPONSABLE*/
actualizandoResponsable(){
    axios.put('responsablesController.php',{
      nombre:this.nombre,
      numero_nomina:this.numero_nomina,
      correo:this.correo,
      telefono:this.telefono,
      id:this.id
    }).then(response =>{
        console.log(response.data)
        if (response.data[0]==true){
          this.consultarResponsables()
          this.nombre=''
          this.numero_nomina=''
          this.correo=''
          this.telefono=''
          this.id=''
          this.actualizarResponsable = false
          this.nuevoResponsable = false
          this.selectResponsable = ''
          alert("Se actualizo correctamente")
        }else{
            alert("No se actualizó la Metodología.")
        }
    }).catch(error =>{
      //console.log('Erro :-('+error)
    }).finally(() =>{

    })
},
      /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR OBJETIVO*/
      actualizarObjetivo(){
        if(this.nuevoNombre!='' && this.siglas!='' && this.select_pilar !=''){
           axios.put('objetivosController.php',{
              id:this.id,
              nombre:this.nuevoNombre,
              siglas:this.siglas,
              id_pilar:this.select_pilar,
            }).then(response =>{
                console.log(response.data)
                if (response.data[0]==true){
                  this.myModalCRUD.hide();
                  this.consultarObjetivos()
                  this.nuevoNombre=''
                  this.siglas=''
                  this.id=''
                  this.select_pilar = ''
                  this.checkObjetivos = []
                }else{
                    alert("No se actualizo el Objetivo.")
                }
            }).catch(error =>{
              //console.log('Erro :-('+error)
            }).finally(() =>{

            })
          }else{
            alert("Todos los campos son requeridos para poder actualizar.")
          }
      },
        /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR IMPACTO AMBIENTAL*/
        actualizarImpactoAmbiental(){
          if(this.nuevoNombre!=''){
                axios.put('impactoAmbientalController.php',{
                id:this.id,
                nuevo:this.nuevoNombre
              }).then(response =>{
                  console.log(response.data)
                   if(response.data[0]==true){
                    this.myModal.hide();
                    this.consultarImpactoAmbiental()
                    this.id = ''
                    this.nuevoNombre ='' 
                    alert("Se actualizo correctamente.")
                  }else{
                      alert("No se actualizo el Objetivo.")
                  }
              }).catch(error =>{
                //console.log('Erro :-('+error)
              }).finally(() =>{
  
              })
            }else{
              alert("Todos los campos son requeridos para poder actualizar.")
            }
        },
        /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR IMPACTO AMBIENTAL*/
        actualizarEstandaresCO2(){
          if(this.nuevoNombre!='' && this.cantidad!='' && this.unidadMedida!=''){
                axios.put('estandaresCO2Controller.php',{
                id:this.id,
                nuevo:this.nuevoNombre,
                cantidad:this.cantidad,
                unidadMedida:this.unidadMedida
              }).then(response =>{
                  console.log(response.data)
                   if(response.data[0]==true){
                    this.myModal.hide();
                    this.consultarEstandaresCO2()
                    this.id = ''
                    this.nuevoNombre ='' 
                    this.cantidad=''
                    this.unidadMedida=''
                    alert("Se actualizo correctamente.")
                  }else{
                      alert("No se actualizo el Objetivo.")
                  }
              }).catch(error =>{
                //console.log('Erro :-('+error)
              }).finally(() =>{
  
              })
            }else{
              alert("Todos los campos son requeridos para poder actualizar.")
            }
        },
     /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR PLANTA*/
     eliminarPlanta(){
        const id_nombre_planta = this.selectPlanta.split('<->');
        this.id=id_nombre_planta[0]
        var nombre_planta=id_nombre_planta[1]
        console.log(this.selectPlanta)
        if(this.selectPlanta!=""){
          if(confirm("¿Desea eliminar la planta " + nombre_planta+"?"))
          {
            axios.delete('plantasController.php',{
              data:{
                id:this.id
              }
            }).then(response =>{
                console.log(response.data)
                if (response.data[0]==true){
                  this.selectPlanta="";
                  this.myModalCRUD.hide()
                  this.consultarPlantas()
                  this.id=''
                }else{
                    alert("No se elimino.")
                }
        
            }).catch(error =>{
              //console.log('Erro :-('+error)
            }).finally(() =>{
      
            })
          }
        }else{ 
          alert("Selecione la planta a eliminar")
        }
      },
      /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR PLANTA*/
     eliminarMision(id){
        if(confirm("¿Desea eliminar la mision?"))
        {
          axios.delete('misionesController.php',{
            data:{
              id:id
            }
          }).then(response =>{
              console.log(response.data)
              if (response.data[0]==true){
                // this.myModalCRUD.hide()
                this.consultarMisiones()
                this.id=''
              }else{
                  alert("No se elimino.")
              }
      
          }).catch(error =>{
            //console.log('Erro :-('+error)
          }).finally(() =>{
    
          })
        }
  
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR PLANTA*/
    eliminarPilar(id){
      if(confirm("¿Desea eliminar el Pilar?"))
      {
        axios.delete('pilaresController.php',{
          data:{
            id:id
          }
        }).then(response =>{
            console.log(response.data)
            if (response.data[0]==true){
              // this.myModalCRUD.hide()
              this.consultarPilares()
              this.id=''
            }else{
                alert("No se elimino.")
            }
    
        }).catch(error =>{
          //console.log('Erro :-('+error)
        }).finally(() =>{
  
        })
      }

  },
      /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR AREA*/
     eliminarArea(){
      const id_nombre_area = this.selectArea.split('<->');
      this.id=id_nombre_area[0]
      var nombre=id_nombre_area[1]
      console.log(this.selectArea)
      if(this.selectArea!=""){
        if(confirm("¿Desea eliminar la área " + nombre+"?"))
        {
          axios.delete('areasController.php',{
            data:{
              id:this.id
            }
          }).then(response =>{
              console.log(response.data)
              if (response.data[0]==true){
                this.selectArea="";
                this.myModalCRUD.hide()
                this.consultarAreas()
                this.id=''
              }else{
                  alert("No se elimino.")
              }

          }).catch(error =>{
            //console.log('Erro :-('+error)
          }).finally(() =>{
    
          })
        }
      }else{ 
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR DEPARTAMENTOS*/
    eliminarDepartamento(){
      const id_nombre_area = this.selectDepartamento.split('<->');
      this.id=id_nombre_area[0]
      var nombre=id_nombre_area[1]
      console.log(this.selectDepartamento)
      if(this.selectDepartamento!=""){
        if(confirm("¿Desea eliminar Departamento: " + nombre+"?"))
        {
          axios.delete('departamentosController.php',{
            data:{
              id:this.id
            }
          }).then(response =>{
              console.log(response.data)
              if (response.data[0]==true){
                this.selectDepartamento="";
                this.myModalCRUD.hide()
                this.consultarDepartamentos()
                this.id=''
              }else{
                  alert("No se elimino.")
              }
      
          }).catch(error =>{
            //console.log('Erro :-('+error)
          }).finally(() =>{
    
          })
        }
      }else{ 
        alert("Selecione la planta a eliminar")
      }
    },
     /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR METODOLOGIAS*/
     eliminarMetodologia(){
      const id_nombre_area = this.selectMetodologia.split('<->');
      this.id=id_nombre_area[0]
      var nombre=id_nombre_area[1]
      console.log(this.selectMetodologia)
      if(this.selectMetodologia!=""){
        if(confirm("¿Desea eliminar la Metodología: " + nombre+"?"))
        {
          axios.delete('metodologiasController.php',{
            data:{
              id:this.id
            }
          }).then(response =>{
              console.log(response.data)
              if (response.data[0]==true){
                this.selectMetodologia="";
                this.myModalCRUD.hide()
                this.consultarMetodologias()
                this.id=''
              }else{
                  alert("No se elimino la Metodología.")
              }
      
          }).catch(error =>{
            //console.log('Erro :-('+error)
          }).finally(() =>{
    
          })
        }
      }else{ 
        alert("Selecione la planta a eliminar")
      }
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
    eliminarResponsable(){
      const id_nombre_responsable = this.selectResponsable.split('<->');
      this.id=id_nombre_responsable[0]
      var nombre=id_nombre_responsable[1]
      console.log(this.selectResponsable)
      if(this.selectResponsable!=""){
        if(confirm("¿Desea eliminar al Responsable: " + nombre+"?"))
        {
          axios.delete('responsablesController.php',{
            data:{
              idResponsable:this.id
            }
          }).then(response =>{
              console.log(response.data)
              if (response.data[0]==true){
                this.consultarResponsables()
                this.nombre=''
                this.numero_nomina=''
                this.correo=''
                this.telefono=''
                this.id=''
                this.actualizarResponsable = false
                this.nuevoResponsable = false
                this.selectResponsable = ''
              }else{
                  alert("No se elimino al Responsable.")
              }
          }).catch(error =>{
            //console.log('Erro :-('+error)
          }).finally(() =>{
    
          })
        }
      }else{ 
        alert("Selecione la planta a eliminar")
      }
    },
  
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
    eliminarObjetivo(id){
       if(confirm("¿Desea eliminar el Objetivo?"))
        {
          axios.delete('objetivosController.php',{
            data:{
              id:id
            }
          }).then(response =>{
              console.log(response.data)
              if (response.data[0]==true){
                this.consultarObjetivos()
                this.id=''
              }else{
                  alert("No se elimino al Responsable.")
              }
          }).catch(error =>{
            //console.log('Erro :-('+error)
          }).finally(() =>{
    
          })
        }
    },
     /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
     eliminarImpactoAmbiental(id){
      if(confirm("¿Desea eliminar el Impacto Ambiental?"))
       {
         axios.delete('impactoAmbientalController.php',{
           data:{
             id:id
           }
         }).then(response =>{
             console.log(response.data)
             if (response.data[0]==true){
               this.consultarImpactoAmbiental()
               this.id=''
             }else{
                 alert("No se elimino al Responsable.")
             }
         }).catch(error =>{
           //console.log('Erro :-('+error)
         }).finally(() =>{
   
         })
       }
   },
   /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
   eliminarEstandares(id){
    if(confirm("¿Desea eliminar el Estandar ?"))
     {
       axios.delete('estandaresCO2Controller.php',{
         data:{
           id:id
         }
       }).then(response =>{
           console.log(response.data)
           if (response.data[0]==true){
             this.consultarEstandaresCO2()
             this.id=''
           }else{
               alert("No se elimino al Responsable.")
           }
       }).catch(error =>{
         //console.log('Erro :-('+error)
       }).finally(() =>{
 
       })
     }
 },
    verificarCantidadDirectosPilares(){
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
    verificarCantidadDirectosObjetivos(){
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
    crearResponsable(){
      this.nuevoResponsable = true;
      this.actualizarResponsable=false;
      this.nombre = ''
      this.numero_nomina = ''
      this.correo =''
      this.telefono =''
    },
   abrirModal(modal,tipo,accion){
      this.respondio=true;
      this.nueva=''
      this.tipo = tipo
      this.accion = accion
      if (modal=="Alta"){
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
          
      }else if(modal=="CRUD"){
        this.myModalCRUD = new bootstrap.Modal(document.getElementById("modal-alta-crud"))
          if(accion=="Crear"){
            this.select_pilar='';
            this.siglas='';
            this.myModalCRUD.show()
          }else if(accion=="Actualizar"){
                if(tipo=="Planta"){
                    if(this.selectPlanta!=""){
                      this.myModalCRUD.show()
                        const id_nombre_planta = this.selectPlanta.split('<->');//separando
                        this.id=id_nombre_planta[0]//recuperando nombre planta
                        this.nuevoNombre=id_nombre_planta[1]//recuperando nombre planta
                        this.siglas =this.siglas =id_nombre_planta[2]
                    }else{
                      alert("Favor de seleccionar la Planta que actualizará")
                    }
                }
              if(tipo=="Área"){
                console.log(this.selectArea)
                    if(this.selectArea!=""){
                      this.myModalCRUD.show()
                        const id_nombre_area = this.selectArea.split('<->');//separando
                        this.id = id_nombre_area[0]//recuperando ID
                        this.nuevoNombre =id_nombre_area[1]//recuperando Nombre  
                        this.siglas =id_nombre_area[2]//recuperando Siglas
                    }else{
                      alert("Favor de seleccionar la Área que actualizará")
                    }
                }
                if(tipo=="Departamento"){
                  console.log(this.selectDepartamento)
                      if(this.selectDepartamento!=""){
                        this.myModalCRUD.show()
                          const id_nombre = this.selectDepartamento.split('<->');//separando 
                          this.id = id_nombre[0]//recuperando nombre planta
                          this.nuevoNombre =id_nombre[1]//recuperando nombre planta
                          this.siglas =id_nombre[2]//recuperando siglas de departamento
                      }else{
                        alert("Favor de seleccionar la Departamento que actualizará")
                      }
                  }
                  if(tipo=="Metodología"){
                    console.log(this.selectMetodologia)
                        if(this.selectMetodologia!=""){
                          this.myModalCRUD.show()
                            const id_nombre = this.selectMetodologia.split('<->');//separando 
                            this.id = id_nombre[0]//recuperando nombre planta
                            this.nuevoNombre =id_nombre[1]//recuperando nombre planta
                        }else{
                          alert("Favor de seleccionar la Departamento que actualizará")
                        }
                    }
                    if(tipo=="Objetivo"){
                      console.log(this.checkObjetivos)
                          if(this.checkObjetivos!=""){      
                              if(this.checkObjetivos.length==1){
                                this.myModalCRUD.show()
                                const id_nombre_idpilar_siglas = this.checkObjetivos[0].split('<->');//separando
                                this.id = id_nombre_idpilar_siglas[0]//recuperando nombre planta
                                this.nuevoNombre = id_nombre_idpilar_siglas[1]//recuperando nombre planta*/
                                this.select_pilar = id_nombre_idpilar_siglas[2]
                                this.siglas =id_nombre_idpilar_siglas[3]//recuperando nombre planta*/
                               
                              }else{
                                alert("Seleccione solo un Objetivo para actualizar")
                              }
                          }else{
                            alert("Favor de seleccionar el Objetivo que actualizará")
                          }
                      }
          }
      }else{
        alert("No encontramos esa modal")
      }
     
    },
    cerrarModal(){
        this.myModal.hide()
    },
    cancelar(){
      this.nuevoResponsable = false;
      this.actualizarResponsable=false;
    },
    verificarAltaProyecto(){
     
      //Comprobando fecha
      if(this.fecha_alta==''){this.respondio = false;  alert("Coloque una fecha");}
    
      //nombre del proyecto
      else if(this.nombre_proyecto==''){this.respondio = false; alert("Agregue un nombre al proyecto");}
      //Planta
      else if(this.selectPlanta==''){this.respondio=false; alert("Seleccione un Planta");}
      //Area
      else if(this.selectArea==''){this.respondio=false; alert("Seleccione una Área")}
      //Departamento
      else if(this.selectDepartamento==''){this.respondio=false; alert("Seleccione el Departamento")}
      //Metodologia
      else if(this.selectMetodologia==''){this.respondio=false; alert("Seleccione la Metodología")}
      //Responsable
      else if(this.selectResponsable==''){this.respondio=false;  alert("Seleccione un Responsable")}
      //Misiones
      else if(this.checkMisiones.length<=0){this.respondio=false;  alert("Seleccione minimo una Misión")}
      //Pilares
      else if(this.checkPilares.length<=0){this.respondio=false;  alert("Seleccione Pilar, para visualizarlos seleccione Mision")}
      //Objetivos
      else if(this.checkObjetivos.length<=0){this.respondio=false; alert("Seleccione Objetivo, para visualizarlos, seleccione Mision y Objetivo")}
      //Verificar minimo un directo
      else if(this.selectPilar.includes("directo")==false){this.respondio=false; alert("Debe de existir minimo un 'Directo' en Pilar, check el Pilar y elija 'Directo'")}
      //Verificar minimo un directo
      else if(this.selectPilar.includes("directo")==false){this.respondio=false; alert("Debe de existir minimo un 'Directo' en Pilar, check el Pilar y elija 'Directo'")}
      //Verificar minimo un directo
      else if(this.selectObjetivo.includes("directo")==false){this.respondio=false; alert("Debe de existir minimo un 'Directo' en Objetivo, check el Objetivo y elija 'Directo'")}
      //Impacto Ambiental
      else if(this.checkImpactoAmbiental.length<=0){this.respondio=false; alert("Seleccione minimo una Impacto Ambiental")}
      //Ahorros
      else if(this.tons_co2==0 && this.ahorro_duro==0 && this.ahorro_suave==0 && (this.objetivo_estrategico==false || this.objetivo_estrategico==true)){this.respondio=false; alert("Minimo uno debe ser distinto a 0")}
      //Si algo no se a contestado
      else{
        this.respondio=true
      }
 
      if(this.respondio===true){
        this.guardarAltaProyecto()
      }

    },
    guardarAltaProyecto(){
      const separandoPlanta= this.selectPlanta.split('<->');//separando
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
      for (var i = 0; i <this.checkObjetivos.length; i++) {
         var nombre_objetivo = this.checkObjetivos[i].split('<->')[1];//tomo el nombre
         objetivos_nombres.push(nombre_objetivo);
         var orden = this.checkObjetivos[i].split('<->')[4];
         objetivoOrden +=orden;

      }
      console.log(objetivos_nombres)

      //combinando checkPilares con selectPilares
      // Verificamos que ambos arreglos tengan la misma longitud
    if (this.selectPilar.length === pilares_nombres.length) {
      // Creamos un nuevo arreglo para almacenar la combinación
      var combinadoPilar = [];
      // Recorremos los arreglos
      for (var i = 0; i < this.selectPilar.length; i++) {
        // Si la posición en selectPilar no está vacía, combinamos con la correspondiente en checkPilares
        if (this.selectPilar[i] !== "") {
          combinadoPilar.push(pilares_nombres[i] + "->" + this.selectPilar[i]);
        } else {
          // Si la posición en selectPilar está vacía, simplemente añadimos la correspondiente en checkPilares
          combinadoPilar.push(pilares_nombres[i]);
        }
      }
      // Imprimimos el resultado
      console.log("combinadoPilar")
      console.log(combinadoPilar);
    } else {
      console.log("Los arreglos de Pilares no tienen la misma longitud");
    }

      //combinando checkPilares con selectPilares
      // Verificamos que ambos arreglos tengan la misma longitud
      if (this.selectObjetivo.length === objetivos_nombres.length) {
        // Creamos un nuevo arreglo para almacenar la combinación
        var combinadoObjetivo = [];
        // Recorremos los arreglos
        for (var i = 0; i < this.selectObjetivo.length; i++) {
          // Si la posición en selectPilar no está vacía, combinamos con la correspondiente en checkPilares
          if (this.selectObjetivo[i] !== "") {
            combinadoObjetivo.push(objetivos_nombres[i] + "->" + this.selectObjetivo[i]);
          } else {
            // Si la posición en selectPilar está vacía, simplemente añadimos la correspondiente en checkPilares
            combinadoObjetivo.push(objetivos_nombres[i]);
          }
        }
        // Imprimimos el resultado
        console.log("combinadoObjetivo")
        console.log(combinadoObjetivo);
      } else {
        console.log("Los arreglos no tienen la misma longitud");
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
      var folio=siglasPlanta+"-"+siglasArea+'-'+siglasDepartamento+'-P'+pilarOrden+'-OB'+objetivoOrden;
      console.log(folio);

      axios.post("proyectosController.php",{
        fecha_alta:this.fecha_alta,  
        nombre_proyecto:this.nombre_proyecto,
        select_planta:planta,
        select_area:area,
        select_departamento:departamento,
        select_metodologia:metodologia,
        responsable_id:responsable_id,
        misiones:misiones_nombres,
        pilares:combinadoPilar,
        objetivos:combinadoObjetivo,
        impacto_ambiental:impacto_ambiental_nombres,
        tons_co2:this.tons_co2,
        ahorro_duro:this.ahorro_duro,
        ahorro_suave:this.ahorro_suave   
      }).then(response=>{
          console.log(response.data)
          if(response.data[0]==true){
             this.myModal.hide()
             this.consultarProyectos()
          }else{
            alert("No se dio de alta el proyecto.")
          }
      }).catch(error =>{

      })
    },
    modalCatalogos(accion,tipo,id,nombre,cantidad, unidadMedida){//accion: es CREAR, ACTUALIZAR, ELIMINAR y tipo: es Pilares, Misiones, Objetivos.
      this.id = ''
      this.accion = accion
      this.tipo = tipo
      this.myModal = new bootstrap.Modal(document.getElementById("modalCrearCatalogos"))
      this.myModal.show()
     

      if(accion=='Actualizar'){
          if(tipo=='Impacto Ambiental'){
              this.nuevoNombre = nombre;
              this.id = id;
          }
      }
      }
  }
};

const altaProyectos = Vue.createApp(AltaProyectos);

altaProyectos.mount("#alta-proyectos");