<template>
    <div class="container">
        <h1 class="text-center">Contattaci</h1>
        <div class="row">
            <div class="col-4 offset-4">
                <!-- al submit prevengo il reload della pagina, e invoco metodo per chiamata POST axios -->
                <form @submit.prevent="sendForm">
                    <!-- name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" v-model="name">
                    </div>
                    <!-- email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" v-model="email">
                    </div>
                    <!-- message -->
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea v-model="message" class="form-control" style="min-height: 250px" placeholder="Motivo del contatto" id="message" name="message" rows="50"></textarea>
                            <label for="message">Messaggio</label>
                        </div>
                    </div>
                    <!-- button submit -->
                    <button type="submit" class="btn btn-primary">Invia</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Contact',
    data() {
        return {
            // v-model su
            name: '',
            email: '',
            message:'',
        }
    },
    methods: {
        sendForm() {
            // chiamata in cui devo passare anche i parametri salvati in v-model, verranno ricevuti dalla request e salvati secondo logiche controller ContactController@show
            axios.post('/api/contacts',
            // parametri json
                {
                    'name' : this.name,
                    'email' : this.email,
                    'message' : this.message,
                }
            ).then(response =>{
                console.log(response);
                //se response true

                //se response false
            })
        }
    },
}
</script>

<style>

</style>
