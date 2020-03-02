<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<title>Biuro</title>
					<?php
						echo $style;
					?>


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../js/jquery-ui.css">
  <script src="../js/jquery-1.12.4.js"></script>
  <script src="../js/jquery-ui.js"></script>
  <script src="../js/sortTable.js"></script>
  <script>

  $( function() {
    
	
	$( "#data_wystawienia" ).datepicker({dateFormat: "dd.mm.yy"});
	$( "#data_zaplaty_faktury" ).datepicker({dateFormat: "dd.mm.yy"});
	$( "#data_otzymania" ).datepicker({dateFormat: "dd.mm.yy"});

	<?php
			if(isset($script))
			    echo $script;
		?>

  } );
  
  	$( ".selector" ).datepicker({
  defaultDate: +7
});
	</script>
	<script src="../js/moje.js"></script>
	<script src="../js/sortTable.js"></script>



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
	<aside>
		<nav>
					<?php
						echo $menu;
					?>
		</nav>
	</aside>		
    	<!-- main -->
	<section id="main"> 
	<?php
    echo $echo;
	$time_end = microtime_float();
	$time = $time_end - $time_start;
	echo '<br>'.$time;
    ?>
	</section>
    </div>
</body>
</html>
