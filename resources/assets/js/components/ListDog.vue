<template>
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">Tabla de Ejemplo</div>
  
            <div class="panel-body">
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
    mounted() {
      console.log('Component mounted.');
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
        fetch(`/perros/${perro.id}`, { method: 'DELETE' })
          .then(response => {
            if (response.ok) {
              // Lógica para manejar la respuesta del servidor en caso de éxito
            } else {
              // Lógica para manejar la respuesta del servidor en caso de error
            }
          })
          .catch(error => {
            // Lógica para manejar el error de la solicitud
          });
      }
    }
  };
  </script>
  