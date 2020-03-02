<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Strona internetowa spółki 'Zakład Remontowy SERVICE' z siedzibą we Wrocławiu">
	<meta name="keywords" content="wrocław, Wrocław, wroclaw, dolny, dolny śląsk, zakład, remontowy, SERVICE, service, praca, PL7792422251, firma, kontakt, zr, z, r, sieci, ciepłownicze, remonty intalacji, współpraca, mufy, nawiertka, balonowanie, wzorniki, szafki gazowe, Metal-gaz, prace tokarskie, prace frezerskie, frezerskie, spawalnicze, spawanie, spawalnictwo, gazownictwo, bembny, bębny, hamulce, chamulce, hamólce, chamólce, ogrodzenia, balustrady, toczenie metali, produkcja, usługi">
	<title>Z.R. SERVICE</title>
	<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
	<link rel='stylesheet' href='./html/style.css'>
	<link rel='stylesheet' href='./html/zerogrid.css'>
	</head>
	<body>
	<div class='container'>

		<!-- header --> 
		<header>
		   <div class="zerogrid">
			  <div class="row">
				<div class="col-1-6">
					<img src="./html/logo.png" alt=""/>
				</div>
				<div class="col-4-6">
					<p class="text_shadow">Zakład Remontowy </p><p class="text_shadow">SERVICE Sp. z o.o.</p>
				</div>
			  </div>
			</div>
		</header>
			
		<!-- sidebar --> 
		<aside>
			<nav>
				<ul>
        <?php echo $navig; ?>
		
			</ul>
		</nav>
	</aside>
   
	<!-- main -->
	<section id="main">
			Aby przesłać zapytanie ofertowe proszę napisać ma adres: <span class="bold">biuro@zrservice.pl</span> <br />lub skorzystać z naszego formularza:<br /><br />
			<?php if(isset($error)) echo $error; ?>
			<form action="index.php?title=form" method="post" enctype="application/x-www-form-urlencoded">
			<fieldset><legend>informacje</legend>
				email do korespondecji: <input name="email" type="text" /><br/>
				zapytanie  dotyczy:<input name="dotyczy" type="text" size="45" value="<?php echo $dotyczy; ?>" /><br/>
			</fieldset>
			<fieldset><legend>treść zapytania</legend>
			<textarea name="tresc" cols="50" rows="20"></textarea><br/>
			<input name="nrtestu" type="hidden" value="<?php echo $nrtestu; ?>" />
			</fieldset>
			Proszę wpisać wartość rozwiązania:<br />  <?php echo $zabesp[$nrtestu][0]; ?> <input name="test" type="text" value="" />
			<input name="wyslij" type="submit" value="wyślij" />
			</form>
        	</section>
	
	<!-- footer -->
	<footer>
		<p>Zakład Remontowy SERVICE Sp. z o.o 50-429 Wrocław ul. Krakowska 29 </p>
		<p>

tel: 609-613-997
tel: 71 33 75 389 
e-mail: biuro@zrservice.pl</p>
	</footer>

</div>

</body>
</html>
