<?php
    class Animal {
        public string $name;

        public function __construct($name)
        {
           $this->name = $name; 
        }

        public function speak(): void {
            echo "Cet animal n'a pas de son spécifique.\n";
        }

        public function describe() {
            echo "Je decris dans la classe Animal.\n";
        }
    }

    class Dog extends Animal {
        public function speak(): void {
        echo "Woof!\n";
        }

        public function describe() {
            echo "Je suis un chien qui s'appelle".$this->name. ".\n";
        }
    }

    
    class Cat extends Animal {
        public function speak(): void {
        echo "Meow!\n";
        }

        public function describe() {
            echo "Je suis un chat qui s'appelle".$this->name. ".\n";
        }
    }

    
    class Cow extends Animal {
        public function speak(): void {
        echo "Moo!\n";
        }

        public function describe() {
            echo "Je suis une vache qui s'appelle: ".$this->name. ".\n";
        }
    }

    function  makeAnimalsSpeak(array $animals) {
        foreach ($animals as $animal) {
            $animal->describe();
            echo "Mon cri c'est: ";
            $animal->speak();
        }
    }
        
    //$animals = [new Dog("Rex"), new Cat("Mimi"), new Cow("Daisy")];
    $animals = [new Dog("Rex"), new Cat("Mimi"), new Cow("Daisy"), "point"];
    

    $allvalid = true;

    foreach ($animals as $animal) {
        if (!($animal instanceof Animal)) {
            $allvalid = false;
            break;
        }
    }
    
    if ($allvalid) {
        makeAnimalsSpeak($animals);
    } else {
        echo "Erreur: un des objets n'herite pas d'Animal.\n";
    }
    
    

?>