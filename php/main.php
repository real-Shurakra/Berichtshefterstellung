<?php
session_start();
// Session variables
// $_SESSION['id_user'] The id of the current user

class Main{
    function __construct($mode) {
        switch ($mode) {
            case 'bouncerCheck':   echo (json_encode($this->bouncerCheck()));break;
            default:                    echo (json_encode('Fail'));break;
        }
    }
    public static function bouncerCheck() {
        if (isset($_SESSION['id_user'])){return True;}
        else{return False;}
    }
}
$jsablauf = new Main($_REQUEST['mode']);
