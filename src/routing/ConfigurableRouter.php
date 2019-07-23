<?php

namespace qk1e\mysite\routing;

class ConfigurableRouter
{
    private $configuration;

    public function __construct($configuration_file)
    {
        $this->configuration = new FileRouterConfig($configuration_file);
    }

    public function route()
    {
        $path = $_SERVER["REQUEST_URI"];
        $args = $_REQUEST;

        $mappings = $this->configuration->getMappings($path, $args["action"]);

        foreach ($mappings as $mapping)
        {
            $controller_name = "qk1e\mysite\controllers\\".$mapping["controller"];
            $controller = new $controller_name();
            $method = $mapping["method"];

            $controller->$method($args);
        }
    }
}