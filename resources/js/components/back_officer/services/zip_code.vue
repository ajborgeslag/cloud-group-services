<template>

    <v-card>

        <v-card-title>

            Códigos Postales

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
            v-model="selected"
            :single-select="singleSelect"
            item-key="id"
            show-select
            class="elevation-1"
        >
            <template v-slot:top>
                <v-btn color="primary" class="ma-3" @click="aplicar()">
                    Aplicar
                    <v-icon
                        dark
                        right
                    >
                        mdi-checkbox-marked-circle
                    </v-icon>
                </v-btn>
            </template>
            <template v-slot:item.sobreprecio="{ item }">
                <v-text-field
                    placeholder="Sobrecio"
                    v-model="item.sobreprecio"
                ></v-text-field>
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
        singleSelect: false,
        selected: [],
        selectedId: [],
        totalElements: 0,
        elements: [],
        loading: true,
        options: {},
        dialog: false,
        dialogDelete: false,
        search: '',
        columns: [
            {text: 'Provincia', value: 'province'},
            {text: 'Municipio', value: 'populate'},
            {text: 'Código Postal', value: 'zip_code', sortable: false},
            {text: 'Sobreprecio', value: 'sobreprecio', sortable: false}
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
        selected: function (val) {
            console.log(val)
            console.log(this.elements)
        },
        search: {
            handler () {
                this.getDataFromApi()
            },
            deep: true,
        },
    },

    created () {
        /*this.initialize()*/
    },

    methods: {
        aplicar(){
            this.loading = true
            this.elements = [];
            this.totalElements = 0;
            const data = {selected:this.selected, elements: this.elements};
            HTTP.post(`service/update-zip-codes`, data)
                .then(response => {
                    this.loading = false;
                    this.getDataFromApi();
                })
                .catch(e => {
                    this.loading = false
                })
        },
        getDataFromApi () {
            const { sortBy, sortDesc, page, itemsPerPage } = this.options
            this.loading = true
            const data = {page:page, itemsPerPage: itemsPerPage, search: this.search}
            HTTP.post(`service/search-zip-code`, data)
                .then(response => {
                    this.elements = response.data.data.items
                    this.totalElements = response.data.data.total
                    this.loading = false
                    var arrayTemp = []
                    response.data.data.items.forEach(function(obj) {
                        if(obj.postal_code_id!=null)
                        {
                            arrayTemp.push(obj)
                        }
                    });
                    this.selected = arrayTemp;
                })
                .catch(e => {
                    this.loading = false
                })
        },
        fakeApiCall () {
            return new Promise((resolve, reject) => {
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
