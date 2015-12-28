<?php
namespace ShiftBundle\Handler;

use ShiftBundle\Entity\Shift;
use ShiftBundle\Model\ShiftCreationInterface;

interface ShiftHandlerInterface
{
    /**
     * @param ShiftCreationInterface $shiftCreation
     * @return Shift
     */
    public function create(ShiftCreationInterface $shiftCreation);

    /**
     * @param Shift $shift
     * @return void
     */
    public function delete(Shift $shift);

    /**
     * @return Shift[]
     */
    public function find();
}