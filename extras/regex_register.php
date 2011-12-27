<?php
$subject = $argv[1];

// Using % as delimiter
// Using 'i' flag to make the search case-insensitive
// Using 's' to represent any character with the dot
// "MDA" is hardcoded. It should be var

$pattern = '%MDA[\s\.\,;:/]*(?P<name>[\D]+)(?P<facility>[0-9]+)%is';

//%(?P<item>[a-zA-Z]{3})[\s,\./;:]*(?P<modifier>[+=\-]*)(?P<quantity>[0-9]+)[\s,\./;:]*%is';

$offset = 0;
$matchesCount=-1;
$result = "";

$matchesCount=preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER, $offset);

for ( $i = 0; $i < $matchesCount; $i++ ) 
{
	printf("Name: %s, Facility: %d\n",$matches[$i]["name"],$matches[$i]["facility"]);

}

printf("Found %d matches, now we should go into working on each one, and reply to the user",$matchesCount);
?>

