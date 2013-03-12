<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../theme/main.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Документ без названия</title>
</head>
<body>
<?
	require_once( "../config/connect.php" );
	
	$checks = $_POST['select'];
	$del 	= $_POST['del'];
	$edit	= $_POST['edit'];
	$ban	= $_POST['ban'];
	
	if ( $_POST['del'] ) {
		$count = count($checks);
		for($i=0; $i<$count; $i++) {			
			$query = "DELETE FROM users WHERE id='{$checks[$i]}'";
			mysql_query($query, $connect) or die ("ERROR DELETING");			
		}
		
		if ( $count!==0) {
			$admin = "SELECT users_count FROM admin WHERE id=1";
			$result = mysql_query($admin, $connect);
			$row = mysql_fetch_array($result);
			$row = $row['users_count']-$count;
			$admin = "UPDATE admin SET users_count=$row, indexing=$row+1 WHERE id=1";
			mysql_query($admin, $connect) or die("ERROR CONNECTION");
		}
	}
	
	if ( $_POST['edit'] ) {
?>		
		<form action="update.php" method="post">
        <fieldset style="margin:auto auto;">    
        	<legend>Редактировать пользователей: </legend>
		<table class="ttable" width="100%" border="1px">
			<tr><b>
				<td>id</td><td>Имя пользователя</td>
                <td>Пароль</td>
                <td>Полное имя</td><td>Электронная почта</td><td>Статус аккаунта</td><td>Дата регистрации</td></b>
			</tr>
			<?
				$count = count($checks);
				for ($i=0; $i<$count; $i++) {				
					$query = "SELECT * FROM users WHERE id='{$checks[$i]}'";
					$result = mysql_query( $query );
					$row = mysql_fetch_array( $result );
					echo "<tr>";
					$trole1=$trole2=$trole3=$trole4="";
					switch ($row['role']) {
						case 1: { $trole1 = 'CHECKED'; 	$trole2 = $trole3 = $trole4 = ''; } break;
						case 2: { $trole2 = 'CHECKED'; 	$trole1 = $trole3 = $trole4 = ''; } break;
						case 3: { $trole3 = 'CHECKED'; 	$trole2 = $trole1 = $trole4 = ''; } break;
						case 4: { $trole4 = 'CHECKED'; 	$trole2 = $trole3 = $trole1 = ''; } break;
					}
						
					echo "<td><input type=\"text\" name=\"id\" value=\"".$row['id']."\" /></td>
						<td><input type=\"text\" name=\"login\" value=\"".$row['login']."\" /></td>
						<td>Введите новый пароль:<br><input type=\"text\" name=\"password\" value=\"\" /></td>
						<td><input type=\"text\" name=\"fullname\" value=\"".$row['fullname']."\" /></td>
						<td><input type=\"text\" name=\"email\" value=\"".$row['email']."\" /></td>
						<td><input type=\"radio\" name=\"role['{$i}']\" value=\"'{$row['id']}'.1\" ".$trole1.">Администратор<br>
						<input type=\"radio\" name=\"role['{$i}']\" value=\"'{$row['id']}'.2\" ".$trole2.">Игрок<br>
						<input type=\"radio\" name=\"role['{$i}']\" value=\"'{$row['id']}'.3\" ".$trole3.">Модератор<br>
						<input type=\"radio\" name=\"role['{$i}']\" value=\"'{$row['id']}'.4\" ".$trole4.">Забаненный
						</td>
						<td><input type=\"text\" name=\"date\" value=\"".$row['date']."\" /></td>";
						
					echo "</tr>";
				}
				
			?>
		</table>
        </fieldset>
        <fieldset style="margin:auto auto" class="tblFooters">    
        	
       		<input type="submit" name="sender" value="Отправить"  />
        </fieldset>
		</form>
<?
	}
	
	require_once( "../config/disconnect.php" );
?>
</body>
</html>