<?php

class Moco implements TimeTrackerInterface
{
    private $communicator;
    private $config;

    public function __construct(CommunicatorInterface $communicator, ConfigInterface $config)
    {
        $this->communicator = $communicator;
        $this->config = $config;
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