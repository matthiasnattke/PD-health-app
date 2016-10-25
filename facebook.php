<?php

// Facebook OAuth
include_once("libraries/Facebook/facebook.php"); //include facebook SDK
######### Facebook API Configuration ##########
$appId = '1774926422787659'; //Facebook App ID
$appSecret = 'ec3b361ac80a9943b79e01e82c605390'; // Facebook App Secret
$homeurl = 'https://lnu.couch-blog.de/assignment3/facebook.php';  //return to home
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret

));

ini_set('error_reporting', E_ALL);
$servername = "localhost";
$username = "lnu";
$password = "lnu2016";
$dbname = "lnu";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$fbuser = $facebook->getUser();

//include_once("includes/functions.php");
//destroy facebook session if user clicks reset
if(!$fbuser){
	$fbuser = null;
	$loginUrl = $facebook->getLoginUrl(array('redirect_uri'=>$homeurl,'scope'=>$fbPermissions));
	$output = '<a href="'.$loginUrl.'" class="button-green">Facebook</a>'; 	
}else{
	$user_profile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
    
	if(!empty($user_profile)){
        $_SESSION['in'] = 1;
        $_SESSION['name'] = $user_profile['first_name'] . " " .$user_profile['last_name'];
        $_SESSION['emailaddress'] = $user_profile['email'];
        $_SESSION['uid'] = $user_profile['id'];
        $_SESSION['Role'] = 'Patient';
        
    $checkuser = "SELECT UserID FROM users WHERE FacebookID =".$user_profile['id'];
    
    $result = mysqli_query($conn, $checkuser);
    $row = mysqli_fetch_assoc($result);
    
    $_SESSION['uid'] = $row['UserID'];
    
	//check if user exist in database using COUNT
    
    $sql = "SELECT COUNT(UserID) as usercount FROM users WHERE FacebookID = ".$user_profile['id']."";
    
	$result = $conn->query($sql);
	$user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist

	if($user_count) {       
        $sql = "UPDATE users SET Role='Patient', Username='".$user_profile['first_name']."".$user_profile['last_name']."', EmailAddress='".$user_profile['email']."' WHERE FacebookID='".$user_profile['id']."'";
    }
	else //else greeting text "Thanks for registering"
	{
        $sql = "INSERT INTO users (Username, FacebookID, EmailAddress, Role) VALUES('".$user_profile['first_name']."".$user_profile['last_name']."', '".$user_profile['id']."', '".$user_profile['email']."','Patient')";  
    }
        echo "<meta http-equiv=\"refresh\" content=\"0;index.php\">";
        mysqli_query($conn, $sql);   
	    

        
	}else{
		$output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
	}
}

    echo $output;
?>