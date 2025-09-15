<?php
//Construire une application console en PHP qui permet à un utilisateur de gérer une liste de tâches stockées de manière persistante dans un fichier JSON.


class Task
{
    public int $id;
    public string $description;
    public bool $done;


    public function __construct($id, $description, $done)
    {
        $this->description = $description;
        $this->id = $id; //TODO: En procédant ainsi, on peut renseigner l'ID manuellement en instanciant la classe
        $this->done = $done;
    }

    public function __toString()
    {
        return "\n" . $this->id . ". " . $this->description . " [" . ($this->done ? "✓" : " ") . "]\n";
    }

    public function toArrray()
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'done' => $this->done
        ];
    }

    public static function fromArray($arr)
    {
        return new Task($arr['id'], $arr['description'], $arr['done']);
    }
}

class TodoList
{
    public array $tasks;
    public $nextId;

    public function __construct()
    {
        $this->tasks = [];
        $this->nextId = 0;
    }


    public function addTask($description)
    {
        $this->nextId++;
        $tache = new Task($this->nextId, $description, false);
        $this->tasks[] = $tache;
        echo "Tache ajoute";
    }

    public function listTasks()
    {
        //print_r($tasks[]);
        foreach ($this->tasks as $task) {
            echo $task . "\n";
        }
    }

    //TODO: Ajouter la possibilité de faire l'inverse; c-à-d, marquer la tâche comme non terminée
    public function markDone($taskId)
    {
        foreach ($this->tasks as $task) {
            if ($task->id == $taskId) {
                $task->done = true;
                return true;
            }
        }
        return false; // si ID non trouvé    
    }

    public function deleteTask($taskId)
    {
        foreach ($this->tasks as $task) {
            if ($task->id == $taskId) {
                unset($this->tasks[$taskId]);
            }
        }
    }

    public function saveToFile($filename)
    {
        // Sauvegarde
        file_put_contents($filename, json_encode($this->tasks));
    }

    public function loadFromFile($filename)
    {
        //$this->tasks = json_decode(file_get_contents($filename));
        if (file_exists($filename)) {
            $data = json_decode(file_get_contents($filename), true);
            $this->tasks = [];
            $maxId = 0;
            foreach ($data as $item) {
                $task = Task::fromArray($item);
                $this->tasks[] = $task;
                if ($task->id > $maxId) $maxId = $task->id;
            }
            $this->nextId = $maxId; // pour continuer l'ID
        }
    }
}

//$tache = new Task();
$todo = new TodoList();

do {
    $v = 1;
    $todo->loadFromFile("list.json");

    echo " Application Console To-Do List\n 1. Ajouter une tache\n 2. Lister les tâches\n 3. Marquer une tâche comme terminée\n 4. Supprimer une tâche\n 5. Quitter\n";

    $line = trim(fgets(STDIN));
    $level = substr($line, 0, 1);

    if ($level == "1") {
        echo "Ajouter une tache.";
        do {
            echo "\n Decrivez la tache : ";
            $description = trim(fgets(STDIN));
        } while (empty($description));

        $todo->addTask($description);
        $todo->saveToFile("list.json");
    } elseif ($level == "2") {
        echo "\n --- Listes des taches ---";
        $todo->listTasks();
    } elseif ($level == "3") {
        do {
            echo "\n ID de la tache termine : ";
            $taskId = trim(fgets(STDIN));
        } while (empty($taskId));
        $todo->markDone($taskId);
        $todo->saveToFile("list.json");
    } elseif ($level == "4") {
        do {
            echo "\n ID de la tache termine : ";
            $taskId = trim(fgets(STDIN));
        } while (empty($taskId));
        $todo->deleteTask($taskId);
        $todo->saveToFile("list.json");
    } elseif ($level == "5") {
        $v = 0;
    } else {
        echo " Option invalide. Choisis entre 1 et 5: ";
    }
} while ($v);