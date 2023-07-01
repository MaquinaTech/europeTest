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
                  <button class="btn btn-success btn-sm" @click="abrirModalNuevoPerro">Nuevo Perro</button>

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
                        <button class="btn btn-info btn-sm" @click="editarPerro(perro)">Editar</button>
                        <button class="btn btn-danger btn-sm" @click="eliminarPerro(perro)">Eliminar</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal" :style="{ display: mostrarModal ? 'block' : 'none' }">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Nuevo Perro</h5>
                <button type="button" class="close" @click="cerrarModal">
                  <span>&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form @submit="añadirPerro" :action="formAction" method="PUT">
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
                    <div class="flex">
                      <label for="color">Color:</label>
                      <div class="color-indicator" :class="colorSelected"></div>
                    </div>
                    <select name="color" class="form-control" v-model="perro.hair_color" @change="updateColorIndicator" required>
                      <option value="">Selecciona un color</option>
                      <option v-for="color in colors" :value="color">{{ color }}</option>
                    </select>
                  </div>

                  <button type="submit" class="btn btn-success">Añadir</button>
                </form>
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
          mostrarModal: false,
          csrfToken: '',
          mostrarNotificacion: false,
          tipoNotificacion: '',
          mensajeNotificacion: '',
          perro: {
            race: '',
            name: '',
            size: '',
            hair_color: '',
          },
          sizeOptions: [
            { label: 'Grande (+30kg)', value: 'big' },
            { label: 'Mediano (20-30kg)', value: 'medium' },
            { label: 'Pequeño (10-20kg)', value: 'small' },
            { label: 'Muy pequeño (-10kg)', value: 'smaller' }
          ],
          colorSelected:null,
          colors: ['negro', 'blanco', 'marrón', 'gris'],
        };
      },
      mounted() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.formAction = `/perros/add`;
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

        abrirModalNuevoPerro() {
          console.log('abrir modal');
          this.mostrarModal = true;
        },

        cerrarModal() {
          this.mostrarModal = false;
        },

        añadirPerro(event) {
          event.preventDefault();
          console.log(event);
          // Realizar la solicitud POST para agregar el perro
          fetch('/perros', {
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

              // Agregar el nuevo perro a la lista
              this.perros.push(data.perro);

              // Ocultar el modal y limpiar los datos del perro
              this.cerrarModal();
              this.perro = {
                race: '',
                name: '',
                size: '',
                hair_color: '',
              };
            })
            .catch(error => {
              // Lógica para manejar el error de la solicitud
              console.error(error);

              // Mostrar la notificación de error
              this.mensajeNotificacion = 'Hubo un error al añadir el perro.';
              this.mostrarNotificacion = true;
              this.tipoNotificacion = 'error';
            });
        },

        updateColorIndicator() {
          // Realizar acciones adicionales según sea necesario
          console.log('Color seleccionado:', this.perro.hair_color);
          this.colorSelected=this.perro.hair_color;
        }
      },
    };
    </script>
