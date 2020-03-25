<?php
    require 'connection.php';
    $conn = connection();
    $mode_name = trim($_GET['mode']);
    /*echo $mode_name;*/

    $mode_params = pg_query_params($conn, "SELECT * FROM room_modes where name = $1", array($mode_name));

    while ($row = pg_fetch_row($mode_params)) { 
      /*  echo "read_id: $row[0] name: $row[1] temperature_bmp: $row[2] humidity: $row[3] uv_index: $row[4] light_frequency: $row[5]";
        echo "<br />\n";*/
        $mode_temperature_bmp = $row[2];
        $mode_humidity = $row[3];
        $mode_uv_index = $row[4];
        $current_light_frequency = $row[5];
    }
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
    <div class="sidebar">
        <ul class="style">
            <li>Default modes</li>
            <li class="active"><a href="modes.php?mode=work"><?php echo $mode_name; ?></a></li>
            <li><a href="">Relax</a></li>
            <li><a href="">Sleep</a></li>
            <li><a href="">Avarage</a></li>
            <li>User modes</li>
            <li><a href="">Mode 1</a></li>
            <li><a href="">Mode 2</a></li>
            <li><a href="">Mode 3</a></li>
            <li><a href="">Mode 4</a></li>
            <li><a href="">Mode 5</a></li>
            <li><a href="">Mode 1</a></li>
            <li><a href="">Mode 2</a></li>
            <li><a href="">Mode 3</a></li>
            <li><a href="">Mode 4</a></li>
            <li><a href="">myfavouritemode</a></li>
        </ul>
    </div>    

    <div class="mainbar">
	<h1>Edit modes</h1>    
    <table class="table" align="center">
      <thead>
      <tr align="center">
          <th>Name</th>
          <th><input type="text" name="current_mode" placeholder="<?php echo $mode_name; ?>"></th>
	  </tr>
      </thead>
      <tbody>
      <tr align="center">
          <td>Temperature</td>
          <td>
              <input type="number" name="temperature"min="16" max="26" value="<?php echo $mode_temperature_bmp; ?>">
          </td>
	  </tr>
      <tr align="center">
          <td>Light color</td>
          <td>    
            <select name="light_color">
            <option value="cold">cold</option>
            <option selected value="neutral">neutral</option>
            <option value="warm">warm</option>
            </select>
          </td>
	  </tr>
      <tr align="center">
          <td>Humidity</td>
          <td>    
            <select name="humidity">
            <option selected disabled hidden value="<?php echo $mode_humidity; ?>%"><?php echo $mode_humidity; ?>%</option>
            <option value="30%">30%</option>
            <option value="35%">35%</option>
            <option value="40%">40%</option>
            <option value="45%">45%</option>
            <option value="50%">50%</option>
            <option value="55%">55%</option>
            <option value="60%">60%</option>
            </select>
          </td>
	  </tr>
          <tr>
          <td colspan="2"><input type="submit" name="save mode" value="Save mode"></td>
          </tr>
      </tbody>
    </table>
        </div>
    </div>

    <div class="footer">
    </div>

</body>
</html>

