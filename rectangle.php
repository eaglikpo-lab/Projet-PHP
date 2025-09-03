<?php
// Objectif : Travailler avec plusieurs méthodes et la logique interne dans une classe PHP.

class Rectangle {
    // TODO: seuls les attributs $width et height sont nécessaires. Faire sans les autres
    public $width;
    public $height;

    public function __construct($width, $height)
    {
        $this ->width = $width;
        $this ->height = $height;
      
    }

    public function area() {
        // TODO: Correct, mais on peut se passer des attributs privés
        return $this ->width * $this ->height;
    }

    public function perimeter() {
        // TODO: Correct, mais on peut se passer des attributs privés
        return 2 * ($this->width + $this->height);
    }

    public function isSquare() {
        // TODO: Correct mais pourrait être simplifié par un ternaire ou mieux
       return ($this->width == $this->height)? true:false;
    } 

    public function scale($factor) {
       // TODO: incorrect. Revoir la logique. On veut élargir le rectangle en fonction du facteur passé
       $this->width *= $factor;
       $this->height *= $factor;
    }
}

$r = new Rectangle(5, 10);
echo "Area: ".$r->area().".\n";        // 50
echo "Perimeter: ".$r->perimeter().".\n";   // 30
var_dump($r->isSquare());  // false
$r->scale(9);   // 

echo "=== Test apres factor === \n Area: ".$r->area().".\n";        // 4050
echo "Perimeter: ".$r->perimeter().".\n";   // 270

?>