<?php
  include('createInstance.php');

  $result = array();
  $json = array();

  $username = trim($_POST['username']);

  error_log($username);

  $password = trim($_POST['password']);

  if ( (strlen($username) == 0) or (strlen($password) == 0) ){
    $result[] = array("error" => "invalid parameters");
    $json = array("status" => "1", "message" => $result);

    header('Content-type: application/json');
    echo json_encode($json);
  }
  else {

    $json = createAWSInstance($username, $password);
    header('Content-type: application/json');
    echo json_encode($json);
  }



?>
