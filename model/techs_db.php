<?php

function get_Techs() {
    global $db;
    $query = 'SELECT techID, firstName, lastName, email, phone, password FROM technicians ORDER BY lastName';
    $statement = $db->prepare($query);
    $statement->execute();
    $techs = $statement->fetchAll();
    $statement->closeCursor();
    return $techs;
}

function delete_Techs($techID) {
    global $db;
    $query = 'DELETE FROM technicians WHERE techID = :techID';
    $statement = $db->prepare($query);
    $statement->bindValue(':techID', $techID);
    $statement->execute();
    $statement->closeCursor();
}

?>