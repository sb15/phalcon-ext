<?php

namespace Sb\Phalcon\Mvc\Model\MetaData;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Mvc\Model\MetaData;
use Phalcon\Mvc\Model\MetaDataInterface;
use Phalcon\Cache\Backend\Memcache as CacheBackend;
use Phalcon\Cache\Frontend\Data as CacheFrontend;
use Phalcon\Mvc\Model\Exception;

/**
 * \Phalcon\Mvc\Model\MetaData\Memcache
 * Memcache adapter for \Phalcon\Mvc\Model\MetaData
 */
class Memcache extends MetaData implements InjectionAwareInterface, MetaDataInterface
{

    /**
     * Default options for cache backend.
     *
     * @var array
     */
    protected static $defaults = array(
        'lifetime' => 8600,
        'prefix'   => '',
    );

    /**
     * Default option for memcache port.
     *
     * @var array
     */
    protected static $defaultPort = 11211;

    /**
     * Default option for persistent session.
     *
     * @var boolean
     */
    protected static $defaultPersistent = false;

    /**
     * Memcache backend instance.
     *
     * @var \Phalcon\Cache\Backend\Memcache
     */
    protected $memcache = null;

    /**
     * {@inheritdoc}
     *
     * @param  null|array                   $options
     * @throws \Phalcon\Mvc\Model\Exception
     */
    public function __construct($options = null)
    {
        if (is_array($options)) {
            if (!isset($options['host'])) {
                throw new Exception('No host given in options');
            }

            if (!isset($options['port'])) {
                $options['port'] = self::$defaultPort;
            }

            if (!isset($options['persistent'])) {
                $options['persistent'] = self::$defaultPersistent;
            }
        } else {
            throw new Exception('No configuration given');
        }

        if (is_array($options)) {
            if (!isset($options['lifetime'])) {
                $options['lifetime'] = self::$defaults['lifetime'];
            }

            if (!isset($options['prefix'])) {
                $options['prefix'] = self::$defaults['prefix'];
            }
        }

        $this->options = $options;
    }


    /**
     * Backend's options.
     *
     * @var array
     */
    protected $options = null;

    /**
     * {@inheritdoc}
     * @param  string $key
     * @return array
     */
    public function read($key)
    {
        return $this->getCacheBackend()->get($this->getId($key), $this->options['lifetime']);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key
     * @param array  $data
     */
    public function write($key, $data)
    {
        $this->getCacheBackend()->save($this->getId($key), $data, $this->options['lifetime']);
    }

    /**
     * Returns the sessionId with prefix
     *
     * @param  string $id
     * @return string
     */
    protected function getId($id)
    {
        return (!empty($this->options['prefix']) > 0)
            ? $this->options['prefix'] . '_' . $id
            : $id;
    }

    /**
     * {@inheritdoc}
     * @return \Phalcon\Cache\Backend\Memcache
     */
    protected function getCacheBackend()
    {
        if (null === $this->memcache) {
            $this->memcache = new CacheBackend(
                new CacheFrontend(array('lifetime' => $this->options['lifetime'])),
                array(
                    'host'       => $this->options['host'],
                    'port'       => $this->options['port'],
                    'persistent' => $this->options['persistent'],
                )
            );
        }

        return $this->memcache;
    }
}
