<?php
namespace MessageBundle\Controller;

use Api\Exception\ConstraintViolationBadRequestException;
use FOS\Message\Model\ConversationInterface;
use FOS\Message\Model\MessageInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\OffsetRepresentation;
use MessageBundle\Model\MessageInterface as InputMessageInterface;
use FOS\Message\Model\PersonInterface;
use FOS\Message\RepositoryInterface;
use FOS\Message\SenderInterface;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class MessageController
 * @package MessageBundle\Controller
 *
 * @Route("/conversations/{conversation}/messages", service="message_bundle.controller.message")
 */
class MessageController
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var SenderInterface
     */
    private $sender;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * ConversationController constructor.
     * @param RepositoryInterface $repository
     * @param SenderInterface $sender
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        RepositoryInterface $repository,
        SenderInterface $sender,
        TokenStorageInterface $tokenStorage
    ) {
        $this->repository = $repository;
        $this->sender = $sender;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @ApiDoc(
     *     section="Messaging",
     *     description="Get a list of messages for a Conversation",
     *     resource=true,
     *     output={
     *         "class" = "array<FOS\Message\Model\Message>",
     *         "groups" = { "message_list" },
     *     },
     * )
     * @Method("GET")
     * @Route
     * @View(serializerGroups={"message_list"})
     * @param ConversationInterface $conversation
     * @param ParamFetcherInterface $paramFetcher
     * @QueryParam(name="limit", requirements="\d+", default="10", description="Limit Results")
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Offset Results")
     * @ParamConverter(name="conversation", converter="message_bundle.conversation")
     * @return OffsetRepresentation|MessageInterface[]
     */
    public function messagesAction(ConversationInterface $conversation, ParamFetcherInterface $paramFetcher)
    {
        return new OffsetRepresentation(
            new CollectionRepresentation(
                $this->repository->getMessages(
                    $conversation,
                    (int) $paramFetcher->get('offset'),
                    (int) $paramFetcher->get('limit')
                ),
                'message:message',
                'message'
            ),
            'message_message_messages',
            [
                'conversation' => $conversation->getId(),
            ],
            (int) $paramFetcher->get('offset'),
            (int) $paramFetcher->get('limit'),
            null,
            'offset',
            'limit'
        );
    }

    /**
     * @ApiDoc(
     *     section="Messaging",
     *     description="Send a message in a conversation",
     *     input="MessageBundle\Model\Message",
     *     statusCodes={
     *         201 = "Created",
     *     },
     * )
     * @Method("POST")
     * @Route
     * @param ConversationInterface $conversation
     * @param InputMessageInterface $message
     * @param ConstraintViolationListInterface $validationErrors
     * @ParamConverter(name="conversation", converter="message_bundle.conversation")
     * @ParamConverter(name="message", converter="fos_rest.request_body", class="MessageBundle\Model\Message")
     * @View(statusCode=201)
     */
    public function sendMessageAction(ConversationInterface $conversation, InputMessageInterface $message, ConstraintViolationListInterface $validationErrors)
    {
        if(count($validationErrors) > 0) {
            throw new ConstraintViolationBadRequestException($validationErrors);
        }

        $this->sender->sendMessage($conversation, $this->getSender(), $message->getBody());
    }

    /**
     * @return PersonInterface
     */
    private function getSender()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}