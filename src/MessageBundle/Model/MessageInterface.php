<?php
namespace MessageBundle\Model;

interface MessageInterface
{
    /**
     * @return string
     */
    public function getBody();
}