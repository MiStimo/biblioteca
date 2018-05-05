<?php

use api\routes\Route;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'BookManager.php';

class BookRoutes extends Route
{

    public static function registerRoutes(App $app)
    {
        $app->get('/libri', self::class . ':getTuttiLibri');
    }

    public function getTuttiLibri(Request $request, Response $response)
    {
        $result = false;
        $message = null;
        $dataKey = "libri";
        $data = null;
        $status = null;

        $con = DBController::getConnection();

        if ($con) {

            $data = BookManager::getTuttiLibri();

            if ($data) {
                $result = true;
                $message = "libri esistenti";
                $status = 200;
            } else {
                $message = "libri non esistenti";
                $status = 204;
            }
        } else {
            $message = "database non connesso";
            $status = 503;
        }

        $myResponse = self::getResponse($response, $status, $result, $message, $dataKey, $data);

        return $myResponse;
    }

}