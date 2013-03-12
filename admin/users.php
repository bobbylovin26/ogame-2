<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../theme/main.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Управление пользователями</title>
</head>
<body>
<?
	require_once("../config/connect.php");
	
	$query = "SELECT * FROM users";
	$result = mysql_query( $query );	
?>
<form action="delete_users.php" method="post">
<fieldset style="margin:auto auto;">    
        	<legend>Редактировать пользователей: </legend>
<table class="ttable" width="100%" border="1px">
	<tr>
    	<td></td><td>id</td><td>Имя пользователя</td><td>Полное имя</td><td>Электронная почта</td><td>Статус аккаунта</td><td>Дата регистрации</td>
    </tr>
    <?
		while ( $row = mysql_fetch_array( $result ) ) {
			echo "<tr>";
			
			switch ($row['role']) {
				case 1: $trole = 'Администратор'; break;
				case 2: $trole = 'Игрок'; break;
				case 3: $trole = 'Модератор'; break;
				case 4: $trole = 'Забаненный'; break;
			}
			
			echo "<td>
			<input name=\"select[]\" value=".$row['id']." type=\"checkbox\"> 
			</td><td>".$row['id']."</td><td>".$row['login']."</td><td>".$row['fullname']."</td><td>".$row['email']."</td><td>".$trole."</td><td>".$row['date']."</td>";
			
			echo "</tr>";
		}
	?>
</table>
</br>
</fieldset>
<fieldset style="margin:auto auto" class="tblFooters">  
    <input type="submit" name="del" value="Удалить"  />
    <input type="submit" name="edit" value="Редактировать"  />
    <input type="submit" name="ban" value="Забанить"  />
</fieldset>	
</form>
<?	
	
	require_once("../config/disconnect.php");
?>
</body>
</html>