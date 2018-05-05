<?php

interface AbstactBookManager
{
    public function getTuttiLibri();

    public function getLibriByNome($nome);

    public function getLibriByAutore($autore);

    public function inserisciNuovoLibro($book);

    public function modificaLibro($book);

    public function eliminaLibroByNome($nome);

}