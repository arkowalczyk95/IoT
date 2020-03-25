
<?php
    require 'connection.php';
    $conn = connection();
    if (!$conn) {
      echo "An error occurred.\n";
    }
    $measures = pg_query($conn, "SELECT * FROM esp_reads where read_id=(select max(read_id) from esp_reads);");
    while ($row = pg_fetch_row($measures)) {
      /*echo "\nread_id: $row[0] humidity: $row[1] light_frequency: $row[2] pressure: $row[3] temperature_bmp: $row[4] temperature_sht: $row[5] uv_index: $row[6]";
      echo "<br />\n";*/
        $current_humidity = $row[1];
        $current_light_frequency = $row[2];
        $current_pressure = $row[3];
        $current_temperature_bmp = $row[4];
        $current_temperature_sht = $row[5];
        $current_uv_index = $row[6];
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <link rel="STYLESHEET" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
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
        <h1>Current mode</h1>

    <table class="table" align="center" style="border-bottom: 2px solid #ddd">
      <thead>
      <tr align="center">
          <th>Mode</th>

          <th>    
            <select name="current_mode">
            <option selected value="Relax">Relax</option>
            <option value="Work">Work</option>
            <option value="Sleep">Sleep</option>
            </select>
          </th>
          <th><input type="submit" name="change_mode" value="Change mode"></th>
	  </tr>
      </thead>
    </table>
    <table class="table" align="center">
        <thead>
        <th></th>
        <th>Current</th>
            <th>Settings</th>
        </thead>
      <tbody>
      <tr align="center">
          <td>Temperature</td>
          <td><?php echo $current_temperature_bmp; ?></td>
          <td>
              <input type="number" name="temperature" min="16" max="26" value="<?php echo $current_temperature_bmp; ?>">
          </td>
	  </tr>
      <tr align="center">
          <td>Light color</td>
          <td>neutral</td>
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
          <td><?php echo $current_humidity; ?>%</td>
          <td>    
            <select name="humidity">
            <option selected disabled hidden value="<?php echo $current_humidity; ?>%"><?php echo $current_humidity; ?>%</option>
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
          <tr align="center">
          <td colspan="3"><input type="submit" name="change_settings" value="Change settings"></td>
          </tr>
      </tbody>
    </table>
    </div>

    <div class="footer">
    </div>

</body>
</html>
