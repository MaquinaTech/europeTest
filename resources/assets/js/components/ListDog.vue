<template>
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Tabla de Ejemplo</div>
  
            <div class="panel-body">
              <!-- Elemento de notificación -->
            <transition name="slide">
              <div v-if="mostrarNotificacion" :class="['notification', tipoNotificacion]">
                {{ mensajeNotificacion }}
              </div>
            </transition>
            <div class="addDog">
              <button @click="añadirPerro(perro)">Nuevo Perro</button>
            </div>
              <table class="table" style="padding-top: 20px;">
                <thead>
                  <tr>
                    <th>Raza</th>
                    <th>Nombre</th>
                    <th>Tamaño</th>
                    <th>Color de pelo</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="perro in perros" :key="perro.id">
                    <td>{{ perro.race }}</td>
                    <td>{{ perro.name }}</td>
                    <td>{{ perro.size }}</td>
                    <td>{{ perro.hair_color }}</td>
                    <td>
                      <button @click="editarPerro(perro)">Editar</button>
                      <button @click="eliminarPerro(perro)">Eliminar</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: ['perros'],
    data() {
    return {
      csrfToken: '',
      mostrarNotificacion: false,
      tipoNotificacion: '',
      mensajeNotificacion: '',
    };
  },
    mounted() {
      console.log('Component mounted.');
      this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      
      console.log(this.csrfToken);
    },
    methods: {
        editarPerro(perro) {
        fetch(`/perros/${perro.id}`)
            .then(data => {
                window.location.href = `/perros/${perro.id}`;
            })
            .catch(error => {
            console.error(error);
            });
        },

        eliminarPerro(perro) {
          fetch(`/perros/${perro.id}`, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': this.csrfToken,
            },
            body: JSON.stringify(this.perro),
          })
            .then(response => response.json())
            .then(data => {
              // Mostrar la notificación de éxito
              this.mensajeNotificacion = data.message;
              this.mostrarNotificacion = true;
              this.tipoNotificacion = 'success';

              // Ocultar la notificación después de 3 segundos
              setTimeout(() => {
                this.mostrarNotificacion = false;
              }, 3000);

              const index = this.perros.findIndex(p => p.id === perro.id);
              if (index !== -1) {
                this.perros.splice(index, 1);
              }
            })
            .catch(error => {
              // Lógica para manejar el error de la solicitud
              console.error(error);
               // Mostrar la notificación de error
              this.mensajeNotificacion = 'Hubo un error al actualizar el perro.';
              this.mostrarNotificacion = true;
              this.tipoNotificacion = 'error';

              // Ocultar la notificación después de 3 segundos
              setTimeout(() => {
                this.mostrarNotificacion = false;
              }, 3000);
            });
        },
    }
  };
  </script>
  