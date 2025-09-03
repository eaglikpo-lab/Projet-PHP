<?php
// Objectif : Travailler avec plusieurs méthodes et la logique interne dans une classe PHP.

class Rectangle {
    // TODO: Good
    public $width;
    public $height;

    public function __construct($width, $height)
    {
        $this ->width = $width;
        $this ->height = $height;
    }

    public function area() {
        // TODO: Good
        return $this ->width * $this ->height;
    }

    public function perimeter() {
        // TODO: Good
        return 2 * ($this->width + $this->height);
    }

    public function isSquare() {
       return ($this->width == $this->height)? true:false; // TODO: Good

       // TODO: Alternative plus simple
       // return $this->width == $this->height; 
    } 

    public function scale($factor) {
       // TODO: Good
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