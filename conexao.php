<?php
try
        {
            $conexao = new PDO("mysql:host=localhost;dbname=esaberes_encontrosaberes", 'root', '',
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo "Impossível conectar: " . $e->getMessage();
        }
