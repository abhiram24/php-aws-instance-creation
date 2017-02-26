# php-fries

* PHP 7.0.10 and AWS PHP SDK 3.19 are used for getting this task completed
* No sessions have been used, hence no load on the server
* For SSH "phpseclib1.0.3", which is a pure PHP solution is used. [This needs to be downloaded https://sourceforge.net/projects/phpseclib/ and the same path needs to be configured in line #5 of "createUser.php", this is hard-coded.]
* All settings related to AWS needs to be done in "settings.php" file.
* The current version of AWS PHP SDK does not support for "waitUntilInstanceRunning" hence a hard wait has been used in "createInstance.php".
* To get this working, just unzip the folder inside your Apache or Nginx. (PHP.ini settings related to SSL needs to be uncommented).
* Basic validations have been provided, but much more can be done.

# What does this code do for end-user?

* Use POSTMAN or CURL or any HTTP request tool and pass the username and password as POST parameter like shown below:
        ** http://localhost:8888/aws/<project_name>
        ** form-data
          *** username: abhiram
          *** password: cool123
* Once submitted:
    ** Firstly a AWS t2 Micro Instance is created and a private key for the same is downloaded in your box
    ** Once (a) is successfully completed, the code gets more info about your instance like public IP, private IP etc..
    ** Information from (b) is passed to then automatically create username and password on the instance created by (1)
    ** All the information is then posted as JSON response back to user.

#Thanks

* Thanks for amazing community and Doc support from Amazon. Without https://aws.amazon.com/blogs/developer/provision-an-amazon-ec2-instance-with-php/ it would not have been possible
