<x-app-layout>
    <x-slot name='header'>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <x-container id="app" class="py-8">
       <x-formsection>
            <x-slot name='title'>
                Agregar Cliente
            </x-slot>
            <x-slot name='description'>
                Ingrese los datos solicitados
            </x-slot>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4">
                    <x-input-label>
                        Nombre
                    </x-input-label>
                    <x-text-input id="name" name="name" v-model="Createform.name" class="block mt-1 w-full" type="text"/>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-input-label>
                        URL de redireccion
                    </x-input-label>
                    <x-text-input id="redirect" name="redirect" v-model="Createform.redirect" class="block mt-1 w-full" type="text"/>
                </div>
            </div>
            <x-slot name='actions' >
                <x-primary-button v-on:click="store" v-bind:disabled="$data.Createform.disabled">
                    Crear
                </x-primary-button>
            </x-slot>
        </x-formsection>
        <x-formsection>
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
                                <a class="pr-2 hover:text-blue-600 font-semibold cursor-pointed">
                                    Editar
                                </a>
                                <a class="pl-2 hover:text-red-600 font-semibold cursor-pointed">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    </tbody>   
                </table>
                              
            </div>
        </x-formsection>
    
    </x-container>

    

    @push('js')
    <script>
const app = Vue.createApp({
    data() {
        return {
            clients: [],
            Createform: {
                disabled: true,
                errors: null,
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
        store() {
            this.Createform.disabled = true;
            axios.post('/oauth/clients', this.Createform)
                .then(response => {
                    this.Createform.name = null;
                    this.Createform.redirect = null;
                    Swal.fire({
                        title: "Cliente creado",
                        text: "El cliente se ha creado correctamente.",
                        icon: "success"
                    });
                    this.getClients();
                    this.Createform.disabled = true;
                }).catch(error => {
                    console.error('Error al crear el cliente:', error);
                    alert('No has enviado los datos solicitados');
                });
        }
    },
    watch: {
    'Createform.name': function (val) {
        console.log('Name changed:', val);
        this.Createform.disabled = !val || !this.Createform.redirect;
    },
    'Createform.redirect': function (val) {
        console.log('Redirect changed:', val);
        this.Createform.disabled = !val || !this.Createform.name;
    }
}
});

app.mount('#app');
    </script>
    @endpush
</x-app-layout>

