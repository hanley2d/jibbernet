<?php
session_start();
if(isset($_SESSION["email"])) {
    $db = new mysqli("us-cdbr-east-05.cleardb.net", "b59706ca4e953f", "7aab941f", "heroku_4db4cf2503e4bbb");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    $name = $_SESSION['name'];
    $id = $_SESSION['id'];

    $room_name = $_GET['room'];
    $group_id = $_GET['g_id'];

    $q = "SELECT * from heroku_4db4cf2503e4bbb.messages;";
    $result = $db->query($q);

    $db->close();
}
else
{
header("Location: index.php");
}
?>


<!DOCTYPE html>

<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css"/> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
    <title>jibbernet chat</title>
</head>

<body>
    <header class="navBar">  
                <h3 class="navTitle"><a href="../viewgroups.php">jibbernet</a></h3>
                                         
    </header>  
        <div class="chat-container">
            <header class="chat-header">
                <h2 id="room-name"><?=$room_name?></h2>               
                <a href="../viewgroups.php" class="btn" id="leave-btn">Leave Room</a>
            </header>
            <main class="chat-main">
                <div class="chat-messages">	
                <?
                    while ($row = $result->fetch_assoc()) {
                ?> 
                    <div style="display:none" class="message" id="<?= $row["idMessages"] ?>">
                            
                    </div>
                <? } ?>
               
                </div>                                    
            </main>   
            <div class="chat-sidebar">   
                <h3> <?=$name?></h3>
                <ul id="users">
                </ul>
            </div>  
            
            <div class="chat-form-container">
                <form id="chat-form" method="POST">
                    <input type="hidden" id="group_id" value="<?=$group_id?>"></input> 
                    <input
                        id="msg"
                        name="message"
                        type="text"
                        placeholder="Type something"
                        required
                        autocomplete="off"
                    />
                  <button id="butsave" type="submit" class="btn">Send</button>                
                </form>
            </div>                   
        </div> 
        
    
    <footer class="footer"></footer>

    <script>
        
    </script>
    
    <!-- this script used to query URL. This is to get the user and room from URL -->
    <script 
        src="https://cdnjs.cloudflare.com/ajax/libs/qs/6.10.3/qs.min.js" 
        integrity="sha512-juaCj8zi594KHQqb92foyp87mCSriYjw3BcTHaXsAn4pEB1YWh+z+XQScMxIxzsjfM4BeVFV3Ij113lIjWiC2w==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer">
    </script>
    
    <script type="text/javascript" src="./js/updateMessages.js"></script>
</body>
</html>