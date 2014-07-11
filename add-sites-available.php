<?php
    /* SCRIPT TO GENERATE VIRTUAL HOST FILES IN /etc/apache2/sites-available/
	 * NEEDS TO BE RUN AS SUDO
    *****************************************************************************/

	//PATH TO VIRTUAL HOST FILES
	$path = '/etc/apache2/sites-available/';

	//SERVER ADMIN
	$server_admin = 'pj@digitalbrands.com';

	//SITE DOMAIN
	$site_domain = 'pj.passprotect.me';

	//SITE PREFIXES
	$site_prefixes = array(
		'',     //DEFAULT HOME
		'db',   //DIGITALBRANDS
		'da',   //DATING ADVICE
		'pr',	//PRINTAHOLIC
		'cd',	//COUPONSDAILY
		'bc',	//BADCREDIT
		'cr',	//CARDRATES
		'gvs',  //GAINESVILLESHOWS
		'ha',   //HOSTINGADVICE
	);


	//LOOP THORUGH EACH SITE AND CREATE THE VIRTUAL HOST FILE
	$stdout = fopen('php://stdout', 'w');
	foreach( $site_prefixes as $site_prefix ) :
		if( empty( $site_prefix ) ) :
			$site_url = $site_domain;
		else :
			$site_url = $site_prefix . '.' . $site_domain;
		endif;
		
		$file_handle = fopen( $path . $site_url . '.conf', 'w' );
		fwrite( $stdout, "Writing file: $site_url\n" );
		fwrite( $file_handle,
"<VirtualHost *:80>
	ServerAdmin $server_admin
	ServerName $site_url
	ServerAlias www.$site_url
	DocumentRoot /home/$site_url/public_html
	ErrorLog /home/$site_url/logs/error.log
	CustomLog /home/$site_url/logs/access.log combined
</VirtualHost>");
		fclose( $file_handle );
		unset( $file_handle );
	endforeach;
	fwrite( $stdout, "\nDONE!!\n" );
	fclose( $stdout );
?>
