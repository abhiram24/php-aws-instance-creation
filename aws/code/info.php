<?php

use Aws\Ec2\Ec2Client;

function getInfoAboutAWS($key, $secret){

  require '../vendor/autoload.php';

  $getInfoResult = array();

  $ec2Client = Ec2Client::factory(array(
      'version' => 'latest',
      'region' => 'us-west-2',

      'credentials' => array(
        'key' => $key,
        'secret' => $secret,
    ),
    ));

  $getInfoResult = array();
  $result = $ec2Client->DescribeInstances();

  $reservations = $result['Reservations'];
  foreach ($reservations as $reservation) {
    $instances = $reservation['Instances'];
    foreach ($instances as $instance) {
      if ($instance['State']['Name'] ==  'running') {
        $getInfoResult[] = array("current_state" =>  $instance['State']['Name'], "public_ip_Address" => $instance['PublicIpAddress'], "private_ip_address" => $instance['PrivateIpAddress']);
    }
  }

}
  return $getInfoResult;
}
?>
