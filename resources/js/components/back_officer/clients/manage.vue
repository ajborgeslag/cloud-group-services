<template>

    <v-card>

        <v-card-title>

            Clientes

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
                                                    v-model="editedItem.name"
                                                    label="Nombre"
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

                <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="text-h5">Está seguro que desea eliminar el cliente ?</v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="closeDelete">Cancelar</v-btn>
                            <v-btn color="blue darken-1" text @click="deleteItemConfirm">Aceptar</v-btn>
                            <v-spacer></v-spacer>
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
/*export default {
    name: "manage"
}*/

import {HTTP} from "../../../utils/http_commons";

export default {
    data: () => ({
            totalElements: 0,
            elements: [],
            loading: true,
            options: {},
            dialog: false,
            dialogDelete: false,
            search: '',
            columns: [
                {text: 'Nombre', value: 'name'},
                {text: 'Correo', value: 'email'},
                {text: 'Acciones', value: 'actions', sortable: false}
            ],
            editedIndex: -1,
            editedItem: {
                named: '',
                email: '',
            },
            defaultItem: {
                name: '',
                email: '',
            },
    }),

    computed: {
        formTitle () {
            //return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            return 'Editar Cliente'
        },
    },
    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
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

    created () {
        this.initialize()
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
        deleteItem (item) {
            this.editedIndex = this.elements.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        deleteItemConfirm () {
            // this.elements.splice(this.editedIndex, 1)
            // this.closeDelete()

            if (this.editedIndex > -1) {
                Object.assign(this.elements[this.editedIndex], this.editedItem)
            } else {
                // this.elements.push(this.editedItem)
                this.elements.splice(this.editedIndex, 1)
            }
            // this.close()
            this.closeDelete()
        },
        close () {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        closeDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },
        save () {
            if (this.editedIndex > -1) {
                Object.assign(this.elements[this.editedIndex], this.editedItem)
            } else {
                this.elements.push(this.editedItem)
            }
            this.close()
        },
    },
}
</script>

<style scoped>

</style>
