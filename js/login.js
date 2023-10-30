const app = {
    data() {
      return {
        usuario: '',
        contrasena: '',
        incorrecta:0
      };
    },
    created() {
      // Obtener los valores de $_SESSION o usar datos de prueba
      //this.nombre = 'Nombre de Usuario';
     // this.tipo = 'Tipo de Usuario';
    },
    methods:{
      submitForm() {
        const formData = {
          usuario: this.usuario,
          contrasena: this.contrasena
        };
  
        // Ejemplo de cómo hacer una solicitud POST utilizando Axios
        axios.post('verificar.php', formData)
          .then(response => {
            // Manejar la respuesta si es necesario
            console.log(response.data);
            if(response.data=="Autorizado"){
              window.location.href="panel.php"  
            }else{
              this.incorrecta = 1;
              setTimeout(() => {
                this.incorrecta = 0;
              },3000)
            }
          })
          .catch(error => {
            // Manejar errores si es necesario
            console.error(error);
          });
    }
  }
  };
  
  const App = Vue.createApp(app);
  
  App.mount('#app');