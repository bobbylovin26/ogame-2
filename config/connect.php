<?
	$host = "localhost";
	$user = "root";
	$password = "fA1Arsd8";
	$db = "ogame";
	
	$connect = @mysql_pconnect( $host, $user, $password );
	
	if (! $connect ) {
		die( "Cannot connect to DB: ". mysql_error() );
	}
	
	@mysql_select_db( $db ) or die( "Cannot open DB: " .mysql_error() );

?>