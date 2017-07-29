<?php

class TimeTracker implements TimeTrackerInterface
{
    private $communicator;
    private $config;

    public function __construct()
    {
        $this->communicator = new Communicator();
        $this->config = new Config();
    }

    public function createSprint($name)
    {
        $this->communicator->createProject(
            $name,
            $this->config->leader_id,
            $this->config->customer_id,
            $this->config->client,
            $this->config->api_key
        );
    }

    public function createTicket($name)
    {
        //        $this->communicator->createTicket($name);
    }
}