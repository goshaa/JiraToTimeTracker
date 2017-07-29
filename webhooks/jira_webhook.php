<?php

$controller = new MainController(
    new Config(),
    new Communicator(),
    new TimeTracker()
);
$controller->render();
