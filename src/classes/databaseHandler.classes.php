<?php

class databaseHandler {

    protected function connect() {
        try {
            $username = "root";
            $password = "";
            $database = "interact";
            $host = "localhost";

            $databaseHandler = new mysqli($host, $username, $password, $database);
            return $databaseHandler;
        } catch (Exception $e) {
            // ToDo: Log the error, Not show it.
            echo("Connection failed: " . $e->getMessage());
            die();
        }
    }
}