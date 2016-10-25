<?php
    // checks in session and gets rolebased content or login interface
    if(!empty($_SESSION['in'])) {

     echo "<h1>Member Area</h1>";
     echo "<p>Thanks for logging in! You are <code>".$_SESSION['name']."</code>.<br /> or <a href=\"logout.php\">logout</a>.</p>";
        
    $sql = "SELECT Role FROM users WHERE UserID =".$_SESSION['uid'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    // What role are you and which content is the right?
    switch ($_SESSION['Role']) {
     
        case Patient: 
            include "patient.php";
            break;
            
        case Researcher:
            include "map.php";
            include "physician.php"; 
            include "researcher.php";
            break;
            
        case Physician: 
            include "physician.php";
            break;
                  
        default: echo "<p>Oh no! You have no role and so you get no content, please <a href=\"index.php\">go back</a> or contact administrator for allocation.</p>";
    }
        
    } elseif(!empty($_POST['username']) && !empty($_POST['password'])) {
        
        // reads username and password (as md5 hash value)
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = md5(mysqli_real_escape_string($conn,$_POST['password']));
     
        $sql = "SELECT * FROM users WHERE Username = '".$username."' AND Passwort = '".$password."'";
        
        // is there a user / password combination?
        if(mysqli_num_rows(mysqli_query($conn, $sql)) == 1) {
        
            $row = mysqli_fetch_array($sql);
            
            // then save username, UserID and that you are member in sessions
            $_SESSION['name'] = $username;
            $_SESSION['in'] = 1;
            $_SESSION['uid'] = $row['UserID'];
         
            echo "<h1>Welcome!</h1>";
            echo "<p>Thanks for logging in!</p>";
            echo "<meta http-equiv=\"refresh\" content=\"1;index.php\">";
            
        } else {

            echo "<h2>Error</h2>";
            echo "<p>Sorry, your account don´t exist. Please <a href=\"index.php\">go back</a>.</p>";
        }
        
    } else {
        
?>
        <h1>Login</h1>
        <p>Please Login or <a href="register.php">register</a>.</p>
        <form method="post" action="index.php" name="loginform" id="loginform">
            <fieldset>
                <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
                <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
                <input type="submit" class="button-blue" name="login" id="login" value="Login" />
            </fieldset>
        </form>
        <?php 
        include "google.php"; 
        echo '<a class="button-yellow white" href="twitter.php">Twitter</a>'; 
        include "facebook.php";
         


}
?>       