<?php  
// Select details of all forums
    session_start();
    try
    {
        $db=new PDO('mysql:host=localhost;port=6033;dbname=air_ngo', 'root','');
    }
    catch (PDOException $e)
    {
        echo "Error connecting to database server:<br />";
        echo $e->getMessage();
        exit;
    }

    function log_event($event_type, $event_details)
        {
            global $db;
            $log_stmt = $db->prepare("INSERT INTO log (ip_address, event_type, event_details) VALUES (?,?,?)");
            $log_stmt->execute([$_SERVER['REMOTE_ADDR'], $event_type, $event_details]);
        }
?>
