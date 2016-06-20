<?php
//Exibe erros PHP
@ini_set('display_errors', '1');
error_reporting(E_ALL); 

$DBUSER="root";
$DBPASSWD="lic54eca";
$DATABASE1="igsis";
$DATABASE2="cep";

$filename1 = "backup-$DATABASE1" . date("YmdHis") . ".sql.gz";
$filename2 = "backup-$DATABASE2" . date("YmdHis") . ".sql.gz";
$mime = "application/x-gzip";

header( "Content-Type: " . $mime );
header( 'Content-Disposition: attachment; filename="' . $filename1 . '"' );

$cmd1 = "mysqldump -u $DBUSER --password=$DBPASSWD -h 200.237.5.34 $DATABASE1 | gzip --best > /var/www/html/igsis/sql/$filename1";   

passthru( $cmd1 );

header( "Content-Type: " . $mime );
header( 'Content-Disposition: attachment; filename="' . $filename2 . '"' );

$cmd2 = "mysqldump -u $DBUSER --password=$DBPASSWD -h 200.237.5.34 $DATABASE2 | gzip --best > /var/www/html/igsis/sql/$filename2";   

passthru( $cmd2 );


exit(0);
?>
