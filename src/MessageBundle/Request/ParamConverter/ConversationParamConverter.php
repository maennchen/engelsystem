<?php
namespace MessageBundle\Request\ParamConverter;

use FOS\Message\Model\ConversationInterface;
use FOS\Message\RepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConversationParamConverter implements ParamConverterInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * ConversationParamConverter constructor.
     * @param RepositoryInterface $repository
     */
    public function __construct(
        RepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if(!$request->attributes->has($configuration->getName())) {
            return false;
        }

        $id = $request->attributes->get($configuration->getName());

        $conversation = $this->repository->getConversation($id);

        if(!$conversation) {
            throw new NotFoundHttpException();
        }

        $request->attributes->set($configuration->getName(), $conversation);

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === ConversationInterface::class;
    }
}