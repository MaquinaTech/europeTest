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
              <input type="hidden" name="_method" value="POST">
              <input type="hidden" name="_token" :value="csrfToken">
              <div class="flex">
                <div class="profile">
                  <img :src="getImageUrl(perro.img_url)" alt="Perro" />
                </div>
                
                <div class="form-group">
                  <label for="image">Imagen:</label>
                  <input type="file" name="image" @change="handleImageChange">
                </div>
              </div>

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
                <div class="flex">
                  <label for="color">Color:</label>
                  <div class="color-indicator" :class="colorSelected"></div>
                </div>
                <select name="color" class="form-control" v-model="perro.hair_color" @change="updateColorIndicator" required>
                  <option value="">Selecciona un color</option>
                  <option v-for="color in colors" :value="color">{{ color }}</option>
                </select>
                
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
      colors: ['negro', 'blanco', 'marrón', 'gris'],
      colorSelected:this.perro.hair_color,
      sizeOptions: [
        { label: 'Grande (+30kg)', value: 'big' },
        { label: 'Mediano (20-30kg)', value: 'medium' },
        { label: 'Pequeño (10-20kg)', value: 'small' },
        { label: 'Muy pequeño (-10kg)', value: 'smaller' }
      ],
      imageFile: null
      
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
      const formData = new FormData();
      formData.append('image', this.imageFile);
      formData.append('perro', JSON.stringify(this.perro));

      // Realizar la solicitud PUT para actualizar el perro
      fetch(this.formAction, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': this.csrfToken,
        },
        body: formData,
      })
        .then(response => response.json())
        .then(data => {
          // Lógica para manejar la respuesta del servidor
          console.log(data);
          // Mostrar la notificación de éxito
          this.mensajeNotificacion = data.message;
          this.tipoNotificacion = 'success';
          this.mostrarNotificacion = true;
          //Actualizamos imagen
          this.perro = data.perro;

          

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
          this.tipoNotificacion = 'error';
          this.mostrarNotificacion = true;
          

          // Ocultar la notificación después de 3 segundos
          setTimeout(() => {
            this.mostrarNotificacion = false;
          }, 3000);
        });
    },
    handleImageChange(event) {
      this.imageFile = event.target.files[0];
    },
    updateColorIndicator() {
      // Realizar acciones adicionales según sea necesario
      console.log('Color seleccionado:', this.perro.hair_color);
      this.colorSelected=this.perro.hair_color;
    },
    getImageUrl(imgUrl) {
      const url = imgUrl ? `/storage/${imgUrl}` : '';
      console.log(url);
      return url;
    }

  }
};
</script>