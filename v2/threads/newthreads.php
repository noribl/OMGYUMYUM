<?php
// ######################################################
// ## configuration
// ##
// ## $xml_file= 'http://www.vbulletin.com/forum/external.php?type=xml';
// ## Adjust this variable to point to your XML feed

$xml_file = 'http://www.omgyumyum.com/forums/external.php?type=xml&count=5';

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