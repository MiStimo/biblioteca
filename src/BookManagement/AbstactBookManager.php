<?php

interface AbstactBookManager
{
    public function getTuttiLibri();

    public function getLibriByNome($nome);

    public function inserisciNuovoLibro($nome, $autore);

    public function modificaLibro($id, $nome, $autore);

    public function eliminaLibroById($id);

}