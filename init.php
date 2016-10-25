<?php        
session_start();

//debug area
//error_reporting(E_ALL|E_STRICT);
//ini_set('display_errors', 1);


// global definition of database user data
$servername = "localhost";
$username = "lnu";
$password = "lnu2016";
$dbname = "lnu";

// Create global database connection
$conn = mysqli_connect($servername, $username, $password,$dbname);
// Check connection or giveout the exception
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Google OAuth
require_once ('libraries/Google/autoload.php');

//Insert your cient ID and secret 
$client_id = '422471985108-vpbhb4kl4v4auf7cdtjgnhu3f2q73hjc.apps.googleusercontent.com'; 
$client_secret = 'svF-70zsDbYMigqdJ-M2i2Va';
$redirect_uri = 'https://lnu.couch-blog.de/assignment3/index.php';

//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


?>