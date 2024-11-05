# ReadnShare

## Permbledhje
`ReadnShare` eshte nje aplikacion uebi i zhvilluar me PHP, MySQL dhe Bootstrap ku perdoruesit mund te blejne dhe shesin libra. Platforma i lejon perdoruesit te listojne librat e tyre per shitje, te blejne libra nga perdorues te tjere dhe te menaxhojne llogarite e tyre. Administratoret mund te shikojne dhe menaxhojne perdoruesit, porosite dhe listat e librave. I integruar nje API i jashtem me JavaScript per te shtuar funksionalitet shtese.

## Karakteristikat

- **Index Page**: Ne Index jane te shfaqura librat, te grumbulluara ne dy grupe: librat e fundit dhe best sellers!
![Index Page](./assets/images/documentation/index.png)
 - Ne index ekziston mundesia e te berit subscribe (qe informon perdoruesin nese eshte bere subscribe).
![Index Page (Subscribed Successfully)](./assets/images/documentation/subscribed-successfully.png)
 - Perdoruesi informohet nese eshte bere subscribe me heret me ate email.
![Index Page (Already Subscribed)](./assets/images/documentation/already-subscribed.png)
 - Librat ne Index mund te klikohen per te pare detajet si dhe mund te shtohen ne Cart edhe nese nuk jemi te kycur ne ndonje llogari dhe llogaria e pare qe kycet, i shtohet asaj llogarie ai liber ne Cart. Mirepo, pa qene i kycur, keto produkte te shtuara ne Cart nuk shihen.
![Index Page (Redirect to book-details)](./assets/images/documentation/book-details.png)

- **Books Page**: Ne Books shfaqen te gjithe librat me informacione kryesore, me mundesi klikimi ne to per te pare me shume detaje rreth librit.
![Books Page](./assets/images/documentation/books.png)
 - Ne Books, librat mund te filtrohen ne baze te nje apo me shume faktoreve njekohesisht (Me poshte kemi shfaqur disa shembuj te filtrimit te librave):
 ![Books Page (Filter by Price)](./assets/images/documentation/books-filter-by-price.png)
 ![Books Page (Filter by Language and Condition)](./assets/images/documentation/books-filter-by-lang-and-condition.png)
 - Ne Books, eshte mundesia qe te filtrohen librat per te cilet ka edhe review!
 ![Books Page (Books with Reviews)](./assets/images/documentation/books-with-reviews-wanted.png)
 - Ne Books, ne rast se me te dhenat e kerkuara nuk kemi libra, shfaqet mesazhi:
 ![Books Page (No books)](./assets/images/documentation/when-no-books-with-filtered-data.png)
 - Librat, pervec filtrimit ne baze te cmimit, gjendjes, autorit, zhanrit, kategorise e te tjera, mund te kerkohen edhe ne baze te titullit apo vitit te publikimit:
 ![Books Page (Find Books by Title or Published Year)](./assets/images/documentation/find-books-by-title-or-publishedyear.png)
 - Librat, jane te ndare dhe ne baze te zhanreve, ku me ndihmen e dropdown zgjedhim zhanrin e deshiruar te librit.
 ![Books Page (Genre)](./assets/images/documentation/books-genre-novel.png)
 - Librat, jane te ndare edhe ne baze te kategorise, ku me ndihmen e dropdown zgjedhim kategorine e deshiruar te librit.
 ![Books Page (Category)](./assets/images/documentation/books-category-newreleases.png)

 - **Soon to Arrive Page**: Ne Soon to Arrive shfaqen te gjithe librat te cilet do jene se shpejti te qasshem per blerje. Keta libra jane marre nga nje API i jashtem me perdorim te JavaScript. Po ashtu, mund dhe te kerkojme ne baze te titullit apo vitit te publikimit per liber te caktuar se a eshte pjese e ketij API apo jo.
  ![Soon to Arrive Page](./assets/images/documentation/books-soon-to-arrive.png)


- **Autentikimi i Perdoruesit**: Regjistrimi i sigurt (qe dhe informon se jeni regjistruar me sukses) dhe funksionaliteti i kyçjes per perdoruesit.
![SignUp (Dropdown)](./assets/images/documentation/signup.png)
![Registered Successfully](./assets/images/documentation/registered-successfully.png)
![SignIn (Dropdown)](./assets/images/documentation/signin.png)


- **Funksionalitet e Perdoruesit me Rol te Userit**:
  - Modifikoni informacionin e profilit te perdoruesit.
    ![Modify Account](./assets/images/documentation/modify-account.png)
  - Ne rast te modifikimit te suksesshem te te dhenave, shfaqet mesazhi
    ![Modify Account Successfully](./assets/images/documentation/modified-successfully.png)
  - Fshini llogarine e perdoruesit. (Fshirja e llogarise mund te behet vetem me konfirmim te fjalekalimit si dhe eshte e mundur vetem per perdoruesit me rol te userit)
    ![Delete Account](./assets/images/documentation/delete-account-modal.png)
  - Perdoruesi mund t'i shoh produktet ne cart te tij dhe te vazhdoj me tutje me checkout apo edhe ti fshij. Ne rast se nuk ka produkte ne cart, shfaqet nje mesazh.
    ![My Orders](./assets/images/documentation/my-items.png)
  - Perdoruesi mund t'i shoh orders te tij.
    ![My Orders](./assets/images/documentation/order-done.png)
  - Perdoruesi mund te porosite libra aq sa jane ne stock. Perdoruesit informohen kur librat jane out of stock .
    ![Book Out of Stock](./assets/images/documentation/out-of-stock.png)
  - Perdoruesi mund te shtoj libra per t'u blere nga perdorues te tjere
    ![User Add Book](./assets/images/documentation/add-or-view-my-books.png)
  - Perdoruesi mund te modifikoj librat e tij apo edhe ti fshij
    ![User Modify Book](./assets/images/documentation/modify-book.png)
  - Perdoruesi njoftohet ne rast se librat e tij jane shitur
    ![User's Sold Listings](./assets/images/documentation/my-sold-books.png)
  - Perdoruesi mund te shtoj review per libra (kur eshte i kycur)
    ![User Add Review](./assets/images/documentation/review-added.png)


- **Paneli i Adminit**:
  - Paneli i Adminit perfshin menaxhimin e librave, perdoruesve dhe menaxhimin e porosive.
    ![Admin Dashboard](./assets/images/documentation/admin-dashboard.png)
  - Admini ka mundesi te shoh apo te fshij porosine
    ![Admin Manage Order](./assets/images/documentation/admin-manage-orders.png)
  - Admini mund te modifikoj librat apo edhe ti fshij ato (si dhe te shtoj libra te addbook page). 
    ![Admin Manage Book](./assets/images/documentation/admin-manage-books.png)
  - Admini mund te shtoj perdorues te ri dhe te caktoj rolin e tyre:user,admin apo autor.
    ![Admin Add User](./assets/images/documentation/admin-add-user.png)
  - Admini mund te modifikoj te dhenat e perdoruesit apo edhe te fshij llogarine e perdoruesit
    ![Admin Modify User](./assets/images/documentation/admin-manage-users.png)
  - Admini mund vetem te modifikoj te dhenat e llogarise se tij por jo edhe ta fshij ate.
    ![Admin Modify his Account](./assets/images/documentation/admin-modify.png)




## Teknologjite e Perdorura
- **Frontend**: HTML, CSS, Bootstrap per dizajnin e pershtatshem.
- **Backend**: PHP per pjesen e serverit.
- **Baza e te Dhenave**: MySQL.

## Instalimi
Per te ekzekutuar `readnshare` lokal, ndiqni keto hapa:
1. Klononi repositorin: `git clone https://github.com/hajrijemjeku/readnshare`
2. Shkoni ne drejtorine e projektit: `cd readnshare`
3. Importoni skemen e bazes se te dhenave dhe te dhenat fillestare nga `sql/readnshare.sql` ne bazen tuaj MySQL.
4. Konfiguroni lidhjen me bazen e te dhenave ne `includes/db.php`.
5. Startoni serverin tuaj PHP per zhvillim ose konfiguroni me Apache/Nginx sipas nevojes.

## Perdorimi
1. Startoni serverin PHP.
2. Vizitoni `http://localhost/readnshare` ne shfletuesin tuaj web.
3. Regjistrohuni per nje llogari te re ose kyçuni me kredencialet ekzistuese.
4. Eksploroni dhe perdorni karakteristikat bazuar ne rol te perdoruesit tuaj (perdorues apo admin).



