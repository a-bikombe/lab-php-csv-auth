#!/usr/local/bin/php
<?php

/* Write a command line script that allows the user to store authentication credentials in a file. */

/* 
	pseudocode
		ask for username input (https://www.php.net/manual/en/function.readline.php)
			search username array for duplicate
				report error if duplicate
			check if username input follows pattern

		ask for password input
			check if password input follows pattern

		put contents into file (var_export())
*/

$usernamePattern = '/^\w+$/';	// username pattern variable (upper/lowercase letters, digits)
$passwordPattern = '/^\S[^,]{17,}$/';	// password pattern variable (no spaces/commas, >= 17 characters long)

if (is_file('usernames.csv') && is_file('passwords.csv')) {
	$usernames = trim(file_get_contents('usernames.csv'));
	$usernames = explode(',', $usernames);
	$passwords = trim(file_get_contents('passwords.csv'));
	$passwords = explode(',', $passwords);
} else {
	$usernames = [];	// create username array
	$passwords = [];	// create password array
}

switch($argc) {
	case 0:
		echo '0 args'.PHP_EOL;
	case 1:
		$username = readline("Username: ");	// ask for username input
		if (preg_match($usernamePattern, $username) == 0) {	// check if username input follows pattern
			die('Please follow the username pattern (upper/lowercase letters, digits)'.PHP_EOL);
		} elseif (in_array($username, $usernames) == 1) {	// search username array for duplicate
			die('Duplicate username'.PHP_EOL);	// report error if duplicate
		}
		// duplicate
	case 2:
		$username = $username ?? $argv[1];	// get username from argv array
		$password = readline("Password: ");	// ask for password input
		if (preg_match($passwordPattern, $password) == 0) {	// check if password input follows pattern
			die('Please follow the password pattern (no spaces/commas, >= 17 characters long)'.PHP_EOL);
		}
	case 3:
		$username = $username ?? $argv[1];
		$password = $password ?? $argv[2];
		break;
	default:
		die('Try again'.PHP_EOL);
}

// add username and password to their respective arrays
array_push($usernames, $username);
array_push($passwords, $password);

// print arrays
echo 'var_dump'.PHP_EOL;
var_dump($usernames);
var_dump($passwords);

// encode as php
echo 'var_export'.PHP_EOL;
var_export($usernames);
var_export($passwords);

// put into respective files
$fopen_u = fopen('usernames.csv', 'w');
fputcsv($fopen_u, $usernames);
fclose($fopen_u);

$fopen_p = fopen('passwords.csv', 'w');
fputcsv($fopen_p, $passwords);
fclose($fopen_p);
/* 
file_put_contents('usernames.csv', $usernames);
file_put_contents('passwords.csv', $passwords); */