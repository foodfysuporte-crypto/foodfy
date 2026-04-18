<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DbUpdate extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        echo "Iniciando atualização do banco de dados...<br>";

        // Adicionar coluna id_funcionario na tabela login
        try {
            $db->query("ALTER TABLE `login` ADD `id_funcionario` INT(11) NULL AFTER `id_empresa` ");
            echo "Coluna 'id_funcionario' adicionada com sucesso à tabela 'login'.<br>";
        } catch (\Exception $e) {
            echo "Erro ao adicionar coluna (ou ela já existe): " . $e->getMessage() . "<br>";
        }

        echo "Concluído.";
    }
}
