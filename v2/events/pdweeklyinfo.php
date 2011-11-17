<?PHP
	include ("upcomingevents.php");
	if ($pdid != ''){
		$weekly = new DOMDocument();
		$weeklyurl = 'http://api.z33k.com/v1/tournaments/'.$pdid.'.xml';
		$weekly->load( $weeklyurl );
		$tournaments = $weekly->getElementsByTagName( "tournament" );
		foreach( $tournaments as $tourny ){
			$urls = $tourny->getElementsByTagName( "full-url" );
			$url = $urls->item(0)->nodeValue;
			
			$names = $tourny->getElementsByTagName( "name" );
			$name = $names->item(0)->nodeValue;
			
			$ruless = $tourny->getElementsByTagName( "rules-html" );
			$rules = $ruless->item(0)->nodeValue;
			$rules = htmlspecialchars_decode($rules);
			$rules = strip_tags($rules, '<ul><li><br /><b><strong><br><p>');
			
			
			$times = $tourny->getElementsByTagName( "start-at" );
			$time = $times->item(0)->nodeValue;
			$time1 = date('D M d, Y',$time).' at ';
			$time2 = date('g:i A', $time).' EST';
			$time = $time1.$time2;
			
			$weeklyinfo .= '
			<h2>OMGYUMYUM\'s Platinum & Diamond Weekly Tournament</h2>
			<h3> Event Starts @: '.$time.'</h3>
			<h2 style="text-align:center";><a href="'.$url.'">>> Register Here</a> | <a href="http://www.omgyumyum.com/forums/showthread.php?t=415" target="_blank">Discuss <<</a></h2>
			<h3>Current Information: </h3>
			<p style="text-align:left;">
			'.$rules.'
			</p>';
		}
	}
	else{
		$weeklyinfo .='<h2>OMGYUMYUM\'s Platinum and Diamond Weekly Tournament</h2>
		<h3>Currently, there is no weekly tournament scheduled.  Please check back later</h3>
		<h2 style="text-align:center";><a href="http://www.omgyumyum.com/forums/showthread.php?t=415" target="_blank">>> Discuss <<</a></h2>';
	}
unset($weekly, $weeklyurl, $tournaments, $tourny, $urls, $url, $names, $name, $ruless, $rules, $times, $time, $time1,$time2);
 ?>