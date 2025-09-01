<?php
    //  Organisateur de Fichiers
    do {
        echo "\n Entrer le chemin du dossier à organiser: ";
        $chemin = trim(fgets(STDIN));
    }while (empty($chemin));

    $dossier = scandir($chemin); // liste les fichiers du dossier
    $extensions = []; // tableau pour classer par extension
    $ext ="";

    foreach ($dossier as $fichier) {
        if (is_file($chemin . $fichier)) { // vérifier que c'est bien un fichier
        $info = pathinfo($fichier);
        $ext = isset($info['extension']) ? strtolower($info['extension']) : "autre";

        // on classe le fichier par extension
        //$extensions[$ext][] = $fichier;
        }

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

        $filePath = $chemin. DIRECTORY_SEPARATOR . $fichier; // Déplacer le fichier dans son dossier
        $destination = $folderName . DIRECTORY_SEPARATOR . $fichier;
        if (rename($filePath, $destination)) {
            echo "Fichier '$fichier' déplacé dans '$folderName' ✅\n";
        } else {
            echo "⚠️ Impossible de déplacer '$fichier'. Vérifiez les permissions.\n";
        }



    }

?>