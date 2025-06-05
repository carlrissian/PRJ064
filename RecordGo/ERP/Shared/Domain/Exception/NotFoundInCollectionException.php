<?php


namespace Shared\Domain\Exception;

/**
 * Class NotFoundInCollectionException
 * @package Shared\Domain\Exception
 */
class NotFoundInCollectionException extends \Exception
{

    /**
     * NotFoundInCollectionException constructor.
     * @param null $message
     */
    public function __construct($message = null)
    {
        parent::__construct($message, 404);
    }
}
