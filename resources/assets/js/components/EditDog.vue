<template>
  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Editar Perro</div>

                  <div class="panel-body">
                      <form @submit="actualizarPerro" :action="formAction" method="POST">
                          <input type="hidden" name="_method" value="PUT">
                          <input type="hidden" name="_token" :value="csrfToken">

                          <div class="form-group">
                              <label for="race">Raza:</label>
                              <input type="text" name="race" class="form-control" v-model="perro.race" required>
                          </div>

                          <div class="form-group">
                              <label for="name">Nombre:</label>
                              <input type="text" name="name" class="form-control" v-model="perro.name" required>
                          </div>

                          <div class="form-group">
                              <label for="size">Tamaño:</label>
                              <input type="text" name="size" class="form-control" v-model="perro.size" required>
                          </div>

                          <div class="form-group">
                              <label for="hair_color">Color de Pelo:</label>
                              <input type="text" name="hair_color" class="form-control" v-model="perro.hair_color" required>
                          </div>

                          <button type="submit" class="btn btn-primary">Actualizar</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
  props: ['perro'],
  data() {
    return {
      csrfToken: '',
      formAction: '',
    };
  },
  mounted() {
      // Obtener el token CSRF del elemento meta en el DOM
      this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Establecer la URL de acción del formulario
      this.formAction = `/perros/${this.perro.id}`;
  },
  methods: {
      actualizarPerro(event) {
          event.preventDefault();

          // Realizar la solicitud PUT para actualizar el perro
          fetch(this.formAction, {
              method: 'PUT',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': this.csrfToken,
              },
              body: JSON.stringify(this.perro),
          })
              .then(response => response.json())
              .then(data => {
                  // Lógica para manejar la respuesta del servidor
                  console.log(data);
                  // Recargar los datos del perro si es necesario
              })
              .catch(error => {
                  // Lógica para manejar el error de la solicitud
                  console.error(error);
              });
      },
  },
};
</script>
