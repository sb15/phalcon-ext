<?php

namespace Sb\Phalcon\Exception;

use \Phalcon\Validation\Message;

class ApplicationException extends \Exception
{

    private $messages = [];

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        if ($message instanceof \Phalcon\Validation\Message\Group) {
            $messages = [];
            foreach ($message as $temp) {
                $messages[] = $temp;
            }
        } elseif (is_array($message)) {
            $messages = $message;
        } else {
            $messages = [$message];
        }

        $this->messages = $messages;

        $message = reset($messages);
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return Message[]
     */
    public function getMessages()
    {
        $result = [];

        foreach ($this->messages as $message) {
            if ($message instanceof Message) {
                $result[] = $message;
            } elseif ($message instanceof \Phalcon\Mvc\Model\Message) {
                $result[] = new Message($message->getMessage(), $message->getField(), $message->getType());
            } else {
                $result[] = new Message($message);
            }
        }

        return $result;
    }

    public function getMessagesByFields()
    {
        $result = [];
        $messages = $this->getMessages();
        foreach ($messages as $message) {
            $field = $message->getField();
            if (!$field) {
                $field = '_';
            }
            if (!array_key_exists($field, $result)) {
                $result[$field] = [];
            }
            $result[$field][] = $message;
        }
        return $result;
    }

}