<?php

namespace Sb\Phalcon\Service\Auth;

use Phalcon\Di\Injectable;
use Sb\Phalcon\Exception\ApplicationException;

/**
 * @property \Sb\Phalcon\Model\Repository modelsRepository
 */
class Auth extends Injectable
{
    const USER_ID = 'userId';

    private $data = [];
    private $dataModel;

    public function __construct($dataModel = null)
    {
        $data = $this->session->get('auth');
        if (is_array($data)) {
            $this->data = $data;
        }
        if ($dataModel) {
            $this->dataModel = $dataModel;
        }
    }

    public function isAuthorized()
    {
        if (!array_key_exists(self::USER_ID, $this->data)) {
            return false;
        }
        if (!$this->data[self::USER_ID]) {
            return false;
        }
        return true;
    }

    public function getUserId()
    {
        if (!$this->isAuthorized()) {
            throw new ApplicationException('User not auth');
        }

        $userId = $this->data[self::USER_ID];

        return $userId;
    }

    public function getUser()
    {
        if (!$this->isAuthorized()) {
            throw new ApplicationException('User not auth');
        }

        $userId = $this->data[self::USER_ID];

        if (!$this->dataModel) {
            throw new ApplicationException('User data model not defined');
        }

        return $this->modelsRepository->getModel($this->dataModel)->getUserById($userId);
    }

    public function getUserIdIfExist()
    {
        if (!array_key_exists(self::USER_ID, $this->data)) {
            return null;
        }

        $userId = $this->data[self::USER_ID];
        return $userId;
    }

    public function save(array $data)
    {
        $this->data = $data;
        $this->session->set('auth', $data);
    }

    public function getData()
    {
        return $this->data;
    }
}