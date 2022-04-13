<template>
    <div class="container">
        <!-- <h1> Lo slug del post è: {{ $route.params.slug }}</h1> -->
        <h1><em>Titolo:</em> {{post.title}}</h1>
        <p><strong class="fs-4">Contenuto: </strong> {{post.content}}</p>
        <p>Cateogrie</p>
        <ul>
            <li v-if="post.category">{{post.category.name}}</li>
        </ul>
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
                console.log(response);
                this.post = response.data.result;
                if(response.data.result.tags.length > 0){
                    this.tags = response.data.result.tags
                    console.log(this.tags);
                } else {
                    this.tags = this.tagPlaceholder
                    console.log(this.tags);
                }
            })
        }
    },
    created() {
        this.getSinglePost(this.$route.params.slug);
    },
    // computed:{
    //     tags: function(){
    //         if(this.posts.tags){
    //             return this.post.tags;
    //         } else {
    //             return this.tagPlaceholder
    //         }
    //     }
    // }
}
</script>

<style>

</style>
