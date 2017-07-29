<?php

class Communicator implements CommunicatorInterface
{
    public $config;

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

    public function getNewIdent()
    {
        $identifier = 0;
        $projects = $this->mocoContent(
            $this->config->domain,
            $this->config->api_key
        );

        foreach ($projects as $project)
        {
            if ($identifier < $project->identifier)
            {
                $identifier = $project->identifier;
            }
        }

        return $identifier+1;
    }

    public function createProject($name, $leader_id, $customer_id, $domain, $api_key)
    {
        $params = array(
            "name" => $name,
            "currency" => "EUR",
            "leader_id" => $leader_id,
            "customer_id" => $customer_id,
            "finish_date" => date("Y-m-d", strtotime("+2 week")),
            "identifier" => $this->getNewIdent()
        );
        $data = $this->mocoContent($domain, $api_key, implode("&", $params), true);
    }

    private function mocoContent($domain,$api_key, $params = '', $post = false)
    {
        $headers = array(
            "authorization: Token token={$api_key}"
        );
        $sUrl = "https://{$domain}.mocoapp.com/api/v1/projects";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sUrl);

        if ($post)
        {
            $headers[] = "content-type: application/x-www-form-urlencoded";
            curl_setopt($ch, CURLOPT_POST, true);
        }

        if ($params)
        {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $data = curl_exec($ch);
        curl_close($ch);
        var_dump("<pre>", $data);exit;
        return json_decode($data);
    }

}