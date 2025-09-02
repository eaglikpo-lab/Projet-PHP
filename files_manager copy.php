<?php
    //  Organisateur de Fichiers
    do {
        echo "\n Entrer le chemin du dossier à organiser: ";
        $chemin = trim(fgets(STDIN));
    }while (empty($chemin));
    
    organiserDossier($chemin);

    function organiserDossier($chemin) {

        //$dossier = scandir($chemin); // liste les fichiers du dossier
        $dossier = array_diff(scandir($chemin), ['.', '..']); // liste les fichiers du dossier tt en filtrant les . et ..
        //print_r($dossier);
        

        foreach ($dossier as $fichier) {
            $path = $chemin .DIRECTORY_SEPARATOR . $fichier;

            if (is_file($path)) { // vérifier que c'est bien un fichier
                $info = pathinfo($fichier);
                $ext = isset($info['extension']) && $info['extension'] !== "" ? strtolower($info['extension']) : "autres";
                

                // Define the folder name or path
                $folderName = $chemin . DIRECTORY_SEPARATOR . $ext;

                // Check if the folder already exists
                if (!file_exists($folderName)) {
                    // Attempt to create the folder with appropriate permissions (e.g., 0755)
                    if (mkdir($folderName, 0755, true)) {
                        echo "Folder '$folderName' created successfully.";
                    } else {
                        echo "Failed to create folder '$folderName'. Please check permissions.";
                    }
                }  

                $filePath = $chemin. DIRECTORY_SEPARATOR . $fichier; 
                $destination = $folderName . DIRECTORY_SEPARATOR . $fichier;
                if (rename($filePath, $destination)) {                  // Déplacer le fichier dans son dossier
                    echo "Fichier '$fichier' déplacé dans '$folderName' ✅\n";
                } else {
                    echo "⚠️ Impossible de déplacer '$fichier'. Vérifiez les permissions.\n";
                }

            } elseif (is_dir($path)) {
                organiserDossier($path);
            }

        }
    }

?>