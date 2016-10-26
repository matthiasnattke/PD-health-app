   <h2>Discussion about data</h2>

   <p>Write some comments to annotate the diagrams of your patient.</p>
     
    <form method="post" action="index.php" name="registerform" id="registerform">
    <fieldset>
        <textarea name="comment" rows="10" cols="100"></textarea>
        <input class="button-blue" type="submit" name="sent" id="sent" value="Sent" />
    </fieldset>
    </form>

  <?php 
    	
    	$sql = "SELECT * FROM feedback";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
	
	date_default_timezone_set('UTC');
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	    	$time = date('l jS \of F Y \a\t G:i:s', strtotime($row["time"]));
	        echo "<h3>You on ".$time."</h3> <p>".$row["message"]."</p><br>";
	    }
	} 

        if(!empty($_POST['comment'])) {
     
            $sql = "SELECT * FROM feedback";
                
                $sql = "INSERT INTO feedback (user, message) VALUES('1', '".$_POST["comment"]."')";
                mysqli_query($conn, $sql);
                          
             }
            

    echo "<h2>Latest news in PHD research</h2></br>";

    // load file or give exception
    $xml=simplexml_load_file("http://www.news-medical.net/tag/feed/Parkinsons-Disease.aspx") or die("Error: Cannot create object");
    // discover all item in channel tree and display them
    foreach($xml->channel->item as $items) { 
    echo "<h3><a href=\"".$items->link."\">".$items->title."</a></h3><br>"; 
    echo "<p>$items->description</p><br>"; 
    } 
?>