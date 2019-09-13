<?php

namespace qk1e\mysite\routing;

use qk1e\mysite\Request;

class ConfigurableRouter
{
    private static $config_path = "config/router-config";

    private $configuration;
    private static $instance;

    private function __construct()
    {
        $this->configuration = new FileRouterConfig(ConfigurableRouter::$config_path);
    }

    public static function getInstance(): ConfigurableRouter
    {
        if(ConfigurableRouter::$instance)
        {
            return ConfigurableRouter::$instance;
        }
        else
        {
            ConfigurableRouter::$instance =  new ConfigurableRouter();
            return ConfigurableRouter::$instance;
        }
    }



    public function route($path,$method,$args): void
    {
        $mappings = $this->configuration->getMappings($path, $method);

        foreach ($mappings as $mapping)
        {
            $controller_name = "qk1e\mysite\controllers\\".$mapping["controller"];
            $controller = new $controller_name();
            $method = $mapping["method"];

            $request = new Request();
            $request->setMethod($method);
            $request->setArguments($args);
            $request->setUrl($path);

            $controller->$method($request);
        }
    }

    public function redirect(string $url)
    {
        header("Location: ".$url);
    }
}