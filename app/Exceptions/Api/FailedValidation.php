<?php

namespace App\Exceptions\Api;

use App\Traits\ApiResponser;
use Exception;

class FailedValidation extends Exception
{
    use ApiResponser;

    public function __construct(private $errors)
    {
    }

    public function render()
    {
        return $this->validationError($this->errors);
    }
}
