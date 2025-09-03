<?php
//  Construire une simulation de combat utilisant les principes POO en PHP : attributs, interactions et progression d'expérience.

class Fighter {

    public string $name;
    public int $healthPoints = 100;
    public int $attack; 
    public int $level = 1;
    public int $experience = 0;


    public function __construct($name, $attack)
    {
        $this->name = $name;
        $this->attack = $attack;
    }

    public function attackOpponent(Fighter $target) : void{
        $target->healthPoints -= $this->attack;
        echo $this->name." frappe ".$target->name." pour ".$this->attack." points!\n"; // TODO: revoir l'espacement
        if ($target->healthPoints <= 0) {
            echo $target->name." est vaincu!\n";
            $this->gainExperience(50);
        }
    }

    public function gainExperience($xp) : void {
        
        $this->experience += $xp;
        // TODO: Tous les 100 XP → montée de niveau, augmente l'attaque de 2, restaure 20 HP
        // TODO: revoir la logique
        if ($this->experience % 100 == 0) {
            $this->level += 1;
            $this->attack +=2;
            $this->healthPoints +=20;
        }
    }

    public function isAlive(): bool {
        // TODO: Correct mais peut être simplifié par une structure ternaire ou mieux encore
        return ($this->healthPoints > 0)? true: false;
    }

    public function showStatus (): void {
        echo $this->name. "--> HP: ".$this->healthPoints. "; attacks: ".$this->attack."; level: ".$this->level."; XP: ".$this->experience.".\n"; // TODO: revoir l'espacement
    }

}

$a = new Fighter("Arthur", 15);
$b = new Fighter("Lancelot", 12);

while ($a->isAlive() && $b->isAlive()) {
    $a->attackOpponent($b);
    if ($b->isAlive()) {
        $b->attackOpponent($a);
    }
    echo "\n";
    $a->showStatus();
    $b->showStatus();
    echo str_repeat("=", 20) . "\n";
}

?>