<?php

include_once 'bootstrap.php';

$tracker = new \TestInfuse\RequestTracker();

$tracker->handleRequest();

(new \TestInfuse\BannerImage(BANNER_FILE))->response();