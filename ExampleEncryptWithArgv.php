<?php
/**
 * Author: Matthew Ahrenstein
 * Project: GPG2-Bulk-File-Encryptor
 * File created on: 7/12/14 14:17
 * License: AGPL
 */

////////This is a sample script where all of the parameters are specified on the command line////////

require_once("includes/GPGBulkFileEncryptor.class.php"); //Require the GPG Bulk File Encryptor class

$directory       = $argv[1]; //Store our directory in a variable
$recipient = $argv[2]; //Store our recipient in a variable
$deleteOriginals = ($argv[3] === 'true'); //if the string is true then it is boolean true and files will be deleted. Anything else matches false to be safe

//The below if/else is used to check if CLI arguments were properly filled out.
if (count($argv) == 4 AND file_exists($argv[1]) == TRUE) //Check to make sure we have 3 arguments, and a valid directory path (the script counts as an entry in the argv array)
{
	//Do nothing
}
else
{
	echo "Usage: " . $argv[0] . " <directory to recursively encrypt> <recipient key e-mail. <delete files>\n";
	echo "directory to recursively encrypt: Must be a valid existing directory\n";
	echo "recipient key e-mail: Must be a valid e-mail address of someone in your GPG keyring\n";
	echo "delete files: true/false\n";
	exit;
}

//The below code is the actual script, and will run if CLI arguments look good above
$encryptionTime = new GPGBulkFileEncryptor(); //Instantiate a new instance of our bulk file encryption class
$encryptionTime->gpgBulkFileEncrypt($directory, $recipient, $deleteOriginals); //Run the encryption function with our parameters
