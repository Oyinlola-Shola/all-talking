<?php
namespace NewdichSchema;
use NewdichSchema\Migration;
use NewdichSchema\Platform;
use NewdichSchema\Settings;

$dbName = Settings::SERVER_DB;
$usersTable = Platform::USERS;
$usersTableColumns = platform::USERS_COLUMNS;
$adminTable = Platform::ADMINS;
$adminTableColumns = Platform::ADMINS_COLUMNS;

//Create DB(NB:comment it out if you already created DB)
$newMigration = new Migration($usersTableColumns, $usersTable); //createDB does not need the arguments passed into the constructor, but just not to let constructor empty, we put it there
echo $newMigration->createDB($dbName);
exit;

//create table(NB:comment it out if you have alredy created the table)
$newMigration = new Migration($usersTableColumns, $usersTable); //pass the table columns and the table name as contructor. check the Platform.php file to see how the table columns must be
echo $newMigration->createTB();
exit;

//NOTE:WHEN PUSHING TO PRODUCTION, IGNORE THIS FILE RunMigration.php
?>