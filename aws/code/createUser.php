<?php

function createUserOnAWS($ip, $username, $password, $keyPairName) {

  set_include_path(get_include_path() . PATH_SEPARATOR . '/Users/landmark/Downloads/phpseclib1.0.3');
  include('Net/SSH2.php');
  include('Crypt/RSA.php');

  $createUserResult =  array();
  $key = new Crypt_RSA();
  $key->loadKey(file_get_contents(getenv('HOME') . "/.ssh/$keyPairName.pem"));

  $ssh = new Net_SSH2($ip);
  if (!$ssh->login('ec2-user', $key)) {
      $createUserResult[] = array("user_creation_status" => "failure", "message" =>"Login issues", "username" => $username);
  }

  if (!$ssh->exec("sudo useradd -p $password $username")) {
    $createUserResult[] = array("user_creation_status" => "success", "username" => $username);
  }
  else {
    $createUserResult[] = array("user_creation_status" => "failure", "username" => $username);
  }
    return $createUserResult;
}


?>
