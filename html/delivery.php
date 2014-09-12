<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include ('./includes/login.inc.php');
}
require ('./includes/config.inc.php');
require (MYSQL);

include ('./includes/header.html');


if (isset($_SESSION['user_id'])) {


 ?>
 
<form action="confirm.php" method="post"> 
  
<h2>Nacin dostave proizvoda</h2>
  <div>
    
  <br><br><hr>
    
 <input name="order_params[delivery_term_id]" value="Osobno Preuzimanje <br><b>Cijena Dostave: </b><i>Nema</i>" type="radio">  Osobno preuzimanje vase narudzbe <br><br><hr>
 <input name="order_params[delivery_term_id]" value="Dostava Postom <br><b>Cijena Dostave:</b><i> 15 kn</i>" type="radio">  Dostava postom <br><br><hr>
 
	  <h3>Dostavom:</h3>
	<div></div>

    <div>
      <table  border="0" cellpadding="0" cellspacing="0">
  <tbody><tr>
    <td><strong>Vrijeme</strong></td>
      <td>
    Ponedjeljak

  </td>
  <td>
    Utorak

  </td>
  <td>
    Srijeda

  </td>
  <td>
    Cetvrtak

  </td>
  <td>
    Petak 

  </td>
  <td>
    Subota

  </td>
  <td>
    Nedjelja

  </td>

  </tr>
      <tr>
      <td style="padding: 7px 0px; width: 20%;">
        09:00 - 11:00      </td>
          <td></td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Utorak 09:00-11:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Srijeda 09:00-11:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Cetvrtak 09:00-11:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input name="order_params[delivery_term_id]" value="Petak 09:00-11:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Subota 09:00-11:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Nedjelja 09:00-11:00 <br><b>Cijena Dostave: </b><i>30 kn</i>" type="radio">
    
  </td>


    </tr>
      <tr>
      <td  style="padding: 7px 0px; width: 20%;">
        11:00 - 13:00      </td>
          <td class="booked"></td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Utorak 11:00-13:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Srijeda 11:00-13:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Cetvrtak 11:00-13:00 <br><b>Cijena Dostave: </b><i>30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Petak 11:00-13:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
 
    
  </td>

  
  <td>
    
      
    
  </td>


    </tr>
      <tr>
      <td style="padding: 7px 0px; width: 20%;">
        13:00 - 15:00      </td>
          <td></td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Utorak 13:00-15:00 <br><b>Cijena Dostave: </b><i>30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Srijeda 13:00-15:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Cetvrtak 13:00-15:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Petak 15:00-17:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
     
    
  </td>

  
  <td>
    
     
    
  </td>


    </tr>
      <tr>
      <td style="padding: 7px 0px; width: 20%;">
        15:00 - 17:00      </td>
          <td class="booked"></td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Utorak 15:00-17:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Srijeda 15:00-17:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>"  type="radio">
    
  </td>

    <td></td>

    <td></td>

  
  <td>
    
      
    
  </td>

  
  <td>
    
     
    
  </td>


    </tr>
      <tr>
      <td  style="padding: 7px 0px; width: 20%;">
        17:00 - 19:00      </td>
          <td></td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Utorak 17:00-19:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Srijeda 17:00-19:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

    <td ></td>

    <td></td>

  
  <td>
    
    
    
  </td>

  
  <td>
    

    
  </td>


    </tr>
      <tr>
      <td  style="padding: 7px 0px; width: 20%;">
        19:00 - 21:00      </td>
        
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Ponedjeljak 19:00-21:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Utorak 19:00-21:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

  
  <td>
    
      <input  name="order_params[delivery_term_id]" value="Srijeda 19:00-21:00 <br><b>Cijena Dostave:</b><i> 30 kn</i>" type="radio">
    
  </td>

    <td ></td>

    <td></td>

  
  <td>
    
     
    
  </td>

  
  <td>
    
  
    
  </td>


    </tr>
  </tbody></table>

    </div>
    <br>
    <div></div>

    <div>
      <div>
   <?     

?>

      </div>
      
	  
	  
      <input type="hidden" name="order_id" value=<?php echo($_SESSION['order_id']); ?>" />
       <input  name="dalje"  value="Korak dalje" type="submit">
 

     
    </div>
  </div>

</form>
<br/><form action="index.php">
   <input type="submit" name="submit" value="&lt;&lt; Nastavite kupovati!">
   </form>
<?php
} elseif (!isset($_SESSION['user_id'])) {
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
				<h4>Dostava</h4>
			</div>
			<ul>
			<div>
        <br>      
 Svu narucenu robu dostavljamo vlastitim dostavnim vozilima. Dostava je moguca 
postom, a mozete rezervirati termin 
dostave i do 7 dana unaprijed.<br><br>
Dostavu trenutno vrsimo na podrucjima:
Grad Zagreb s okolicom, Split i Osijek s okolicom.<br><br>



<strong><p>Cjenik dostave</p></strong>
<ul>
  <h4><b>Cijena dostave ovisi o nacinu dostave</b></h4>
  Osobno preuzimanje   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;   <strong>0 kn</strong> <br> 
  Dostava postom     &nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>15 kn</strong>  <br>
  Dostava dostavnim vozilom    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <strong>30 kn</strong>  <br>
</ul>


<strong><p>Osobno preuzimanje</p></strong>
<ul>
  
  Je usluga pripremanja robe za kupce koji 
narudzbu napravljenu preko internet prodavaonice preuzimaju sami na 
unaprijed odabranim lokacijama.
</ul>
<hr>
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