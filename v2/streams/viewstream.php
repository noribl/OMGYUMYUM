<?PHP
require ("internal/server.php");
include("internal/functions.php");
mysql_select_db("omgyydatabase", $m);

$result = mysql_query("SELECT * FROM `livestreams`, `memberslist` WHERE (`livestreams`.`online` =1) AND (livestreams.id = memberslist.id) ORDER BY livestreams.viewers DESC");
	if (mysql_num_rows($result) == 0){
				$streamoutput ='		
		<div class="title"><span class="nav twitter"></span></div>
        <div id="livestreams"  style="white-space:inherit; font-size: small;width:312px">
			<strong class="small" style="margin-bottom:5px">Latest Tweets - <a href="http://www.twitter.com/omgyumyum">Follow us @OMGYUMYUM</a></strong><br />
			<div class="threecolsep"></div>';
			
			if(!file_exists("./twitter/tweets.txt"))
			  {
			  die("File not found");
			  }
			else
			  {
				  $file = './twitter/tweets.txt';
				  $streamoutput .= file_get_contents($file);
			  }
		$streamoutput .='<div style="text-align:center;padding-top:2px;margin-left:-25px;height:100%;"><strong class="small"><a href="http://www.twitter.com/omgyumyum">View More Tweets</a></strong></div></div>';
	}
	else{
		$streamoutput .='
		<div class="title"><span class="nav livestreams"></span></div>
		<div id="livestreams" >
		<strong class="small" style="margin-bottom:5px">Current Online Streams</strong><br />
		<div class="threecolsep"></div>
		<div id="overflow" style="overflow:scroll;max-height:176px;overflow-x:hidden;overflow-y:auto;">';
		while($row = mysql_fetch_array($result)){
			$row['caption'] = view_safe($row['caption']);
			$row['game'] = view_safe($row['game']);
			if (($row['id'] == 9999) && ($row['online'] == 1)){
				$streamoutput .='
				<a href="http://www.twitch.tv/'.$row['twitchtv'].'" target="_blank" title="'.$row['caption'].'">'.$row['forumname'].'</a><br />
				<div class="small" style="padding-right:12px;float:right">'.$row['viewers'].' viewers</div>
				<div class="small">Title: <acronym title="'.$row['caption'].'">'.substr($row['caption'],0,40).'</acronym></div>
				<div class="threecolsep"></div>';
			}else{
				if ($row['game'] == 'StarCraft II: Wings of Liberty'){	$sc2rr = ' - '.$row['rank'].' '.$row['race']; $row['game'] = 'Starcraft II'; $name = '('.$row['battlenet'].')';	}
				if ($row['game'] == 'League of Legends'){	$sc2rr = ' - '.$row['lolrank']; $name = '('.$row['lolname'].')';	}
				$streamoutput .='
					<div style="float:left;width:321px;margin-bottom:3px;">
					<div class="crop"><a href="http://www.twitch.tv/'.$row['twitchtv'].'" target="_blank"><img src="http://static-cdn.jtvnw.net/previews/live_user_'.$row['twitchtv'].'-150x113.jpg" width="115px" height="64px" alt="'.$row['caption'].'" /></a></div>
					<div style="display: inline-block; line-height: 0.9em; margin: 0pt 0px 0pt 5px;" id="singlestream">
					<a href="http://www.twitch.tv/'.$row['twitchtv'].'" target="_blank" title="'.$row['caption'].'"><strong>'.$row['forumname'].'</strong></a> <small style="line-height:.7;">'.$name.'</small>
						<div class="small" style="display:block;font-size:.8em;">
						' .$row['game'].''.$sc2rr.' <br />
						Title: <acronym title="'.$row['caption'].'">'.substr($row['caption'],0,29).'</acronym><br />
						<div style="background-image: url(\'http://www-cdn.jtvnw.net/images/xarth/g/g18_live_viewers.png\');background-position: -2px -1px; width:16px; height:14px; background-repeat:no-repeat;padding-left:20px;line-height:2em;"> '.$row['viewers'].'</div>  
						</div>
					</div>
				</div>
				<div class="overflowsep"></div>';
				unset($sc2rr, $row,$name);
			}
		}
		$streamoutput .= '</div><div class="threecolsep"></div><div style="text-align:center;padding-top:2px;"><strong class="small"><a href="#?w=321" rel="offlinestreams" class="poplight" id="loadoff">Show Offline Streams</a></strong></div></div>';
	}
	mysql_close($m);
unset($result,$row);
?>