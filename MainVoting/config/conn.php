
<?php

class Connections{
    public static function Connect(){
        $conn = new mysqli("localhost","root","","voting");
        if($conn->connect_error)
           print_r($conn->error);
        else
          return $conn;
    }
}

?>