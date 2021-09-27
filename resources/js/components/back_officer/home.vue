<template>
    <div>Welcome</div>
</template>

<script>
export default {
    data: () => ({
        authenticatedUser: localStorage.getItem('authenticatedUser')
    }),
    /*beforeCreate: function () {
        console.log(localStorage.getItem('authenticatedUser'))
        // the data object is not yet created
        this.authenticatedUser = localStorage.getItem('authenticatedUser');
    },*/
    methods: {

    },
}
</script>
