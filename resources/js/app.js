/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//funzione per verifica eliminazione
const deleteConfirm = document.querySelectorAll('.delete');
deleteConfirm.forEach(button =>{
    button.addEventListener('click',
        function(e){
            if(!confirm('Vuoi davvero eliminare il post?')){
                e.preventDefault();
            }
        }
    )
})
