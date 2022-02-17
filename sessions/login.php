<?php

include("menu.php");
$secure = false;
$setBtn = isset($_POST['setBtn']) ? true : false;
$uid = isset($_COOKIE['usrId']) ? $_COOKIE['usrId'] : 13;
if( $setBtn )
{	// przetwarzaj logowanie
	$login = isset($_POST['login']) ? $_POST['login'] : null;
	$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : null;
	$keep = isset($_POST['remember']) ? true : false;
	
	if($login=='root' && $passwd=='qaz'){
		
		$logged = array(
			'Czas' => date("Y-m-d H:i:s"),
			'Dzialanie' => "Zalogowanie użytkownika",
			'url' => "login.php",
		);
		array_push($_SESSION['journal'], $logged);
		// $_SESSION['journal'][] = $logged;
		// $_SESSION['journal'][] = $_POST['journal'];
		//var_dump($_SESSION['journal']);
		$msg = 'Access granted V';
		$_SESSION['usrId'] = $uid;
		$_SESSION['usrName'] = $login;
		if($keep){
			$name = 'usrId';
			$body = $uid; 
			$host = 'lo.local';
			$time = 300;
			$expTime = time()+$time;
			# 60 - 1 minuta # 60
			# 3600 - 1godz # 60*60
			# 86400 - 1 dzień # *24
			# 604800 - 1 tydz. / 7 dni # *30
			# 2592000 - 1 miesiąc
			# 5184000 - 2mc
			# 7776000 - 3mc
			setcookie( $name, $body, $expTime,'/',$host,false,false);
			echo 'Niby ustawiono cookie';
			var_dump($_COOKIE);
			
			
		}
		header("Refresh:0");
	} else{
		$msg = 'Access restricted X';
		$failedLogin= array(
			'Czas' => date("Y-m-d H:i:s"),
			'Dzialanie' => "Nieudana proba logowania",
			'url' => "login.php",
		);
		array_push($_SESSION['journal'], $failedLogin);
	}
}
echo '<h3>Logowanie</h3>';
if($secure==false || ($secure==true && $_SERVER['HTTPS'] ))
{	// pokaż tylko gdy jest to bezpieczne
	$hTxt = '<p>Podaj login i hasło</p>';
	$lbl1 = '<label>Login</label>';
	$inp1 = '<input type="text" name="login" /><br/>';
	$lbl2 = '<label>Hasło</label>';
	$inp2 = '<input type="password" name="passwd" /><br/>';
	$cb1 = '<input type="checkbox" name="remember" />';
	$lbl3 = '<label>'.$cb1.'Zapamiętaj mnie</label><br/>';
	$setBtn = '<button type="submit" name="setBtn">Zaloguj</button>';
	$form = $hTxt.$msg.'<form action="login.php" method="POST">'.$lbl1.$inp1.$lbl2.$inp2.$lbl3.$setBtn.'</form>';
} else
	$form = '<p>Formularz logowania nie mógł zostać wyświetlony, ponieważ połączenie nie jest bezpieczne (brak protokołu HTTPS)!</p>';
echo $form;
?>
