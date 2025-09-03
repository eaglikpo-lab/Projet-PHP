<?php

$filename = "system_report.txt";
$file = fopen($filename, "w");

// === Mémoire ===
exec("wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value", $output);
$freeMem = 0;
$totalMem = 0;

foreach ($output as $line) {
    if (strpos($line, "FreePhysicalMemory=") === 0) {
        $freeMem = (int) explode("=", $line)[1];
    }
    if (strpos($line, "TotalVisibleMemorySize=") === 0) {
        $totalMem = (int) explode("=", $line)[1];
    }
}
$usedMem = $totalMem - $freeMem;

// === Disques ===
$disques = ["C:" , "D:"];
$infoDisques = "";

foreach ($disques as $disque) {
    $total = disk_total_space($disque);
    $free = disk_free_space($disque);
    $used = $total - $free;

    $infoDisques .= "Disque $disque" . PHP_EOL .
        "  Capacité totale : " . round($total / 1024 / 1024 / 1024, 2) . " Go" . PHP_EOL .
        "  Espace utilisé  : " . round($used / 1024 / 1024 / 1024, 2) . " Go" . PHP_EOL .
        "  Espace libre    : " . round($free / 1024 / 1024 / 1024, 2) . " Go" . PHP_EOL . PHP_EOL;
}

// === Infos générales ===
$content = "=== Rapport Système ===" . PHP_EOL .
    "Utilisateur : " . getenv("USERNAME") . PHP_EOL .
    "Date        : " . date("d/m/Y H:i") . PHP_EOL .
    "OS          : " . php_uname('s') . " " . php_uname('r') . PHP_EOL .
    "Mémoire     : " . round($usedMem / 1024, 2) . " Mo utilisée ; " .
                      round($freeMem / 1024, 2) . " Mo libre" . PHP_EOL . PHP_EOL .
    $infoDisques;

fwrite($file, $content);
fclose($file);

echo "Rapport généré dans $filename\n";


/*
$filename = " system_report.txt";

$file = fopen($filename, "w");

exec("wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value", $output);
//print_r($output);
$utilise = $output[3]-$output[2];
$libre = $output[2];

$disqueC = "C:"; 

$totalC = disk_total_space($disque);
$libreC = disk_free_space($disque);
$utiliseC = $total - $libre;

$disqueC = "D:"; 

$totalD = disk_total_space($disque);
$libreD = disk_free_space($disque);
$utiliseD = $total - $libre;

if ($file) {

    $content = "=== Information systeme ou d'environnement === \n
        ".$getenv("USERNAME"). "\n Ce". date("d/m/Y H\hi"). "\n"
        .php_uname('s', 'r'). "\n Utilisation de la mémoire: ($utilise utilise; $libre libre)
        Disque : $disqueC\n 
        Capacité totale : " . round($totalC / 1024 / 1024 / 1024, 2) . " Go\n 
        Espace utilisé : " . round($utiliseC / 1024 / 1024 / 1024, 2) . " Go\n
        Espace libre  : " . round($libreC / 1024 / 1024 / 1024, 2) . " Go\n
        
        Disque : $disqueD\n 
        Capacité totale : " . round($totalD / 1024 / 1024 / 1024, 2) . " Go\n 
        Espace utilisé : " . round($utiliseD / 1024 / 1024 / 1024, 2) . " Go\n
    Espace libre  : " . round($libreD / 1024 / 1024 / 1024, 2) . " Go\n";
        
    fwrite($file, $content);
}
*/


?>