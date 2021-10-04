<template>

    <v-card>

        <v-card-title>

            Users

            <v-spacer></v-spacer>

                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>

        </v-card-title>

            <v-data-table
                :headers="columns"
                :items="elements"
                :search="search"
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
                                                    v-model="editedItem.firstname"
                                                    label="First Name"
                                                ></v-text-field>
                                            </v-col>
                                            <v-col
                                            >
                                                <v-text-field
                                                    v-model="editedItem.lastname"
                                                    label="Last Name"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col
                                            >
                                                <v-text-field
                                                    v-model="editedItem.email"
                                                    label="Email"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col
                                            >
                                                <v-text-field
                                                    v-model="editedItem.address"
                                                    label="Address"
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
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                <v-dialog v-model="dialogDelete" max-width="500px">
                    <v-card>
                        <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                            <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
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

export default {
    data: () => ({
            dialog: false,
            dialogDelete: false,
            search: '',
            columns: [
                {text: 'First Name', value: 'firstname'},
                {text: 'Last Name', value: 'lastname'},
                {text: 'Email', value: 'email'},
                {text: 'Address', value: 'address'},
                {text: 'Actions', value: 'actions', sortable: false}
            ],
            editedIndex: -1,
            editedItem: {
                firstname: '',
                lastname: '',
                email: '',
                address: '',
            },
            defaultItem: {
                firstname: '',
                lastname: '',
                email: '',
                address: '',
            },
    }),

    // computed: {
    //     formTitle () {
    //         return this.editedIndex// === -1 ? 'New Item' : 'Edit Item'
    //     },
    // },

    watch: {
        dialog (val) {
            val || this.close()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },

    created () {
        this.initialize()
    },

    methods: {
        initialize () {
            this.elements = [
                {
                    firstname: 'Miguel',
                    lastname: 'Abreu',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 891 apto 25 zona 5 Alamar'
                },
                {
                    firstname: 'Alejandro',
                    lastname: 'Borges',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 892 apto 26 zona 6 Alamar'
                },
                {
                    firstname: 'Guillermo',
                    lastname: 'Abreu',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 893 apto 27 zona 7 Alamar'
                },
                {
                    firstname: 'Javier',
                    lastname: 'Borges',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 894 apto 28 zona 9 Alamar'
                },
                {
                    firstname: 'Roberto',
                    lastname: 'Quintana',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 895 apto 29 zona 10 Alamar'
                },
                {
                    firstname: 'Lisuan',
                    lastname: 'Martinez',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 896 apto 24 zona 58 Alamar'
                },
                {
                    firstname: 'Christian',
                    lastname: 'Martinez',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 897 apto 23 zona 47 Alamar'
                },
                {
                    firstname: 'Miguel',
                    lastname: 'Abreu',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 891 apto 25 zona 5 Alamar'
                },
                {
                    firstname: 'Alejandro',
                    lastname: 'Borges',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 892 apto 26 zona 6 Alamar'
                },
                {
                    firstname: 'Guillermo',
                    lastname: 'Abreu',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 893 apto 27 zona 7 Alamar'
                },
                {
                    firstname: 'Javier',
                    lastname: 'Borges',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 894 apto 28 zona 9 Alamar'
                },
                {
                    firstname: 'Roberto',
                    lastname: 'Quintana',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 895 apto 29 zona 10 Alamar'
                },
                {
                    firstname: 'Lisuan',
                    lastname: 'Martinez',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 896 apto 24 zona 58 Alamar'
                },
                {
                    firstname: 'Christian',
                    lastname: 'Martinez',
                    email: 'mabreucardenas95@gmail.com',
                    address: 'edif 897 apto 23 zona 47 Alamar'
                }
            ]
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
            this.elements.splice(this.editedIndex, 1)
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
