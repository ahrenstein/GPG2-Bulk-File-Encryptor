<?php
/**
 * Author: Matthew Ahrenstein
 * Project: GPG2-Bulk-File-Encryptor
 * File created on: 7/12/14 14:17
 * License: AGPL
 */

////////This is a sample script where all of the parameters are specified inside the file already////////

require_once("includes/GPGBulkFileEncryptor.class.php"); //Require the GPG Bulk File Encryptor class

$directory       = "/Users/MacUser/Desktop/StuffToEncrypt/"; //The directory to recursively encrypt in
$recipient       = "macuser@icloud.com"; //The e-mail address of the public key in our keyring with permission to decrypt
$deleteOriginals = FALSE; //Let's keep originals afterwards

$encryptionTime = new GPGBulkFileEncryptor(); //Instantiate a new instance of our bulk file encryption class
$encryptionTime->gpgBulkFileEncrypt($directory, $recipient, $deleteOriginals); //Run the encryption function with our parameters
