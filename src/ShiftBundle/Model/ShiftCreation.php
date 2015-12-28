<?php
namespace ShiftBundle\Model;


use DateTime;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ShiftCreation implements ShiftCreationInterface
{
    /**
     * @Type("string")
     * @NotBlank
     * @Length(max="255")
     * @var string
     */
    private $title;

    /**
     * @var string|null
     * @Type("string")
     */
    private $description;

    /**
     * @var DateTime
     * @Type("DateTime")
     * @NotNull
     */
    private $start;

    /**
     * @var DateTime
     * @Type("DateTime")
     * @NotNull
     */
    private $end;

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnd()
    {
        return $this->end;
    }
}