<?php
$kasutaja='lastovskitarpv21'; //lastovskitarpv21 d113367_mihhail
$server = 'localhost'; //localhost d113367.mysql.zonevs.eu'
$andmebaas = 'restoran'; //lastovskitarpv21 d113367_baaslast
$salasyna = '12354';
//teeme käsk mis ühendab andmebaasiga
$yhendus = new mysqli($server, $kasutaja, $salasyna, $andmebaas);
$yhendus->set_charset('UTF8');
/*
CREATE TABLE loomad(
	id int PRIMARY KEY AUTO_INCREMENT,
    loomanimi varchar(15) UNIQUE,
    vanus int,
    pilt text
)
*/
?>
