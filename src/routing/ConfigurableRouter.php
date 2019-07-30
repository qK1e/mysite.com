<?php

namespace qk1e\mysite\routing;

use qk1e\mysite\Request;

class ConfigurableRouter
{
    private $configuration;

    public function __construct($configuration_file)
    {
        $this->configuration = new FileRouterConfig($configuration_file);
    }

    public function route($path, $method, $args)
    {
        $mappings = $this->configuration->getMappings($path, $method, $args["action"]);

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
}