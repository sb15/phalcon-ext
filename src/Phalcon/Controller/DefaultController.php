<?php

namespace Sb\Phalcon\Controller;

class DefaultController extends \Phalcon\Mvc\Controller
{
    /**
     * @param $data
     * @deprecated
     */
    public function setViewVars($data)
    {
        $this->setParamsToView($data);
    }

    public function setParamsToView($data)
    {
        $this->view->setVars($data);
    }

    public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
    {

    }

    public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
    {

    }

    /**
     * @return \Model\ModelsRepository
     */
    public function getModels()
    {
        return $this->getDI()->get('modelsRepository');
    }

    /**
     * @return \Phalcon\Cache\BackendInterface
     */
    public function getFastCache()
    {
        return $this->getDI()->get('fastCache');
    }

    /**
     * @return \Phalcon\Cache\BackendInterface
     */
    public function getSlowCache()
    {
        return $this->getDI()->get('slowCache');
    }

    /**
     * @return Raven_Client
     */
    public function getSentry()
    {
        return $this->getDI()->get('sentry');
    }

    public function url($routeName, $params = array())
    {
        $urlHelper = new Helpers\UrlHelper($this->getDI());
        $url = $urlHelper->get($routeName, $params);
        return $url;
    }

    /**
     * @return Helpers\UrlHelper
     */
    public function getUrlHelper()
    {
        return $this->di->get(Helpers\UrlHelper::SERVICE_NAME);
    }

    /**
     * @return Helpers\SeoHelper
     */
    public function getSeoHelper()
    {
        return $this->di->get(Helpers\SeoHelper::SERVICE_NAME);
    }

    /**
     * @return Helpers\ViewHelper
     */
    public function getViewHelper()
    {
        return $this->di->get('helper');
    }

    /**
     * @return Helpers\BreadcrumbHelper
     */
    public function getBreadcrumbHelper()
    {
        return $this->di->get(Helpers\BreadcrumbHelper::SERVICE_NAME);
    }

    protected function p($param = null, $default = null, $filters = null)
    {

        if (is_null($param)) {
            $result = array();

            $params = array_keys($this->dispatcher->getParams());
            foreach ($params as $paramName) {
                $result[$paramName] = $this->dispatcher->getParam($paramName, $filters);
            }

            $params = array_keys(array_merge($_GET, $_POST));

            foreach ($params as $paramName) {
                if ($paramName == '_url') {
                    continue;
                }
                $result[$paramName] = $this->request->get($paramName, $filters);
            }

            return $result;

        } else {

            $params = $this->dispatcher->getParams();
            $value = null;

            foreach ($params as $paramName => $paramValue) {
                if ($paramName === $param) {
                    $value = $this->dispatcher->getParam($param, $filters);
                    break;
                } elseif (is_numeric($paramName) && $paramValue === $param) {
                    $value = $params[$paramName+1];
                    break;
                }
            }

            if (!$value) {
                $value = $this->request->get($param, $filters);
            }

            if (!empty($default) && empty($value)) {
                $value = $default;
            }

            if (is_null($value)) {
                $result = null;
            } elseif (is_array($value)) {
                $result = $value;
            } else {
                $result = trim($value);
            }
        }
        return $result;
    }

    public function error404()
    {
        header("Status: 404 Not Found");
        $this->view->pick('error/404');
    }
}