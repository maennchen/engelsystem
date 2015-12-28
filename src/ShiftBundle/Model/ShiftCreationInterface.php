<?php
namespace ShiftBundle\Model;

use DateTime;

interface ShiftCreationInterface
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string|null
     */
    public function getDescription();

    /**
     * @return DateTime
     */
    public function getStart();

    /**
     * @return DateTime
     */
    public function getEnd();
}