<?php

namespace Framework;


use Zend\Diactoros\ServerRequestFactory;

/**
 * Class Request
 * @package Framework
 */
class Request
{
    /**
     * @var
     */
    private $server;

    /**
     * @var
     */
    private $get;

    /**
     * @var
     */
    private $post;

    /**
     * @var
     */
    private $cookie;

    /**
     * @var
     */
    private $token;

    /**
     * @var \Zend\Diactoros\ServerRequest
     */
    private $request;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->request = ServerRequestFactory::fromGlobals();
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = array_splice($_POST,1);
        $this->cookie = $_COOKIE;
        if (isset($_POST['token'])){
            $this->token = $_POST['token'];
        }
    }

    /**
     * @return \Zend\Diactoros\ServerRequest
     */
    public function getRequest(): \Zend\Diactoros\ServerRequest
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return mixed
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return mixed
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

}