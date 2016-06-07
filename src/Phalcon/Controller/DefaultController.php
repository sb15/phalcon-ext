<?php

namespace Sb\Phalcon\Controller;

use Sb\Phalcon\Helpers;
/**
 * Class DefaultController
 * @package Sb\Phalcon\Controller
 *
 * @property \Phalcon\Mvc\Dispatcher dispatcher
 * @property \Phalcon\Mvc\Router router
 * @property \Phalcon\Mvc\Url url
 * @property \Phalcon\Http\Request request
 * @property \Phalcon\Http\Response response
 * @property \Phalcon\Http\Response\Cookies cookies
 * @property \Phalcon\Filter filter
 * @property \Phalcon\Flash\Direct flash
 * @property \Phalcon\Flash\Session flashSession
 * @property \Phalcon\Session\Adapter\Files session
 * @property \Phalcon\Events\Manager eventsManager
 * @property \Phalcon\Db db
 * @property \Phalcon\Security security
 * @property \Phalcon\Crypt crypt
 * @property \Sb\Phalcon\Service\Tag\Tag tag
 * @property \Phalcon\Escaper escaper
 * @property \Phalcon\Annotations\Adapter\Memory annotations
 * @property \Phalcon\Mvc\Model\Manager modelsManager
 * @property \Phalcon\Mvc\Model\MetaData\Memory modelsMetadata
 * @property \Phalcon\Mvc\Model\Transaction\Manager transactionManager
 * @property modelsCache
 * @property viewsCache
 * @property \Phalcon\Mvc\View view
 * @property \Sb\Phalcon\Model\Repository modelsRepository
 * @property \Sb\Phalcon\Form\Repository formsRepository
 * @property \Phalcon\Cache\Backend\File slowCache
 * @property \Phalcon\Cache\Backend\Memcache fastCache
 * @property \Phalcon\Config config
 * @property \Raven_Client sentry          
 * @property \Sb\Phalcon\Service\Path\Path path
 * @property \Sb\Phalcon\Service\Seo\Seo seo
 * @property \Sb\Phalcon\Service\Breadcrumb\Breadcrumb breadcrumb
 *
 * @method void beforeDispatchLoop(Phalcon\Mvc\Dispatcher $dispatcher)
 * @method void beforeDispatch(Phalcon\Mvc\Dispatcher $dispatcher)
 * @method void beforeExecuteRoute(Phalcon\Mvc\Dispatcher $dispatcher)
 * @method void initialize(Phalcon\Mvc\Dispatcher $dispatcher)
 * @method void afterExecuteRoute(Phalcon\Mvc\Dispatcher $dispatcher)
 * @method void beforeNotFoundAction(Phalcon\Mvc\Dispatcher $dispatcher)
 * @method void beforeException(Phalcon\Mvc\Dispatcher $dispatcher)
 * @method void afterDispatch(Phalcon\Mvc\Dispatcher $dispatcher)
 * @method void afterDispatchLoop(Phalcon\Mvc\Dispatcher $dispatcher)
 * 
 */
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

    public function disableLayout()
    {
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
    }

    public function setJsonResponse()
    {
        $this->view->setVar(\Sb\Phalcon\Plugins\ViewReturnPlugin::SET_JSON_RESPONSE, true);
    }

    /**
     * @deprecated
     * @return \Model\ModelsRepository
     */
    public function getModels()
    {
        return $this->getDI()->get('modelsRepository');
    }

    /**
     * @deprecated
     * @return \Phalcon\Cache\BackendInterface
     */
    public function getFastCache()
    {
        return $this->getDI()->get('fastCache');
    }

    /**
     * @deprecated
     * @return \Phalcon\Cache\BackendInterface
     */
    public function getSlowCache()
    {
        return $this->getDI()->get('slowCache');
    }

    /**
     * @deprecated
     * @return Raven_Client
     */
    public function getSentry()
    {
        $sentry = $this->getDI()->get('sentry');
        if (!$sentry) {
            $sentry = new \Sb\Phalcon\Replacer\Replacer();
        }
        return $sentry;
    }

    /**
     * @deprecated
     * @param $routeName
     * @param array $params
     * @return string
     */
    public function url($routeName, $params = array())
    {
        $urlHelper = new Helpers\UrlHelper($this->getDI());
        $url = $urlHelper->get($routeName, $params);
        return $url;
    }

    /**
     * @deprecated
     * @return Helpers\UrlHelper
     */
    public function getUrlHelper()
    {
        return $this->di->get(Helpers\UrlHelper::SERVICE_NAME);
    }

    /**
     * @deprecated
     * @return Helpers\SeoHelper
     */
    public function getSeoHelper()
    {
        return $this->di->get(Helpers\SeoHelper::SERVICE_NAME);
    }

    /**
     * @deprecated
     * @return Helpers\ViewHelper
     */
    public function getViewHelper()
    {
        return $this->di->get('helper');
    }

    /**
     * @deprecated
     * @return Helpers\BreadcrumbHelper
     */
    public function getBreadcrumbHelper()
    {
        return $this->di->get(Helpers\BreadcrumbHelper::SERVICE_NAME);
    }

    /**
     * @deprecated
     * @param null $param
     * @param null $default
     * @param null $filters
     * @return array|mixed|null|string
     */
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

    protected function error404()
    {
        $this->dispatcher->forward(array(
            'controller' => 'error',
            'action' => 'notFound',
        ));
        return [];
    }

}