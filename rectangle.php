<?php
// Objectif : Travailler avec plusieurs méthodes et la logique interne dans une classe PHP.

class Rectangle {
    public $width;
    public $height;
    private $area = 0;
    private $perimeter = 0;
    private $factor = 0;

    public function __construct($width, $height)
    {
        $this ->width = $width;
        $this ->height = $height;
        //$this ->area = $area;
        //$this ->perimeter = $perimeter;
    }

    public function area() {
        $this ->area = $this ->width * $this ->height;
        return $this->area;
    }

    public function perimeter() {
        $this->perimeter = 2 * ($this->width + $this->height);
        return $this->perimeter;
    }

    public function isSquare() {
        if ($this->width == $this->height) {
            return true;
        }else {
            return false;
        }
    }

    public function scale($factor) {
       return $this->factor = $this->height*$this->width*$factor;
    }
}

$r = new Rectangle(5, 10);
echo "Area: ".$r->area().".\n";        // 50
echo "Perimeter: ".$r->perimeter().".\n";   // 30
$r->isSquare();  // false
echo "Factor: ".$r->scale(9).".\n";   // 30

?>