<?php
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/Session.php');
    include_once ($filepath.'/../lib/Cookie.php');
    include_once ($filepath.'/../core/Database.php');
    include_once ($filepath.'/../classes/Admin.php');

    if(isset($_GET['id'])){
        $ad = new Admin();
        $id = $_GET['id'];
        $ad->delete($id);
    }
?>