<?php

include("ConfigInterface.php");

class MainConfig implements ConfigInterface
{
    public $sprint_id;
    public $board_id;
    public $atlassian_url;
    public $username;
    public $password;
    public $customer_id;
    public $project;
    public $api_key;
    public $client;
    public $leader_id;

    public function __construct($config)
    {
        $params = array_merge($_POST, $_GET);
        $this->sprint_id = $params['sprint_id'];
        $this->board_id = $config->board_id;
        $this->atlassian_url = $config->atlassian_url;
        $this->username = $config->username;
        $this->password = $config->password;
        $this->customer_id = $config->customer_id;
        $this->leader_id = $config->leader_id;
        $this->api_key = $config->api_key;
        $this->client = $config->client;
    }
}