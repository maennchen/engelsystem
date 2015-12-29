<?php
namespace MessageBundle\Model;

interface ConversationInterface extends MessageInterface
{
    /**
     * @return string|null
     */
    public function getSubject();
}