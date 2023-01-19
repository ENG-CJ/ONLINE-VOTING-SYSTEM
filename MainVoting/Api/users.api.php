<?php
include '../config/conn.php';

$action =$_POST['action'];

if(isset($action))
    RequestOperations::$action();


class RequestOperations{

    public static function insert(){
        sleep(2);
        extract($_POST);
        $fileTempName = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $uploadedFile='../uploads/'.$username.'-'.$fileName;
        $responseMessages=array();
        $sqlQuery="CALL add_user('$username','$email','$password','$fileName','$status','$type')";
        $result = Connections::Connect()->query($sqlQuery);
        
        // files
        if($result)
            {
              $responseMessages=array("status"=>true,"response"=>"Successfully Registered the Username ".$username);
             
            }
        else
        $responseMessages=array("status"=>false,"response"=>Connections::Connect()->error);

       echo  json_encode($responseMessages);
    }


    public static function AddUserWithImage(){
      sleep(2);
      extract($_POST);
      $fileTempName = $_FILES['file']['tmp_name'];
      $fileName = $_FILES['file']['name'];
      $uploadedFile='../uploads/'.$username.'-'.$fileName;
      $fileDB=$username."-".$fileName;
      $responseMessages=array();
      $sqlQuery="CALL add_user('$username','$email','$password','$fileDB','$status','$type')";
      $result = Connections::Connect()->query($sqlQuery);
      
      // files
      if($result)
          {
            $responseMessages=array("status"=>true,"response"=>"Successfully Registered the Username ".$username);
           move_uploaded_file($fileTempName,$uploadedFile);
          }
      else
      $responseMessages=array("status"=>false,"response"=>Connections::Connect()->error);

     echo  json_encode($responseMessages);
  }

  public static function update(){
  
    extract($_POST);
  
    $responseMessages=array();
    $sqlQuery="CALL update_user('$targetID','$username','$email','$type','$status')";
    $result = Connections::Connect()->query($sqlQuery);
    
    // files
    if($result)
        {
          $responseMessages=array("status"=>true,"response"=>"$username Has Been Successfully Updated");
        
        }
    else
    $responseMessages=array("status"=>false,"response"=>Connections::Connect()->error);

   echo  json_encode($responseMessages);
}

    public static function findUser(){
       
        extract($_POST);
        $responseMessages=array();
        $sqlQuery="select Username from users where Username='$target';";
        $result = Connections::Connect()->query($sqlQuery);
        if($result){
              if(mysqli_num_rows($result)>0)
                  $responseMessages=array("isExist"=>true,"RowsReturned"=>mysqli_num_rows($result));
              else
                 $responseMessages=array("isExist"=>false,"RowsReturned"=>mysqli_num_rows($result));
        }else
           $responseMessages=array("Status"=>false,"response"=>Connections::Connect()->error);

       echo  json_encode($responseMessages);
    }


    public static function deleteUser(){
       
      extract($_POST);
      $responseMessages=array();
      $sqlQuery="delete from users where USERID='$targetID';";
      $result = Connections::Connect()->query($sqlQuery);
      if($result){
           
               $responseMessages=array("Status"=>true,"responseMessage"=>"User That Has An ID - '$targetID' Was Successfully Removed... ");
      }else
         $responseMessages=array("Status"=>false,"response"=>Connections::Connect()->error);

     echo  json_encode($responseMessages);
  }

    public static function readOne(){
       
     
      $responseMessages=array();
      $sqlQuery="CALL readUsers();";
      $result = Connections::Connect()->query($sqlQuery);
      if($result){
            
        while($rows=$result->fetch_assoc()){
          $responseMessages[]=$rows;
          
        }
      }else
         $responseMessages=array("Status"=>false,"response"=>Connections::Connect()->error);

     echo  json_encode($responseMessages);
  }


    public static function findEmail(){
       
      extract($_POST);
      $responseMessages=array();
      $sqlQuery="select Email from users where Email='$target';";
      $result = Connections::Connect()->query($sqlQuery);
      if($result){
            if(mysqli_num_rows($result)>0)
                $responseMessages=array("isExist"=>true,"RowsReturned"=>mysqli_num_rows($result));
            else
               $responseMessages=array("isExist"=>false,"RowsReturned"=>mysqli_num_rows($result));
      }else
         $responseMessages=array("Status"=>false,"response"=>Connections::Connect()->error);

     echo  json_encode($responseMessages);
  }
}

?>