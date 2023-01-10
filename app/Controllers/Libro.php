<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LibroModel;

class Libro extends BaseController
{

    public function index()
    {
        $model = new LibroModel();

        $data['libros_detail'] = $model->orderBy('id', 'desc')->findAll();

        return view('list', $data);
    }


    public function store()
    {
        helper(['form', 'url']);

        $model = new LibroModel();

        $data = [
            'nombre' => $this->request->getVar('txtNombre'),
            'autor'  => $this->request->getVar('txtAutor'),
            'fecha_de_edicion'  => $this->request->getVar('txtFecha'),
        ];
        $save = $model->insert_data($data);
        if ($save != false) {
            $data = $model->where('id', $save)->first();
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false, 'data' => $data));
        }
    }

    public function edit($id = null)
    {

        $model = new LibroModel();

        $data = $model->where('id', $id)->first();

        if ($data) {
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false));
        }
    }

    public function update()
    {

        helper(['form', 'url']);

        $model = new LibroModel();

        $id = $this->request->getVar('hdnLibroId');

        $data = [
            'nombre' => $this->request->getVar('txtNombre'),
            'autor'  => $this->request->getVar('txtAutor'),
            'fecha_de_edicion'  => $this->request->getVar('txtFecha'),
        ];

        $update = $model->update($id, $data);
        if ($update != false) {
            $data = $model->where('id', $id)->first();
            echo json_encode(array("status" => true, 'data' => $data));
        } else {
            echo json_encode(array("status" => false, 'data' => $data));
        }
    }

    public function delete($id = null)
    {
        $model = new LibroModel();
        $delete = $model->where('id', $id)->delete();
        if ($delete) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
    }
}
