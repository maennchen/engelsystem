<?php
namespace ShiftBundle\Controller;

use Api\Exception\ConstraintViolationBadRequestException;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use ShiftBundle\Entity\Shift;
use ShiftBundle\Handler\ShiftHandlerInterface;
use ShiftBundle\Model\ShiftCreationInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ShiftsController
 * @package ShiftBundle\Controller
 *
 * @Route("/shifts", service="shift_bundle.controller.shift")
 */
class ShiftController
{
    /**
     * @var ShiftHandlerInterface
     */
    private $shiftHandler;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * ShiftController constructor.
     * @param ShiftHandlerInterface $shiftHandler
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        ShiftHandlerInterface $shiftHandler,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->shiftHandler = $shiftHandler;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @ApiDoc(
     *     section="Shift",
     *     description="Lists Shifts",
     *     resource=true,
     * )
     * @Method("GET")
     * @Route()
     * @View()
     */
    public function listAction()
    {
        return $this->shiftHandler->find();
    }

    /**
     * @ApiDoc(
     *     section="Shift",
     *     description="Create a Shift",
     *     input="ShiftBundle\Model\ShiftCreation",
     *     statusCodes={
     *         201 = "Successfully created the shift",
     *     },
     * )
     * @Method("PUT")
     * @Route()
     * @View(statusCode=201)
     * @param ShiftCreationInterface $shiftCreation
     * @param ConstraintViolationListInterface $validationErrors
     * @ParamConverter(name="shiftCreation", converter="fos_rest.request_body", class="ShiftBundle\Model\ShiftCreation")
     * @return Response
     */
    public function createAction(ShiftCreationInterface $shiftCreation, ConstraintViolationListInterface $validationErrors)
    {
        if(count($validationErrors) > 0) {
            throw new ConstraintViolationBadRequestException($validationErrors);
        }

        $shift = $this->shiftHandler->create($shiftCreation);

        return new Response(null, Response::HTTP_CREATED, [
            'Location' => $this->urlGenerator->generate('shift_shift_details', [
                'shift' => $shift->getId(),
            ])
        ]);
    }

    /**
     * @ApiDoc(
     *     section="Shift",
     *     description="Show details of a shift",
     *     resource=true,
     *     output={
     *         "class" = "ShiftBundle\Entity\Shift",
     *         "groups" = { "shift_detail" },
     *     },
     *     statusCodes={
     *         200 = "Successfully show Shift",
     *     },
     * )
     * @Method("GET")
     * @Route("/{shift}")
     * @View(serializerGroups={"shift_detail"})
     * @param Shift $shift
     * @ParamConverter(name="shift", converter="doctrine.orm", class="ShiftBundle:Shift")
     * @return Shift
     */
    public function detailsAction(Shift $shift)
    {
        return $shift;
    }

    /**
     * @ApiDoc(
     *     section="Shift",
     *     description="Delete a Shift",
     *     statusCodes={
     *         204 = "Successfully deleted the shift"
     *     }
     * )
     * @Method("DELETE")
     * @Route("/{shift}")
     * @View(statusCode=204)
     * @param Shift $shift
     * @ParamConverter(name="shift", converter="doctrine.orm", class="ShiftBundle:Shift")
     */
    public function deleteAction(Shift $shift)
    {
        $this->shiftHandler->delete($shift);
    }
}