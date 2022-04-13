<template>
    <main>
        <h1 class="mb-3">Post presenti nel sito</h1>
        <div class="row row-cols-2 row-md-cols-3 row-cols-lg-4">
            <div v-for="post in posts" :key="post.id" class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ post.title }}</h5>
                        <p class="card-text">{{ post.content.slice(0,10) }} ...</p>
                        <a href="#" class="btn btn-primary">Continua la lettura</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center gap-5">
            <!-- al click chiamata api con pagina corrente avanti o indietro -->
            <button @click="getApi(currentPage - 1)" type="button" class="btn btn-outline-primary page-item" :class=" currentPage == 1 ? 'disabled' : '' " ><i class="bi bi-chevron-left"></i> Indietro</button>
            <button @click="getApi(currentPage + 1)" type="button" class="btn btn-outline-primary page-item" :class="currentPage == lastPage  ? 'disabled' : ''" >Avanti <i class="bi bi-chevron-right"></i></button>
        </div>
    </main>
</template>

<script>
export default {
    name: 'myMain',
    //data
    data (){
        return {
            posts : [],
            // pagina corrente: di default quella iniziale : 1
            currentPage : 1,
            lastPage: null,
        }
    },

    methods: {
        // metodo per chiamata axios
        getApi(page){
            //rotta definita in api.php
            axios.get('/api/posts', {
                // secondo parametro di pagina corrente
                'params' : {
                    'page' : page,
                }
            })
                .then((response) => {
                    // handle success
                    console.log(response);
                    // store in data della risposta
                    // this.posts = data.results.data;
                    this.posts = response.data.results.data;
                    this.currentPage = response.data.results.current_page;
                    this.lastPage = response.data.results.last_page;
                    console.log(response.data.results.last_page);
            })
        }
    },
    // alla creazione lancia chiamata axios
    created(){
        this.getApi(this.currentPage)
    }
}
</script>

<style>

</style>