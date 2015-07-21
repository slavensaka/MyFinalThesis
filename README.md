# WEB INTERFACE FOR SALES

### My final thesis at college <a href="http://www.etfos.unios.hr/?pocetna"> <b>ETFOS</b></a> created year 2011.
Web site is down for a while, will be back up.
The web interface can be found at <a href="http://slaven-sakacic.from.hr/zavrsni_rad/html/index.php">slaven-sakacic.from.hr/zavrsni_rad</a>

<h4>Croatian language introduction:</h4>
<p align="justify">Cilj ovog završnog rada je koristeći programerski jezik PHP ostvariti web sučelje na kojem su implementirane komponente virtualne košarice kojom se omogućuje kupovina proizvoda koji su dodani na skladište. Uz teorijska razmatranja o elektroničkoj trgovini u trećem poglavlju, rad sadrži i opis PHP koda važan za razumijevanje cijelokupnog rada.
Izrađeno web sučelje sadržava karakteristične elemente za jednu elektroničku trgovinu poput, virtualne košarice, registraciju korisnika, prijavu korisnika i administratorske stranice. Kreirane su forme za unos korisnikovih podataka. Koristeći MySQL bazu podataka, podaci o proizvodima,  korisnicima, narudžbama spremaju se u tablice koje se onda ispisuju zbog moguće evidencije i ispravaka. U četvrtom i petom poglavlju dano je nešto detaljnije objašnjenje koda koje se tiče programerskog rješenja, zajedno sa slikama i komentarima radi što boljeg razumijevanja.</p>

<h4>English language introduction:</h4>
<p align="justify">The aim of this final work is using the programming language PHP to achieve a website on which components of a virtual shopping cart are implemented that allows the purchase of products that have been added to the virtual warehouse. Theoretical considerations on Electronic Commerce are discussed in the third chapter, the work includes a description of the PHP code which is  important for the understanding of the entire work.Created web interface contains characteristic elements for a electronic commerce such as, virtual shopping cart, user registration, user login and admin pages.Created the entry forms of user data. Using MySQL database, data about products, customers, orders are stored in tables that are then printed out for possible records and corrections. In the fourth and fifth chapter is given some more detailed explanation of the code concerning the programming solutions, along with pictures and comments for better understanding.</p>

<h2>The task of the final paper</h2>
<p align="justify">
This final thesis allows you to add products, monitor the remaining amount of products in stock and sell them online. Customers can log on too the site and add products to their cart, choose payment options and product options. </p>

<b>Configurations to work on your machine: </b>
### DEFINE EVERYWHERE WHERE THIS LINES ARE SITUATED
<b>/html/config.php define:</b>

<i>if (!defined("DB_SERVER")) define("DB_SERVER", "localhost");</i>

<i>if (!defined("DB_NAME")) define("DB_NAME", "baza");</i>

<i>if (!defined("DB_USER")) define ("DB_USER", "root");</i>

<i>if (!defined("DB_PASSWORD")) define ("DB_PASSWORD", "sys");</i>


<b>/html/confirm.php define:</b>

<i>define ('BASE_URI', 'C:/xampp/htdocs/zavrsni_rad/');</i>

<i>define ('BASE_URL', 'localhost/zavrsni_rad/html/');</i>

<i>define ('PDFS_DIR', BASE_URI . 'pdfs/'); </i>

<i>define ('MYSQL', BASE_URI . 'mysql.inc.php');</i>

<b>and mysql.inc.php define: </b>

<i>DEFINE ('DB_U', 'root');</i>

<i>DEFINE ('DB_P', 'sys');</i>

<i>DEFINE ('DB_H', 'localhost');</i>

<i>DEFINE ('DB_N', 'baza');</i>

