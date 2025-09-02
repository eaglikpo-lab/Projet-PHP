<?php
    // Script de nettoyage
    $f_to_delete = []; 

    //function ShowFile($chemin, &$f_to_delete): array {
    function ShowFile($chemin): array {
        $contenu = array_diff(scandir($chemin), ['.', '..']); // liste les fichiers du dossier tt en filtrant les . et ..

        

        foreach ($contenu as $fichier) {
            $path = $chemin .DIRECTORY_SEPARATOR . $fichier;

            if (is_file($path)) { // vérifier que c'est bien un fichier
                $info = pathinfo($fichier);
                $ext = isset($info['extension']) ? strtolower($info['extension']) : '';
                if ( $ext and ($ext == "log" or $ext == "tmp" or $ext == "bak")) {
                    //print_r("\n".$fichier);
                    $f_to_delete[] = $fichier;
                }

            }
        }
        print_r($f_to_delete);
        return $f_to_delete;
    }


    function SaveFile ($f_to_delete, $chemin): void {
        $backup_dir = $chemin . DIRECTORY_SEPARATOR . "sauvegarde";
        if (!is_dir($backup_dir)) {
            mkdir($backup_dir);
        }
        foreach ($f_to_delete as $f_name) {
            $src = $chemin . DIRECTORY_SEPARATOR . $f_name;
            $dst = $backup_dir . DIRECTORY_SEPARATOR . $f_name;
            if (copy($src, $dst)) {
                echo "✔ Sauvegardé : $f_name → $backup_dir\n";
            } else {
                echo "✖ Erreur lors de la sauvegarde de $f_name\n";
            }
        }
    }


    function SaveList($f_to_delete, $chemin) {
        $reportFile = $chemin . DIRECTORY_SEPARATOR . 'cleanup_report.txt';
        file_put_contents($reportFile, implode(PHP_EOL, $f_to_delete));
        echo "\nListe des fichiers supprimés sauvegardée dans $reportFile\n";
    }


    function DeleteFile ($f_to_delete, $chemin ) : void {
        foreach ($f_to_delete as $key => $f_name) {
            $fi_tosup = $chemin .DIRECTORY_SEPARATOR . $f_name;
            if (file_exists($fi_tosup)) {
                unlink($fi_tosup);
                echo "\n Fichier ".$fi_tosup." supprime";
            } else {
                echo "Error: Unable to delete the file '$fi_tosup'. Check permissions.";
            }       
        } 
        SaveList($f_to_delete, $chemin); 
    }

   

    
    // ----------------- SCRIPT PRINCIPAL -----------------
    do {
        echo "\n Entrer le chemin du répertoire à scanner: ";
        $chemin = trim(fgets(STDIN));
    } while (empty($chemin) || !is_dir($chemin));

    ShowFile($chemin, $f_to_delete);

    if (!empty($f_to_delete)) {
        do {
            echo "\n Voulez-vous supprimer les fichiers trouvés (O/N): ";
            $decision = strtoupper(substr(trim(fgets(STDIN)), 0, 1));
        } while (!in_array($decision, ['O','N']));

        if ($decision == 'O') {
            do {
                echo "\n Voulez-vous sauvegarder avant suppression (O/N): ";
                $save = strtoupper(substr(trim(fgets(STDIN)), 0, 1));
            } while (!in_array($save, ['O','N']));

            if ($save == 'O') SaveFile($f_to_delete, $chemin);
            DeleteFile($f_to_delete, $chemin);
        } else {
            DeleteFile($f_to_delete, $chemin);
        }
    } else {
        echo "\n Aucun fichier a supprimer.";
    }

?>
