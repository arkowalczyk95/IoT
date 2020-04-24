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

    /*$edit = 'enabled';
    $other_modes_names = array();
    foreach ($other_modes as $row)
        array_push($other_modes_names, $row["name"]);
    if (in_array($mode_name, $other_modes_names) || $mode_name=='AVERAGE') 
          $edit = 'disabled';*/

    if ($mode_params["owner"] == $login)
        $edit = 'enabled';
    else
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
            <li class="<?= ($mode_name == $row["name"]) ? 'active':''; ?>">
                <a href="modes.php?login=<?php echo $login; ?>&mode=<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></a></li>
            <?php endforeach; ?>
            <?php endif; ?>
            <li>User modes</li>
            <?php if (isset($user_modes)): ?>
            <?php foreach ($user_modes as $row): ?>
            <li class="<?= ($mode_name == $row["name"]) ? 'active':''; ?>">
                <a href="modes.php?login=<?php echo $login; ?>&mode=<?php echo $row["name"]; ?>"><?php echo str_replace('_', ' ', $row["name"]); ?></a></li>
            <?php endforeach; ?>
            <?php endif; ?>
            <li>Other modes</li>
            <?php if (isset($other_modes)): ?>
            <?php foreach ($other_modes as $row): ?>
            <li class="<?= ($mode_name == $row["name"]) ? 'active':''; ?>">
                <a href="modes.php?login=<?php echo $login; ?>&mode=<?php echo $row["name"]; ?>"><?php echo str_replace('_', ' ', $row["name"]); ?></a></li>
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
          <th><input disabled type="text" name="current_mode" value="<?php echo str_replace('_', ' ', $mode_name); ?>" required="required"></th>
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
          <td>Temperature [°C]<br/>(16°C to 26°C)</td>
          <td>
              <input <?php echo $edit; ?> type="range" name="temperature" id="tempInputId" min="16" max="26"
                     value="<?php echo $mode_params["temperature"]; ?>" oninput="tempOutputId.value = tempInputId.value" required="required"
                     style="background-image: linear-gradient(to right, dodgerblue, gold, orangered)">
              <output name="tempOutputName" id="tempOutputId"><?php echo $mode_params["temperature"]; ?></output>
          </td>
	  </tr>
          
      <tr align="center">
          <td>Light intensity<br/>(1 to 10)</td>
          <td>    
              <input <?php echo $edit; ?> type="range" name="light_frequency" id="lightInputId" min="1" max="10"
                     value="<?php echo $mode_params["light_frequency"]; ?>" oninput="lightOutputId.value = lightInputId.value" required="required"
                     style="background-image: linear-gradient(to right, lightskyblue, white, gold)">
              <output name="lightOutputName" id="lightOutputId"><?php echo $mode_params["light_frequency"]; ?></output>
              
            <!--<select <?php echo $edit; ?> name="light_frequency">
            <option selected value="<?php echo $mode_params["light_frequency"]; ?>"><?php echo $mode_params["light_frequency"]; ?></option>
            <option value="0-3000">0-3000</option>
            <option value="3000-6000">3000-6000</option>
            <option value="6000-9000">6000-9000</option>
            <option value="9000-12000">9000-12000</option>
            <option value="12000-15000">12000-15000</option>
            <option value="15000-18000">15000-18000</option>
            <option value="18000-21000">18000-21000</option>
            <option value="21000-24000">21000-24000</option>
            <option value="24000-27000">24000-27000</option>
            <option value="27000-30000">27000-30000</option>
            </select>-->
          </td>
	  </tr>
          
      <tr align="center">
          <td>Humidity [%]<br/>(10% to 90%)</td>
         <td>    
          <input <?php echo $edit; ?> type="number" name="humidity" min="10" max="90" value="<?php echo $mode_params["humidity"]; ?>"  required="required">
          </td>
	  </tr>
          
      <?php if ($mode_params["owner"] == $login) : ?>
      <tr align="center">
          <td>Is mode public</td>
         <td style="text-align:left">
             <input style="align:left; margin: 20px 30px; height:20px; width:20px;" type="checkbox" name="public" 
                    <?php if ($mode_params["is_public"] == 't') { ?> checked <?php }?>>
          </td>
       </tr>
          
      <tr align="center">
       <td><input type="submit" name="delete_mode" value="Delete mode"></td>
      <td><input type="submit" name="save_mode" value="Save mode"></td>
      </tr>
      <tr><td><br/></td></tr>
      <?php else : ?>
      <tr><td><br/></td></tr>
      <tr><td><br/></td></tr>
      <tr><td><br/></td></tr>
      <tr><td><br/></td></tr>
      <tr><td><br/></td></tr>
      <tr><td><br/></td></tr>
       <?php endif; ?>
          
      </tbody>
    </table>
        </form>
        
        <?php
        
	if (isset($_POST['save_mode'])) {   // do zmiany na update przez api/modes/update
        $url = 'localhost:8080/api';  // dodanie modu przez api/modes/create
        $collection_name = 'modes/update';
        $request_url = $url . '/' . $collection_name;
        //$new_mode_name = trim(str_replace(' ', '_', $_POST['current_mode'])) ? trim(str_replace(' ', '_', $_POST['current_mode'])) : $mode_name;
        /*echo trim($_POST['selected']);*/
        if ($mode_params["owner"] == $login){
            $is_public = (trim($_POST['public']) == 'on') ? 'true' : 'false';
            /*$new_data = array($new_mode_name, $is_public, trim($_POST['temperature']), trim($_POST['humidity']), trim($_POST['light_frequency']), $mode_params["mode_id"]);
            $res1 = pg_query_params($conn, "UPDATE room_modes set name = $1, is_public = $2, temperature = $3, humidity = $4, light_frequency = $5 where mode_id = $6", $new_data);*/

            $data = array(
                'modeId' => $mode_params["mode_id"],
                'name' => $mode_name, 
                'isPublic' => $is_public, 
                'temperature' => trim($_POST['temperature']), 
                'humidity' => trim($_POST['humidity']), 
                'lightFrequency' => trim($_POST['light_frequency'])
            );
            
        }else{
            /*$new_data = array($new_mode_name, trim($_POST['temperature']), trim($_POST['humidity']), trim($_POST['light_frequency']), $mode_params["mode_id"]);
            $res1 = pg_query_params($conn, "UPDATE room_modes set name = $1, temperature = $2, humidity = $3, light_frequency = $4 where mode_id = $5", $new_data);*/
            
            $data = array(
                'modeId' => $mode_params["mode_id"],
                'name' => $mode_name, 
                'temperature' => trim($_POST['temperature']), 
                'humidity' => trim($_POST['humidity']), 
                'lightFrequency' => trim($_POST['light_frequency'])
            );
        }
        
            $curl = curl_init($request_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
              'Accept: application/json',
              'Content-Type: application/json'
            ]);
            $response = curl_exec($curl);
            curl_close($curl);
            echo $response . PHP_EOL;
            $url = "modes.php?login=$login&mode=$new_mode_name";
            echo "<script type='text/javascript'> document.location = '$url'; </script>";
            exit();
        
        /*if ($res1) {
            $url = "modes.php?login=$login&mode=$new_mode_name";
            echo "<script type='text/javascript'> document.location = '$url'; </script>";
            exit();
        }else{
            echo "Edit mode unsucessful:\n";
            echo pg_last_error($conn);
        }*/
    }
	if (isset($_POST['delete_mode'])) { 
        $url = 'localhost:8080/api/modes/delete';
        $request_url = $url . '/' . $mode_name;

        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'Content-Type: application/json'
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response . PHP_EOL;
        $url = "modes.php?login=$login";
        echo "<script type='text/javascript'> document.location = '$url'; </script>";
        exit();
        }
	
	
        ?>
        
        </div>
    </div>

    <div class="footer">
    </div>

</body>
</html>

