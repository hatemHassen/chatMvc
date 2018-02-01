<?php

namespace Chat\Entities;

class Message extends Entity
{

    protected $senderId;
    protected $createdAt;
    protected $message;

    /**
     * Message constructor.
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->createdAt=(new \DateTime())->format('d-m-Y H:i');
    }

    /**
     * @return int
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * @param int $senderId
     * @return  $this
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return  $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return  $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

}