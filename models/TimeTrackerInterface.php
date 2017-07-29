<?php

/**
 * User: Baszarab
 * Date: 29/07/2017
 * Time: 14:27
 */
interface TimeTrackerInterface
{
    public function createSprint($name);

    public function createTicket($name);
}