<template>
    <div class="card mb-3">
        <div class="card-body">
            <!-- immagine -->
            <img :src="post.cover" class="card-img-top mb-2 ms_card-img img-fluid" :alt="post.title">
            <h5 class="card-title">{{ sliceContent(post.title,20) }}</h5>
            <p class="card-text">{{ sliceContent(post.content, 10) }}</p>
            <!-- mostro i tags -->
            <div class="d-flex mb-3">
                <span v-for="tag in tags" :key="tag.id" class="badge rounded-pill bg-primary me-2">{{tag.name}}</span>
            </div>
            <router-link :to="{name: 'single-post', params: {slug: post.slug}}" class="btn btn-primary">Continua la lettura</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Post',
    props: {
        'post' : Object,
    },
    data(){
        return {
            tagPlaceholder :
                [
                    {
                        id : 0,
                        name : 'Nessun tag presente'
                    }
                ]
        }
    },
    methods:{
        sliceContent(text, param){
            if(text.length > param){
                return text.slice(0,param) + "...";
            } else {
                return text;
            }
        }
    },
    computed:{
        tags: function(){
            if(this.post.tags.length > 0){
                return this.post.tags;
            } else {
                return this.tagPlaceholder
            }
        }
    }
}
</script>

<style>
.ms_card-img{
    height: 150px;
}
</style>
