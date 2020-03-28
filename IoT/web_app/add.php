<?php
    require 'connection.php';
    require 'db_helper.php';
    $conn = connection();

    $login = trim($_GET['login']);

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
		<li><a href="home.php?login=<?php echo $login; ?>">HOME</a></li>
		<li><a href="modes.php?login=<?php echo $login; ?>">MODES</a></li>
		<li><a href="index.php">LOGOUT</a></li>
	</ol>
    </div>

    <div class="article">    

	<h1>Add mode</h1>   
        
    <form method="POST" action="" >	
    <table class="table" align="center">
      <thead>
      <tr align="center">
          <th>Name</th>
          <th><input type="text" name="mode_name"></th>
	  </tr>
      </thead>
        
      <tbody>
          
      <tr align="center">
          <td>Temperature</td>
          <td>
              <input type="number" name="temperature" min="16" max="26">
          </td>
	  </tr>
          
      <tr align="center">
          <td>Light color</td>
          <td>    
            <select name="light_color">
            <option value="cold">cold</option>
            <option value="neutral">neutral</option>
            <option value="warm">warm</option>
            </select>
          </td>
	  </tr>
          
      <tr align="center">
          <td>Humidity [%]</td>
         <td>    
          <input type="number" name="humidity" min="10" max="90">
          </td>
	  </tr>
          
         
      <tr align="center"> 
          <td>Is mode public</td>
         <td style="text-align:left">
             <input style="align:left; margin: 20px 30px; height:20px; width:20px;" type="checkbox" name="public">
          </td>
	  </tr>
          
      <tr align="center">
          <td colspan="2"><input type="submit" name="add_mode" value="Add mode"></td>
          </tr>
      </tbody>
    </table>
        </form>
        
    <?php 
            
	if (isset($_POST['add_mode'])) {
        $mode_name = trim($_POST['mode_name']);
        $id_public = (trim($_POST['public']) == 'on') ? 'true' : 'false';
        $new_data = array($mode_name, $login, 'false', $id_public, trim($_POST['temperature']), trim($_POST['humidity']), '100', '1');
        $res1 = pg_query_params($conn, "INSERT INTO room_modes (name, owner, selected, is_public, temperature, humidity, light_frequency, uv_index) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)", $new_data);
        if ($res1) {
            echo "Mode '$mode_name' added";
        }else{
            echo "Add mode unsucessful:\n";
            echo pg_last_error($conn);
        }
    }
    ?>
        
    </div>

    <div class="footer">
    </div>

</body>
</html>

