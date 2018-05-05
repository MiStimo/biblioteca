<?php

require_once 'Utilities/DBController.php';
require_once 'Utilities/Route.php';
require_once 'BookManagement/BookRoutes.php';

BookRoutes::registerRoutes($app);
