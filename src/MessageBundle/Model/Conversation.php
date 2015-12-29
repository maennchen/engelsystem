<?php
namespace MessageBundle\Model;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class Conversation implements ConversationInterface
{
    /**
     * @var string
     * @Type("string")
     * @NotBlank
     */
    private $body;

    /**
     * @var string|null
     * @Type("string")
     * @Length(max="255")
     */
    private $subject;

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->subject;
    }
}