<?php 
    //  Sans constructeur
    /*class Etudiant{
        public $nom;
        public $age;

        public function introduce () {
            return "My name is ".$this->nom." et j'ai ".$this->age."ans.";
        }
    }
        $eleve  = new Etudiant();
        $eleve ->nom = "Enice";
        $eleve ->age = 10;

        echo $eleve -> introduce();*/
        


   

// Constructeur
    class Personne {
    
        public $nom ;
        public $age;

        public function __construct($nom,$age) {
            //echo "Salut, je m'appelle $nom et j'ai $age ans.\n";
            //return "Je m'appelle ".$this->nom." et j'ai ".$this->age." ans.";
            $this->nom = $nom;
            $this->age = $age;
        }
        
        public function check_age () {
            if ($this->age < 0) {
                echo "Ton age doit etre positif. Rentre encore ton age: ";
                $new_age = (int)trim(fgets(STDIN));
                $this ->age = $new_age;

            }
        }
        public function introduce () {
            return " Hello my name is " .$this->nom." and I'm ".$this->age." years old.\n";
        }

        public function adult () {
            if ($this->age < 18) {
                echo "Tu n'es pas un adulte.\n";
            } else {
                echo " Tu es adulte.\n";
            }
        }
    }

    $p1 = new Personne("Laurence",-2 );
    //echo "Je m'appelle $p1->nom et j'ai $p1->age";
    $p1 -> check_age();
    echo $p1->introduce();
    $p1 -> adult();
?>