<?php

class DBpropieties
{
    const host = 'localhost';
    const database = 'biblioteca';
    const username = 'root';
    const password = '';

    public static function getConnection(){
        $con = mysqli_connect(self::host, self::username, self::password, self::database);
        return $con;
    }

}