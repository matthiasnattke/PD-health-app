<?php
    echo "<h3>Your Patient metadata overview</h3></br>";

    // load file or give exception
    $xml=simplexml_load_file("http://4me302-16.site88.net/getFilterData.php?parameter=User_IDpatient&value=3") or die("Error: Cannot create object");
    // discover all item in channel tree and display them
?>

<script src="//d3js.org/d3.v3.min.js"></script>

	<div id="a"><script type='text/javascript' src='js/xml.js'></script></div>

     <table>
    	<tr class="thead">
    		<th>Session ID</th>
    		<th>Therapy ID</th>
    		<th>Test ID</th>
    		<th>Date and Time</th>
    		<th>DataURL</th>
    	</tr>

    	<?php 
    	 foreach($xml->test_sessionID as $items) { 
    	 echo "<tr class=\'tbody\'>"; 
    	 echo "<td>".$items['id']."</td>";
    	 echo "<td>".$items->therapyID."</td>";
    	 echo "<td>".$items->testID."</td>";
    	 echo "<td>".$items->test_datetime."</td>";
     	 echo "<td>".$items->DataURL."</td>";
    	 echo "</tr>"; 
		} 
    	?>

    </table>

<?php
    
	// find metadata of the patient 1 exercise
	// date of exercise (Balkendiagram mit Tagen)
	//

    // integrates the YouTube playlist
    echo "<p>Here are some Parkinson´s exercises</p>";
    echo "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube-nocookie.com/embed/videoseries?list=PLD6l5HGahCtxor5uWHTU6aqxxMrWPntXd\" frameborder=\"0\" allowfullscreen></iframe>";
?>