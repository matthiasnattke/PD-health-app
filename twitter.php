<?php
include_once("init.php");
include_once("libraries/Twitter/twitteroauth.php");

define('CONSUMER_KEY', 'GL0WA4orZPTvQbPQY4FmHlkRe');
define('CONSUMER_SECRET', 'BtXyq8LrbNooKlvvQcAtTRfsL6v29fVRUMXoVFvu8uxVmxoXHz');
define('OAUTH_CALLBACK', 'https://lnu.couch-blog.de/assignment3/twitter.php');

if(isset($_REQUEST['oauth_token']) && $_SESSION['token']  !== $_REQUEST['oauth_token']) {

	//If token is old, distroy session and redirect user to index.php
	session_destroy();
	header('Location: index.php');
	
} elseif (isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']) {

	//Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	if($connection->http_code == '200')
	{
		//Redirect user to twitter
		$_SESSION['status'] = 'verified';
        $_SESSION['in'] = 1;
		$_SESSION['request_vars'] = $access_token;
        $_SESSION['Role'] = 'Physician';
    
	//check if user exist in database using COUNT 
		
		//Insert user into the database
		$user_info = $connection->get('account/verify_credentials'); 
        $_SESSION['name'] = $user_info->screen_name;
        
        $checkuser = "SELECT UserID FROM users WHERE TwitterID = $user_info->id";
    
        $result = mysqli_query($conn, $checkuser);
        $row = mysqli_fetch_assoc($result);
    
        $_SESSION['uid'] = $row['UserID'];
		
		//Unset no longer needed request tokens
		unset($_SESSION['token']);
		unset($_SESSION['token_secret']);
		header('Location: index.php');
	}else{
		die("error, try again later!");
	}
    
        $sql = "SELECT COUNT(UserID) as usercount FROM users WHERE TwitterID = $user_info->id";
    

} else {

	if(isset($_GET["denied"]))
	{
		header('Location: index.php');
		die();
	}

	//Fresh authentication
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
	
	//Received token info from twitter
	$_SESSION['token'] 			= $request_token['oauth_token'];
	$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];
	
	// value 200 is true, everthing else is an error
	if($connection->http_code == '200')
	{
		//it´s time to redirect the user to twitter
		$twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
		header('Location: ' . $twitter_url); 
	}else{
		die("No no no! Error connecting to twitter! Try again later!");
	}
}
?>

