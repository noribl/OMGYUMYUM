<?PHP
date_default_timezone_set('America/New_York');
  $doc = new DOMDocument();
  $doc->load( 'http://api.z33k.com/v1/groups/omgyumyumweekly.xml' );
  
  $livetournaments =  $doc->getElementsByTagName( "live-tournament" );
   foreach( $livetournaments as $tourny )
  {
	$ids = $tourny->getElementsByTagName( "id" );
	$id = $ids->item(0)->nodeValue;
	
	$names = $tourny->getElementsByTagName( "name" );
	$name = $names->item(0)->nodeValue;
	
	$playerss = $tourny->getElementsByTagName( "players-active-registered" );
	$players = $playerss->item(0)->nodeValue;
	
	if (preg_match("/\bBronze-Silver-Gold\b/i", $name)) {
    	$weekly = 'weekly';
		$weeklyid = $id;
	} else {
    	$weekly = 'pdweekly';
		$pdid = $id;
		
	}
	
	$bottombrackets .= '<div id="z33k_bracket_embed_'.$id.'" data-width="1000" data-height="600" class="popup_block" style="background-color:#fff"></div>
	<script type="text/javascript" src="http://www.z33k.com/starcraft2/tournaments/'.$id.'.js"></script>';
  
  	$output .= '<strong class="small" style="margin-bottom:5px">>> Live Tournaments <<</strong><br />
        	<div class="threecolsep"></div><div class="threecolsep"></div>
			<a href="/#'.$weekly.'">'.$name.'</a>
		<div class="small" style="padding-right:12px;float:right"><strong><a href="#'.$weekly.'">More Info</a> | <a href="#?w=1000" rel="z33k_bracket_embed_'.$id.'" class="poplight"><strong style="color:#FF0000">Brackets & Report Matches</strong></a></strong></div><br />
	<div class="small">'.$players.' signups <strong style="color:#FF0000">(LIVE)</strong></div>
	<div class="threecolsep"></div><div class="threecolsep"></div><strong class="small" style="margin-bottom:5px">Upcoming Tournaments</strong><div class="threecolsep"></div>';
  }
  unset($tourny);
  $uptournaments = $doc->getElementsByTagName( "upcoming-tournament" );
  foreach( $uptournaments as $tourny )
  {
	$ids = $tourny->getElementsByTagName( "id" );
	$id = $ids->item(0)->nodeValue;
	
	$names = $tourny->getElementsByTagName( "name" );
	$name = $names->item(0)->nodeValue;
	
	$playerss = $tourny->getElementsByTagName( "players-active-registered" );
	$players = $playerss->item(0)->nodeValue;
	
	$times = $tourny->getElementsByTagName( "start-at" );
	$time = $times->item(0)->nodeValue;
	$time1 = date('D M d, Y',$time).' @ ';
	$time2 = date('g:i A', $time).' EST';
	$time = $time1.$time2;
	
	if (preg_match("/\bBronze-Silver-Gold\b/i", $name)) {
    	$weekly = 'weekly';
		$weeklyid = $id;
		$icon = '<img src="images/leagueicon/BronzeMedium.png" width="11px" height="13px" alt="B"/><img src="images/leagueicon/SilverMedium.png" width="11px" height="13px" alt="S"/><img src="images/leagueicon/GoldMedium.png"  width="11px" height="13px" alt="G"/>';
		$share = '
		<script type="text/javascript">
		reddit_url="http://www.omgyumyum.com/weekly";
		</script>
		<script type="text/javascript" src="http://www.reddit.com/static/button/button1.js"></script>';
	} else {
    	$weekly = 'pdweekly';
		$pdid = $id;
		$icon = '<img src="images/leagueicon/PlatinumMedium.png" width="11px" height="13px" alt="P"/><img src="images/leagueicon/DiamondMedium.png" width="11px" height="13px" alt="D"/>';
		$share = '
		<script type="text/javascript">
		reddit_url="http://www.omgyumyum.com/pdweekly";
		</script>
		<script type="text/javascript" src="http://www.reddit.com/static/button/button1.js"></script>';

	}
  	$output .= '	'.$icon. ' <a href="/#'.$weekly.'">OMGYY\'s '.substr($name,12).'</a>
		<div class="small" style="padding-right:12px;float:right"><strong><a href="#'.$weekly.'">More Info</a> | <a href="http://www.z33k.com/starcraft2/tournaments/'.$id.'">Sign Up</a></strong></div><br />
	<div class="small" style="margin-bottom:5px;">'.$players.' signups ('.$time.')</div>
	<div>'.$share.'</div>	
	<div class="threecolsep"></div>';
  }
  $icon = '';
 ?>