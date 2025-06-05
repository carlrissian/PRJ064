<?php


namespace App\Validator;


use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateRateValidator
{
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * CreateRateValidator constructor.
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function validate($command)
    {
        $dataToValidate = $this->serializer->serialize($command,"json");
        $dataToValidate = json_decode($dataToValidate,true);
        unset($dataToValidate["id"]);

        return $this->validator->validate($dataToValidate, $this->getRules());
    }

    public function getRules()
    {
        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'name' => new Assert\NotBlank(),
            'delegationId' => new Assert\NotBlank(),
        ]);
        return $constraint;

    }
}