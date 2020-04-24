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
          <th><input type="text" name="mode_name" required="required"></th>
	  </tr>
      </thead>
        
      <tbody>
          
      <tr align="center">
          <td>Temperature [°C]<br/>(16°C to 26°C)</td>
          <td>
              <input type="range" name="temperature" id="tempInputId" min="16" max="26"
                     oninput="tempOutputId.value = tempInputId.value" required="required"
                     style="background-image: linear-gradient(to right, dodgerblue, gold, orangered)">
              <output name="tempOutputName" id="tempOutputId"><p> </p></output>
          </td>
	  </tr>
          
      <tr align="center">
          <td>Light intensity<br/>(1 to 10)</td>
          <td>    
              <input type="range" name="light_frequency" id="lightInputId" min="1" max="10"
                     oninput="lightOutputId.value = lightInputId.value" required="required"
                     style="background-image: linear-gradient(to right, lightskyblue, white, gold)">
              <output name="lightOutputName" id="lightOutputId"><p> </p></output>
            <!--<select name="light_frequency">
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
          <input type="number" name="humidity" min="10" max="90" required="required">
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
        $mode_name = trim(str_replace(' ', '_', $_POST['mode_name']));
        $is_public = (trim($_POST['public']) == 'on') ? 'true' : 'false';
        /*$new_data = array($mode_name, $login, 'false', $is_public, trim($_POST['temperature']), trim($_POST['humidity']), '100', '1');  // dodanie modu tylko do bazy
        $res1 = pg_query_params($conn, "INSERT INTO room_modes (name, owner, selected, is_public, temperature, humidity, light_frequency, uv_index) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)", $new_data);
        if ($res1) {
            echo "Mode '$mode_name' added";
        }else{
            echo "Add mode unsucessful:\n";
            echo pg_last_error($conn);
        }*/

        $url = 'localhost:8080/api';  // dodanie modu przez api/modes/create
        $collection_name = 'modes/create';
        $request_url = $url . '/' . $collection_name;
        $data = array(
            'name' => $mode_name, 
            'owner' => $login, 
            'selected' => false,
            'isPublic' => $is_public, 
            'temperature' => trim($_POST['temperature']), 
            'humidity' => trim($_POST['humidity']), 
            'lightFrequency' => trim($_POST['light_frequency'])
        );
        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'Content-Type: application/json'
        ]);
        $response = json_decode(curl_exec($curl), true);
        if (isset($response["name"]))
            echo 'Mode ' . $response["name"] . ' added';
        else
            echo 'Error occured ' . curl_strerror($curl);
        curl_close($curl);
        
    }
    ?>
        
    </div>

    <div class="footer">
    </div>

</body>
</html>

