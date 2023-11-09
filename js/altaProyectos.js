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
      select_pilar:'',
      select_mision:'',
      tons_co2:'',
      ahorro_duro:'',
      ahorro_suave:'',
      respondio: true,//utilizo para cambiar el css si no repondio en altas
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
      id:''// utilizado y reseteado despues de usar.
    }
  },
  mounted(){
  //  this.consultarUsuarios()
  },
  methods: {
    toggleDiv(){
      this.showDiv = !this.showDiv;
      console.log(this.showDiv);
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
      this.checkObjetivos =[]
        console.log(this.checkPilares);
        axios.post('objetivosController.php',{
            idsPilares:this.checkPilares
        }).then(response =>{
            console.log(response.data[0])
            if (response.data[0][1]==true){
                if (response.data[0][0].length>0) {
                  //this.pilares = response.data[0][0]
                  this.objetivos = response.data[0][0]
                }
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
  }
},
    /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR OBJETIVOS*/
    consultarObjetivos(){
      axios.get('objetivosController.php',{
      }).then(response =>{
          console.log(response.data[0])
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
        this.checkPilares =[]
        this.checkObjetivos=[]
          console.log(this.checkMisiones);
          axios.post('pilaresController.php',{
              idsMisiones:this.checkMisiones
          }).then(response =>{
              console.log(response.data[0])
              if (response.data[0][1]==true){
                  if (response.data[0][0].length>0) {
                    this.pilares = response.data[0][0]
                    //this.objetivos = response.data[0][2]
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
          if(this.nueva!='' && this.siglas!='' && this.select_pilar!=''){
              axios.post('objetivosController.php',{
                nueva:this.nueva,
                siglas:this.siglas, 
                id_pilar:this.select_pilar
              }).then(response =>{
                  console.log(response.data)
                  if (response.data[0]==true){
                    this.myModalCRUD.hide()
                    this.consultarObjetivos()
                    this.siglas=''
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
                  this.myModalCRUD.hide()
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
              nueva:this.nueva
            }).then(response =>{
                console.log(response.data)
                if (response.data[0]==true){
                  this.myModalCRUD.hide()
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
     /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR PILAR*/
     eliminarPilar(){
      if(this.checkPilares.length==1){
        this.id=this.checkPilares[0]
        if(confirm("Desea eliminar el Pilar seleccionado?")){
              axios.delete('pilaresController.php',{
                data:{
                  id:this.id
                }
              }).then(response =>{
                  console.log(response.data)
                  if (response.data[0]==true){
                    this.consultarPilares()
                    this.checkPilares = [] 
                    this.id=''
                  }else{
                      alert("No se elimino el Pilar.")
                  }
          
              }).catch(error =>{
                //console.log('Erro :-('+error)
              }).finally(() =>{
        
              })
        }
      }else{
        alert("Solamente debe estar marcado un Pilar a eliminar, no varios.")
      }
      /*const id_nombre_area = this.selectMetodologia.split('<->');
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
      }*/
    },
    /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR RESPONSABLE*/
    eliminarObjetivo(){
      if(this.checkObjetivos.length>0){

      const id_nombre_responsable = this.checkObjetivos[0].split('<->');
      this.id=id_nombre_responsable[0]
      var nombre=id_nombre_responsable[1]
      console.log(this.id)

       if(confirm("¿Desea eliminar el Objetivo: " + nombre+"?"))
        {
          axios.delete('objetivosController.php',{
            data:{
              id:this.id
            }
          }).then(response =>{
              console.log(response.data)
              if (response.data[0]==true){
                this.consultarObjetivos()
                this.id=''
                this.checkObjetivos = [] 
              }else{
                  alert("No se elimino al Responsable.")
              }
          }).catch(error =>{
            //console.log('Erro :-('+error)
          }).finally(() =>{
    
          })
        }
      }else{
        alert("Selecione el objetivo a eliminar a eliminar")
      }
    },
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
          this.consultarObjetivos()
          this.consultarPilares()
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
    guardarAltaProyecto(){
     
      //Comprobando fecha
      if(this.fecha_alta!=''){ this.respondio = true;}else{this.respondio = false;}
      //nombre del proyecto
      if(this.nombre_proyecto!=''){ this.respondio = true;}else{this.respondio = false;}
      //Planta
      if(this.selectPlanta!=''){this.respondio=true;}else{this.respondio=false;}
      //Area
      if(this.selectArea!=''){this.respondio=true;}else{this.respondio=false;}
      //Departamento
      if(this.selectDepartamento!=''){this.respondio=true;}else{this.respondio=false;}
      //Metodologia
      if(this.selectMetodologia!=''){this.respondio=true;}else{this.respondio=false;}
      //Responsable
      if(this.selectResponsable!=''){this.respondio=true;}else{this.respondio=false;}
      //Responsable
      if(this.selectResponsable!=''){this.respondio=true;}else{this.respondio=false;}
      //Misiones
      if(this.checkMisiones.length>0){this.respondio=true;}else{this.respondio=false;}
      //Pilares
      if(this.checkPilares.length>0){this.respondio=true;}else{this.respondio=false;}
      //Objetivos
      if(this.checkPilares.length>0){this.respondio=true;}else{this.respondio=false;}
      //Objetivos
      if(this.checkObjetivos.length>0){this.respondio=true;}else{this.respondio=false;}
      //Impacto Ambiental
      if(this.checkImpactoAmbiental.length>0){this.respondio=true;}else{this.respondio=false;}
      //Si algo no se a contestado
      
      if(this.respondio===false){alert("Existen campos vacios, favor de contestar")}
      //fecha_alta  nombre_proyecto selectPlanta selectArea selectDepartamento selectMetodologia selectResponsable  checkMisiones checkPilares checkObjetivos checkImpactoAmbiental tons_co2 ahorro_duro ahorro_suave      
    },
    modalCatalogos(accion,tipo){//accion: es CREAR, ACTUALIZAR, ELIMINAR y tipo: es Pilares, Misiones, Objetivos.
      this.accion = accion
      this.tipo = tipo
      this.myModal = new bootstrap.Modal(document.getElementById("modalCrearCatalogos"))
      this.myModal.show()
      }
  }
};

const altaProyectos = Vue.createApp(AltaProyectos);

altaProyectos.mount("#alta-proyectos");