<template>
    <div class="container">
        <h1 class="text-center">Contattaci</h1>
        <div class="row"  v-if="success">
            <div class="col-6 offset-3 text-center bg-success rounded mb-5 mt-2">
                <h4 class="px-1 py-4">Messaggio inviato con successo!</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-4 offset-4">
                <!-- al submit prevengo il reload della pagina, e invoco metodo per chiamata POST axios -->
                <form @submit.prevent="sendForm">
                    <!-- name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <!-- classe is invalid se esiste errors.name -->
                        <input :class="errors.name ? 'is-invalid' : '' " type="text" class="form-control" id="name" name="name" v-model="name">
                        <!-- errors.name è un array, ciclo e mostro i messaggi che contiene -->
                        <div  class="invalid-feedback" v-for="(error, index) in errors.name" :key="'name_error_' + index">
                            {{ error }}
                        </div>
                        <!-- stessa cosa per input in basso -->
                    </div>
                    <!-- email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input :class="{'is-invalid':errors.email }" type="email" class="form-control" id="email" name="email" v-model="email">
                        <div  class="invalid-feedback" v-for="(error, index) in errors.email" :key="'name_error_' + index">
                            {{ error }}
                        </div>
                    </div>
                    <!-- message -->
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea :class="errors.message ? 'is-invalid' : '' " v-model="message" class="form-control" style="min-height: 250px" placeholder="Motivo del contatto" id="message" name="message" rows="50"></textarea>
                            <label for="message">Messaggio</label>
                            <div  class="invalid-feedback" v-for="(error, index) in errors.message" :key="'name_error_' + index">
                            {{ error }}
                            </div>
                        </div>
                    </div>
                    <!-- button submit -->
                    <button type="submit" class="btn btn-primary">{{ sending ? 'Invio in corso...' : 'Invia' }}</button>
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
            // salvo errors
            errors: [],
            // mostra messaggio successo
            success: false,
            // invio in corso
            sending: false, // andrà su true al momento della chiamata, torna su false ricevuta la risposta
        }
    },
    methods: {
        sendForm() {
            //visualizzo ...invio in corso
            this.sending = true,
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
                // smetto ..invio in corso
                this.sending = false;
                //se response true
                if(response.data.success){
                    this.success =  true;
                    this.name = '';
                    this.email = '';
                    this.message = '';
                    this.errors = [];
                } else {
                    //se response false
                    this.errors = response.data.errors;
                    this.success = false;
                    console.log(this.errors);
                }
            })
        }
    },
}
</script>

<style>

</style>
