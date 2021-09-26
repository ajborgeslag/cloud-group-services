<template>
    <validation-observer
        ref="observer"
        v-slot="{ invalid }"
    >
    <form @submit.prevent="submit">
        <validation-provider
            v-slot="{ errors }"
            name="Name"
            rules="required|max:20"
        >
            <v-text-field
                v-model="name"
                :error-messages="errors"
                label="Name"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="Last Name"
            rules="required|max:20"
        >
            <v-text-field
                v-model="lastName"
                :error-messages="errors"
                label="Last Name"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="Email"
            rules="required|email"
        >
            <v-text-field
                v-model="email"
                :error-messages="errors"
                label="Email"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="password"
            rules="required"
        >
            <v-text-field
                v-model="password"
                :error-messages="errors"
                label="Password"
                type="password"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="repeatPassword"
            rules="required"
        >
            <v-text-field
                v-model="password"
                :error-messages="errors"
                label="Repeat Password"
                type="password"
                required
            ></v-text-field>
        </validation-provider>

        <div class="mt-4">
            <v-btn @click="clear" href="/login">
                Cancel
            </v-btn>
            <v-btn
                class="mr-4"
                type="submit"
                :disabled="invalid"
                :loading="loading"
            >
                Register
            </v-btn>
        </div>

    </form>

    <v-snackbar
        v-model="error_snackbar"
        absolute
        centered
        elevation="24"
    >
        {{ error_message }}
        <template v-slot:action="{ attrs }">
            <v-btn
                color="pink"
                text
                v-bind="attrs"
                @click="error_snackbar = false"
            >
                Cerrar
            </v-btn>
        </template>
    </v-snackbar>
    </validation-observer>
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

import {HTTP} from '../../utils/http_commons'

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        name: '',
        lastName: '',
        email: '',
        password: '',
        loading: false,
        error_snackbar: false,
        error_message: '',
    }),

    methods: {
        submit () {
            this.$refs.observer.validate()
            this.loading = true
            const data = {name :this.name, lastName:this.lastName, 'email':this.email, password: this.password}
            HTTP.post(`auth/register`, data)
                .then(response => {
                    console.log(response.data.data.access_token)
                    localStorage.setItem('access_token', JSON.stringify(response.data.data.access_token));
                    this.loading = false
                })
                .catch(e => {
                    console.log(e.response.data)
                    this.error_snackbar = true
                    this.error_message = e.response.data.message
                    this.loading = false
                })
        },
        clear () {
            this.email = ''
            this.password = ''
            this.$refs.observer.reset()
        },
    },
}
</script>
