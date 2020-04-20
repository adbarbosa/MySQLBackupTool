#!/usr/bin/php
<?php
define("VERSION", "0.2.1");

// Path to config file in JSON format
echo "\n";
echo "+-----------------------------+\n";
echo "| ADBSoft - MySQL Backup Tool |\n";
echo "+-----------------------------+\n";

require_once __DIR__ . "/func.php";

$pathToConfigFile = __DIR__ . "/config.json";

$arrConfig = array();

// Verify if config file exists
if(file_exists($pathToConfigFile)) {
    // Read File with config
    $strConfig = file_get_contents($pathToConfigFile);
    $arrConfig = json_decode($strConfig,true);
    echo "\nConfig file read\n";

    if($arrConfig["debug"] == 1) {
        echo "\nConfig:\n";
        print_r($arrConfig);
    }
} 
else {
    // Print error
    echo "\nERROR: Config file not found!!\n";
    exit("\n*** END ***\n");
}

if($arrConfig["debug"] == 1) {
    echo "\nversion: " . VERSION . "\n";
}

// Get absolute path to backup folder
$arrConfig["path_to_backup"] = truepath($arrConfig["path_to_backup"]);

if($arrConfig["debug"] == 1) {
    echo "\nAbsolute path to save backup file:\n";
    echo $arrConfig["path_to_backup"] . "\n";
}

// verify if backup path exists (if not create it)
if(file_exists($arrConfig["path_to_backup"])) {
    echo "\nBackup path exists!\n";
}
else {
    echo "Backup path do not existe but i will attempt to create it\n";
    mkdir($arrConfig["path_to_backup"], 0700, true);
    if(file_exists($arrConfig["path_to_backup"])) {
        echo "\nBackup path exists!\n";
    }
    else {
        echo "\nERROR: Backup path is invalid!\n";
        exit("\n*** END ***\n");
    }
}

// Gel all databases available
$output = array();
exec("mysql -u ".$arrConfig['user']." -p".$arrConfig['pass']." -h ".$arrConfig['host']." -Bse 'show databases'", $output, $return_var );

// Verify if all database exist, if not it is removed from array of databases to backup
foreach($arrConfig['database_to_backup'] as $pos => $db) {
    if (!in_array($db,$output)) {
        unset($arrConfig['database_to_backup'][$pos]);
    }
}

foreach ($arrConfig['database_to_backup'] as $pos => $db) {
    if($arrConfig["debug"] == 1) echo "\nStart backup of database: " . $db . " ";
    $db_backup_file = "/mysqldump_".$arrConfig['host']."_".$db."_".date("YmdHis").".sql";
    exec("mysqldump -u ".$arrConfig['user']." -p".$arrConfig['pass']." -h ".$arrConfig['host']." ".$db." > ".$arrConfig["path_to_backup"].$db_backup_file, $output, $return_var);
    if($arrConfig["debug"] == 1) echo " Complete!\n";
}

// Ends the script
exit("\n*** END ***\n");
?>