<template>
    <validation-observer
        ref="observer"
        v-slot="{ invalid }"
    >
    <form @submit.prevent="submit">
        <validation-provider
            v-slot="{ errors }"
            name="Name"
            rules="required|max:10"
        >
            <v-text-field
                v-model="user"
                :error-messages="errors"
                label="Usuario"
                required
            ></v-text-field>
        </validation-provider>
        <validation-provider
            v-slot="{ errors }"
            name="email"
            rules="required|email"
        >
            <v-text-field
                v-model="password"
                :error-messages="errors"
                label="Password"
                required
            ></v-text-field>
        </validation-provider>
        <v-btn
            class="mr-4"
            type="submit"
            :disabled="invalid"
        >
            Cancelar
        </v-btn>
        <v-btn @click="clear">
            Loguin
        </v-btn>
    </form>
    </validation-observer>
</template>
<script>

import { required, digits, email, max, regex } from 'vee-validate/dist/rules'
import { extend, ValidationObserver, ValidationProvider, setInteractionMode } from 'vee-validate'

setInteractionMode('eager')

/*extend('digits', {
    digits,
    message: '{_field_} needs to be {length} digits. ({_value_})',
})

extend('required', {
    required,
    message: '{_field_} can not be empty',
})

extend('max', {
    max,
    message: '{_field_} may not be greater than {length} characters',
})

extend('regex', {
    regex,
    message: '{_field_} {_value_} does not match {regex}',
})

extend('email', {
    email,
    message: 'Email must be valid',
})*/


export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        user: '',
        password: ''
    }),

    methods: {
        submit () {
            this.$refs.observer.validate()
        },
        clear () {
            this.name = ''
            this.phoneNumber = ''
            this.email = ''
            this.select = null
            this.checkbox = null
            this.$refs.observer.reset()
        },
    },
}
</script>
