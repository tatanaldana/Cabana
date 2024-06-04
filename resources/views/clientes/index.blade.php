<x-app-layout>
    <x-slot name='header'>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>
    <div id="app">
        <x-container class="py-8">
        <!--Crear clientes-->
            <x-formsection class="mb-12">
                <x-slot name='title'>
                    Agregar Cliente
                </x-slot>
                <x-slot name='description'>
                    Ingrese los datos solicitados
                </x-slot>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <div v-if="Createform.errors.length > 0"
                        class="mb-4 bg-red-100 border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong class="font-bold">Whoops</strong>
                                <span>Algo salio mal</span>
                                <ul>
                                    <li v-for="errors in Createform.errors">
                                        @{{errors}}
                                    </li>
                                </ul>
                        </div>

                        <x-input-label>
                            Nombre
                        </x-input-label>
                        <x-text-input id="name" name="name" v-model="Createform.name" class="block mt-1 w-full" type="text"/>

                        <x-input-label>
                            URL de redireccion
                        </x-input-label>
                        <x-text-input id="redirect" name="redirect" v-model="Createform.redirect" class="block mt-1 w-full" type="text"/>
                        <x-slot name='actions' >
                            <x-primary-button v-on:click="store" v-bind:disabled="$data.Createform.disabled">
                                Crear
                            </x-primary-button>
                        </x-slot>
                    </div>
                </div>
            </x-formsection>
        <!--Mostrar clientes-->
            <x-formsection v-if="clients.length > 0">
                <x-slot name='title'>
                    Agregar Cliente
                </x-slot>
                <x-slot name='description'>
                    Ingrese los datos solicitados
                </x-slot>
                <div>
                    <table class=text-gary-600>
                        <thead class="border-b border-grauy-300">
                            <tr class="text-left">
                                <th class="py-2 w-full">
                                    Nombre
                                </th>
                                <th class="py-2">
                                    Accion
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                            <tr v-for="client in clients">
                                <td class="py-2">
                                    @{{client.name}}
                                </td> 
                                <td class="flex divide-x divide-black-300">
                                    <a v-on:click="show(client)" class="pr-2 hover:text-green-600 font-semibold cursor-pointer">
                                        Ver
                                    </a>
                                    <a class="pr-2 hover:text-blue-600 font-semibold cursor-pointed" 
                                    v-on:click="edit(client)">
                                        Editar
                                    </a>
                                    <a class="pl-2 hover:text-red-600 font-semibold cursor-pointed"
                                    v-on:click="destroy(client)">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        </tbody>   
                    </table>              
                </div>
            </x-formsection>

        </x-container>

        <x-dialog-modal modal="editForm.open">
            <x-slot name="title">
                Editar cliente 
            </x-slot>
            <x-slot name="content">
                <div class=" space-y-6">
                    <div v-if="editForm.errors.length > 0"
                        class=" bg-red-100 border-red-400 text-red-700 px-4 py-3 rounded">
                        <strong class="font-bold">Whoops</strong>
                            <span>Algo salio mal</span>
                            <ul>
                                <li v-for="errors in editForm.errors">
                                    @{{errors}}
                                </li>
                            </ul>
                    </div>

                    <x-input-label>
                        Nombre
                    </x-input-label>
                    <x-text-input id="name" name="name" v-model="editForm.name" class="block mt-1 w-full" type="text"/>

                    <x-input-label>
                        URL de redireccion
                    </x-input-label>
                    <x-text-input id="redirect" name="redirect" v-model="editForm.redirect" class="block mt-1 w-full" type="text"/>
                </div>       
            </x-slot>
            <x-slot name="footer">
                <x-primary-button type="button"
                    v-on:click="update()"
                    v-bind:disabled="editForm.disabled"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                    Actualizar
                </x-primary-button>


                <x-primary-button v-on:click="editForm.open = false" type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-gray-300 text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancelar
                </x-primary-button>
            </x-slot>
        </x-dialog-modal>

                {{-- Modal show --}}
        <x-dialog-modal modal="showClient.open">
            <x-slot name="title">
                Mostrar credenciales
            </x-slot>

            <x-slot name="content">
                <div class="space-y-2">

                    <p>
                        <span class="font-semibold">CLIENTE: </span>
                        <span v-text="showClient.name"></span>
                    </p>

                    <p>
                        <span class="font-semibold">CLIENT_ID: </span>
                        <span v-text="showClient.id"></span>
                    </p>

                    <p>
                        <span class="font-semibold">CLIENT_SECRET: </span>
                        <span v-text="showClient.secret"></span>
                    </p>
                    
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-primary-button v-on:click="showClient.open = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                    Cancelar
                </x-primary-button>
            </x-slot>

        </x-dialog-modal>
    
    </div>  
    @push('js')
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    clients: [],
                    showClient:{
                        open: false,
                        name: null,
                        id: null,
                        secret: null
                    },
                    Createform: {
                        errors: [],
                        disabled: false,
                        name: null,
                        redirect: null,
                    },                    
                    editForm: {
                        open: false,
                        errors: [],
                        disabled: false,
                        id: null,
                        name: null,
                        redirect: null,
                    }
                };
            },
            mounted() {
                this.getClients();
            },
            methods: {
                getClients() {
                    axios.get('/oauth/clients')
                        .then(response => {
                            this.clients = response.data;
                        }).catch(error => {
                            console.error('Error al obtener los clientes:', error);
                        });
                },
                show(client){
                        this.showClient.open = true;
                        this.showClient.name = client.name;
                        this.showClient.id = client.id;
                        this.showClient.secret = client.secret;
                    },

                store() {
                    this.Createform.disabled = true;
                    axios.post('/oauth/clients', this.Createform)
                        .then(response => {
                            this.Createform.name = null;
                            this.Createform.redirect = null;
                            this.Createform.errors = [];
                            Swal.fire({
                                title: "Cliente creado",
                                text: "El cliente se ha creado correctamente.",
                                icon: "success"
                            });
                            this.getClients();
                        }).catch(error => {
                            this.Createform.errors = _.flattenDeep(_.toArray(error.response.data.errors));
                        }).finally(() => {
                            this.Createform.disabled = false; // Reactivar el formulario incluso si ocurre un error
                        });
                },
                edit(client){
                        this.editForm.open = true;
                        this.editForm.errors = [];
                        
                        this.editForm.id = client.id;
                        this.editForm.name = client.name;
                        this.editForm.redirect = client.redirect;
                    },

                    update(){
                        this.editForm.disabled = true;

                        axios.put('/oauth/clients/' + this.editForm.id, this.editForm)
                            .then(response => {
                                this.editForm.open = false;
                                this.editForm.disabled = false;
                                this.editForm.name = null;
                                this.editForm.redirect = null;
                                this.editForm.errors = [];

                                Swal.fire(
                                    '¡Actualizado con éxito!',
                                    'El cliente se actualizó satisfactoriamente.',
                                    'success'
                                );

                                this.getClients();
                                

                            }).catch(error => {

                                this.editForm.errors = _.flatten(_.toArray(error.response.data.errors));

                                this.editForm.disabled = false;

                            })
                    },
                destroy(client) {// Cambiado de clients a client para que el parámetro sea singular              
                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "¡No podrás revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, ¡elimínelo!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete('/oauth/clients/' + client.id )
                                .then(response => {
                                    this.getClients();
                                    Swal.fire({
                                        title: "¡Eliminado!",
                                        text: "El cliente ha sido eliminado correctamente.",
                                        icon: "success"
                                    });
                                }).catch(error => {
                                    console.error('Error al eliminar el cliente:', error);
                                    Swal.fire({
                                        title: "Error",
                                        text: "Se produjo un error al intentar eliminar el cliente.",
                                        icon: "error"
                                    });
                                });
                        }
                    });
                }
            }
        });

        app.mount('#app');
    </script>
@endpush
</x-app-layout>
