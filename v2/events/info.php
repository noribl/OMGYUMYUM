<?PHP

  $weekly = new DOMDocument();
  $weekly->load( 'http://api.z33k.com/v1/tournaments/'.$bsgid.'.xml' );
	$tournaments = $weekly->getElementsByTagName( "tournament" );
	foreach( $tournaments as $tourny )
  {
	$urls = $tourny->getElementsByTagName( "full-url" );
	$url = $urls->item(0)->nodeValue;
	
	$names = $tourny->getElementsByTagName( "name" );
	$name = $names->item(0)->nodeValue;
	
	$ruless = $tourny->getElementsByTagName( "rules-html" );
	$rules = $ruless->item(0)->nodeValue;
	$rules = htmlspecialchars_decode($rules);
	$rules = strip_tags($rules, '<ul><li><br /><b><strong><br>');
	
	
	$times = $tourny->getElementsByTagName( "start-at-utc" );
	$time = $times->item(0)->nodeValue;
  
  	$weeklyinfo .= '
	<h2>'.$name.'</h2><br />
	<h3> Event Starts @: '.$time.'</h3>
	<a href="'.$url.'"><h3>Register Here </h3></a>
	<h3> Current Rule Set: </h3>
	<p style="text-align:left;">
	'.$rules.'
	</p>';
  }
unset($weekly, $weeklyinfo, $tournaments, $tourny, $urls, $url, $names, $name, $ruless, $rules, $times, $time);
 ?>