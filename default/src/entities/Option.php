<?php

namespace simplon\entities;

class Option {

    private $id;
    private $text;
    private $pollId;

    public function __construct(string $text,
                                int $pollId,
                                int $id=null) {
        $this->id = $id;
        $this->text = $text;
        $this->pollId = $pollId;
    }
    

}