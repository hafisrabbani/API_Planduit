<?php

namespace App\DTO;

class ProfileResikoDTO{
    public array $answers;
    public function __construct(array $answers)
    {
        $this->answers = $answers;
    }
}
