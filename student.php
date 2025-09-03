<?php
//Travailler avec des tableaux internes, ajouter/supprimer des éléments et calculer des statistiques.

class Student {

    public string $name;
    public array $grades= [];
    private float $moyenne = 0; // TODO: on peut s'en passer

    public function __construct(string $name)
    {
        $this->name = $name;
    }
        
    // TODO: Eviter les codes morts. Supprimer si plus besoin

    public function addGrade (float $grade): void {
        if ($grade >=0 && $grade<=20) {
            $this->grades[] = $grade;
        }else {
            echo "Invalid grade. \n";
        }
    }
    
    public function removeGrade(float $grade): void {
        // TODO: Pourrait être simplifié. Check "array_splice()"
        foreach ($this->grades as $key =>$g) {
            if ($grade == $g) {
                array_splice($this->grades, $key, 1);
            }
        }
    }

    public function average() : float {
        $somme = 0;
        echo "Your average is: ";
        if (count($this->grades)!=0) {
            foreach ($this->grades as $key =>$g) {
                $somme += $g; 
            }
            // TODO: correct mais division par 0 possible. Gérer ce cas. Juste retourner 0 si pas de notes
            $this->moyenne = $somme/count($this->grades); 
            return $this->moyenne;
        } else {
            return $this->moyenne = 0;
        }
        
    }

    public function honor() : void{
        // TODO: Good
        echo "Honor: ";
        if ($this->moyenne <10) {
            echo "Insuffisant\n" ;
        } elseif ($this->moyenne>=10 && $this->moyenne<12) {
            echo "Passable\n";
        } elseif ($this->moyenne>=12 && $this->moyenne<14) {
            echo  "Assez-bien \n";
        } elseif ($this->moyenne>=14 && $this->moyenne<16) {
            echo "Bien \n";
        } else {
             echo "Tres bien \n";
        }
    }

    public function showGrades() {
        echo "Here's your grades: ".implode(" ;", $this->grades)."\n";
    }
}

$s = new Student("John");
$s->addGrade(15);
$s->addGrade(18);
$s->addGrade(-2);
$s->showGrades();       // [15, 18]
echo $s->average()."\n";     // 16.5
echo $s->honor();     // 16.5
$s->removeGrade(15);
$s->showGrades();       // [18]

?>