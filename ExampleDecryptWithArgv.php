<?php
/**
 * Author: Matthew Ahrenstein
 * Project: GPG2-Bulk-File-Encryptor
 * File created on: 4/02/15 15:58
 * License: AGPL
 */

////////This is a sample script where all of the parameters are specified on the command line////////

require_once("includes/GPGBulkFileEncryptor.class.php"); //Require the GPG Bulk File Encryptor class

$directory       = $argv[1]; //Store our directory in a variable
$deleteOriginals = ($argv[2] === 'true'); //if the string is true then it is boolean true and files will be deleted. Anything else matches false to be safe

//The below if/else is used to check if CLI arguments were properly filled out.
if (count($argv) == 3 AND file_exists($argv[1]) == TRUE) //Check to make sure we have 2 arguments, and a valid directory path (the script counts as an entry in the argv array)
{
	//Do nothing
}
else
{
	echo "Usage: " . $argv[0] . " <directory to recursively decrypt> <delete files>\n";
	echo "directory to recursively decrypt: Must be a valid existing directory\n";
	echo "delete files: true/false\n";
	exit;
}

//The below code is the actual script, and will run if CLI arguments look good above
$decryptionTime = new GPGBulkFileEncryptor(); //Instantiate a new instance of our bulk file encryption class
$decryptionTime->gpgBulkFileDecrypt($directory, $recipient, $deleteOriginals); //Run the decryption function with our parameters
