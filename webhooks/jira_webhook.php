<?php

$controller = new MainController(
    new Config(),
    new Communicator(),
    new Moco()
);
$controller->render();
