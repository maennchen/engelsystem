<?php
namespace MessageBundle\Model;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class Message implements MessageInterface
{
    /**
     * @var string
     * @Type("string")
     * @NotBlank
     */
    private $body;

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}