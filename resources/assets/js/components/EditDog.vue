<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Editar Perro</div>

          <div class="panel-body">
            <!-- Elemento de notificación -->
            <transition name="slide">
              <div v-if="mostrarNotificacion" :class="['notification', tipoNotificacion]">
                {{ mensajeNotificacion }}
              </div>
            </transition>

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
                <select name="size" class="form-control" v-model="perro.size" required>
                  <option value="">Selecciona un tamaño</option>
                  <option v-for="size in sizeOptions" :value="size.value">{{ size.label }}</option>
                </select>
              </div>


              <div class="form-group">
                <label for="hair_color">Color de Pelo:</label>
                <div class="color-picker">
                  <input type="hidden" name="hair_color" v-model="perro.hair_color" required>
                  <div v-for="color in colores" :key="color" @click="selectColor(color)">
                    <div :class="['color-option', color, { selected: perro.hair_color === color }]">
                      <div class="color-circle"></div>
                    </div>
                  </div>
                </div>
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
      mostrarNotificacion: false,
      tipoNotificacion: '',
      mensajeNotificacion: '',
      colores: ['negro', 'blanco', 'marrón', 'gris'],
      sizeOptions: [
      { label: 'Grande (+30kg)', value: 'big' },
      { label: 'Mediano (20-30kg)', value: 'medium' },
      { label: 'Pequeño (10-20kg)', value: 'small' },
      { label: 'Muy pequeño (-10kg)', value: 'smaller' }
    ],
      
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
          // Mostrar la notificación de éxito
          this.mensajeNotificacion = data.message;
          this.mostrarNotificacion = true;
          this.tipoNotificacion = 'success';

          // Ocultar la notificación después de 3 segundos
          setTimeout(() => {
            this.mostrarNotificacion = false;
          }, 3000);
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
    selectColor(color) {
      this.perro.hair_color = color;
    },
    getColorClass(color) {
      return {
        'color-option': true,
        [color]: true,
        'selected': this.perro.hair_color === color
      };
    },
  },
};
</script>