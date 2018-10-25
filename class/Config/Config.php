<?php
namespace appName\Config;

class Config{
    private $config;

    public function __construct(){
        $this->getINIConfig();
    }
    
    public function getConfig(){
        return $this->config;
    }

    private function getINIConfig(){
        $iniArrayDB = parse_ini_file('config/config.ini', true);
        $this->config = $iniArrayDB['app'];
        return $this->config;
    }

}