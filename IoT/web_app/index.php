<?php
    require 'connection.php';
    require 'db_helper.php';
    $conn = connection();
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
		<li><a href="index.php">LOGIN</a></li>
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

    if (isset($_POST['login'])) {
		$username = trim($_POST['username']);
		$password = md5(trim($_POST['password']));
        
		if (!isset($username) || empty($username)) 
			echo 'Please, enter the username';
		else if (!isset($password) || empty($password))
			echo 'Please, enter the password';
		
        else {
            $res = pg_query_params($conn, "SELECT * FROM users where username = $1 and password = $2;", array($username, $password));
            if (pg_num_rows($res) == 1) {
                header('Location: home.php?login=' . $username);
            }
            else if (pg_num_rows($res) == 0) {
                $res = pg_query_params($conn, "INSERT INTO users (username, password) VALUES ($1, $2);", array($username, $password));
                if ($res) {
                    header('Location: home.php?login=' . $username);
                }else{
                    echo "Login unsucessful:\n";
                    echo pg_last_error($conn);
                }
            }else{
                echo "Login unsucessful:\n";
                echo pg_last_error($conn);
            }   
        }
    }    
?>

    </div>

    <div class="footer">
    </div>


</body>
</html>

