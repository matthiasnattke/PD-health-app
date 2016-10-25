<?php //Display user info or display login url as per the info we have.
echo '<div>';
if (isset($authUrl)){ 
	//show login url
	//echo '<div align="center">';
	echo '<a class="login button-red" href="'.$authUrl.'">Google</a>';
	//echo '</div>';
	
} else {
	$user = $service->userinfo->get(); //get user info 
    $_SESSION['in'] = 1;
    $_SESSION['name'] = $user->name;
    $_SESSION['emailaddress'] = $user->email;
    $_SESSION['Role'] = 'Researcher';
    
    $checkuser = "SELECT UserID FROM users WHERE GoogleID = $user->id";
    
    $result = mysqli_query($conn, $checkuser);
    $row = mysqli_fetch_assoc($result);
    
    $_SESSION['uid'] = $row['UserID'];
    
	//check if user exist in database using COUNT
    
    $sql = "SELECT COUNT(UserID) as usercount FROM users WHERE GoogleID = $user->id";
    
	$result = $conn->query($sql);
	$user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
	
	if($user_count) //if user already exist change greeting text to "Welcome Back"
    {       
        echo "<p> schon da </p>";
        $sql = "UPDATE users SET Role='Researcher', Username='".$user->name."', EmailAddress='".$user->email."' WHERE GoogleID='".$user->id."'";
    }
	else //else greeting text "Thanks for registering"
	{
        echo "<p> neu </p>";
        $sql = "INSERT INTO users (Username, GoogleID, EmailAddress, Role) VALUES('".$user->name."', '".$user->id."', '".$user->email."','Researcher')";  
    }
        
                mysqli_query($conn, $sql);
	    echo "<meta http-equiv=\"refresh\" content=\"0;index.php\">";

}
echo '</div>';
        
?>