$contents = file_get_contents('./input.txt');
$accumulator = [];
$total = 0;
$bag = [];

if ($contents == false) 
{
	echo "error reading the file";
	return;
}

$contents = explode("\n", $contents);

foreach ($line in $contents) {
  $trimmed = trim($line);

	if (empty($trimmed) == false) {
		$value = intval($trimmed); // parse the value from string to int
		$bag[] = $value // store for later
	} else {
		$accumulator[] = array_reduce($bag, function ($previous, $current) {
			return $previous + $current
		}, 0); // add all items in $bag up to a total, and store for later
		$bag = []; // empty out the bag to be filled up with values
	}

	rsort($accumulator);

	var_dump($accumulator[0]);
}
