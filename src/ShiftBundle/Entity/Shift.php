<?php

namespace ShiftBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Blameable;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation\Groups;

/**
 * Shift
 *
 * @ORM\Table(name="shift")
 * @ORM\Entity(repositoryClass="ShiftBundle\Repository\ShiftRepository")
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *         "shift_shift_details",
 *         parameters = { "shift" = "expr(object.getId())" }
 *     ),
 *     exclusion=@Hateoas\Exclusion(
 *         groups={"shift_detail"}
 *     ),
 * )
 */
class Shift implements Timestampable, Blameable
{
    use TimestampableEntity;
    use BlameableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Groups({"shift_detail"})
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var
     *
     * @Groups({"shift_detail"})
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var DateTime
     *
     * @Groups({"shift_detail"})
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @var DateTime
     *
     * @Groups({"shift_detail"})
     *
     * @ORM\Column(name="end", type="datetime")
     */
    private $end;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Shift
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Shift
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set start
     *
     * @param DateTime $start
     *
     * @return Shift
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param DateTime $end
     *
     * @return Shift
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }
}

