<template>
        <v-data-table
            :headers="columns"
            :items="elements"
            class="elevation-5"
        >
        </v-data-table>
</template>

<script>
/*export default {
    name: "manage"
}*/

export default {
    data: () => {
        return {
            columns:[
                {text:'First Name', value:'firstname'},
                {text:'Last Name', value:'lastname'},
                {text:'Email', value:'email'},
                {text:'Address', value:'address'}
            ],
            elements:[
                {firstname: 'Miguel', lastname: 'Abreu', email: 'mabreucardenas95@gmail.com', address: 'edif 891 apto 25 zona 5 Alamar'},
                {firstname: 'Alejandro', lastname: 'Borges', email: 'mabreucardenas95@gmail.com', address: 'edif 892 apto 26 zona 6 Alamar'},
                {firstname: 'Guillermo', lastname: 'Abreu', email: 'mabreucardenas95@gmail.com', address: 'edif 893 apto 27 zona 7 Alamar'},
                {firstname: 'Javier', lastname: 'Borges', email: 'mabreucardenas95@gmail.com', address: 'edif 894 apto 28 zona 9 Alamar'},
                {firstname: 'Roberto', lastname: 'Quintana', email: 'mabreucardenas95@gmail.com', address: 'edif 895 apto 29 zona 10 Alamar'},
                {firstname: 'Lisuan', lastname: 'Martinez', email: 'mabreucardenas95@gmail.com', address: 'edif 896 apto 24 zona 58 Alamar'},
                {firstname: 'Christian', lastname: 'Martinez', email: 'mabreucardenas95@gmail.com', address: 'edif 897 apto 23 zona 47 Alamar'}
            ]
        }
    }
}
</script>

<style scoped>

</style>
