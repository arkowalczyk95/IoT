<?php

    function get_mode_params($conn, $mode_name){
        /*echo $mode_name;*/
        $params = pg_fetch_all(pg_query_params($conn, "SELECT * FROM room_modes where upper(name) = upper($1)", array($mode_name)));
        /*while ($row = pg_fetch_row($params)) {
            echo "mode_id: $row["mode_id"] humidity: $row["humidity"] light_frequency: $row["light_frequency"] selected: $row["selected"] temperature: $row["temperature"] uv_index: $row["uv_index"]";
            echo "<br />\n";
        }*/
        return $params[0];
    }

    function get_active_mode_params($conn){
        $params = pg_fetch_all(pg_query($conn, "SELECT * FROM room_modes where selected = 'yes';"));
        /*while ($row = pg_fetch_row($params)) {
            echo "mode_id: $row["mode_id"] humidity: $row["humidity"] light_frequency: $row["light_frequency"] selected: $row["selected"] temperature: $row["temperature"] uv_index: $row["uv_index"]";
            echo "<br />\n";
        }*/
        return $params[0];
    }

    function get_all_accesible_modes($conn, $username){
        return pg_fetch_all(pg_query_params($conn, "SELECT * FROM room_modes where owner in ($1, 'all') or is_public = 'yes' order by mode_id;", array($username)));
    }

    function get_all_default_modes($conn){
        return pg_fetch_all(pg_query($conn, "SELECT * FROM room_modes where owner = 'all' order by mode_id;"));
    }

    function get_user_modes($conn, $username){
        return pg_fetch_all(pg_query_params($conn, "SELECT * FROM room_modes where owner = $1 order by mode_id;", array($username)));
    }

    function get_other_users_modes($conn, $username){
        return pg_fetch_all(pg_query_params($conn, "SELECT * FROM room_modes where owner not in ($1, 'all') and is_public = 'yes' order by mode_id;", array($username)));
    }
?>
