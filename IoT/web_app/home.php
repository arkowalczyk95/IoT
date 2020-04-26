<?php
    require 'connection.php';
    require 'db_helper.php';
    require 'api_helper.php';
    $conn = connection();
    $url = 'localhost:8080/api';
    $login = trim($_GET['login']);

    /*$measures = pg_query($conn, "SELECT * FROM esp_reads where read_id=(select max(read_id) from esp_reads);");  // odczytanie danych przez baze
    while ($row = pg_fetch_row($measures)) {
        $current_humidity = $row[1];
        $current_light_frequency = $row[2];
        $current_pressure = $row[3];
        $current_temperature_bmp = $row[4];
        $current_temperature_sht = $row[5];
        $current_uv_index = $row[6];
    }*/

    $collection_name = 'espRead/recent';  // odczytanie danych przez API
    $request_url = $url . '/' . $collection_name;
    $curl = curl_init($request_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Accept: application/json',
      'Content-Type: application/json'
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    //echo $response . PHP_EOL;
    $measures = json_decode($response, true);

    $current_humidity = $measures["humidity"];
    $current_light_frequency = $measures["lightFrequency"];
    $current_pressure = $measures["pressure"];
    $current_temperature_bmp = $measures["temperatureBmp"];
    $current_temperature_sht = $measures["temperatureSht"];
    $current_uv_index = $measures["uvIndex"];

//    $active_mode_params = get_active_mode_params($conn);  // pobiera z bazy - stary sposob
    $active_mode_params = api_get_active_mode_params();  // pobiera z API
    $modes = get_all_accesible_modes($conn, $login);

    // wybranie trybu przez API
	if (isset($_POST['change_mode'])) {

        $url = 'localhost:8080/api';
        $collection_name = 'modesName';
        $new_mode_name = trim(str_replace(' ', '_', $_POST['current_mode']));
        $request_url = $url . '/' . $collection_name . '/' . $new_mode_name;

        echo $request_url;

        $curl = curl_init($request_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
          'Accept: application/json',
          'Content-Type: application/json'
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response . PHP_EOL;

        header("Refresh:0");
    }
        // wybranie trybu przez baze
        /* $res1 = pg_query_params($conn, "UPDATE room_modes set selected = false where upper(name) = upper($1)", array($active_mode_params["name"]));

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
         }*/
     
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <script src="https://code.jquery.com/jquery-1.7.2.js"></script>
    <meta charset="utf-8"/>
    <link rel="STYLESHEET" type="text/css" href="style.css" />
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
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
                    value="<?php echo $row["name"]; ?>"><?php echo str_replace('_', ' ', $row["name"]); ?></option>
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
        <th colspan="2">Current measures</th>
        </thead>
      <tbody>
      <tr align="center">
          <td style="padding: 30px 50px 0px 0px ">Temperature [°C]</td>
          <td style="padding: 30px 10px 0px 50px"><?php echo $current_temperature_bmp; ?></td>
	  </tr>
      <tr align="center">
          <td style="padding: 30px 50px 0px 0px">Light intensity<br/>(1 to 10)</td>
          <td style="padding: 30px 10px 0px 50px"><?php echo $current_light_frequency; ?></td>
	  </tr>
      <tr align="center">
          <td style="padding: 30px 50px 0px 0px">Humidity [%]</td>
           <td style="padding: 30px 10px 0px 50px"><p data-color2="<?php echo $current_humidity; ?>" ><?php echo $current_humidity; ?></p></td>
	  </tr>
      <tr align="center">
          <td style="padding: 30px 50px 0px 0px">Pressure [hPa]</td>
          <td style="padding: 30px 10px 0px 50px"><?php echo $current_pressure; ?></td>
          </tr>
      <tr align="center" >
          <td style="padding: 20px 50px 0px 0px">UV index</td>
          <td style="padding: 20px 10px 0px 50px"><p data-color="<?php echo $current_uv_index; ?>" ><?php echo $current_uv_index; ?></p></td>
          </tr>
      </tbody>
    </table>

    </div>

    <div class="footer">
    </div>

<script>
$(document).ready(function(){

  var mc_uv = {
    '0-2'   : 'green',
    '3-5'   : 'yellow',
    '6-7'   : 'orange',
    '8-10'  : 'red',
    '11-20' : 'purple'
  };

  var mc_humi = {
    '0-20'   : 'red',
    '21-30'  : 'orange',
    '31-40'  : 'yellow',
    '41-50'  : 'green',
    '51-70'  : 'yellow',
    '71-80'  : 'orange',
    '81-100' : 'red'
  }; 

function between(x, min, max) {
  return x >= min && x <= max;
}



  var dc_uv;
  var dc_humi;
  var first;
  var second;
  var th;

  $('p').each(function(index){

    th = $(this);

    dc_uv = parseInt($(this).attr('data-color'),10);
    dc_humi = parseInt($(this).attr('data-color2'),10);

      $.each(mc_uv, function(name, value){


        first = parseInt(name.split('-')[0],10);
        second = parseInt(name.split('-')[1],10);

        console.log(between(dc_uv, first, second));

        if( between(dc_uv, first, second) ){
          th.addClass(value);
        }
      });

      $.each(mc_humi, function(name, value){


        first = parseInt(name.split('-')[0],10);
        second = parseInt(name.split('-')[1],10);

        console.log(between(dc_humi, first, second));

        if( between(dc_humi, first, second) ){
          th.addClass(value);
        }
      });


  });
});
</script>

<script src="./script.js"></script>
</body>
</html>




