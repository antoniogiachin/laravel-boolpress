<template>
    <div class="container">
        <!-- <h1> Lo slug del post è: {{ $route.params.slug }}</h1> -->
        <h1><em>Titolo:</em> {{post.title}}</h1>
        <p><strong class="fs-4">Contenuto: </strong> {{post.content}}</p>
        <p>Cateogrie</p>
        <ul>
            <li v-if="post.category">{{post.category.name}}</li>
        </ul>
        <h2 class="my-2">Post collegati</h2>
        <div class="row row-cols-4">
            <div class="col card ms_card" v-for="relatedPost in relatedPostsFiltered" :key="relatedPost.id">
                <h3 class="card-title">{{sliceContent(relatedPost.title,20)}}</h3>
                <p> Anteprima: {{sliceContent(relatedPost.content, 10)}}</p>
                <router-link  :to="{name: 'single-post', params: {slug: relatedPost.slug}}" class="btn btn-success">Vai al post</router-link>
            </div>
        </div>
        <p>Tags</p>
        <ul>
            <li v-for="tag in tags" :key="tag.id">{{tag.name}}</li>
        </ul>

    </div>
</template>

<script>
export default {
    name: 'SinglePost',
    data()  {
        return {
            // salvo post di risposta
            post: [],
            category_id : null,
            relatedPosts : [],
            tags: [],
            tagPlaceholder :
                [
                    {
                        id : 0,
                        name : 'Nessun tag presente'
                    }
                ],
        }
    },
    methods: {
        getSinglePost(slug){
            axios.get('/api/posts/' + slug)
            .then((response) => {
                // handle success
                this.post = response.data.result;
                this.category_id = response.data.result.category.id
                this.getCategory(this.category_id);
                if(response.data.result.tags.length > 0){
                    this.tags = response.data.result.tags
                } else {
                    this.tags = this.tagPlaceholder
                }
            })
        },
        // chiamata axios per post legati categoria, category.php come ocntroller  ha la funzione post(), quindi posso vedere tutti i post legati ad una categoria, la chimata sarà show sul categorycontroller in api php artisan make:controller Api/CategoryController, allo show passo id della cateogria
        getCategory(id){
            axios.get('/api/category/' + id)
            .then((response) => {
                this.relatedPosts = response.data.result.post;
            })
        },
        // trim stringa
        sliceContent(text, param){
            if(text.length > param){
                return text.slice(0,param) + "...";
            } else {
                return text;
            }
        }
    },
    mounted() {
        this.getSinglePost(this.$route.params.slug);
    },
    //vedi watchers https://v3.router.vuejs.org/guide/advanced/navigation-guards.html#in-component-guards
    // beforeRouteUpdate(to, from, next){
    //     this.$route.params = to.relatedPost.slug
    //     next()
    // },
    computed:{
        relatedPostsFiltered : function(){
            return this.relatedPosts.filter(relatedPost =>{
                return relatedPost.title != this.post.title
            })
        }
    }


}
</script>

<style>
.ms_card{
    margin-right: 5px;
    margin-bottom: 5px;
    height: 200px;
    padding: 1rem;

}
</style>
