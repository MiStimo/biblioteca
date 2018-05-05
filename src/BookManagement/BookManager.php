<?php

require_once 'AbstactBookManager.php';

class BookManager implements AbstactBookManager
{

    public function getTuttiLibri()
    {
        $con = DBController::getConnection();

        $query = "SELECT id, nome, autore FROM libro";

        $stmt = $con->prepare($query);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows() > 0) {
            $stmt->bind_result($id, $nome, $autore);

            $libri = array();

            while ($stmt->fetch()) {
                $temp = array();
                $temp['id'] = $id;
                $temp['nome'] = $nome;
                $temp['autore'] = $autore;
                array_push($libri, $temp);

            }
            return $libri;
        } else {
            return false;
        }
    }

    private function getLibroById($id)
    {
        $con = DBController::getConnection();

        $query = "SELECT id, nome, autore FROM libro WHERE id = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt) {
            $stmt->bind_result($id, $nome, $autore);

            $stmt->fetch();
            $libro['id'] = $id;
            $libro['nome'] = $nome;
            $libro['autore'] = $autore;

            return $libro;
        } else {
            return false;
        }
    }

    public function getLibriByNome($nome)
    {
        $con = DBController::getConnection();

        $query = "SELECT id, nome, autore FROM libro WHERE nome = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows() > 0) {
            $stmt->bind_result($id, $nome, $autore);

            $libri = array();

            while ($stmt->fetch()) {
                $temp = array();
                $temp['id'] = $id;
                $temp['nome'] = $nome;
                $temp['autore'] = $autore;
                array_push($libri, $temp);
            }
            return $libri;
        } else {
            return false;
        }
    }

    public function inserisciNuovoLibro($nome, $autore)
    {
        $con = DBController::getConnection();

        $query = "INSERT INTO libro (nome, autore) VALUES (?, ?)";

        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $nome, $autore);
        $stmt->execute();

        $stmt->store_result();

        if ($stmt) {
            $libro = self::getLibroById($stmt->insert_id);
            return $libro;
        } else {
            return false;
        }
    }

    public function modificaLibro($id, $nome, $autore)
    {
        $con = DBController::getConnection();

        $libro = self::getLibroById($id);

        if ($libro['id']) {
            $query = "UPDATE libro SET id = ? WHERE nome = ?, autore = ?";

            $stmt = $con->prepare($query);
            $stmt->bind_param("iss", $id, $nome, $autore);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt) {
                $libro = self::getLibroById($stmt->insert_id);
                return $libro;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function eliminaLibroById($id)
    {
        $con = DBController::getConnection();

        $libro = self::getLibroById($id);

        if ($libro['id']) {
            $query = "DELETE FROM libro WHERE id = ?";

            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return true;

        } else {
            return false;
        }
    }


}