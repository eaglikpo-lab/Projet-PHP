<?php
//Travailler avec des tableaux internes, ajouter/supprimer des éléments et calculer des statistiques.

class Student {

    public string $name;
    public array $grades= [];
    private float $moyenne = 0;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
        
    /*public function addGrade (float $grade): void {
        $new_note = 0;
        if ($grade <0 && $grade>20) {
            do {
                echo "Invalid grade. Put a right grade here: \n";
                $new_note = (float)trim(fgets(STDIN));
            }while ($new_note>=0 && $new_note<=20);  
            $grade = $new_note;
        }
          $this->grades[] = $grade; 
    }*/

    public function addGrade (float $grade): void {
        $new_note = 0;
        if ($grade >=0 && $grade<=20) {
            $this->grades[] = $grade;
        }else {
            echo "Invalid grade. \n";
            //$new_note = (float)trim(fgets(STDIN));    
        }
    }
    
    public function removeGrade(float $grade): void {
        foreach ($this->grades as $key =>$g) {
            if ($grade == $g) {
                unset($this->grades[$key]); 
            }
            $this->grades = array_values($this->grades);
        }

    }

    public function average() : float {
        $somme = 0;
        foreach ($this->grades as $key =>$g) {
            $somme += $g; 
        }
        echo "Your average is: ";
        $this->moyenne = $somme/count($this->grades);
        return $this->moyenne;
    }

    public function honor() : void{
        if ($this->moyenne <10) {
            echo "Insuffisant\n" ;
            echo $this->moyenne;
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