<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Регистрация</title>
</head>
<body>
<?
	require_once('../config/connect.php');
			
	require_once('recaptchalib.php');
	
	include( "main.php" );
	
  	$privatekey = "6Lc_N90SAAAAAGYcxarUG_fmuy_3Ld3RXUzRBf19";
  	$resp = recaptcha_check_answer ($privatekey,
                                	$_SERVER["REMOTE_ADDR"],
                                	$_POST["recaptcha_challenge_field"],
                                	$_POST["recaptcha_response_field"]);

  	if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  	} else {
		
		$info = $_POST['info'];
    	$info = strip_tags($_POST['info']);
		$info = mysql_real_escape_string($info);
	
		if ( !$_POST['login'] ) {
			echo "Вы не заполнили поле логина</br>";
		} else {
			$login  = $_POST['login'];
			if (iconv_strlen($login)<3) {
				echo "Логин должен быть не менее трех символов</br>";
			} elseif (iconv_strlen($login)>20) {
				echo "Логин должен быть менее 20 символов</br>";
			}
		} 
		if ( !$_POST['pass'] ) {
			echo "Вы не заполнили поле пароля</br>";
		} else {
			if ( !$_POST['pass'] ) {
				echo "Вы не заполнили поле повтора пароля</br>";
			} else {
				$pass   = $_POST['pass'];
				
				if (iconv_strlen($pass)<6) {
					echo "Пароль должен быть не менее 6 символов</br>";
				} elseif (iconv_strlen($pass)>20) {
					echo "Пароль должен быть менее 20 символов</br>";
				}
			}
		}
		
		if ( !is_email($_POST['email']) ) {
			echo "Вы не заполнили поле почты или адрес указан некорректно</br>";
		} else {
			$email  = $_POST['email'];
		}
		
		if ( !$_POST['fname'] ) {
			echo "Вы не заполнили поле полного имени</br>";
		} else {
			$fname  = $_POST['fname'];
		}
		
		if ( !$_POST['info'] ) {
			$info= 'Empty';
		}
		
		if ($_POST['login'] && $_POST['fname'] && $_POST['pass'] && $_POST['pass2'] && $_POST['email']) {
			
			if (filter_var('{$email}', FILTER_VALIDATE_EMAIL)==true) {
				echo "Вы ввели некорректный email";
				exit;
			}		
			///////////////////////////////////////////////////////////
			//Проверка логина и почты на наличие совпадений в бд
			///////////////////////////////////////////////////////////		
			$tname = "SELECT login, email FROM users";
			$result = mysql_query( $tname, $connect );
			
			while ( $row = mysql_fetch_array($result)) {
				if ( $row['login'] == $login) {
					echo "Пользователь с таким логином уже существует!</ br>";
					exit;
				} elseif ( $row['email'] == $email ){
					echo "Пользователь с таким email уже существует!</ br>";
					exit;
				}
			}
			
			///////////////////////////////////////////////////////////
			//Обновление администраторских данных
			///////////////////////////////////////////////////////////	
			$admin = "SELECT users_count FROM admin WHERE id=1";
			$result = mysql_query($admin, $connect);
			$row = mysql_fetch_array($result);
			$row = $row['users_count']+1;
			$admin = "UPDATE admin SET users_count=$row, indexing=$row+1 WHERE id=1";
			mysql_query($admin, $connect) or die("ERROR CONNECTION");
			
			
			///////////////////////////////////////////////////////////
			//Получение даты
			///////////////////////////////////////////////////////////
			$d = getdate();
			if (iconv_strlen($d['mon'])<2 ) {
				$m = '0'.$d['mon']; 
			} else {
				$m = $d['mon'];
			}
			if (iconv_strlen($d['mday'])<2 ) {
				$dday = '0'.$d['mday'];
			} else {
				$dday = $d['mday']; 
			}
			$k = $d['year'].'-'.$m.'-'.$dday;
		
			///////////////////////////////////////////////////////////
			//Добавляем данные в бд
			///////////////////////////////////////////////////////////
			$pass = crypt($pass, CRYPT_BLOWFISH);
			
			$query = "INSERT INTO users ( login, password, fullname, info, email, date, lastdate ) 
			VALUES ('{$login}', '{$pass}', '{$fname}', '{$info}', '{$email}', '{$k}', '{$k}')";
			mysql_query ( $query, $connect ) or die("ERROR CONNECTION");
		}
  	}
	echo "OK";
	require_once('../config/disconnect.php');	
?>
</body>
</html>