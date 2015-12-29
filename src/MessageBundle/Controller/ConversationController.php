<?php

namespace MessageBundle\Controller;

use Api\Exception\ConstraintViolationBadRequestException;
use FOS\Message\Model\ConversationInterface;
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
use MessageBundle\Model\ConversationInterface as InputConversationInterface;

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

    /**
     * @ApiDoc(
     *     section="Messaging",
     *     description="Start a conversation wich a user",
     *     input="MessageBundle\Model\Conversation",
     *     statusCodes={
     *         201 = "Created",
     *     },
     * )
     * @Method("POST")
     * @Route("/users/{user}/conversations")
     * @param PersonInterface $user
     * @param InputConversationInterface $conversation
     * @param ConstraintViolationListInterface $validationErrors
     * @ParamConverter(name="conversation", converter="fos_rest.request_body", class="MessageBundle\Model\Conversation")
     * @ParamConverter(name="user", class="UserBundle:User", converter="doctrine.orm")
     * @View(statusCode=201)
     */
    public function startConversationAction(PersonInterface $user, InputConversationInterface $conversation, ConstraintViolationListInterface $validationErrors)
    {
        if(count($validationErrors) > 0) {
            throw new ConstraintViolationBadRequestException($validationErrors);
        }

        $this->sender->startConversation($this->getSender(), $user, $conversation->getBody(), $conversation->getSubject());
    }

    /**
     * @return PersonInterface
     */
    private function getSender()
    {
        return $this->tokenStorage->getToken()->getUser();
    }
}
