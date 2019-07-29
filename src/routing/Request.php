<?php


namespace qk1e\mysite\routing;


class Request
{
    private $http_method;
    private $url;
    private $arguments;

    public function getMethod()
    {
        return $this->http_method;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setMethod($http_method)
    {
        $this->http_method = $http_method;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function getArgument($argument_name)
    {
        return $this->arguments[$argument_name];
    }
}