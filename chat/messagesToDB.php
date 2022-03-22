<?php
session_start();
if(isset($_SESSION["email"])) {
    
    $db = new mysqli("us-cdbr-east-05.cleardb.net", "b59706ca4e953f", "7aab941f", "heroku_4db4cf2503e4bbb");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    $id = $_SESSION['id'];
    $text = $_POST['text'];
    $time = $_POST['time'];
    $name = $_SESSION['name'];
    $group_id = $_POST['group_id'];  

    $q1 = "INSERT INTO heroku_4db4cf2503e4bbb.messages (profilename, time,text,groupedid) VALUES ('$name', NOW(), '$text', '$group_id')";
    $db->query($q1); 
    
    
    echo $text;
    $db->close();    
}

else {
    header("Location: index.php");
    exit();
}
?>