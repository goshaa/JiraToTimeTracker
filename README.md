# JiraToTimeTracker
This application works with Jira webhooks in order to auto-create new components in the time tracking tools.

It will help the work of project managers when they have to spend several hours in a year just by putting the new tickets from a Jira Sprint into the time tracking tools.

It can be easily configured with a config.php in the root:

#### Jira config

```
$this->board_id = <jira board ID>;
$this->atlassian_url = <jira url>;
$this->username = <jira username>;
$this->password = <jira password>;
```

#### Time tracker config

```
$this->customer_id = <customer id>;
$this->leader_id = <leader id>;
$this->api_key = <moco api key>;
$this->client = <client>;
```

## Creating a Webhook in Jira

We create a new webhook under **Administration -> System -> Webhooks**

- Create a new Webhook
- Add a specific name to this hook
- Add the URL of the jira_webhook.php and parse the ${sprint.id}
``
http://example.com/rest/webhooks/jira_webhook.php?sprint_id=${sprint.id}
``
- Assign the "Sprint started" event to the Hook. This way a new Project with all the tickets in the Sprint will be added to the time tracker application.
- Click create

These were all the basics of creating a Hook. But for now, we still have to assign this Hook to our workflow.
We assign the Hook under **Administration -> Issues -> Worklfow**
- you have to choose the worklfow you are gonna add the webhook to and click edit
- under the diagram view, click on the create flow
- after that choose the post functions
- add post function
- choose "trigger a webhook" section and click the add button
- now choose the right webhook for your workflow and click the add button
- and finally publish the draft

## The Sprint start webhook

When a sprint is started, the configured webhook will trigger our service. It will parse the aktive Sprint Id, so the system will get the sprint content through a curl call.
After the call, we have all the information needed to create a new Time tracker project and components. The name of the new project will be exactly as the sprint name is and the components will have the same name as the tickets.
In case the project or tickets already exists, it will not create another one, but it will update it.

## Todos

The development of the application just started and is focusing primarely on the case of my company, so the time tracker tool what we use is Moco.
I will try to make it more **SOLID** so you can also add your own services to communicate with other time tracker tools. The configurations are not clear yet, so feel free to advise me.
Regarding to Jira, I am planing to create also a Sprint finish webhook, what will close the project in the time tracking tool. Another important part is also to add new tickets to the running sprint, what will need a new hook to.