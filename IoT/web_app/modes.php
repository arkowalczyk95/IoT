<?php
    require 'connection.php';
    require 'db_helper.php';
    $conn = connection();

    $mode_name = trim($_GET['mode']);
    $login = trim($_GET['login']);
    $modes = get_all_default_modes($conn);
    $user_modes = get_user_modes($conn, $login);
    $other_modes = get_other_users_modes($conn, $login);

    if (empty($mode_name)) {
        $active_mode = get_active_mode_params($conn);
        $mode_name = $active_mode["name"];
    }

    $mode_params = get_mode_params($conn, $mode_name);

    $edit = 'enabled';
    $other_modes_names = array();
    foreach ($other_modes as $row)
        array_push($other_modes_names, $row["name"]);
    if (in_array($mode_name, $other_modes_names)) 
          $edit = 'disabled';

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
    <div class="sidebar">
        <ul class="style">
            <li><input type="submit" name="add_mode" value="Add mode" onclick="location.href='add.php?login=<?php echo $login; ?>';" ></li>
            <li>Default modes</li>
            <?php if (isset($modes)): ?>
            <?php foreach ($modes as $row): ?>
            <li class="<?= ($mode_name == $row["name"]) ? 'active':''; ?>"><a href="modes.php?login=<?php echo $login; ?>&mode=<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></a></li>
            <?php endforeach; ?>
            <?php endif; ?>
            <li>User modes</li>
            <?php if (isset($user_modes)): ?>
            <?php foreach ($user_modes as $row): ?>
            <li class="<?= ($mode_name == $row["name"]) ? 'active':''; ?>"><a href="modes.php?login=<?php echo $login; ?>&mode=<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></a></li>
            <?php endforeach; ?>
            <?php endif; ?>
            <li>Other modes</li>
            <?php if (isset($other_modes)): ?>
            <?php foreach ($other_modes as $row): ?>
            <li class="<?= ($mode_name == $row["name"]) ? 'active':''; ?>"><a href="modes.php?login=<?php echo $login; ?>&mode=<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></a></li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>    

    <div class="mainbar">
	<h1>Edit modes</h1>   
        
    <form name="form1" method="POST" action="" >	
    <table class="table" align="center">
      <thead>
      <tr align="center">
          <th>Name</th>
          <th><input <?php echo $edit; ?> type="text" name="current_mode" placeholder="<?php echo $mode_name; ?>"></th>
	  </tr>
      </thead>
        
      <tbody>
          
         <!-- <tr align="center">
              <td>Active</td>
              <td>
                 <label style="display:inline-block;">
                     <input style="margin: 0px 10px;" type="radio" name="selected" value="true"
                            <?php if ($mode_params["selected"] == 't') { ?> checked <?php }?>>
                     yes</label>
                 <label style="display:inline-block;">
                     <input style="margin: 0px 10px;" type="radio" name="selected" value="false"
                            <?php if ($mode_params["selected"] == 'f') { ?> checked <?php }?>>
                     no</label>
              </td>
          </tr> -->
          
      <tr align="center">
          <td>Temperature</td>
          <td>
              <input <?php echo $edit; ?> type="number" name="temperature" min="16" max="26" value="<?php echo $mode_params["temperature"]; ?>">
          </td>
	  </tr>
          
      <tr align="center">
          <td>Light color</td>
          <td>    
            <select <?php echo $edit; ?> name="light_color">
            <option value="cold">cold</option>
            <option selected value="neutral">neutral</option>
            <option value="warm">warm</option>
            </select>
          </td>
	  </tr>
          
      <tr align="center">
          <td>Humidity [%]</td>
         <td>    
          <input <?php echo $edit; ?> type="number" name="humidity"min="10" max="90" value="<?php echo $mode_params["humidity"]; ?>">
          </td>
	  </tr>
          
      <?php if ($mode_params["owner"] == $login) : ?>
      <tr align="center">
          <td>Is mode public</td>
         <td style="text-align:left">
             <input style="align:left; margin: 20px 30px; height:20px; width:20px;" type="checkbox" name="public" 
                    <?php if ($mode_params["is_public"] == 't') { ?> checked <?php }?>>
          </td>
       <?php endif; ?>
       </tr>
          
      <tr align="center">
      <td colspan="2"><input type="submit" name="save_mode" value="Save mode"></td>
      </tr>
      </tbody>
    </table>
        </form>
        
        <?php
        
	if (isset($_POST['save_mode'])) {
        $new_mode_name = trim($_POST['current_mode']) ? trim($_POST['current_mode']) : $mode_name;
        /*echo trim($_POST['selected']);*/
        if ($mode_params["owner"] == $login){
            $is_public = (trim($_POST['public']) == 'on') ? 'true' : 'false';
            $new_data = array($new_mode_name, $is_public, trim($_POST['temperature']), trim($_POST['humidity']), $mode_params["mode_id"]);
            $res1 = pg_query_params($conn, "UPDATE room_modes set name = $1, is_public = $2, temperature = $3, humidity = $4 where mode_id = $5", $new_data);
        }else{
            $new_data = array($new_mode_name, trim($_POST['temperature']), trim($_POST['humidity']), $mode_params["mode_id"]);
            $res1 = pg_query_params($conn, "UPDATE room_modes set name = $1, temperature = $2, humidity = $3 where mode_id = $4", $new_data);
        }
        if ($res1) {
            $url = "modes.php?login=$login&mode=$new_mode_name";
            echo "<script type='text/javascript'> document.location = '$url'; </script>";
            exit();
        }else{
            echo "Edit mode unsucessful:\n";
            echo pg_last_error($conn);
        }
    }
        ?>
        
        </div>
    </div>

    <div class="footer">
    </div>

</body>
</html>

