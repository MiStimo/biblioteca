<?php

require_once'AbstractBookManager.php';

class BookManager implements AbstactBookManager
{
    public function getTuttiLibri()
    {
        $con = DBController::getConnection();

        $query = "SELECT id, nome, autore FROM libro";

        $stmt = $con->prepare($query);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows()) {
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

    public function getLibriByNome($nome)
    {
        // TODO: Implement getLibriByNome() method.
    }

    public function getLibriByAutore($autore)
    {
        // TODO: Implement getLibriByAutore() method.
    }

    public function inserisciNuovoLibro($book)
    {
        // TODO: Implement inserisciNuovoLibro() method.
    }

    public function modificaLibro($book)
    {
        // TODO: Implement modificaLibro() method.
    }

    public function eliminaLibroByNome($nome)
    {
        // TODO: Implement eliminaLibroByNome() method.
    }


}