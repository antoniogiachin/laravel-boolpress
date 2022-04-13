<template>
  <div class="container mt-5">
    <Header/>
    <Main/>
    <Footer/>
  </div>
</template>

<script>
//importo componenti
import Header from './Header.vue';
import Main from './Main.vue'
import Footer from './Footer.vue';

export default {
    name: 'App',
    components : {
      Header,
      Main,
      Footer
    }

}
</script>

<style>
body{
  background-color: cyan;
}
</style>
