<?php
	$username = "your_username";
	$password = "your_pass";
	$url      = 'your_stp_server_url';
	// Make our connection
	$connection = ssh2_connect($url);
	 
	// Authenticate
	if (!ssh2_auth_password($connection, $username, $password)) throw new Exception('Unable to connect.');
	 
	// Create our SFTP resource
	if (!$sftp = ssh2_sftp($connection)) throw new Exception('Unable to create SFTP connection.');
	$localDir  = '/path/to/your/local/dir';
	$remoteDir = '/path/to/your/remote/dir';
	// download all the files
	$files    = scandir('ssh2.sftp://' . $sftp . $remoteDir);
	if (!empty($files)) {
	  foreach ($files as $file) {
	    if ($file != '.' && $file != '..') {
	      ssh2_scp_recv($connection, "$remoteDir/$file", "$localDir/$file");
	    }
	  }
	}
?>
