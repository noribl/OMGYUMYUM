<?php
unset ($xml_output,$date,$time,$author);
// ######################################################
// ## configuration
// ##
// ## $xml_file= 'http://www.vbulletin.com/forum/external.php?type=xml';
// ## Adjust this variable to point to your XML feed
$xml_file = 'http://www.omgyumyum.com/forums/external.php?type=xml&forumids=2,41,30,72&count=5';

// ## configuration end
// ######################################################


$is_item = false;
$tag = '';
$title = '';
$description = '';
$link = '';
$n = 0;

$url_array = parse_url($xml_file);
$filename = strrchr($url_array['path'], '/');
$realpath = substr($url_array['path'], 0, (strlen($url_array['path']) - strlen($filename)));
$forumlink = $url_array['scheme'] . '://' . $url_array['host'] . $realpath . '/showthread.php?t=';

function character_data($parser, $data)
{
    global $is_item, $tag, $title, $author, $date, $time;
    if ($is_item)
    {
        switch ($tag)
        {
            case "TITLE":
                $title .= $data;
            break;
            
            case "AUTHOR":
                $author .= $data;
            break;
            
            case "DATE":
                $date .= $data;
            break;
            
            case "TIME":
                $time .= $data;
            break;
        }
    }
}

function begin_element($parser, $name, $attribs)
{
    global $is_item, $tag, $attribute;
    if ($is_item)
    {
        $tag = $name;
    }
    else if ($name == "THREAD")
    {
        $is_item = true;
        $attribute = $attribs[ID];
    }
}

function end_element($parser, $name)
{
    global $is_item, $title, $author, $date, $time, $xml_output, $attribute, $forumlink;
    if ($name == "THREAD")
    {
        $description = "By " . $author . " on " . $date . " at " . $time;
        $xml_output .= "<div class='threaddiv'><a href='" . $forumlink . $attribute . "'>" . htmlspecialchars(trim($title)) . "</a><br />
		<div class='small'>" . htmlspecialchars(trim($description)) . "</div></div><div class='threadlist'></div>";
        $title = "";
        $author = "";
        $date = "";
        $time = "";
        $attribute = "";
        $is_item = false;
    }
}

$parser = xml_parser_create();

xml_set_element_handler($parser, "begin_element", "end_element");
xml_set_character_data_handler($parser, "character_data");
$fp = fopen($xml_file,"r");

while ($data = fread($fp, 4096))
{
    xml_parse($parser, $data, feof($fp));
}

fclose($fp);
xml_parser_free($parser);
?>