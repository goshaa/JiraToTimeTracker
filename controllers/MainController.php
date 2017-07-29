<?php

class MainController
{
    private $config;
    private $communicator;
    private $timeTracker;

    public function __construct(
        ConfigInterface $config,
        CommunicatorInterface $communicator,
        TimeTrackerInterface $timeTracker
    )
    {
        $this->config = $config;
        $this->communicator = $communicator;
        $this->timeTracker = $timeTracker;
    }

    public function render()
    {
        $data = $this->communicator->getContentFromJira(
            $this->config->atlassian_url,
            $this->config->board_id,
            $this->config->sprint_id,
            $this->config->username,
            $this->config->password
        );
        $this->processData($data);

    }

    public function processData($data)
    {
        $this->timeTracker->createSprint($data->sprint->name);

        foreach ($data->contents->issuesNotCompletedInCurrentSprint as $ticket)
        {
            $this->timeTracker->createTicket($ticket->summary);
        }
    }

}