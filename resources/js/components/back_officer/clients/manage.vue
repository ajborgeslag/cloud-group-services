<template>

    <v-card>

        <v-card-title>

            Clientes

            <v-spacer></v-spacer>

                 <v-icon
                    size=25
                    class="mr-2"
                    @click="addNewClient"
                    >
                   mdi-account-plus
                </v-icon>

            <v-spacer></v-spacer>

                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Buscar"
                    single-line
                    hide-details
                ></v-text-field>

        </v-card-title>

            <v-data-table
                :headers="columns"
                :items="elements"
                :options.sync="options"
                :server-items-length="totalElements"
                :loading="loading"
            >

                <template v-slot:top>
                        <v-dialog
                            v-model="dialog"
                            max-width="500px"
                        >
                            <v-card>
                                <v-card-title>
                                    <span class="text-h5">{{ formTitle }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col
                                            >
                                                <v-text-field
                                                    v-model="editedItem.first_name"
                                                    label="Nombre(s)"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row>
                                            <v-col
                                            >
                                                <v-text-field
                                                    v-model="editedItem.last_name"
                                                    label="Apellido(s)"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row>
                                            <v-col
                                            >
                                                <v-text-field
                                                    v-model="editedItem.email"
                                                    label="Correo"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row>
                                            <v-col
                                            >
                                                <v-text-field
                                                    v-model="editedItem.address"
                                                    label="Dirección"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>

                                        <v-row>
                                            <v-col
                                            >
                                                <v-text-field
                                                    v-model="editedItem.phone_number"
                                                    label="Teléfono"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>

                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                    >
                                        Cancelar
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                    >
                                        Salvar
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                <v-dialog v-model="dialogDelete" max-width="475px">
                    <v-card>
                        <v-card-title class="text-h6 ">¿Está seguro que desea eliminar el cliente?</v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="closeDelete">Cancelar</v-btn>
                            <v-btn color="blue darken-1" text @click="deleteItemConfirm">Aceptar</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="dialogAddClient"
                          max-width="500px"
                >
                        <v-card>
                            <v-card-title>
                                <span class="text-h5">{{ formTitle }}</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <form @submit.prevent="saveNewClient">
                                            <v-text-field
                                                v-model="editedItem.first_name"
                                                label="Nombre(s)"
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="editedItem.last_name"
                                                label="Apellido(s)"
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="editedItem.email"
                                                label="Correo"
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="editedItem.address"
                                                label="Dirección"
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="editedItem.phone_number"
                                                label="Teléfono"
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="editedItem.password"
                                                clear-icon="mdi-close"
                                                clearable
                                                :error-messages="errors"
                                                :rules="[(v => !!v || passwordRequired) && minimumChar]"
                                                @click:append="showPassword = !showPassword"
                                                :append-icon="showPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
                                                :type="showPassword ? 'text' : 'password'"
                                                label="Contraseña"
                                                required
                                            ></v-text-field>

                                            <v-text-field
                                                v-model="editedItem.passwordAgain"
                                                clear-icon="mdi-close"
                                                clearable
                                                @click:clear="clearMessage"
                                                :error-messages="errors"
                                                :rules="[(password === passwordAgain) || 'Password must match']"
                                                @click:append="showRepeatPassword = !showRepeatPassword"
                                                :append-icon="showRepeatPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
                                                :type="showRepeatPassword ? 'text' : 'password'"
                                                label="Repetir Contraseña"
                                            ></v-text-field>
                                    </form>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="close"
                                >
                                    Cancelar
                                </v-btn>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="saveNewClient"
                                >
                                    Salvar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(item)"
                    >
                        mdi-delete
                    </v-icon>
                </template>

            </v-data-table>

    </v-card>

</template>

<script>

import { required, digits, email, max, regex } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'

setInteractionMode('eager')

extend('required', {
    ...required,
    message: '{_field_} requerido',
})

extend('email', {
    ...email,
    message: 'Email inválido',
})

import {HTTP} from "../../../utils/http_commons";
export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
            totalElements: 0,
            showRepeatPassword:false,
            showPassword:false,
            passwordAgain: '',
            password: '',
            elements: [],
            loading: true,
            options: {},
            dialog: false,
            dialogDelete: false,
            dialogAddClient: false,
            search: '',
            columns: [
                {text: 'Nombre', value: 'first_name'},
                {text: 'Apellidos', value: 'last_name'},
                {text: 'Correo', value: 'email'},
                {text: 'Teléfono', value: 'phone_number'},
                {text: 'Dirección', value: 'address'},
                {text: 'Acciones', value: 'actions', sortable: false}
            ],
            editedIndex: -1,
            editedItem: {
                first_name: '',
                last_name: '',
                email: '',
                address: '',
                phone_number: '',
                passwordAgain: '',
                password: '',
            },
            defaultItem: {
                first_name: '',
                last_name: '',
                email: '',
                address: '',
                phone_number: '',
                passwordAgain: '',
                password: '',
            },
            minimumChar: v => v.length >= 8 || 'Min 8 characters',
            passwordRequired: v => !!v || 'Password is required',
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'Agregar Nuevo Cliente' : 'Editar Datos del Cliente'

        },
    },
    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
        dialogAddClient (val) {
            val || this.close()
        },
        options: {
            handler () {
                this.getDataFromApi()
            },
            deep: true,
        },
        search: {
            handler () {
                this.getDataFromApi()
            },
            deep: true,
        },
    },

    methods: {
        getDataFromApi () {
            const { sortBy, sortDesc, page, itemsPerPage } = this.options
            this.loading = true
            const data = {page:page, itemsPerPage: itemsPerPage, search: this.search}
            HTTP.post(`user/search`, data)
                .then(response => {
                    console.log(response)
                    this.elements = response.data.data.items
                    this.totalElements = response.data.data.total
                    this.loading = false
                })
                .catch(e => {
                    this.loading = false
                })
        },
        fakeApiCall () {
            return new Promise((resolve, reject) => {
                console.log(this.options);
                const { sortBy, sortDesc, page, itemsPerPage } = this.options
            })
        },
        editItem (item) {
            this.editedIndex = this.elements.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },
        addNewClient (item) {
            this.editedIndex = this.elements.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogAddClient = true
        },
        deleteItem (item) {
            this.editedIndex = this.elements.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm () {
            const data = {id:this.editedItem.id}
            HTTP.delete(`user/remove`, {data})
                .then(response => {
                    this.getDataFromApi()
                    this.elements.splice(this.editedIndex, 1)
                    this.closeDelete()
                })
                .catch(e => {
                    this.loading = false
                })
        },
        close () {
            this.dialog = false
            this.dialogAddClient = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
            this.loading = false
        },
        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
            this.loading = false
        },
        save () {
            if (this.editedIndex > -1) {
                this.loading = true
                Object.assign(this.elements[this.editedIndex], this.editedItem)
                const data = {
                    id:this.editedItem.id,
                    first_name:this.editedItem.first_name,
                    last_name:this.editedItem.last_name,
                    email:this.editedItem.email,
                    address:this.editedItem.address,
                    phone_number:this.editedItem.phone_number
                }
                HTTP.post('user/update', data)
                .then(response =>{
                    this.getDataFromApi()
                })
            }
            this.close()
        },
        saveNewClient(){
                this.loading = true
                const data = {
                    first_name:this.editedItem.first_name,
                    last_name:this.editedItem.last_name,
                    email:this.editedItem.email,
                    address:this.editedItem.address,
                    phone_number:this.editedItem.phone_number,
                    password:this.editedItem.password
                }
                HTTP.post('auth/register', data)
                    .then(response =>{
                        this.getDataFromApi()
                        console.log(response.data.data.access_token)
                        localStorage.setItem('access_token', JSON.stringify(response.data.data.access_token));
                        localStorage.setItem('authenticatedUser', true);
                        Object.assign(this.elements[this.editedIndex], this.editedItem)
                        this.loading = false;
                    })
            this.close()
        },
        clearMessage () {
            this.message = ''
        }
    },
}
</script>

<style scoped>

</style>
