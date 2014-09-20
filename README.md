IZRADA WEB SUČELJA ZA PRODAJU
===========

<h1>Moj Završni rad etfos-a rad izrađen 2011. godine</h1>

<p align="justify">Cilj ovog završnog rada je koristeći programerski jezik PHP ostvariti web sučelje na kojem su implementirane komponente virtualne košarice kojom se omogućuje kupovina proizvoda koji su dodani na skladište. Uz teorijska razmatranja o elektroničkoj trgovini u trećem poglavlju, rad sadrži i opis PHP koda važan za razumijevanje cijelokupnog rada. Izrađeno web sučelje sadržava karakteističnre elemente za jednu elektroničku trgovinu poput, virtualne košarice, registraciju korisnika, prijavu korisnika i administratorske stranice. Kreirane su forme za unos korisnikovih podataka. Koristeći MySQL bazu podataka, podaci o proizvodima,  korisnicima, narudžbama spremaju se u tablice koje se onda ispisuju zbog moguće evidencije i ispravaka. U četvrtom i petom poglavlju dano je nešto detaljnije objašnjenje koda koje se tiče programerskog rješenja, zajedno sa slikama i komentarima radi što boljeg razumijevanja.</p>

<h2>1. Zadatak završnog rada </h2>
<p align="justify">
Izrada web sučelja za prodaju omogućava dodavanje proizvoda, praćenje preostale količine proizvoda na skladištu i online prodaju istih. Kupci se mogu prijaviti na stranicu i dodavati proizvode u košaricu, odabrati načine plaćanja i preuzimanja proizvoda.</p>

<b>Unutar </b>
<b>
/html/config.php definirat:</b>

<i>if (!defined("DB_SERVER")) define("DB_SERVER", "localhost");</i>

<i>if (!defined("DB_NAME")) define("DB_NAME", "baza");</i>

<i>if (!defined("DB_USER")) define ("DB_USER", "root");</i>

<i>if (!defined("DB_PASSWORD")) define ("DB_PASSWORD", "sys");</i>


<b>/html/confirm.php definirat:</b>

<i>define ('BASE_URI', 'C:/xampp/htdocs/zavrsni_rad/');</i>

<i>define ('BASE_URL', 'localhost/zavrsni_rad/html/');</i>

<i>define ('PDFS_DIR', BASE_URI . 'pdfs/'); </i>

<i>define ('MYSQL', BASE_URI . 'mysql.inc.php');</i>

<b>i mysql.inc.php: </b>

<i>DEFINE ('DB_U', 'root');</i>

<i>DEFINE ('DB_P', 'sys');</i>

<i>DEFINE ('DB_H', 'localhost');</i>

<i>DEFINE ('DB_N', 'baza');</i>

