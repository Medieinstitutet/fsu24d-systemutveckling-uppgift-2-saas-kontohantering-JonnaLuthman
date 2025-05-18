<?php
function get_newsletters() {
    global $connection;

    $sql = 'SELECT * FROM newsletter';

    $result = $connection->query($sql);
    
    if ($result && $result->num_rows > 0) {
    return $result->fetch_all(MYSQLI_ASSOC);
    } else {
    return [];
    }
}
?>