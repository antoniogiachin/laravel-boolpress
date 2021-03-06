# Passi da compiere - Progetto con front-end (vue) e back-end (laravel - bootstrap per pannello amministrativo) - simil WordPress.

## Installazione componenti
- Installare laravel/ui *composer require laravel/ui:^2.4*
- Scaffolding con **auth** per Vue *php artisan ui vue --aut*
- In package.json metto versione di bootstrap a 5
- lancio istallazione con *npm install*

## Gestione rotte sottoposte a middleware::auth
- Rimozione **HomeController** di Laravel -> voglio il mio controller sotto la cartella(namespace) Admin
- Creo cartella(namespace) Admin sotto controllers
- *php artisan make:controller Admin/HomeController* -> crea controller sotto la cartella/namespace Admin
- Imposto nel file web.php, le rotte affinché esse siano accessibili solo a chi si autentica(usando middleware('auth')) ->vedi file web.php
- Dopo il login Laravel rediretta alla rotta /home, noi vogliamo che dopo il login siamo redirettati ad /admin/, possiamo cambiare la cosa in **app/Providers/RouteServiceProvider.php*

## Gestione HomeController
- Prelevo i dati inseriti dall'utente e li passo alla vista admin.home (che creo in view sotto la cartella Admin), attraverso il model Auth -> Auth::user(), essendo un *facades* va inserito sul controller *use Illuminate\Support\Facades\Auth;*
- Creo la view home.blade.php sotto la cartella Admin, assieme ad una ulteriore sottocartella admin/layouts con il layout di base (che copio da quello già presente)
- Allo stesso modo copio home da quello già presente fuori Admin

## DB Side
- Per quanto riguarda User -> pensa a tutto Laravel, mi basta lanciare la migration

## Gestisco scaffoldiing Front-End di Vue
Mi serve impostare delle rotte: in particolare voglio che tutto ciò che non è intercettqto dalle precedenti (quelle relative all'admin o altro) mi rimandi ad una rotta guest.home
- Imposto la rotta generica per guest.home -> vedi web.php
- Sottocartella view guest-> qui finisce tutto ciò che è gestito front-end, cominciando da home.blade.php
- Creo il component App.vue che contiene tutto il vue di cui il sito ha bisogno -> dentro resources/js/components
- Faccio la import della App.vue in un file JS dedicato al front nello specifico -> dentro resources/js -> guarda il file per vedere come istanziare
- Cancello tutto il contenuto (eccetto bootstrap) del file app.js base (lo uso solo per il backend), e nel webpack.mix.js inserisco anche il front.js
- Nella home di Guest metto lo script per il front.js e il tag div #root, poi rilancio npm run watch/serve

## Gestiamo inserimento post nel DB
- Creiamo table posts  *php artisan make:migration create_posts_table*
- Creiamo controller Crud per i post *php artisan make:controller --resource Admin/PostController* sotto la cartella Admin
- Creo model per i Post *php artisan make:model Post*
- Definisco la tabella nella migration, nei campi con **slug** intendo una stringa che va ad identificare il post nell'url relativo: ad esempio miosito.it/slug, lo slug è unique
- Faccio migration
- Imposto nel model di Post i campi fillable
- TODO

## Gestione rotte PostController e views post
- Route::resource nel file web.php, essendo rotte accessibili solo se admin finiscono all'interno del gruppo di admin
- PostController -> funzione index() mi ritorna index dei post -> nuova cartella post in admin con le varie viste dei post
- Funzione index() PostController -> preleva tutti i post dal DB e li invia compact alla index dei post
- Layout base modificato-> inseriti nella nav collegamento a dashboard(admin.home) e alla tabella dei post (admin.post.index)
- Inserita tabella in admin.post.index e pulsante per admin.post.create
- Form per creazione in admin.post.create -> inserimento {{old}} nel form create
- Inserimento validazioni nello store - e flash message dell'errore - prelievo dati dal form e inserisco in data
- gestisco lo slug da inserire dentro data
- fill di $post con $data e redirect sulla show con post creato -> creo la view post.show e la gestisco nel controller dei post
- Gestisco controller e viste per edit e update
- Gestico destroy/delete

## Creazione tabella categorie
- *php artisan make:migration create_categories_table*
- e effettuo migrazione
- creo model e faccio seed *php artisan db:seed --class=CategoryTableSeeder*

## Collego le due tabelle posts e categories
La relazione è di uno (categoies) a molti (posts). La tabella dipendente è dunque post che conterrà la foreignkey
- Per aggiungerla faccio un update della migration tabella posts, da documentazione il comando artisan *php artisan make:migration add_votes_to_users_table --table=users* -> il mio sarà *php artisan make:migration add_foreign_key_to_posts_table --table=posts* ->vai al file per i passaggi
- Mi occupo dei model per le due tabelle e li collego ->creo model category

## Refactoring per le viste con la categoria
- Create, Edit

## 08 Aprile

### Creazione e gestione tabella tags
- Creazione tabella tags solito procedimento, migration
- Creazione model Tag
- Popolo tabella tag con Seeder

### Gestione relazione many to many posts-tags
- relazione definita nei model post e tag
- creazione migration tabella model *php artisan make:migration create_post_tag_table*
- All'interno della migration pivot, tolgo i $table originari e inserisco le due chiavi provenienti da post e tag per relazione -> aggiungo anche indice che tenga traccia dei due id in coppia

### Gestione Post aggiunta dei tag
- Gestione create -> post controller -> recupero tutti i tags e li passo alla vista
- Gestione create -> nella vista preparo la checkbox con i tags
- Gestione store -> postController ->validazioni
- Gestione store -> postController -> faccio sync
- Visualizzo in post.index e post.show  anche i tag -> utilizzando in blade la funzione tags presente nel model di post.
- Gestione edit -> passo ad edit i tags
- Gestione update

## Gestione rotte dei tags
- Creo controller dei tags *php artisan make:controller --resource Admin/TagController*
- gestisco rotte in web.php e aggiungo rotta per i tags nella navbar in layouts
- gestisco show e index tag

## Carbon date
- Home di admin inserisco i giorni rimanti per la fine del mese - vado su home controller
- Nelle show dei post inserisco la data di creazione del post

# Gestione API
- Creazione controller per API *php artisan make:controller Api/PostController --resource*
- Lascio nel controller solo public function index
- nella funzione index prelevo i post tramite query e ritorno all'index un json con data e success booleano su true
- Imposto le rotte in api.php -> '/api/posts'

# Passo a Vue
- axios- require axios in front.js
- creo component main per app.vue - qui farò chiamata axios
- gestione chiamata axios per category_id -> non solo l'id ma tutto l'oggetto, in api Home controller modifiche
- gestione visualizzazione massimo 4 per pagina ->paginate-> nella chiamata axios bisogna dirlgi quale è la pagina corrente
- In vue imposto nei data la pagina corrente
- nella chiamata axios do come parametro aggiuntivo la pagina corrente page: this.currentPage
- Cambia la rispota axios, non più response.data, ma controllo console.log(response) e adeguo di conseguenza
- Inserisco i bottoni per cambio pagina -> al click richiama la funzione di getApi con una pagina minore o maggiore a seconda se clicco avanti o indietro
- Con classe 'disable' in bootstrap si vieta al pulsante la interazione

# Gestione rotte con Vue Router
- installazione tramite npm *npm install vue-router@3*
- creo dentro la cartella resources-js un file router.js in cui imposto le rotte per VueRouter
- importo nel front.js il file router.js
- creo dentro la cartella resources-js una cartella pages con tutte le pagine da mostrare in front tramite VueRouter
- prima pages create home.vue -> la importo nel file routes.js e ne definisco la rotta
- Creo un nuovo Main.vue dentro componente che mi mostrerà dinamicamente la rotta selezionata tramite <router-view>, App mostra main che mostra dinamicamente le rotte
- Creo gli altri componenti header e footer con router-link e :to="{name: 'nomerotta'}" posso dire di dirigersi dove ho impostato in routes.js
- Creo about, contatti e pagina per visualizzare i posts e importo e definisco in router.js

### visualizzazione singolo post
- quando clicco su continua lettura devo mostrare il risultato di una hciamata api al singolo post -> di conseguenza devo impostare in Api/PostController una show del singolo post e passarlo come json al front. Il post viene richiamato in base allo slug
- vado in api.php e PostController di api
- creo la pagina per visualizzare il post specifico
- Se a questo punto vado in pagina valida e apro ispettore con addon vue, vedo che sotto le $route ho il params slug disponibile, provo a stamparlo per prova. Lo vedo perché quando ho definito la rotta ho messo :slug, ossia quella parte della rotta la salvi in una sorta di variabile dal nome slug
- il link "continua lettura mi rimanda a :to = "{ name: 'single-post', params: {slug: post.slug}}"
- a questo punto dentro lo specifico post nel link post/:slug io ho lo slug salvato come dicevo grazie a :slug, posso fare chiamata api e stampare.

# 13 Aprile
## Refactoring :
- Il comopnente posts diventa blog adatto di conseguenza le rotte,
- Trasformo in un component la card con il post nel blog, passo con props post(dentro a blog.vue)
- Nel component Post.vue rendo lo slice più elegante tramite funzione
- Nella chiamata Api gestisco anche la risposta con category e tags, stampo i tag nella pagina blog

## Gestione categorie post consigliati
- dentro singlePost bisogna lavorare
- va gestito il post uguale, altrimenti tra i consigliati mi mostra il post visualizzato
- quando la pagina è già renderizzata come nel caso dei post collegati la path viene cambiata ma non il contenuto della router view, ho aggiunto :key="$route.fullPath" alla router-view che fa in modo di renderizzare al cambio di url (https://stackoverflow.com/questions/65064006/router-view-will-not-update-when-when-clicking-on-router-link-embedded-within-vi)
- Aggiunta pagina 404 se incrocio rotta catch all
:key="$route.fullPath"


# 14 Aprile - Caricamento file immagine e gestione
- Nel filesystems.php viene di default inserito il valore 'local' ossia i file caricati sono salvati nella cartella storage, nel nostro caso vogliamo che siano salvati dentro la cartella public, cambio il valore in public
- Creo un symlink di storage/app/public all'interno della cartella public di accesso pubblico *php artisan storage:link*
- Aggiuingo alla tabella posts una colonna che salvi la path della immagine -> con migrate seguita da --table=posts -> nella migrate definisco un $table->string('cover')->nullable()->after('dopo la colonna che voglio')
- Lato views (create.blade.php) devo aggiungere al form *enctype="multipart/form-data"* questo permette 'l'upload' del file -> poi aggiungo un input di tipo file al campo name posso mettere quello che preferisco, nel db infatti verrà passata una path e non quel name li che invece sarà gestito dal solo controller
- Nel model di Post imposto nei fillable anche il campo cover
- Lato PostController gestisco lo store, prima validazione immagine, poi salvataggio tramite metodo **Storage::put** a questo tra parentesi primo parametro-> specifico sotto cartella, secondo parametro-> l'immagine recupareta dalla request all e salvata in $data
- A questo punto la immagine è salvata in storage/app/public/uploads e nel symlink presente in public, mi ci posso riferire come facevo con asset, facciamolo nella view show
- Gestisco edit e update, nel caso della edit potrei voler mostrare l'immagine precedente e sotto input per inserimento nuova immagine. Nel controller per update solo se immagine nuova c'è cancello la precedente con **Storage::delete**
- Per eliminazione, prima elimino la immagine e poi il post, sempre in controller sotto destroy -> avevo dimenticato on delete cascade su le foreign key messe dentro la tabella pivot, questo impediva cancellazione, problema corretto

## Passaggio informazioni al Front-end per immagine
- Se vediamo ispettore con vue nel caso di amatriciana e mimosa essendo presente una immagine la path relativa a cover è **"uploads/yJfURSxoXSBX7LmcJEAx9EWOYeNSy393SsJ1R0ay.jpg"**, come riferirci correttamente a questa nel front per stamparla? Non possiamo, dobbiamo quindi tornare nel controller post delle api e fare in modo di trasformare questa path usando la funzione url('path'). Cicliamo i posts da inviare (usiamo un metodo relativo ad una collection [ricordiamo che le quary di laravel restituisocno collection tranne nel caso di first() e queste hanno dei metodi particolari] ossia each, che funziona di fatti come una foreach di javascript) e se per ciascun post è presente una cover allora ne trasformiamo la path con url in modo che sia leggibile dal front-end, altrimenti passiamo una immagine fittizia che funge da placeholder. La immagine di placeholder la metto nella cartella public/img(cartella img fatta da me)
- modifico il component post.vue e visualizzo la immagine nella card, stessa cosa in singlepost

# 19 Aprile - gestione invio email per compilazione form contatti
## Back-end
- creazione migration e model contact *php artisan make:model Lead -m*, i contatti ricevuti si chiamano per convenzione leads, il contattante Lead. Nella tabella inserisco nome, email, messaggio del lead
- setup di mailtrap -> in .env incollo dati , MAIL_FROM_ADDRESS sarà la mail che invia la comunicazione, in questo caso fittizia boolpress@info.it
- devo creare una nuova classe oggetto di tipo Mail, *php artisan make:mail* il comando, il nome sarà *NewContact*, finisce in cartella app/mail -> vai li
- imposto controller per chiamata post in Api/ConctactController *php artisan make:controller Api/ContactController*, salvo i dati prelevati e validati con validator nel db come nuovo Lead.
- gestisco la rotta api post in api.php
- per invio email: se validazione passa non solo salva il lead nel DB, ma manda la mail all'admin (vedi sintassi nel controller) e da come risposta un json di successo!
## Front-end
- nel front in Contact.vue stilizzo un form per invio contatto, metto i v-model sui tre campi (name,email,message)
- imposto chiamata axios di tipo post
- gestisco visualizzazione errori nel form lato utente, in bootstrap div con class invalid-feedback mostra a schermo messaggio di errore se input del form ha classe is-invalid
- Gestisco comparsa di messaggio riuscita invio email
- In caso di successo reset dei campi
- gestione pulsante con scritta invio in corso
