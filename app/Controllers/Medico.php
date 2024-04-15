<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\MedicoModel;

class Medico extends BaseController
{

	protected $medicoModel;
	protected $validation;

	public function __construct()
	{
		$this->medicoModel = new MedicoModel();
		$this->validation =  \Config\Services::validation();
	}

	public function getIndex()
	{

		$data = [
			'controller'    	=> 'medico',
			'title'     		=> 'Medicos y Estilistas'
		];

		return view('medico', $data);
	}

	public function postGetAll()
	{
		$response = $data['data'] = array();

		$result = $this->medicoModel->select()->findAll();

		foreach ($result as $key => $value) {

			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save(' . $value->id_medico . ')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Editar")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove(' . $value->id_medico . ')"><i class="fa-solid fa-trash"></i>   ' .  lang("Eliminar")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$value->id_medico,
				$value->nombre_completo,
				$value->direccion,
				$value->edad,
				$value->estatus,

				$ops
			);
		}

		return $this->response->setJSON($data);
	}

	public function postGetOne()
	{
		$response = array();

		$id = $this->request->getPost('id_medico');

		if ($this->validation->check($id, 'required|numeric')) {

			$data = $this->medicoModel->where('id_medico', $id)->first();

			return $this->response->setJSON($data);
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}
	}

	public function postAdd()
	{
		$response = array();

		$fields['id_medico'] = $this->request->getPost('id_medico');
		$fields['nombre_completo'] = $this->request->getPost('nombre_completo');
		$fields['direccion'] = $this->request->getPost('direccion');
		$fields['edad'] = $this->request->getPost('edad');
		$fields['estatus'] = $this->request->getPost('estatus');


		$this->validation->setRules([
			'nombre_completo' => ['label' => 'Nombre completo', 'rules' => 'required|min_length[0]|max_length[50]'],
			'direccion' => ['label' => 'Dirección', 'rules' => 'required|min_length[0]|max_length[50]'],
			'edad' => ['label' => 'Edad', 'rules' => 'required|numeric|min_length[0]|max_length[10]'],
			'estatus' => ['label' => 'Estatus', 'rules' => 'required|min_length[0]|max_length[20]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->medicoModel->insert($fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Agregado correctamente");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Error al agregar");
			}
		}

		return $this->response->setJSON($response);
	}

	public function postEdit()
	{
		$response = array();

		$fields['id_medico'] = $this->request->getPost('id_medico');
		$fields['nombre_completo'] = $this->request->getPost('nombre_completo');
		$fields['direccion'] = $this->request->getPost('direccion');
		$fields['edad'] = $this->request->getPost('edad');
		$fields['estatus'] = $this->request->getPost('estatus');


		$this->validation->setRules([
			'nombre_completo' => ['label' => 'Nombre completo', 'rules' => 'required|min_length[0]|max_length[50]'],
			'direccion' => ['label' => 'Dirección', 'rules' => 'required|min_length[0]|max_length[50]'],
			'edad' => ['label' => 'Edad', 'rules' => 'required|numeric|min_length[0]|max_length[10]'],
			'estatus' => ['label' => 'Estatus', 'rules' => 'required|min_length[0]|max_length[20]'],

		]);

		if ($this->validation->run($fields) == FALSE) {

			$response['success'] = false;
			$response['messages'] = $this->validation->getErrors(); //Show Error in Input Form

		} else {

			if ($this->medicoModel->update($fields['id_medico'], $fields)) {

				$response['success'] = true;
				$response['messages'] = lang("Actualizado correctamente");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Error al actualizar");
			}
		}

		return $this->response->setJSON($response);
	}

	public function postRemove()
	{
		$response = array();

		$id = $this->request->getPost('id_medico');

		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		} else {

			if ($this->medicoModel->where('id_medico', $id)->delete()) {

				$response['success'] = true;
				$response['messages'] = lang("Eliminado correctamente");
			} else {

				$response['success'] = false;
				$response['messages'] = lang("Error al eliminar");
			}
		}

		return $this->response->setJSON($response);
	}
}
