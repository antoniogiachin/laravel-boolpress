<template>
    <div class="container">
        <h1> Lo slug del post è: {{ $route.params.slug }}</h1>
        <h1>Il titolo del post è {{post.title}}</h1>
        <p>Contenuto del post è {{post.content}}</p>
    </div>
</template>

<script>
export default {
    name: 'SinglePost',
    data()  {
        return {
            // salvo post di risposta
            post: [],
        }
    },
    methods: {
        getSinglePost(slug){
            axios.get('/api/posts/' + slug)
            .then((response) => {
                // handle success
                console.log(response);
                this.post = response.data.result;
            })
        }
    },
    created() {
        this.getSinglePost(this.$route.params.slug);
    }
}
</script>

<style>

</style>