<?php

use api\routes\Route;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require_once 'BookManager.php';

class BookRoutes extends Route
{

    public static function register_routes(App $app)
    {
        $app->get('/libri', self::class . ':getTuttiLibri');
    }

    public function getTuttiLibri(Request $request, Response $response)
    {
        $result = false;

        $con = DBController::getConnection();

        if ($con) {

            $libri = BookManager::getTuttiLibri();

            if ($libri) {
                $result = true;
                $this->message = "libri esistenti";
                $response = self::get_response($response, $result, 'libri', $libri);
            } else {
                $this->message = "libri non esistenti";
                $response = self::get_response($response, $result, 'libri', false);
            }
        } else {
            $this->message = "database non connesso";
            $response = self::get_response($response, $result, 'libri', false);
        }

        return $response;
    }

}