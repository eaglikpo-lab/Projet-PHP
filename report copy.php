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
$disquesData = []; // pour JSON

foreach ($disques as $disque) {
    $total = disk_total_space($disque);
    $free = disk_free_space($disque);
    $used = $total - $free;

    $infoDisques .= "Disque $disque" . PHP_EOL .
        "  Capacité totale : " . round($total / 1024 / 1024 / 1024, 2) . " Go" . PHP_EOL .
        "  Espace utilisé  : " . round($used / 1024 / 1024 / 1024, 2) . " Go" . PHP_EOL .
        "  Espace libre    : " . round($free / 1024 / 1024 / 1024, 2) . " Go" . PHP_EOL . PHP_EOL;

    // On stocke aussi dans un tableau structuré pour JSON
    $disquesData[$disque] = [
        "total_Go" => round($total / 1024 / 1024 / 1024, 2),
        "used_Go"  => round($used / 1024 / 1024 / 1024, 2),
        "free_Go"  => round($free / 1024 / 1024 / 1024, 2),
    ];

}

// === Infos générales ===
$content = "=== Rapport Système ===" . PHP_EOL .
    "Utilisateur : " . getenv("USERNAME") . PHP_EOL .
    "Date        : " . date("d/m/Y H:i") . PHP_EOL .
    "OS          : " . php_uname('s') . " " . php_uname('r') . PHP_EOL .
    "[ ". date("H:i:s"). "] Mémoire     : " . round($usedMem / 1024, 2) . " Mo utilisée ; " .
                      round($freeMem / 1024, 2) . " Mo libre" . PHP_EOL . PHP_EOL .
    "[ ". date("H:i:s"). "] " .$infoDisques;


fwrite($file, $content);
fclose($file);

echo "Rapport généré dans $filename\n";

// === Création du JSON ===
$data = [
    "utilisateur" => getenv("USERNAME"),
    "date"        => date("Y-m-d H:i:s"),
    "os"          => php_uname('s') . " " . php_uname('r'),
    "memoire" => [
        "utilisee_Mo" => round($usedMem / 1024, 2),
        "libre_Mo"    => round($freeMem / 1024, 2),
        "totale_Mo"   => round($totalMem / 1024, 2),
    ],
    "disques" => $disquesData
];

// On sauvegarde le JSON dans un fichier séparé
$jsonFilename = "system_report.json";
file_put_contents($jsonFilename, json_encode($data, JSON_PRETTY_PRINT));

echo "Rapport JSON généré dans $jsonFilename\n";


?>