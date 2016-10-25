<?php
    echo "<h3>API Test</h3></br>";

    // load file or give exception
    $xml=simplexml_load_file("http://4me302-16.site88.net/getFilterData.php?parameter=User_IDpatient&value=3") or die("Error: Cannot create object");
    // discover all item in channel tree and display them
?>

    <table>
    	<tr class="thead">
    		<th>Therapy ID</th>
    		<th>Test ID</th>
    		<th>Test_datetime</th>
    		<th>DataURL</th>
    	</tr>
    </table>


    foreach($xml->userID as $items) { 
    echo "<h3>$items</h3><br>"; 
    echo "<p>$items->Lat</p><br>"; 
	} 
?>