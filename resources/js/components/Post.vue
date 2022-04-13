<template>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ post.title }}</h5>
            <p class="card-text">{{ sliceContent(post.content, 10) }}</p>
            <!-- mostro i tags -->
            <div class="d-flex mb-3">
                <span v-for="tag in tags" :key="tag.id" class="badge rounded-pill bg-primary">{{tag.name}}</span>
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
            return text.slice(0,param) + "...";
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

</style>
