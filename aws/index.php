<?php
// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';

echo "Creating a T2 instance !!!!<br>";

$s3 = new Aws\EC2\EC2Client([
    'version' => 'latest',
    'region'  => 'us-east-1'
]);

echo "Instance created, check and confirm";
?>
