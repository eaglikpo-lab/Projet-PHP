<?php
class Vehicule {
    public string $brand;
    public string $model;


    public function __construct($brand, $model)
    {
        $this->brand = $brand;
        $this->model = $model;
    }
    
    public function move() : void {
        echo "Le vehicule se deplace. \n";
    }

    public function displayInfo() : void {
        echo "Marque: ".$this->brand."; Modele: ".$this->model.". \n";
    }
}

class Car extends Vehicule {
    // TODO: la méthode move doit être redéfini
    public function moved() {
        return "La voiture roule sur la route.\n";
    }
} 


class Boat extends Vehicule {
    // TODO: la méthode move doit être redéfini
    public function moved() {
        return "Le bateau navige sur l'eau.\n";
    }
} 

$v = new Vehicule("Generic", "X");
$v->move();         // Le véhicule se déplace.
$v->displayInfo();  

$car = new Car("Toyota", "Corolla");
echo $car->moved();       // La voiture roule sur la route.
$car->displayInfo();       


$boat = new Boat("Yamaha", "WaveRunner");
echo $boat->moved();      // Le bateau navigue sur l'eau.
$boat->displayInfo();      


?>