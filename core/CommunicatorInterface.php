<?php

/**
 * User: Baszarab
 * Date: 29/07/2017
 * Time: 14:25
 */
interface CommunicatorInterface
{
    public function getContentFromJira($atlassian_url, $board_id, $sprint_id, $username, $password);

    public function createProject($name, $leader_id, $customer_id, $domain, $api_key);
}