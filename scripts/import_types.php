<?php 

$db = mysqli_connect('localhost', 'eve', 'pass1234', 'eve', 3306);

if($db->connect_errno) {
    die("Connect failed: " . $db->connect_error . "\n");
}

$handle = fopen(realpath(dirname(__FILE__) . '/../data/files/typeid.txt'), 'r');
if($handle) {
	$now = date('Y-m-d H:i:s');
	while (($line = trim(fgets($handle))) !== false) {
		if(!$line) continue; //skip blanks
		
		$data = explode(' ', $line, 2);
		$id = (int)$data[0];
		$name = addslashes(trim($data[1]));
		
		if(!$name) die("$id = no name\n");
		
		if(!$db->query(
			"
			INSERT INTO types (id, name, date_created, date_updated)
			VALUES ($id, '$name', '$now', '$now');
			"
		)) {
			die("Insert failed: " . $db->error . "\n");	
		}
		echo "id = $id, name = $name\n";
	}

	fclose($handle);
} else {
	die("data file not found \n");
} 

