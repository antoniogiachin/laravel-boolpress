<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-3">
        <div class="container-fluid">

            <router-link class="navbar-brand" :to="{name: 'home'}">BoolPress</router-link>

            <div class="navbar-nav">
                <router-link :to="{name: 'home'}" class="nav-link" href="#">Home</router-link>
                <router-link :to="{name: 'about'}" class="nav-link" href="#">Chi Siamo</router-link>
                <router-link :to="{name: 'contact'}" class="nav-link" href="#">Contatti</router-link>
                <router-link :to="{name: 'blog'}" class="nav-link" href="#">Visualizza i Post</router-link>
                <a href="/admin" class="nav-link"><u>Area Amministrativa</u></a>
            </div>

        </div>
    </nav>
</template>

<script>
export default {
    name: 'Header',
}
</script>

<style>

</style>
