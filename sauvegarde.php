<?php
//  Outil de Sauvegarde
function addDirToZip($zip, $dir, $baseDir = '') {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $filePath = $dir . DIRECTORY_SEPARATOR . $file;
        $localPath = $baseDir . $file;
        if (is_dir($filePath)) {
            addDirToZip($zip, $filePath, $localPath . '/');
        } else {
            $zip->addFile($filePath, $localPath);
        }
    }
}



do {
        echo "\n Entrer le chemin du fichier ou dossier à sauvegarder: ";
        $toSave = trim(fgets(STDIN));
    } while (empty($toSave) || !file_exists($toSave));

// Files to be added to the ZIP archive
$filesToZip = [$toSave];


do {
        echo "\n Entrer le dossier de destination où la sauvegarde doit être enregistrée: ";
        $dest = trim(fgets(STDIN));
    } while (empty($dest) || !is_dir($dest));



    
// Nom de l'archive avec la date actuelle (format AAAA-MM-JJ)
$date = date("Y-m-d");
$archiveName = rtrim($dest, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . "sauvegarde_$date.zip";


// Créer une nouvelle archive zip
$zip = new ZipArchive();
if ($zip->open($archiveName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach ($filesToZip as $file) {
        if (is_dir($file)) {
            addDirToZip($zip, $file);
        } else {
            $zip->addFile($file, basename($file));
        }

        /*if (file_exists($file)) {
            $zip->addFile($file, basename($file)); // Add file to ZIP
        } else {
            echo "Warning: File '$file' does not exist and will be skipped.\n";
        }*/
    }

    $zip->close();
    echo "Archive créée : $archiveName\n";
} else {
    echo "Impossible de créer l'archive.\n";
}


    // Parcourir le dossier et ajouter les fichiers
   /* $dir = new RecursiveDirectoryIterator($chemin, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($dir);

    foreach ($filesToZip as $file) {
        if ($file->isFile()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($chemin) + 1); // chemin relatif
            $zip->addFile($filePath, $relativePath);
        }
    }*/

?>