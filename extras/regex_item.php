<?php
$subject = $argv[1];

// Using % as delimiter
// Using 'i' flag to make the search case-insensitive
// Using 's' to represent any character with the dot

$pattern = '%(?P<item>[a-zA-Z]+)[\s,\./;:]*(?P<modifier>[+=\-]*)(?P<quantity>[0-9]+)[\s,\./;:]*%is';
//$pattern = '%(?P<item>[a-zA-Z]{3})[\s,\./;:]*(?P<modifier>[+=\-]*)(?P<quantity>[0-9]+)[\s,\./;:]*%is';

$offset = 0;
$matchesCount=-1;
$result = "";

$validItems = array('PTE','PZO','PZT','TEO','ZTO','ZTT');

$matchesCount=preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER, $offset);

for ( $i = 0; $i < $matchesCount; $i++ ) 
{
	if ( in_array(strtoupper($matches[$i]["item"]),$validItems) )
	{
		$result = " OK";
	}
	else
	{
		$result = "<=== INVALID ITEM";
	}

	printf("Item: %s, Modifiers: %s, Quantity, %f\t\t%s\n",$matches[$i]["item"],$matches[$i]["modifier"],$matches[$i]["quantity"],$result);

}

printf("Found %d matches, now we should go into working on each one, and reply to the user",$matchesCount);
?>

