<?php
require('../model/database.php');
require_once('../model/techs_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'tech_list'; // default
    }
}

// Added switch cases for actions to list/delete technicians
// and show the add ptechnicians page
switch ($action){
    case 'tech_list':
        $techs = get_Techs();
        include('tech_list.php');
        break;

    case 'delete_tech':
        $techID = filter_input(INPUT_POST, 'techID');
        if ($techID) {
            delete_Techs($techID);
        }
        header("Location: .?action=tech_list");
        exit();

    case 'add_tech':
        include('add_tech.php');
        break;

    default:
        include('../under_construction.php');
        break;
}

?>