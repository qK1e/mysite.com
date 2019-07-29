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

        $configs = fread($configFile, 10000000);

        $this->mappings = json_decode($configs, true);

        if($this->mappings == null)
        {
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    echo ' - Ошибок нет';
                    break;
                case JSON_ERROR_DEPTH:
                    echo ' - Достигнута максимальная глубина стека';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    echo ' - Некорректные разряды или несоответствие режимов';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    echo ' - Некорректный управляющий символ';
                    break;
                case JSON_ERROR_SYNTAX:
                    echo ' - Синтаксическая ошибка, некорректный JSON';
                    break;
                case JSON_ERROR_UTF8:
                    echo ' - Некорректные символы UTF-8, возможно неверно закодирован';
                    break;
                default:
                    echo ' - Неизвестная ошибка';
                    break;
            }
        }
    }

    public function getMappings($path, $http_method, $action)
    {
        $return_mappings = array();

        foreach ($this->mappings as $mapping)
        {
            if($mapping["http"] == "ANY" || $mapping["http"] == $http_method)
            {
                //should work if both actions are null or equal to each other
                if($mapping["action"] == $action)
                {
                    if($path[0] == "/")
                    {
                        $path = substr($path, 1, strlen($path)-1);
                    }
                    if($mapping["path"][0] == "/")
                    {
                        $mapping["path"] = substr($mapping["path"], 1, strlen($mapping["path"])-1);
                    }
                    //should work if both path are null(which means it was /) and if they are equals or if it doesn't matter
                    if($mapping["path"] == "%" || $mapping["path"] == $path)
                    {
                        array_push($return_mappings, $mapping);
                    }
                }
            }
        }

        return $return_mappings;
    }

}