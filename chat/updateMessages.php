<?php
session_start();
if(isset($_SESSION["email"])) {
    $db = new mysqli("us-cdbr-east-05.cleardb.net", "b59706ca4e953f", "7aab941f", "heroku_4db4cf2503e4bbb");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    
    $group_id = $_POST['group_id'];
    $name = $_SESSION['name'];
    $max = $_POST['max'];

    $q = "SELECT * FROM heroku_4db4cf2503e4bbb.messages 
    WHERE groupedid = '$group_id' AND idMessages > '$max' AND profilename != '$name'";

    $result = $db->query($q); 
    $jsonArray = array();
    while ($row = $result->fetch_assoc()) {
        $jsonArray[] = $row;
    }
    echo json_encode($jsonArray);   
    
    $db->close();
}
else {
    header("Location: index.php");
}
?>