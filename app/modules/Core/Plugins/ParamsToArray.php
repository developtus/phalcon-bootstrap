<?php

namespace Core\Plugins;

use Phalcon\Events\EventInterface;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\User\Plugin;

/**
 * Class ParamsToArray
 * Parse the :params of an url
 * <code>
 * // parse by colons
 * "/foo/bar:baz/1/2:456" => ["foo" => "foo", "bar" => "baz", 1 => 1, 2 => 456]
 *
 * // parse by slashes
 * "/foo/bar/baz/1/2" => ["foo" => "bar", "baz" => "1", 0 => 2]
 * </code>
 *
 * @package Core\Plugins
 */
class ParamsToArray extends Plugin
{
    /**
     * Separated by colons, else, separated by slashes
     * @var bool
     */
    private $colons = true;

    /**
     * ParamsToArray constructor.
     *
     * @param bool $colons
     */
    public function __construct(bool $colons = true)
    {
        $this->colons = $colons;
    }

    /**
     * Parse parameters before dispatch loop
     *
     * @param EventInterface $event
     * @param DispatcherInterface $dispatcher dispatcher
     */
    public function beforeDispatchLoop(EventInterface $event, DispatcherInterface $dispatcher): void
    {
        $keyParams = $this->colons === true ?
            $this->parseByColons($dispatcher->getParams()) :
            $this->parseBySlashes($dispatcher->getParams());

        // override params
        $dispatcher->setParams($keyParams);
    }

    /**
     * @param iterable $params
     * @return array
     */
    private function parseByColons(iterable $params): array
    {
        $keyParams = [];

        foreach ($params as $i => $value) {
            // is named param?
            if (!is_int($i)) {
                $keyParams[$i] = $value;
                continue;
            }

            // parse params by ":"
            if (strpos($value, ':') === false) {
                $parts = [
                    $value, $value,
                ];
            } else {
                $parts = explode(':', $value, 2);
            }
            $keyParams[$parts[0]] = $parts[1];
        }

        return $keyParams;
    }

    /**
     * @param iterable $params
     * @return array
     */
    private function parseBySlashes(iterable $params): array
    {
        $keyParams = [];

        foreach ($params as $i => $value) {
            if ($i & 1) {
                $key = $params[$i - 1];
                $keyParams[$key] = $value;
            }
        }

        if (count($params) & 1) {
            $keyParams[] = array_pop($params);
        }

        return $keyParams;
    }
}
