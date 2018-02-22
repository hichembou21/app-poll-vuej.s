<?php

namespace simplon\dao;
use simplon\entities\Poll;
use simplon\dao\Connect;

class DaoPoll {
    

    public function getAll():array {
        
        $tab = [];
        /*On crée une connexion à notre base de données en utilisant 
        l'objet PDO qui attend en premier argument le nom de notre SGBD,
        l'hôte où est notre bdd (ici c'est mysql du fait qu'on soit sur un docker)
        et le nom de la bdd, en deuxième argument le nom d'utilisateur de notre bdd et en troisième argument son
        mot de passe.
        On récupère une connexion à la base sur laquelle on pourra
        faire des requêtes et autre.
        */
        try {
        /*On utilise la méthode prepare() de notre connexion pour préparer
        une requête SQL (elle n'est pas envoyée tant qu'on ne lui dit pas)
        La méthode prepare attend en argument une string SQL
        */
        $query = Connect::getInstance()->prepare('SELECT * FROM person');
        //On dit à notre requête de s'exécuter, à ce moment là, le résultat
        //de la requête est disponible dans la variable $query
        $query->execute();
        /*On itère sur les différentes lignes de résultats retournées par
        notre requête en utilisant un $query->fetch qui renvoie une ligne
        de résultat sous forme de tableau associatif tant qu'il y a des
        résultat. On stock donc le retour de ce fetch dans une variable 
        $row et on boucle dessus
        */
        while($row = $query->fetch()) {
            /*
            A chaque tour de boucle, on se sert de notre ligne de résultat
            sous forme de tableau associatif pour créer une instance de 
            Person en lui donnant en argument les différentes valeurs des
            colonnes de la ligne de résultat.
            Les index de $row correspondent aux noms de colonnes dans notre
            SQL.
            */
            $pers = new Person($row['name'], 
                        new \DateTime($row['birth_date']), 
                        $row['gender'],
                        $row['id']);
            //On ajoute la person créée à notre tableau
            $tab[] = $pers;
        }
    }catch(\Exception $e) {
        echo $e;
    }
        //On return le tableau
        return $tab;
    }

    public function getById(int $id) {

        try {
            $query = Connect::getInstance()->prepare('SELECT * FROM person WHERE id=:id');
            $query->bindValue(':id', $id, \PDO::PARAM_INT);
            $query->execute();
            if ($row = $query->fetch()) {
                $pers = new Person($row['name'], 
                            new \DateTime($row['birth_date']), 
                            $row['gender'],
                            $row['id']);
                return $pers;
            }
        }catch(\Exception $e) {
            echo $e;
        }
        return null;
    }

    public function add(Person $person) {
        
            try {
                $query = Connect::getInstance()->prepare("INSERT INTO person (name, birth_date, gender) VALUE  (:name, :birth_date, :gender)");
                $query->bindValue(':name', $person->getName(), \PDO::PARAM_STR);
                $query->bindValue(':birth_date', $person->getBirthdate()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
                $query->bindValue(':gender', $person->getGender(), \PDO::PARAM_INT);
                // $query->bindValue(':id', $person->getId(), \PDO::PARAM_INT);
                
                $query->execute();
                $person->setId(Connect::getInstance()->lastInsertId());

            }catch(\Exception $e) {
                echo $e;
            }
    }

    public function update(Person $person) {
        
            try {
                $query = Connect::getInstance()->prepare(" UPDATE person SET name=:name, birth_date=:birth_date, gender=:gender WHERE id=:id");
                $query->bindValue(':name', $person->getName(), \PDO::PARAM_STR);
                $query->bindValue(':birth_date', $person->getBirthdate()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
                $query->bindValue(':gender', $person->getGender(), \PDO::PARAM_INT);
                $query->bindValue(':id', $person->getId(), \PDO::PARAM_INT);
                
                // $query->bindValue(':id', $person->getId(), \PDO::PARAM_INT);
                
                $query->execute();

            }catch(\Exception $e) {
                echo $e;
            }
    }

    public function delete(Person $person) {
        
            try {
                $query = Connect::getInstance()->prepare(" DELETE FROM person WHERE id=:id");
                $query->bindValue(':id', $person->getId(), \PDO::PARAM_INT);
                
                // $query->bindValue(':id', $person->getId(), \PDO::PARAM_INT);
                $query->execute();

            }catch(\Exception $e) {
                echo $e;
            }
    }

}