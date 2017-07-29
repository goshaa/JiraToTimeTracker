# JiraToTimeTracker
This application works with Jira webhooks in order to auto-create new components in the time tracking tools.

It will help the work of project managers when they have to spend several hours in a year just by putting the new tickets from a Jira Sprint into the time tracking tools.

It can be easily configured with a config.php in the root:

#### Jira config

```
$this->board_id = Jira board ID;
$this->atlassian_url = Jira url;
$this->username = Jira username;
$this->password = Jira password;
```

#### Time tracker config

```
$this->customer_id = <customer id>;
$this->leader_id = <leader id>;
$this->api_key = <Moco api key>;
$this->client = <client>;
```

## Creating a Webhook in Jira

In the **Administration -> System -> Webhooks**
