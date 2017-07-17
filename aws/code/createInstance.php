<?php

use Aws\Ec2\Ec2Client;

function createAWSInstance($username, $password){

  require '../vendor/autoload.php';
  include('../config/settings.php');
  include('info.php');
  include('createUser.php');

  $instanceResult = array();
  $finalResult = array();
  $json = array();

  $ec2Client = Ec2Client::factory(array(
      'version' => 'latest',
      'region' => 'us-west-2',

      'credentials' => array(
        'key' => $key,
        'secret' => $secret,
    ),

    ));

    $result = $ec2Client->createKeyPair(array(
        'KeyName' => $keyPairName
    ));

    $saveKeyLocation = getenv('HOME') . "/.ssh/{$keyPairName}.pem";
    file_put_contents($saveKeyLocation, $result['KeyMaterial']);

    chmod($saveKeyLocation, 0600);

    $result = $ec2Client->createSecurityGroup(array(
      'GroupName'   => $securityGroupName,
      'Description' => 'Example exercise security'
  ));

  $securityGroupId = $result->get('GroupId');

  $ec2Client->authorizeSecurityGroupIngress(array(
      'GroupName'     => $securityGroupName,
      'IpPermissions' => array(
          array(
              'IpProtocol' => 'tcp',
              'FromPort'   => 80,
              'ToPort'     => 80,
              'IpRanges'   => array(
                  array('CidrIp' => '0.0.0.0/0')
              ),
          ),
          array(
              'IpProtocol' => 'tcp',
              'FromPort'   => 22,
              'ToPort'     => 22,
              'IpRanges'   => array(
                  array('CidrIp' => '0.0.0.0/0')
              ),
          )
      )
  ));

  $result = $ec2Client->runInstances(array(
    'ImageId'        => $ImageId,
    'MinCount'       => 1,
    'MaxCount'       => 1,
    'KeyName'        => $keyPairName,
    'SecurityGroups' => array($securityGroupName),
    'InstanceType'   => $InstanceType
  ));

  $instanceResult = array("instance_created" => "true");

  sleep(350);

  $infoResult = getInfoAboutAWS($key, $secret);

  $ip = $infoResult[0]['public_ip_Address'];
  $createUserResult = createUserOnAWS($ip, $username, $password, $keyPairName);

  $json = array("status" => "0", "AWS_instance_message" => $instanceResult, "AWS_instance_details" => $infoResult, "AWS_user_details" => $createUserResult);

  return $json;

}
 ?>
