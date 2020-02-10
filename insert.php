<?php
$Name = $_POST['Name'];
//echo $Name;
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];
$Message = $_POST['Message'];

if(!empty($Name) || !empty($Phone) || !empty($Email) || !empty($Message))
{
  $host = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbname = "register";
  $conn = new mysqli($host ,$dbUsername ,$dbPassword ,$dbname);

  if(mysqli_connect_error())
  {
    die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
  }else {
    $SELECT = "SELECT Email FROM contacts Where Email = ? Limit 1";
    $INSERT = "INSERT Into contacts(Name,Phone,Email,Message) values(?,?,?,?)";

    //Prepare statement

    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s",$Email);
    //print_r($Name+$Phone+$Email+$Message);
    $stmt->execute();
    $stmt->bind_result($Email);
    $stmt->store_result();
    $rnum = $stmt->num_rows;
    

    if($rnum == 0)
    {
      $stmt->close();
      $stmt = $conn-> prepare($INSERT);
      $stmt->bind_param("siss",$Name,$Phone,$Email,$Message);
      $stmt->execute();
      header('Location: contact.html');


    }else {
      echo "Someone already register using these email";
      header('Location: contact.html');
    }

    $stmt->close();
    $conn->close();


  }

}else {
  echo "All Fields Required";
  die();
}

 ?>
