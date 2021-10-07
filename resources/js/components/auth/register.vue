<template>
    <v-card
        class="mx-auto my-12 pr-8 pb-8 pl-8"
        max-width="700"
        elevation="15"
        :loading = "loading"
    >
        <v-card-text>
    <validation-observer
        ref="observer"
        v-slot="{ invalid }"
    >
    <form @submit.prevent="submit">
        <validation-provider
            v-slot="{ errors }"
            name="Nombre(s)"
            rules="required"
            :counter = 20
        >
            <v-text-field
                v-model="first_name"
                clear-icon="mdi-close"
                clearable
                :error-messages="errors"
                label="Nombre(s)"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="Apellido(s)"
            rules="required"
            :counter = 20
        >
            <v-text-field
                v-model="last_name"
                clear-icon="mdi-close"
                clearable
                :error-messages="errors"
                label="Apellido(s)"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="Correo electrónico"
            rules="required|email"
        >
            <v-text-field
                v-model="email"
                clear-icon="mdi-close"
                clearable
                :error-messages="errors"
                label="Correo electrónico"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="Dirección"
            rules="required"
        >
            <v-text-field
                v-model="address"
                clear-icon="mdi-close"
                clearable
                :error-messages="errors"
                label="Dirección"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="Teléfono"
            rules="required"
        >
            <v-text-field
                v-model="phone_number"
                clear-icon="mdi-close"
                clearable
                :error-messages="errors"
                label="Teléfono"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="Contraseña"
            rules="required"
        >
            <v-text-field
                v-model="password"
                clear-icon="mdi-close"
                clearable
                :error-messages="errors"
                :rules="[(v => !!v || 'Password is required') && minimumChar]"
                @click:append="showPassword = !showPassword"
                :append-icon="showPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
                :type="showPassword ? 'text' : 'password'"
                label="Contraseña"
                required
            ></v-text-field>
        </validation-provider>

        <validation-provider
            v-slot="{ errors }"
            name="Repetir Contraseña"
            rules="required"
        >
            <v-text-field
                v-model="passwordAgain"
                clear-icon="mdi-close"
                clearable
                @click:clear="clearMessage"
                :error-messages="errors"
                :rules="[(password === passwordAgain) || 'Password must match']"
                @click:append="showRepeatPassword = !showRepeatPassword"
                :append-icon="showRepeatPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
                :type="showRepeatPassword ? 'text' : 'password'"
                label="Repetir Contraseña"
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
            </v-card-text>
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

import {HTTP} from '../../utils/http_commons'

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data: () => ({
        first_name: '',
        last_name: '',
        email: '',
        address: '',
        phone_number: '',
        password: '',
        passwordAgain: '',
        loading: false,
        error_snackbar: false,
        error_message: '',
        showRepeatPassword:false,
        showPassword:false,
        minimumChar: v => v.length >= 8 || 'Min 8 characters',

    }),

    methods: {
        submit () {
            this.$refs.observer.validate()
            this.loading = true
            const data = {first_name :this.first_name, last_name :this.last_name, email:this.email, address :this.address, phone_number :this.phone_number, password: this.password}
                HTTP.post(`auth/register`, data)
                    .then(response => {
                        console.log(response.data.data.access_token)
                        localStorage.setItem('access_token', JSON.stringify(response.data.data.access_token));
                        localStorage.setItem('authenticatedUser', true);
                        window.location.href = 'home';
                        this.loading = false
                    })
                    .catch(e => {
                    console.log(e.response.data)
                    this.error_snackbar = true
                    this.error_message = e.response.data.message
                    this.loading = false
                })
            },
        clearMessage () {
            this.message = ''
        }

        },
        clear () {
            this.first_name = ''
            this.last_name = ''
            this.email = ''
            this.password = ''
            this.address = ''
            this.phone_number = ''
            this.$refs.observer.reset()
        },
    }
</script>
