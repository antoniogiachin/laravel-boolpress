<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-3 border-3 rounded">
        <div class="container-fluid">

            <span class="navbar-brand"><span class="text-uppercase">BoolPress</span></span>

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
.router-link-exact-active{
    color: black;
    display: inline-block;
    border: 1px solid black;
    border-radius: 20px;
}
</style>
