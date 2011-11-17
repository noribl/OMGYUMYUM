<a href="#" class="closepopup"><img src="images/v2/popup_close.png" class="btn_close" title="Close Window" alt="Close"></a>
<h3 style="text-align:center; margin:0;">Current Offline Streams</h3>
<?PHP
require ("internal/server.php");
mysql_select_db("omgyydatabase", $rodb);

$offlineoutput .='';
$result = mysql_query("SELECT forumname, twitchtv FROM `livestreams`, `memberslist` WHERE (`livestreams`.`online` =0) AND (livestreams.id = memberslist.id)");

	while($row = mysql_fetch_array($result)){
		$offlineoutput .=' <a href="http://www.twitch.tv/'.$row['twitchtv'].'">'.$row['forumname'].'</a> <br />';
	}
	echo $offlineoutput;
mysql_close($rodb);
unset($rodb,$result,$row);
?>
