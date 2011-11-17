<?PHP
		$doc = new DOMDocument();
  		$doc->load( 'https://api.twitter.com/1/statuses/user_timeline.xml?&include_rts=true&screen_name=omgyumyum&count=3' );
  
  $tweets =  $doc->getElementsByTagName( "status" );
   foreach( $tweets as $tweet )
  {
	$ids = $tweet->getElementsByTagName( "id" );
	$id = $ids->item(0)->nodeValue;
	
	$dates = $tweet->getElementsByTagName( "created_at" );
	$date = $dates->item(0)->nodeValue;
	
	$texts = $tweet->getElementsByTagName( "text" );
	$text = $texts->item(0)->nodeValue;
	$text = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\">\\0</a>", $text);
	
	$sources = $tweet->getElementsByTagName( "source" );
	$source = $sources->item(0)->nodeValue;
	
	
	$streamoutput .='
	<img src="images/tweet.png" alt="Tweet" style="float:left;margin:0px 5px 0px -5px;"/>'.$text.'<br />
                    <div class="small">'.substr($date,0,10).' from '.$source.' - <a href="https://twitter.com/#!/omgyumyum/statuses/'.$id.'" target="_self">Retweet / Reply</a></div>
                    <div class="threecolsep"></div>
	';
  }
$tweetsFile = "tweets.txt";
$tf = fopen($tweetsFile, 'w') or die("can't open file");
fwrite($tf, $streamoutput);
fclose($tf);
unset($doc,$tweets,$tweet,$ids,$id,$dates,$date,$texts,$text,$sources,$source,$streamoutput);
  ?>
