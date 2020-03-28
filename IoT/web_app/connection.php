<?php
function connection() {
try{
    $conn = pg_connect("host=127.0.0.1 port=5432 dbname=postgres user=postgres password=db_team2");
   /* echo $conn;*/
}catch(Exception $e){
    echo 'Connection failed: ' . $e->getMessage();
}
return $conn;
}
?>
