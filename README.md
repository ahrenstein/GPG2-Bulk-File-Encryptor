What does this do?
===================
GPG Bulk File Encryptor is a simple PHP class and set of example CLI scripts that allows you to encrypt multiple files in a path without them being zipped into a single encrypted archive.  
The directory structure of the specified root path to start with is preserved so /path/to/file.txt will result in /path/to/file.txt.gpg

DEPRECATION
------------
This repo is no longer updated. Doing this in PHP is a weird way to make a CLI tool.  
[A Python3](https://github.com/ahrenstein/GPG-Bulk-File-Management) script was created as a proper replacement for it.

Why did I write this?
----------------------
When using GPG Tools for Mac I discovered that encrypting more than one file at a time zips them together. I wanted to encrypt multiple files at once, but still keep them
as separate files for later individual decryption.

Script workflow
----------------
*1) Use recursive glob function to find all files in the specified root path and store them in an array
*2) Take any files that don't end in ".gpg" and encrypt them using the specified recipient
*3) Either leave the original file alone, or remove it depending on specified parameters

Limitations
-------------
*1) It seems that either PHP exec or gpg2 doesn't like using relative directories like ~/file.txt so if the directory you want to encrypt is in your home directory, then you will need to specify the full path
*2) gpg2 doesn't output a progress bar, so if you start encrypting a 2GB video file, you will be sitting there waiting for it to complete with no idea where it is
*3) gpg2 uses RAM to hold the file being processed, so if your file is larger than your free RAM, you will get errors
*4) Decryption requires a passphrase so unless you store it in an active keyring (ex: Keychain Access for OS X) you will be prompted for it at each file or during a cron

Requirements
--------------
This PHP class requires the gpg2 binary. I have only tested this on OS X 10.9.x Mavericks and 10.10.x Yosemite so far using the GPG binaries provided by https://gpgtools.org/gpgsuite.html but it should work
with any version of the gpg2 binary.
