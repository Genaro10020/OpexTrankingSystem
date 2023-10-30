const AltaProyectos = {
  data() {
    return{
       /*/////////////////////////////////////////////////////////////////////////////////VARIBLES USUARIOS Y DEPARTAMENTOS INICIO*/
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
      departamentos:[],
      metodologias:[],
      pilares:[],
      selectPilar:[],
      /*Planta*/ /*Área*/ /*Departamento*/
      nueva:'',
      nuevoNombre:'',
      eliminar:'',
     /*Responsable*/
      nuevoResponsable:false,
      nombre:'',
      numero_nomina:'',
      correo:'',
      telefono:'',
      //general
      id:''// utilizado y reseteado despues de usar.
    }
  },
  mounted(){
  //  this.consultarUsuarios()
  },
  methods: {
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
     /*/////////////////////////////////////////////////////////////////////////////////CONSULTAR RESPONSABLES*/
    consultarResponsables(){
      axios.get('responsablesController.php',{
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
      consultarPilares(){
      axios.get('pilaresController.php',{
      }).then(response =>{
          console.log(response.data[0])
          if (!response.data[0][1]==false){
              if (response.data[0][0].length>0) {
                this.pilares = response.data[0][0]
              }
          }else{
              alert("La consulta Pilares, no se realizo correctamente.")
          }
  
      }).catch(error =>{
        console.log('Erro :-('+error)
      }).finally(() =>{

      })
    },
     /*/////////////////////////////////////////////////////////////////////////////////INSERTAR PLANTA*/
     insertarPlanta(){
      axios.post('plantasController.php',{
        nueva:this.nueva
      }).then(response =>{
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
        nueva:this.nueva
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
          nueva:this.nueva
        }).then(response =>{
            console.log(response.data)
            if (response.data[0]==true){
              this.myModalCRUD.hide()
              this.consultarDepartamentos()
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
                        this.selectResponsable = nuevo
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
        /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR PLANTA*/
        actualizarPlanta(){
        if(this.selectPlanta!=""){
          axios.put('plantasController.php',{
            idPlanta:this.id,
            nuevoNombre:this.nuevoNombre
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
          nuevo:this.nuevoNombre
        }).then(response =>{
            console.log(response.data)
            if (response.data[0]==true){
              this.myModalCRUD.hide()
              this.consultarAreas()
              this.selectArea='',
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
   /*/////////////////////////////////////////////////////////////////////////////////ACTUALIZAR DEPARTAMENTO*/
   actualizarDepartamento(){
    if(this.selectDepartamento!=""){
      axios.put('departamentosController.php',{
        id:this.id,
        nuevo:this.nuevoNombre
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
     /*/////////////////////////////////////////////////////////////////////////////////ELIMINAR PLANTA*/
     eliminarPlanta(){
        const id_nombre_planta = this.selectPlanta.split('-');
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
      const id_nombre_area = this.selectArea.split('-');
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
      const id_nombre_area = this.selectDepartamento.split('-');
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
      const id_nombre_area = this.selectMetodologia.split('-');
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
    crearResponsable(){
      this.nuevoResponsable =! this.nuevoResponsable;

    },
   abrirModal(modal,tipo,accion){
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
          this.consultarPilares()
      }else if(modal=="CRUD"){
        this.myModalCRUD = new bootstrap.Modal(document.getElementById("modal-alta-crud"))
          if(accion=="Crear"){
            this.myModalCRUD.show()
          }else if(accion=="Actualizar"){
                if(tipo=="Planta"){
                    if(this.selectPlanta!=""){
                      this.myModalCRUD.show()
                        const id_nombre_planta = this.selectPlanta.split('-');//separando
                        this.id=id_nombre_planta[0]//recuperando nombre planta
                        this.nuevoNombre=id_nombre_planta[1]//recuperando nombre planta
                    }else{
                      alert("Favor de seleccionar la Planta que actualizará")
                    }
                }
              if(tipo=="Área"){
                console.log(this.selectArea)
                    if(this.selectArea!=""){
                      this.myModalCRUD.show()
                        const id_nombre_area = this.selectArea.split('-');//separando
                        this.id = id_nombre_area[0]//recuperando nombre planta
                        this.nuevoNombre =id_nombre_area[1]//recuperando nombre planta
                    }else{
                      alert("Favor de seleccionar la Área que actualizará")
                    }
                }
                if(tipo=="Departamento"){
                  console.log(this.selectDepartamento)
                      if(this.selectDepartamento!=""){
                        this.myModalCRUD.show()
                          const id_nombre = this.selectDepartamento.split('-');//separando
                          this.id = id_nombre[0]//recuperando nombre planta
                          this.nuevoNombre =id_nombre[1]//recuperando nombre planta
                      }else{
                        alert("Favor de seleccionar la Departamento que actualizará")
                      }
                  }
                  if(tipo=="Metodología"){
                    console.log(this.selectMetodologia)
                        if(this.selectMetodologia!=""){
                          this.myModalCRUD.show()
                            const id_nombre = this.selectMetodologia.split('-');//separando
                            this.id = id_nombre[0]//recuperando nombre planta
                            this.nuevoNombre =id_nombre[1]//recuperando nombre planta
                        }else{
                          alert("Favor de seleccionar la Departamento que actualizará")
                        }
                    }
          }
      }else{
        alert("No encontramos esa modal")
      }
     
    },
    cerrarModal(){
        this.myModal.hide()
    }
  }
};

const altaProyectos = Vue.createApp(AltaProyectos);

altaProyectos.mount("#alta-proyectos");