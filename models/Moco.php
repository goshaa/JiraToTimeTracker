<?php

include("TimeTrackerInterface.php");

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
            $this->config->client,
            $this->config->api_key,
            $this->config->leader_id,
            $this->config->customer_id
        );

        $this->createTicket("Release");
        $this->createTicket("DoDs");
        $this->createTicket("Projektmanagement");
    }

    public function createTicket($name, $type = '')
    {
        $billable = true;
        if ($type === 'Bugs')
        {
            $billable = false;
        }
        $this->communicator->createTicket(
            $name,
            $this->config->client,
            $this->config->api_key,
            $billable
        );
    }
}