
<?php
    require 'connection.php';
    require 'db_helper.php';
    $conn = connection();

    $login = trim($_GET['login']);

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

    $active_mode_params = get_active_mode_params($conn);
    $modes = get_all_accesible_modes($conn, $login);
    
	if (isset($_POST['change_mode'])) {
        $new_mode_name = trim($_POST['current_mode']);
        $res1 = pg_query_params($conn, "UPDATE room_modes set selected = false where upper(name) = upper($1)", array($active_mode_params["name"]));
        if ($res1) {
            $res2 = pg_query_params($conn, "UPDATE room_modes set selected = true where upper(name) = upper($1)", array($new_mode_name));
            if ($res2) {
                header("Refresh:0");
            }
            else{
                pg_query_params($conn, "UPDATE room_modes set selected = true where upper(name) = upper($1)", array($active_mode_params["name"]));
                echo "Change of mode unsucessful";
                echo pg_last_error($conn);
            }
        }else{
            echo "Change mode unsucessful";
            echo pg_last_error($conn);
        }
        /*$oldTitle = $title;
        $oldAuthor =  $author;
        $oldCategory = $category;
        $oldYear = $year;
		$title = trim($_POST['title']);
		$author = trim($_POST['author']);
		$category = trim($_POST['category']);
		$year = trim($_POST['year']);
        
        $edited = false;
		if (!isset($title) || empty($title)) $title = $oldTitle;
        else $edited = true;
        if (!isset($author) || empty($author)) $author = $oldAuthor;
        else $edited = true;
        if (!isset($category) || empty($category)) $category = $oldCategory;
        else $edited = true;
        if (!isset($year) || empty($year)) $year = $oldYear;
        else $edited = true;

        if ($edited) {   	
            $query = 'UPDATE ksiazki SET tytul=:title, autor=:author, kategoria=:category, rok_wydania=:year WHERE id=:editId';
            if ($sth = $pdo->prepare($query)) {
                $sth->bindValue(':title', $title, PDO::PARAM_STR);
                $sth->bindValue(':author', $author, PDO::PARAM_STR);
                $sth->bindValue(':category', $category, PDO::PARAM_STR);
                $sth->bindValue(':year', $year, PDO::PARAM_INT);
                $sth->bindValue(':editId', $editId, PDO::PARAM_INT);   
                $sth->execute();
                $pdo->commit();
                $ok = true;
            }
            <?php echo (isset($result))?$result:'';?>
        }*/
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
            <li><a href="home.php?login=<?php echo $login; ?>">HOME</a></li>
            <li><a href="modes.php?login=<?php echo $login; ?>">MODES</a></li>
            <li><a href="index.php">LOGOUT</a></li>
        </ol>
    </div>

    <div class="article">
        <h1>Current mode</h1>

    <table class="table" align="center" style="border-bottom: 2px solid #ddd">
      <thead>
      <tr align="center">
          <th>Mode</th>
        <form method="POST" action="" >	
          <th>    
            <select name="current_mode">
            <?php if (isset($modes)): ?> 
            <?php foreach ($modes as $row): ?>
            <option <?php if ($active_mode_params["name"] == $row["name"]) { ?> selected <?php }?>
                    value="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
            </select>
          </th>
          <th><input type="submit" name="change_mode" value="Change mode"></th>
          </form>
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
              <input type="number" name="temperature" min="16" max="26" value="<?php echo $active_mode_params["temperature"]; ?>">
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
          <td>Humidity [%]</td>
          <td><?php echo $current_humidity; ?></td>
         <td>    
          <input type="number" name="humidity"min="10" max="90" value="<?php echo $active_mode_params["humidity"]; ?>">
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
