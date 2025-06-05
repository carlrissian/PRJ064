<?php


namespace App\Validator;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ArticleGroupValidator
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
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function validate($response, $groups)
    {
        $dataToValidate = $this->serializer->serialize($response,"json");
        $dataToValidate = json_decode($dataToValidate,true);

        return $this->validator->validate($dataToValidate, $this->getRules(), $groups);
    }

    public function getRules()
    {
        $constraint = new Assert\Collection([
            // the keys correspond to the keys in the input array
            'name' => [
                        //new Assert\Length(['min' => 50,'minMessage' => "El campo Nombre tiene que tener al menos {{ limit }} caracteres",'groups' => ['store','update']]),
                        //new Assert\Blank(['message' => "El campo Nombre deberia estar vacío y tiene este valor {{ value }}",'groups' => ['store','update']])
                      ],
            'complementCategoryId' => new Assert\Positive()
        ]);
        /*$metadata->addPropertyConstraint('bookingNumber', new Assert\Length([
            'max' => 20,
            'groups' => ['create','update'],
            'maxMessage'=> "El campo debe tener como máximo {{ limit }} carácteres."
        ])); */
        return $constraint;

    }
}