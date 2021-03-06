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
        $app->get('/libri/{nome}', self::class . ':getLibriByNome');
        $app->post('/libri/nuovo', self::class . ':inserisciNuovoLibro');
        $app->delete('/libri/elimina/{id}', self::class . ':eliminaLibroById');
        $app->put('/libri/modifica/{id}', self::class . ':modificaLibroById');
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

            $bookManager = new BookManager();
            $data = $bookManager->getTuttiLibri();

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

    public function getLibriByNome(Request $request, Response $response)
    {
        $result = false;
        $message = null;
        $dataKey = "libri";
        $data = null;
        $status = null;

        $con = DBController::getConnection();

        if ($con) {

            $nome = $request->getAttribute('nome');

            if ($nome) {
                $bookManager = new BookManager();
                $data = $bookManager->getLibriByNome($nome);

                if ($data) {
                    $result = true;
                    $message = "libri esistenti";
                    $status = 200;
                } else {
                    $message = "libri non esistenti";
                    $status = 204;
                }
            } else {
                $message = "richiesta errata";
                $status = 403;
            }
        } else {
            $message = "database non connesso";
            $status = 503;
        }

        $myResponse = self::getResponse($response, $status, $result, $message, $dataKey, $data);

        return $myResponse;
    }

    public function inserisciNuovoLibro(Request $request, Response $response)
    {
        $result = false;
        $message = null;
        $dataKey = "libri";
        $data = null;
        $status = null;

        $con = DBController::getConnection();

        if ($con) {

            $requestData = $request->getParsedBody();
            $nome = $requestData['nome'];
            $autore = $requestData['autore'];

            if ($nome || $autore) {
                if ($nome) {
                    if ($autore) {
                        $bookManager = new BookManager();
                        $data = $bookManager->inserisciNuovoLibro($nome, $autore);

                        if ($data) {
                            $result = true;
                            $message = "libro inserito";
                            $status = 201;
                        } else {
                            $message = "libro non inserito";
                            $status = 204;
                        }
                    } else {
                        $message = "richiesta errata: autore non inserito";
                        $status = 403;
                    }

                } else {
                    $message = "richiesta errata: nome non inserito";
                    $status = 403;
                }

            } else {
                $message = "richiesta errata: nome e autore non inseriti";
                $status = 403;
            }
        } else {
            $message = "database non connesso";
            $status = 503;
        }

        $myResponse = self::getResponse($response, $status, $result, $message, $dataKey, $data);

        return $myResponse;
    }

    public function eliminaLibroById(Request $request, Response $response){
        $result = false;
        $message = null;
        $dataKey = "libri";
        $data = null;
        $status = null;

        $con = DBController::getConnection();

        if ($con) {

            $id = $request->getAttribute('id');

            if ($id) {
                $bookManager = new BookManager();
                $data = $bookManager->eliminaLibroById($id);

                if ($data) {
                    $result = true;
                    $message = "libro eliminato";
                    $status = 202;
                } else {
                    $message = "libro non esistente";
                    $status = 204;
                }
            } else {
                $message = "richiesta errata";
                $status = 403;
            }
        } else {
            $message = "database non connesso";
            $status = 503;
        }

        $myResponse = self::getResponse($response, $status, $result, $message, $dataKey, $data);

        return $myResponse;
    }

    public function modificaLibroById(Request $request, Response $response){
        $result = false;
        $message = null;
        $dataKey = "libri";
        $data = null;
        $status = null;

        $con = DBController::getConnection();

        if ($con) {

            $id = $request->getAttribute('id');

            if ($id) {

                $parsedBody = $request->getParsedBody();
                $nome = $parsedBody['nome'];
                $autore = $parsedBody['autore'];

                $bookManager = new BookManager();
                $data = $bookManager->modificaLibroById($id, $nome, $autore);

                if ($data) {
                    $result = true;
                    $message = "libro modificato";
                    $status = 202;
                } else {
                    $message = "libro non esistente";
                    $status = 204;
                }
            } else {
                $message = "richiesta errata";
                $status = 403;
            }
        } else {
            $message = "database non connesso";
            $status = 503;
        }

        $myResponse = self::getResponse($response, $status, $result, $message, $dataKey, $data);

        return $myResponse;
    }
}