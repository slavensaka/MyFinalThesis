<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include ('./includes/login.inc.php');
}
define ('BASE_URI', 'C:/xampp/htdocs/zavrsni_rad/');
define ('BASE_URL', 'localhost/zavrsni_rad/html/');
define ('PDFS_DIR', BASE_URI . 'pdfs/'); 
define ('MYSQL', BASE_URI . 'mysql.inc.php');
session_start();
require (MYSQL);

include ('./includes/header.html');
?>

<?php

error_reporting(0);
if (isset($_SESSION['user_id'])) {
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

if($_GET['kred_kart'] == 'Unesi') {



$q = "SELECT email FROM current WHERE id=1";
$r = mysqli_query ($dbc, $q);
$o = mysqli_fetch_array($r);
//echo $o['email'];
$e = $o['email'];
$k = $_GET['kartica'];
$b = $_GET['broj'];
$k_b = $_GET['kontr_br'];
$m_i = $_GET['mjesec_isteka'];
$g_i = $_GET['godina_isteka'];
$t = $_GET['put'];
$o_i = $_GET['id'];
// echo $o_i; za debugiranje
$d = "INSERT INTO payment(order_id,email,kartica,broj,kontr_br,mjesec_isteka,godina_isteka,tip) VALUES('$o_i','$e','$k','$b','$k_b','$m_i','$g_i','$t')";
$s = mysqli_query($dbc,$d);

//header("Location: end.php");
echo '<p style="text-align: center">&spades; </p> ';
echo '<h4 style="text-align: center">Obavili ste sve potrebne korake. Zahvaljujem !</h4> ';
echo '<h4 style="text-align: center"> Nastavite da vidite vas racun</h4> ';
?>
<form  style="text-align: center" action="end.php" method="get">
	    <input type="hidden" name="order_id" value="<?php echo $o_i; ?>">
		<input type="submit" name="kraj" value="Zavrsite">
      </form>

<?
echo '<br><br><br>';
echo '<p style="text-align: center">&clubs; </p> ';


}
if($_GET['kred_kart'] == 'Donesi') {



$q = "SELECT email FROM current WHERE id=1";
$r = mysqli_query ($dbc, $q);
$o = mysqli_fetch_array($r);
//echo $o['email'];
$e = $o['email'];
$p = $_GET['placanje'];
$t = $_GET['put'];
$o_i = $_GET['id'];
$d = "INSERT INTO payment(order_id,email,tip,placanje) VALUES('$o_i','$e','$t','$p')";
$s = mysqli_query($dbc,$d);

echo '<p style="text-align: center">&spades; </p> ';
echo '<h4 style="text-align: center">Obavili ste sve potrebne korake. Zahvaljujem !</h4> ';
echo '<h4 style="text-align: center"> Nastavite da vidite vas racun</h4> ';
?>
<form style="text-align: center" action="end.php" method="get">
	    <input type="hidden" name="order_id" value="<?php echo $o_i; ?>">
		<input type="submit" name="kraj" value="Zavrsite">
      </form>

<?
//header("Location: end.php");
echo '<br><br><br>';
echo '<p style="text-align: center">&clubs; </p> ';




}

if ($_GET['nacin'] == "Iduci Korak") {


if($_GET['put'] == "putem_interneta") {
//start putem_interneta


?>
<div style="text-align: left"><b>Podaci o kreditnoj kartici</b></div><br>
<div> 
<div ><b>Tip kartice:</b></div>
  
  
<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
  
<select  style="text-align: center" name="kartica">
<option selected="selected" value="DINERS">Diners</option>
<option value="MASTER">Master Card</option>
<option value="VISA">Visa</option>
<option value="AMERICAN">American Express</option>
</select>
<br/><br>
<b>Broj:</b><span>*</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input  name="broj" type="text">
<br/><br/>
<b>Kontrolni broj:</b><span>*</span>   <input  name="kontr_br" size="4" type="text">
<br/><br/>
<b>Vrijeme isteka kartice</b><span>*</span><br>
<select name="mjesec_isteka">
<option selected="selected" value="">Mjesec</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option></select>
 <select  name="godina_isteka">
 <option selected="selected" value="">Godina</option>
<option value="11">2011</option>
<option value="12">2012</option>
<option value="13">2013</option>
<option value="14">2014</option>
<option value="15">2015</option>
<option value="16">2016</option>
<option value="17">2017</option>
<option value="18">2018</option>
<option value="19">2019</option>
<option value="20">2020</option>
<option value="21">2021</option>
<option value="22">2022</option>
<option value="23">2023</option>
<option value="24">2024</option>
<option value="25">2025</option>
<option value="26">2026</option>
<option value="27">2027</option>
<option value="28">2028</option>
<option value="29">2029</option>
<option value="30">2030</option>
<option value="31">2031</option></select><br>
<br>

<input type="hidden" name="id" value="<? echo $_GET['id'] ?>" />
<input type="hidden" name="put" value="<? echo $_GET['put'] ?>" />
<input type="submit" name="kred_kart" value="Unesi"/></div><br><br><hr>
<p style="text-align: center"><b>Placanje je moguce navedenim karticama:</b></p>
<div align="center"><img src="images/kartice.gif" ></div><br><br>
</form>




<?
//end putem_interneta
echo '<br><br><br><hr>';
}


if($_GET['put'] == "putem_preuzimanja") {

?>


    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">  
 <h2> Podaci o nacinu placanja</h2>
         
    

<input  name="placanje" value="gotovinom" type="radio">            
<b>Placanje gotovinom</b><br> <br>  
<input  name="placanje" value="maestro debitnom karticom jednokratno" type="radio">     
<b>Placanje maestro debitnom karticom jednokratno</b><br><br>
<input  name="placanje" value="maestro debitnom karticom na 2-6 rata" type="radio">    
<b>Placanje maestro debitnom karticom na 2-6 rata - ZABA i PBZ</b><br> <br>
<input name="placanje" value="kreditnom karticom jednokratno" type="radio">        
<b>Placanje kreditnom karticom jednokratno - American Express&reg;, Diners&reg; i MasterCard&reg;</b><br>	<br>	
<input  name="placanje" value="kreditnom karticom na 2-6 rata" type="radio">      
<b>Placanje kreditnom karticom na 2-6 rata - American Express&reg;, Diners&reg; i MasterCard&reg;</b><br><br>

<input type="hidden" name="put" value="<? echo $_GET['put'] ?>" />
<input type="hidden" name="id" value="<? echo $_GET['id'] ?>" />
<input  name="kred_kart" value="Donesi" type="submit">         
		  
       <hr>  <br><br>

<div align="center" style=" margin-left: 25px; margin-top: 10px">
  <a href="http://www.americanexpress.hr/" target="new">
    <img src="images/amex.gif" alt="Amex" class="kartica">
  </a>
  
  <a href="http://www.mastercard.com/" target="new">
    <img src="images/master.gif" alt="MasterCard" class="kartica">
  </a>
  
    <a href="http://www.maestrocard.com/" target="new">
      <img src="images/maestro.gif" alt="Maestro" class="kartica">
    </a>
  
  <a href="http://www.visa.com/" target="new">
    <img src="images/visa.gif" alt="VISA" class="kartica">
  </a>
  <a href="http://www.diners.com.hr/" target="new">
    <img src="images/diners.gif" alt="VISA" class="kartica">
  </a>
  <br>
</div>
</form>


<?
echo '<br><br><br><hr>';
}



}}



?>

<?
if(!$_GET['put']){
?><h2>Odabir nacina placanja</h2><br>
<?
 $d = $_GET['order_id'];
 

 ?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">

     <input class="checkbox"  name="put" value="putem_interneta" type="radio"/>  <b>PLACATE PREKO INTERNETA</b><br/><br>
     <input class="checkbox"  name="put" value="putem_preuzimanja" type="radio"/>  <b>PLACATE PRILIKOM PREUZIMANJA ROBE</b><br/><br><br>
	 <input type="hidden" name="id" value="<?php echo($d); ?>" />
	 <input type="submit" name="nacin" value="Iduci Korak"/>
	
	</form>  
 
	<? } } elseif (!isset($_SESSION['user_id'])) {
		echo '<p class="error">Hvala vam na vasem interesu za ovaj sadrzaj, ali morate biti 
              prijavljeni kao registrirani korisnik da mogli nastaviti.</p>';
	}
	
	?>
	<!-- END CONTENT -->
			<p><br clear="all" /></p>
		</div>		
		<div class="sidebar">				
			<!-- SIDEBAR -->			
<?php
 if (isset($_SESSION['user_id'])) {
	echo '<div class="title">
				<h4>Upravljanje vasim racunom</h4>
			</div>
			<ul>
			
			<li><a href="change_password.php" title="promjena lozinke">Promijenite vasu lozinku</a></li>
			<li><a href="forgot_password.php" title="zaboravljena lozinka">Zaboravili ste vasu lozinku</a></li>
			<li><a href="logout.php" title="odjava">Odjavite se</a></li>
			
			</ul>
			';
	if (isset($_SESSION['user_admin'])) {
		echo '<div class="title">
					<h4>Administracija</h4>
				</div>
				<ul>
				<li><a href="add_book.php" title="dodavanje_knjige">Dodajte knjigu u bazu</a></li>
				<li><a href="kolicina.php" title="dodavanje_kolicine">Dodajte novu kolicinu knjige u BP</a></li>
				
				</ul>
				';		
	}					


?>






<div class="title">
				<h4> MOGUCI NACINI PLACANJA</h4>
			</div>
			<ul>
			<div>
              
 

<h3>Placanje putem Interneta</h3><br>
<strong><p>Kreditnim karticama:</p></strong>
<ul>
  MasterCard&reg;<br/>
  American Express&reg;<br/>
  Diners Club International&reg;<br/>
  Visa&reg;<br/>
</ul>

<h3>Placanje prilikom dostave</h3><br>
<strong><p>1. Kreditnim karticama jednokratno:</p></strong>
<ul>
  MasterCard&reg;<br/>
  American&reg;<br/>
  Diners Club International&reg;<br/>
  Visa&reg;<br/>
</ul>
<strong><p>2. Kreditnim karticama na rate*:</p></strong>
<ul>
  PBZ Maestro - 2 - 6 rata beskamatno<br/>
  ZABA Maestro - 2 - 6 rata beskamatno<br/>
  American Express&reg; i Diners&reg; - 2 - 6 rata beskamatno<br/>
</ul>

<strong><p>3. Gotovinom</p></strong>
<strong><p>4. Debitnom karticom</p></strong>
</div>
			
	<?		} else {	
	require ('includes/login_form.inc.php');	
}
		?>	
			
			
	
	<div class="title">
				
			</div>	
		</div>		
		<div class="footer">
			<p><a href="http://www.etfos.hr" title="Site Map">Elektrotehnicki fakultet</a> | 
			   
			   &nbsp; - &nbsp; &copy; Web sucelje za prodaju knjiga &nbsp; - &nbsp; Website by 
			   <a href="http://preporuci-mi.co.cc/stranica/o_meni.php">Slaven Sakacic</a>
			</p> 
		</div>	
	</div>
</div>
</body>
</html>