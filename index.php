<!DOCTYPE html>
<html>
<? require "head.php"; ?>
<body>
	<div id="main" class="main">
		<?
			require "header.php";
			require "menu.php";	
			
			if ( $_GET['menuItem']!='' ) {
				include $_GET['menuItem'].".php";
			} else {
				include "map.php";
			}
				
			require "rightMenu.php";
			require "footer.php";
		?>			
	</div>	
</body>
</html>