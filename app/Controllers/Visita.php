<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\VisitaModel;

use App\Models\MascotaModel;

use App\Models\MedicoModel;

class Visita extends BaseController
{
	
    protected $visitaModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->visitaModel = new VisitaModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function getIndex()
	{

		$mascotasModel = new MascotaModel();
    	$mascotas = $mascotasModel->findAll();

		$medicosModel = new MedicoModel();
    	$medicos = $medicosModel->findAll();

	    $data = [
                'controller'    	=> 'visita',
                'title'     		=> 'visita',
				'mascotas' => $mascotas,
				'medicos' => $medicos				
			];
		
		return view('visita', $data);
			
	}

	public function postGetAll()
	{
 		$response = $data['data'] = array();	

		 $result = $this->visitaModel
		 ->select('visita.id_visita, mascota.nombre as nombre_mascota, visita.id_mascota, medico.nombre_completo as nombre_medico, visita.id_medico, visita.fecha_visita, visita.tipo_servicio, visita.descripcion_servicio')
		 ->join('mascota', 'mascota.id_mascota = visita.id_mascota')
		 ->join('medico', 'medico.id_medico = visita.id_medico')
		 ->findAll();
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save('. $value->id_visita .')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Editar")  . '</a>';
			$ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("Copiar")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove('. $value->id_visita .')"><i class="fa-solid fa-trash"></i>   ' .  lang("Eliminar")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$value->id_visita,
				$value->nombre_mascota,
				$value->nombre_medico,
				$value->fecha_visita,
				$value->tipo_servicio,
				$value->descripcion_servicio,

				$ops				
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function postGetOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('id_visita');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->visitaModel->where('id_visita' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}	
		
	}	

	public function postAdd()
	{
        $response = array();

		$fields['id_visita'] = $this->request->getPost('id_visita');
		$fields['id_mascota'] = $this->request->getPost('id_mascota');
		$fields['id_medico'] = $this->request->getPost('id_medico');
		$fields['fecha_visita'] = $this->request->getPost('fecha_visita');
		$fields['tipo_servicio'] = $this->request->getPost('tipo_servicio');
		$fields['descripcion_servicio'] = $this->request->getPost('descripcion_servicio');


        $this->validation->setRules([
			'id_mascota' => ['label' => 'Id mascota', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
            'id_medico' => ['label' => 'Id medico', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
            'fecha_visita' => ['label' => 'Fecha visita', 'rules' => 'required|valid_date|min_length[0]'],
            'tipo_servicio' => ['label' => 'Tipo servicio', 'rules' => 'required|min_length[0]|max_length[50]'],
            'descripcion_servicio' => ['label' => 'Descripcion servicio', 'rules' => 'required|min_length[0]|max_length[50]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form
			
        } else {

            if ($this->visitaModel->insert($fields)) {
												
                $response['success'] = true;
                $response['messages'] = lang("Agregado correctamente") ;	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = lang("Error al insertar") ;
				
            }
        }
		
        return $this->response->setJSON($response);
	}

	public function postEdit()
	{
        $response = array();
		
		$fields['id_visita'] = $this->request->getPost('id_visita');
		$fields['id_mascota'] = $this->request->getPost('id_mascota');
		$fields['id_medico'] = $this->request->getPost('id_medico');
		$fields['fecha_visita'] = $this->request->getPost('fecha_visita');
		$fields['tipo_servicio'] = $this->request->getPost('tipo_servicio');
		$fields['descripcion_servicio'] = $this->request->getPost('descripcion_servicio');


        $this->validation->setRules([
			'id_mascota' => ['label' => 'Id mascota', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
            'id_medico' => ['label' => 'Id medico', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
            'fecha_visita' => ['label' => 'Fecha visita', 'rules' => 'required|valid_date|min_length[0]'],
            'tipo_servicio' => ['label' => 'Tipo servicio', 'rules' => 'required|min_length[0]|max_length[50]'],
            'descripcion_servicio' => ['label' => 'Descripcion servicio', 'rules' => 'required|min_length[0]|max_length[50]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form

        } else {

            if ($this->visitaModel->update($fields['id_visita'], $fields)) {
				
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
		
		$id = $this->request->getPost('id_visita');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->visitaModel->where('id_visita', $id)->delete()) {
								
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
