<?php


namespace qk1e\mysite\routing;


class ConfigurableRouter
{
    private $configuration;

    public function __construct($configuration_file)
    {
        $this->configuration = new RouterConfig($configuration_file);
    }

}