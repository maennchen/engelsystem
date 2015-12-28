<?php
namespace ShiftBundle\Handler;

use ShiftBundle\Entity\Shift;
use ShiftBundle\Model\ShiftCreationInterface;
use ShiftBundle\Repository\ShiftRepository;

class ShiftHandler implements ShiftHandlerInterface
{
    /**
     * @var ShiftRepository
     */
    private $shiftRepository;

    /**
     * ShiftHandler constructor.
     * @param ShiftRepository $shiftRepository
     */
    public function __construct(
        ShiftRepository $shiftRepository
    ) {
        $this->shiftRepository = $shiftRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ShiftCreationInterface $shiftCreation)
    {
        $shift = new Shift();

        $shift
            ->setTitle($shiftCreation->getTitle())
            ->setDescription($shiftCreation->getDescription())
            ->setStart($shiftCreation->getStart())
            ->setEnd($shiftCreation->getEnd())
        ;

        $this->shiftRepository->persist($shift);
        $this->shiftRepository->flush($shift);

        return $shift;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Shift $shift)
    {
        $this->shiftRepository->remove($shift);
        $this->shiftRepository->flush($shift);
    }

    /**
     * {@inheritdoc}
     */
    public function find()
    {
        return $this->shiftRepository->findAll();
    }
}