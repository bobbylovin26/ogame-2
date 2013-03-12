<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Регистрация</title>
<link rel="stylesheet" type="text/css" href="theme/main.css">
</head>	
<body>
<div style="margin:auto auto;">
<div style="clear:both">
	<form action="func/reg.php" method="post">
        <fieldset style="margin:auto auto;width:400px; ">    
        	<legend>Основная информация: </legend>
             <div style="margin:auto auto;" align="center">
                <table>
                <tr>
                <td align="left"><label>Логин:</label></td> <td><input name="login" type="text" size="30" /></td> 
                </tr>
                <tr>
                <td align="left"><label>Пароль:</label> </td> <td> <input name="pass" type="password" size="30" /></td> 
                </tr>
                <tr>
                <td align="left"><label>Повторите пароль:</label> </td> <td> <input name="pass2" type="password" size="30" /></td> 
                </tr>
                <tr>
                <td align="left"><label>Email:</label></td>  <td><input name="email" type="text" size="30" /></td> 
                </tr>
                <tr>
                <td align="left"><label>Полное имя:</label> </td> <td><input name="fname" type="text" size="30" /></td> 
                </tr>
                </table>
                <?
                require_once('func/recaptchalib.php');
                $publickey = "6Lc_N90SAAAAAIQ6z1RT-p9IAdEwDFCKvV23K4AC"; // you got this from the signup page
                echo recaptcha_get_html($publickey);
                ?>
                <table>
                <tr><td><label>Дополнительная информация:</label></td></tr>
                <tr><td><textarea name="info" cols="40" rows="6" wrap="physical"></textarea></td></tr>
                <tr><td>  </td></tr>
                </table>
            </div>                     
        </fieldset>
        <fieldset style="margin:auto auto;width:400px; " class="tblFooters">
        	<input type="submit" name="tpsubmit" value="GO" />
        </fieldset>
    </form>
    </div>
</div>
</body>
</html>