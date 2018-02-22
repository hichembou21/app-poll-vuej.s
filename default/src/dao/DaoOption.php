<?php

namespace simplon\dao;
use simplon\dao\Connect;
use simplon\entities\Poll;
use simplon\entities\Option;

class DaoOption {
    

    public function getAll():array {
        
        $tab = [];
        
        try {
        
        $query = Connect::getInstance()->prepare('SELECT * FROM person');
        $query->execute();
    
        while($row = $query->fetch()) {
            
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