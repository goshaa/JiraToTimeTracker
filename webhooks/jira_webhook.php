<?php

include("../controllers/MainController.php");
include("../models/MainConfig.php");
include("../models/Moco.php");
include("../core/Communicator.php");
include("../config.php");

$config = new MainConfig(new config());
$communicator = new Communicator($config);
$controller = new MainController(
    $config,
    $communicator,
    new Moco($communicator, $config)
);
$controller->render();
