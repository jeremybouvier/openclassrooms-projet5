<?php
require 'vendor/autoload.php';
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 22:53
 */




if (isset($_GET['p'])) {

    $p = $_GET['p'];

}
else {

    $p='home';

}



ob_start();
if ($p==='home') {

    require 'view/Home.php';

}

elseif ($p==='post') {

    require 'view/Post.php';

}

$body = ob_get_clean();
require 'view/templates/default.php';


?>