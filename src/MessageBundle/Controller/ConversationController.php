<?php

namespace MessageBundle\Controller;

use FOS\Message\Model\ConversationInterface;
use FOS\Message\Model\PersonInterface;
use FOS\Message\RepositoryInterface;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ConversationController
 * @package MessageBundle\Controller
 * @Route(service="message_bundle.controller.conversation")
 */
class ConversationController
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
     *     description="List all conversations o a user",
     *     resource=true,
     *     output={
     *         "class" = "array<FOS\Message\Model\Conversation>",
     *         "groups" = { "conversation_list" }
     *     },
     *     statusCodes={
     *         200 = "Loaded List",
     *     },
     * )
     * @Route("/users/{user}/conversations")
     * @param PersonInterface $user
     * @ParamConverter(name="user", class="UserBundle:User", converter="doctrine.orm")
     * @Method("GET")
     * @View(serializerGroups={"conversation_list"})
     * @return ConversationInterface[]
     */
    public function listAction(PersonInterface $user)
    {
        return $this->repository->getPersonConversations($user);
    }

    /**
     * @ApiDoc(
     *     section="Messaging",
     *     description="Get details of a conversation",
     *     resource=true,
     *     output={
     *         "class" = "FOS\Message\Model\Conversation",
     *         "groups" = { "conversation_detail" }
     *     },
     * )
     * @Method("GET")
     * @Route("/conversations/{conversation}")
     * @View(serializerGroups={"conversation_detail"})
     * @param ConversationInterface $conversation
     * @ParamConverter(name="conversation", converter="message_bundle.conversation")
     * @return ConversationInterface
     */
    public function detailsAction(ConversationInterface $conversation)
    {
        return $conversation;
    }
}
