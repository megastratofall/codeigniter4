<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class LibroModel extends Model
{
    protected $table = 'libros';

    protected $allowedFields = ['nombre', 'autor', 'fecha_de_edicion'];

    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $db = \Config\Database::connect();
        $builder = $db->table('libros');
    }

    public function insert_data($data)
    {
        if ($this->db->table($this->table)->insert($data)) {
            return $this->db->insertID();
        } else {
            return false;
        }
    }
}
