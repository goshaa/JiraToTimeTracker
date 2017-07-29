<?php

include("CommunicatorInterface.php");

class Communicator implements CommunicatorInterface
{
    private $config;

    private $ident;

    private $id;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function getContentFromJira($atlassian_url, $board_id, $sprint_id, $username, $password)
    {
        $sUrl = "{$atlassian_url}/rest/greenhopper/1.0/rapid/charts/sprintreport?rapidViewId={$board_id}&sprintId={$sprint_id}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data);
    }

    public function createProject($name, $domain, $api_key, $leader_id, $customer_id)
    {
        $params = array(
            "name" => $name,
            "currency" => "EUR",
            "leader_id" => $leader_id,
            "customer_id" => $customer_id,
            "finish_date" => date("Y-m-d", strtotime("+2 week"))
        );
        $url = "https://{$domain}.mocoapp.com/api/v1/projects";
        $postParams = $this->getPostParams($params);
        $data = $this->mocoContent($url, $api_key, $postParams, true);
    }

    public function createTicket($name, $domain, $api_key, $billable)
    {
        $params = array(
            "name" => $name,
            "billable" => $billable
        );

        $ident = $this->getIdent();
        $id = $this->getProjectIdByIdent($ident);
        $url = "https://{$domain}.mocoapp.com/api/v1/projects/{$id}/tasks";
        $postParams = $this->getPostParams($params);

        $data = $this->mocoContent($url, $api_key, $postParams, true);
    }

    private function getPostParams($params)
    {
        return json_encode($params);
    }

    private function mocoContent($url, $api_key, $params = '', $post = false)
    {
        $headers = array(
            "authorization: Token token={$api_key}"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($post)
        {
            $headers[] = "content-type: application/json";
            curl_setopt($ch, CURLOPT_POST, true);
        }

        if ($params)
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



        $data = curl_exec($ch);
        curl_close($ch);

        return json_decode($data);
    }

    private function getIdent()
    {
        if (!$this->ident)
        {
            $identifier = 0;
            $url = "https://{$this->config->client}.mocoapp.com/api/v1/projects";
            $projects = $this->mocoContent(
                $url,
                $this->config->api_key
            );

            foreach ($projects as $project)
            {
                if ($identifier < $project->identifier)
                {
                    $identifier = $project->identifier;
                }
            }

            $this->ident = $identifier;
        }

        return $this->ident;
    }

    private function getProjectIdByIdent($ident)
    {
        if (!$this->id)
        {
            $url = "https://{$this->config->client}.mocoapp.com/api/v1/projects";
            $projects = $this->mocoContent(
                $url,
                $this->config->api_key
            );

            foreach ($projects as $project)
            {
                if ($ident === $project->identifier)
                {
                    $this->id = $project->id;
                }
            }
        }

        return $this->id;
    }
}