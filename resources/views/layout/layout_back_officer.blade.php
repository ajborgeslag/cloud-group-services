<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Servicios</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">

    <v-app>
        <v-navigation-drawer app v-if="auth" permanent expand-on-hover>
            <v-list>
                <v-list-item class="px-2">
                    <v-list-item-avatar>
                        <v-img src="https://randomuser.me/api/portraits/women/85.jpg"></v-img>
                    </v-list-item-avatar>
                </v-list-item>

                <v-list-item link>
                    <v-list-item-content>
                        <v-list-item-title class="text-h6">
                            Sandra Adams
                        </v-list-item-title>
                        <v-list-item-subtitle>sandra_a88@gmail.com</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list-group
                :value="false"
                prepend-icon="mdi-account-circle"
            >
                <template v-slot:activator>
                    <v-list-item-title>Clientes</v-list-item-title>
                </template>
                <v-list-item
                    v-for="([title], i) in clientes"
                    :key="i"
                    link
                >
                    <v-list-item-title v-text="title"></v-list-item-title>
                </v-list-item>
            </v-list-group>
            <v-list-group
                :value="false"
                prepend-icon="mdi-view-dashboard"
            >
                <template v-slot:activator>
                    <v-list-item-title>Servicios</v-list-item-title>
                </template>
                <v-list-item
                    v-for="([title], i) in servicios"
                    :key="i"
                    link
                >
                    <v-list-item-title v-text="title"></v-list-item-title>
                </v-list-item>
            </v-list-group>
            <v-list-group
                :value="false"
                prepend-icon="mdi-help-box"
            >
                <template v-slot:activator>
                    <v-list-item-title>Pedidos</v-list-item-title>
                </template>
                <v-list-item
                    v-for="([title], i) in pedidos"
                    :key="i"
                    link
                >
                    <v-list-item-title v-text="title"></v-list-item-title>
                </v-list-item>
            </v-list-group>
            <v-list-group
                :value="false"
                prepend-icon="mdi-account-circle"
            >
                <template v-slot:activator>
                    <v-list-item-title>Proveedores</v-list-item-title>
                </template>
                <v-list-item
                    v-for="([title], i) in proveedores"
                    :key="i"
                    link
                >
                    <v-list-item-title v-text="title"></v-list-item-title>
                </v-list-item>
            </v-list-group>
            <v-list-group
                :value="false"
                prepend-icon="mdi-account-circle"
            >
                <template v-slot:activator>
                    <v-list-item-title>Coordinadores</v-list-item-title>
                </template>
                <v-list-item
                    v-for="([title], i) in coordinadores"
                    :key="i"
                    link
                >
                    <v-list-item-title v-text="title"></v-list-item-title>
                </v-list-item>
            </v-list-group>
        </v-navigation-drawer>

        <v-app-bar app v-if="auth">
            <!-- -->
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>

            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                @yield('content')
            </v-container>
        </v-main>

        <v-footer app v-if="auth">
            <!-- -->
        </v-footer>
    </v-app>

</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
