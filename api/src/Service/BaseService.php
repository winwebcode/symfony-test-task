<?php

namespace App\Service;

use InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseService
{

    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }

    public function validationErrors(ConstraintViolationListInterface $errors): void
    {
        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                //returns the path to the property that failed validation
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            throw new InvalidArgumentException(json_encode($errorMessages));
        }
    }

    public function validate(object $dto): void
    {
        $errors = $this->validator->validate($dto);
        $this->validationErrors($errors);
    }
}