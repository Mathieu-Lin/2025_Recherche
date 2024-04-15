<?php
require_once("./lib/Database.php");


// Exemple 
/**
 * 
 * 
 * 
 *     function addActionneur($conn,  $nom, $type, $description)
 *  {
 *       //Execution sql 
 *       $res = mysqli_prepare($conn, "insert into actionneur (`nom`, `type_actionneur`,`description`,`etat`) VALUES (?,?,?,'OFF')");
 *       mysqli_stmt_bind_param($res, "sss", $nom, $type, $description);
 *       return mysqli_stmt_execute($res);
 *   }
 * 
 */
function Accueil_getLogin($conn)
{
}
