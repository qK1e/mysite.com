<?php


namespace qk1e\mysite\routing;


class FileRouterConfig
{
    private $mappings;

    /**
     * RouterConfig constructor.
     */
    public function __construct($configuration_file)
    {
        $this->parseConfig($configuration_file);
    }

    private function parseConfig($config)
    {
        if(substr($config, 0 , 1) !== "/")
        {
            $config = "/".$config;
        }

        $configFile = fopen(ROOTDIR.$config, "rt");

        if($configFile == 0)
        {
            echo "ERROR: COULDN'T OPEN ROUTER CONFIG";
        }


    }

}