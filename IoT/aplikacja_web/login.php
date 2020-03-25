<?php
    require 'connection.php';
    $pdo = connection();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <link rel="STYLESHEET" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>SmartRoom</title>
</head>
<body>

    <div class="header">SmartRoom</div>
    <div class="nav">			
	<ol>
		<li><a href="index.php">HOME</a></li>
		<li><a href="modes.php?mode=work">MODES</a></li>
		<li><a href="login.php">LOGIN</a></li>
	</ol>
    </div>

    <div class="article">
	<!--<h1 align="center">LOGIN</h1> -->     
        
    <div id="container">
	<form method="POST" action="">		
	    <input type="text" name="username" placeholder="username" onfocus="this.placeholder=''" onblur="this.placeholder='username'"><br/>
	    <input type="password" name="password" placeholder="password" onfocus="this.placeholder=''" onblur="this.placeholder='password'">
	    <input type="submit" name="login" value="LOGIN">
	</form>
    </div>
        
<?php   

    if (isset($_POST['submit'])) {
		$error = array();
        
		$login = trim($_POST['login']);
		$password = trim($_POST['password']);
        
		if (!isset($login) || empty($login)) 
			array_push($error, 'Podaj login!');
		else if (!isset($password) || empty($password))
			array_push($error, 'Podaj hasło!');
		$checked = true;
        
		if (count($error) == 0) {
			$query = 'SELECT nazwa, haslo FROM uzytkownicy WHERE nazwa = :login AND haslo = :password';
			if ($sth = $pdo->prepare($query)) { 
				$sth->bindValue(':login', $login, PDO::PARAM_STR);
				$sth->bindValue(':password', $password, PDO::PARAM_STR);
                if (!$sth->execute()) 
                    print_r($pdo->errorInfo());
                else {
                    if($sth->rowCount() > 0)
                       $logged = true;
                }
            }
            if(!isset($logged)) {   
                $query = 'INSERT INTO uzytkownicy (nazwa, haslo) VALUES (:login, :password)';
                if ($sth = $pdo->prepare($query)) {
                    $sth->bindValue(':login', $login, PDO::PARAM_STR);
                    $sth->bindValue(':password', $password, PDO::PARAM_STR);
                    if (!$sth->execute()) 
                        print_r($pdo->errorInfo());
                    else
                        $logged = true;  
                }
            }     
            header('Location: Xuser.php?login=' . $login);
        }
        else {
            if ($checked) {
                foreach ($error as $row)
                    echo $row;
            }
        }
    }    
?>

    </div>

    <div class="footer">
    </div>


</body>
</html>

