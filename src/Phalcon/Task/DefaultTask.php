<?php

namespace Sb\Phalcon\Task;

use Phalcon\Cli\Task;

/**
 * Class DefaultTask
 * @package Sb\Phalcon\Task
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
 * @property \Phalcon\Queue\Beanstalk queue
 *
 */

class DefaultTask extends Task
{
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
}