<?php


namespace SoPhp\Amqp;


use PhpAmqpLib\Channel\AMQPChannel;
use SoPhp\Amqp\Exception\InvalidArgumentException;
use stdClass;

/**
 * Describes a destination (exchange)
 * Class EndpointDescriptor
 * @package SoPhp\Amqp
 */
class EndpointDescriptor {
    const DEFAULT_EXCHANGE = '';

    /** @var  string */
    protected $exchange;
    /** @var  string */
    protected $route;

    public function __construct($exchange = self::DEFAULT_EXCHANGE, $route = '')
    {
        $this->setExchange($exchange);
        $this->setRoute($route);
    }

    /**
     * @return string
     */
    public function getExchange()
    {
        return $this->exchange;
    }

    /**
     * @param string $exchange
     * @return self
     */
    public function setExchange($exchange)
    {
        $this->exchange = $exchange;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return self
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault(){
        return $this->exchange == self::DEFAULT_EXCHANGE;
    }

    /**
     * Endpoint format
     * {"exchange": 'value',"route": 'value'}
     *
     * @return string
     */
    public function toJson(){
        return json_encode((object)array(
            'exchange' => $this->exchange,
            'route' => $this->route
        ));
    }

    /**
     * Endpoint format
     * {"exchange": 'value',"route": 'value'}
     *
     * @param string $json
     * @return EndpointDescriptor
     * @throws \SoPhp\Amqp\Exception\InvalidArgumentException
     */
    public static function fromJson($json){
        $obj = json_decode($json);
        return self::fromStdClass($obj);
    }

    /**
     * @param stdClass $obj
     * @return EndpointDescriptor
     * @throws \SoPhp\Amqp\Exception\InvalidArgumentException
     */
    public static function fromStdClass($obj){
        if(!$obj || !isset($obj->exchange) || !isset($obj->route)) {
            throw new InvalidArgumentException("Invalid json provided");
        }
        return new EndpointDescriptor($obj->exchange, $obj->route);
    }

    public function __toString(){
        return "{$this->getExchange()}@{$this->getRoute()}";
    }
} 