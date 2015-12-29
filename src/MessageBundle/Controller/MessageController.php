<?php
namespace MessageBundle\Controller;

use FOS\Message\Model\ConversationInterface;
use FOS\Message\Model\MessageInterface;
use FOS\Message\RepositoryInterface;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class MessageController
 * @package MessageBundle\Controller
 *
 * @Route(service="message_bundle.controller.message")
 */
class MessageController
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * ConversationController constructor.
     * @param RepositoryInterface $repository
     */
    public function __construct(
        RepositoryInterface $repository
    ) {
        $this->repository = $repository;
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
     * @Route("/conversations/{conversation}/messages")
     * @Method("GET")
     * @View(serializerGroups={"message_list"})
     * @param ConversationInterface $conversation
     * @return MessageInterface[]
     */
    public function messagesAction(ConversationInterface $conversation)
    {
        return $this->repository->getMessages($conversation);
    }
}