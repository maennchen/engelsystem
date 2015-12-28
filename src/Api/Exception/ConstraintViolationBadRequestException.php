<?php
namespace Api\Exception;

use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationBadRequestException extends BadRequestHttpException
{
    /**
     * Constructor.
     * @param ConstraintViolationListInterface $violations
     * @param Exception $previous
     * @param int $code
     */
    public function __construct(ConstraintViolationListInterface $violations, Exception $previous = null, $code = 0)
    {
        $message = '';

        /** @var ConstraintViolationInterface $violation */
        foreach($violations as $violation) {
            $message .= $violation->getPropertyPath() . ' - ' . $violation->getMessage() . PHP_EOL;
        }

        parent::__construct($message, $previous, $code);
    }
}