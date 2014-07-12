<?php
/**
 * Author: Matthew Ahrenstein
 * Project: GPG2-Bulk-File-Encryptor
 * File created on: 7/12/14 14:17
 * License: AGPL
 */
//This class requires the gpg2 binary for use with PHP's exec command
class GPGBulkFileEncryptor
{

	/**
	 * Recursive version of glob
	 * Original function located here: https://gist.github.com/wooki/3215801
	 *
	 * @param $pattern string /path/to/root/*file*
	 * @param int $flags Variable is optional and not needed for our use case
	 *
	 * @return array Array of files matching pattern
	 */
	public function glob_recursive($pattern, $flags = 0)
	{

		$files = glob($pattern, $flags);

		foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir)
		{
			$files = array_merge($files, $this->glob_recursive($dir . '/' . basename($pattern), $flags));
		}

		return $files;
	}

	/**
	 * Recursively encrypt files in a directory using gpg2
	 *
	 * @param $rootPath string path to the directory you want to recursively encrypt from
	 * @param $recipient string e-mail address of a public key in your keyring
	 * @param bool $deleteOriginal true or false to keep original unencrypted file after processing.
	 *
	 * We err on the side of caution with the last param and don't delete files by default
	 */
	public function gpgBulkFileEncrypt($rootPath, $recipient, $deleteOriginal = FALSE)
	{
		// The following if/else checks the root path to see if it ends in / or not. The root path needs to end in /*/
		if ($rootPath[strlen($rootPath) - 1] == "/")
		{
			$rootPath = $rootPath . "*.*"; //Just add a search for all file types
		}
		else
		{
			$rootPath = $rootPath . "/*.*"; //Add the trailing / and a search for all file types
		}

		$filesToEncrypt = $this->glob_recursive($rootPath); //Create an array listing every file in the specified root path

		foreach ($filesToEncrypt as $file) //Iterate through the files
		{
			if (substr($file, strlen($file) - 4, 4) != ".gpg") //Check if the file is not encrypted. We are just assuming that the .gpg extension means the file is encrypted
			{
				if ($deleteOriginal == FALSE) //Perform encryption without deleting the original file
				{
					exec("gpg2 --yes -r " . $recipient . " -o \"" . $file . ".gpg\"" . " --encrypt \"" . $file . "\""); //Encrypt the file
					echo $file . " has been encrypted, but the original file was not deleted.\n"; //Alert that the file has been encrypted and the original saved
				}
				elseif ($deleteOriginal == TRUE) //Perform encryption and delete the original file
				{
					exec("gpg2 --yes -r " . $recipient . " -o \"" . $file . ".gpg\"" . " --encrypt \"" . $file . "\""); //Encrypt the file
					unlink($file); //Delete the original
					echo $file . " has been encrypted, and the original file was deleted.\n"; //Alert that the file has been encrypted and the original deleted
				}
			}
			else //Encrypted files just get listed as already encrypted
			{
				echo $file . " is already encrypted, and will be ignored.\n"; //Alert that the file is already encrypted and do nothing
			}
		}
	}
}
