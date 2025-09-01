<?php
    class Book extends Library{
        public string $title;
        public string $author;
        public int $year;
        public bool $available;

        public function __construct($title, $author, $year)
        {
            $this->title = $title;
            $this->author = $author;
            $this->year = $year;
            //$this-> available = $available;
        }

        public function __toString()
        {
            return "Title: ".$this->title."; Author: ".$this->author."; Published: ".$this->year."\n";
            //Description lisible du livre
           
        }
    }

    class Library {
        public array $books;
        

        public function addBook (Book $book) {
            $this->books[]= $book;
        }

        public function removeBook (string $title) : void{
            foreach ($this->books as $key => $t) {
                if ($title==$t->title) { 
                    unset($this->books[$key]);
                }
            }
        }

        public function listBooks() {
            if (empty($this->books)) {
            echo "Aucun livre dans la bibliothèque.\n";
            return;
            }
            print_r($this->books);
          /*  foreach ($this->books as $book){
                echo $book . "\n";
            }*/
        }

        public function searchByTitle(string $title): ?Book {
        foreach ($this->books as $book) {
            if ($book->title === $title) {
                return $book;
            }
        }
        return null;
    }

    // Sauvegarde dans un fichier
    public function sauvegarder($fichier) {
        if(file_put_contents("biblio.txt", serialize($this->books)) === false){
            echo "Erreur : impossible de créer le fichier.\n";
    }
      //file_put_contents($fichier, serialize($this->books))
    }

    
    // Charger depuis un fichier
    public function charger($fichier) {
        if (file_exists($fichier)) {
            $this->books = unserialize(file_get_contents($fichier));
        }
    }

       /* public function listAvailableBooks() {
            foreach ($this->books as $key => $t) {
                if ($title==$t) { 
                   return true;
                } else {
                    return false;
                }
            }
        }*/
    }


// Recharger la bibliothèque
//$newBiblio = new Library();


$biblio = new Library();
do {
   
    $v =1;

   
    $biblio->charger("biblio.txt");

    echo "Bibliothèque rechargée :\n";
    

    echo "\n=== SYSTEME DE BIBLIOTHEQUE ===\n 1. Ajouter un nouveau livre\n 2. Supprimer un livre\n 3. Afficher tous les livres\n 4. Rechercher par titre\n 5. Quitter\n";

    $line = trim(fgets(STDIN));
    $level = substr($line, 0, 1);

    if ($level == "1") {
        echo "Ajouter un nouveau livre.";
        do {
            echo "\n Entre un titre : ";
            $titre = trim(fgets(STDIN));
        } while (empty($titre));

        do {
            echo "\n Entre l'autheur: ";
            $autheur = trim(fgets(STDIN));
        } while (empty($autheur));
       
        do {
            echo "\n Annee de publication: ";
            $annee = trim(fgets(STDIN));
        } while (empty($annee));
        
        $livre = new Book($titre, $autheur, $annee);
       
        $biblio-> addBook($livre);
        echo "Livre ajoute\n";
        $biblio->sauvegarder("biblio.txt"); // sauvegarde immédiate
       
    } elseif ($level == "2") {
        do {
            echo "Titre du livre à supprimer : ";
            $titre = trim(fgets(STDIN));
        } while (empty($titre));
        $biblio->removeBook($titre);
       // $titre = "";
       $biblio->sauvegarder("biblio.txt"); // sauvegarde immédiate

    } elseif ($level == "3") {
       // $a = new Library;
        echo "=== Livres de la bibliotheque === \n";
        $biblio-> listBooks();
        
    } elseif ($level == "4") {
        do {
            echo "\nTitre à rechercher : ";
            $titre = trim(fgets(STDIN));
        } while (empty($titre));
        echo $biblio->searchByTitle($titre);
       // $titre = "";
                
    } elseif($level == "5") {
         // Sauvegarder dans un fichier
        $biblio->sauvegarder("biblio.txt");
        echo "Sauvegarde terminée.\n\n";
        $v = 0;

    }else {
        echo " Option invalide. Choisis entre 1 et 5: ";
    };

} while ($v);
?>
