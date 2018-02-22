<?php

namespace simplon\entities;

class Poll {
    private $id;
    private $title;

    public function __construct(string $title,
                                int $id=null) {
        $this->id = $id;
        $this->name = $name;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
    }
    

   
}