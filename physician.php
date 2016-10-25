<script type="text/javascript" src="js/script.js"></script>

<?php
    
    $xml=simplexml_load_file("http://4me302-16.site88.net/getFilterData.php?parameter=User_IDpatient&value=3") or die("Error: Cannot create object");

    echo "<h2>Data section</h2>";
    echo "<p>Here are the data from <code>patient 1</code> </br>feel free to flipp over the points on diagram</p>";

   	foreach($xml->test_sessionID as $items) { 
	echo "<div id=\"a\"><script type=\"text/javascript\">importCSV('$items->DataURL.csv');</script></div>";
	} 

?>

