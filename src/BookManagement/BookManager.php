<?php

require_once 'AbstactBookManager.php';

/**
 * Class BookManager
 */
class BookManager implements AbstactBookManager
{
    /**
     * Restituisce una lista di libri se estono altrimenti restituisce un valore false
     * @author Giuseppe Spallone
     * @return array|bool
     */
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

    /**
     * Dato un id, restituisce un libro se esiste altrimenti restituisce un valore false
     * @author Giuseppe Spallone
     * @param integer $id
     * @return array|bool
     */
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

    /**
     * Dato un nome, restituisce un libro se esiste altrimenti restituisce un valore false
     * @author Giuseppe Spallone
     * @param string $nome
     * @return array|bool
     */
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

    /**
     * Dato un nome e un autore, inserisce un nuovo libro e lo restituisce
     * in output se l'inserimento è andato a buon fine, altrimenti restituisce
     * un valore false
     * @author Giuseppe Spallone
     * @param string $nome
     * @param string $autore
     * @return array|bool
     */
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

    /**
     * Dato un id, un nome e un autore, modifica gli attributi nome e autore del libro
     * identificato dall'id e lo restituisce in output se la modifica è andata a buon
     * fine, altrimenti restituisce un valore false
     * @author Giuseppe Spallone
     * @param integer $id
     * @param string $nome
     * @param string $autore
     * @return array|bool
     */
    public function modificaLibroById($id, $nome, $autore)
    {
        $con = DBController::getConnection();

        $libro = self::getLibroById($id);

        if ($libro['id']) {
            $query = "UPDATE libro SET nome = ?, autore = ? WHERE id = ?";

            $stmt = $con->prepare($query);
            $stmt->bind_param("ssi", $nome, $autore, $id);
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

    /**
     * Dato un id, elimina il libro e lo restituisce
     * in output true se l'eliminazione è andato a buon fine, altrimenti restituisce
     * un valore false
     * @author Giuseppe Spallone
     * @param $id
     * @return bool
     */
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