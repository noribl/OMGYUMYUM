<?PHP
require ("../internal/server.php");
require("../internal/functions.php");
//connect to database
//select omgyy database
mysql_select_db("omgyydatabase", $m);

//find streams with a twitchtv account on the members list
$result = mysql_query("SELECT * FROM `memberslist` WHERE `twitchtv` REGEXP '[a-z]'");

$s=0;
//each row of a member with a twitchtv acct.
while($row = mysql_fetch_array($result))
	{
	  	//save id,twitchtv,and forumname of row
		$sids[$s] = $row['id'];
		$twitchid[$sids[$s]] = $row['twitchtv'];
		$twitchid[$sids[$s]] = strtolower($twitchid[$sids[$s]]);
		//technically don't need this, but keep it here for future reference
		$lsname[$sids[$s]] = $row['forumname'];
		$s++;
	}
	$fullstream = implode(",",$twitchid);
	//check all the streams if they are online or not
	$streamxml = new DOMDocument();
	$xml = 'http://api.justin.tv/api/stream/list.xml?channel='.$fullstream;
	$streamxml->load( $xml );

		$streamss =  $streamxml->getElementsByTagName( "stream" );
		foreach( $streamss as $streams ){
			$idnames = $streams->getElementsByTagName( "login" );
			$idname = $idnames->item(0)->nodeValue;
			$idname = strtolower($idname);
			$idREF = array_search($idname, $twitchid);
			if ($idREF != NULL){    
				$titles = $streams->getElementsByTagName( "title" );
				$title[$idREF] = $titles->item(0)->nodeValue;
				
				$games = $streams->getElementsByTagName( "meta_game" );
				$game[$idREF] = $games->item(0)->nodeValue;
				
				$viewerss = $streams->getElementsByTagName( "channel_count" );
				$viewers[$idREF] = $viewerss->item(0)->nodeValue;
				
				$online[$idREF] = 1;
			}			
		}
		unset($streamxml,$streamss,$games, $viewerss,$titles);
		sleep(10);
sleep(2);

//dump all the contents into the livestream table
foreach ($sids as $x){
	echo $online[$x];
	$m;
mysql_select_db("omgyydatabase", $m);

	echo '<br />';
	$query = "SELECT * FROM `omgyydatabase`.`livestreams` WHERE id=".$x."";
	//run the query
	$rs =  mysql_query ($query,$m) or die(mysql_error());
	$title[$x] = make_safe($title[$x]);
	$game[$x] = make_safe($game[$x]);
	//now either insert or update depending on how many rows were returned in $rs
	if(mysql_num_rows($rs) == 1) {  //member exists, update.
		$query = "UPDATE `omgyydatabase`.`livestreams` SET name='".$lsname[$x]."',game='".$game[$x]."', online='".$online[$x]."', caption='".$title[$x]."', viewers='".$viewers[$x]."' WHERE id=".$x."";
	echo $query;
	} 
	else {  //member doesn't exist
		$query = "INSERT INTO `omgyydatabase`.`livestreams` (id,name,game,online,caption,viewers) VALUES ('".$x."','".$lsname[$x]."','".$game[$x]."','".$online[$x]."','".$title[$x]."','".$viewers[$x]."')";
	}
	$rs = mysql_query($query, $m);
}	
mysql_close($m);
?>