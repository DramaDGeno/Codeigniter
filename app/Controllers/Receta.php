<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\RecetaModel;

use App\Models\MascotaModel;

use App\Models\VisitaModel;

class Receta extends BaseController
{
	
    protected $recetaModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->recetaModel = new RecetaModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function getIndex()
	{
		$mascotasModel = new MascotaModel();
    	$mascotas = $mascotasModel->findAll();

		$visitasModel = new VisitaModel();
    	$visitas = $visitasModel->findAll();

	    $data = [
                'controller'    	=> 'receta',
                'title'     		=> 'Receta',
				'mascotas' => $mascotas,
				'visitas' => $visitas

			];
		
		return view('receta', $data);
			
	}

	public function postGetAll()
	{
 		$response = $data['data'] = array();	
		
		 $result = $this->recetaModel
		 ->select('receta.id_receta, visita.id_visita as id_visita, receta.id_visita, mascota.nombre as nombre_mascota, receta.id_mascota, receta.desc_receta')
		 ->join('mascota', 'mascota.id_mascota = receta.id_mascota')
		 ->join('visita', 'visita.id_visita = receta.id_visita')
		 ->findAll();

		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save('. $value->id_receta .')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Editar")  . '</a>';
			$ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("Copiar")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove('. $value->id_receta .')"><i class="fa-solid fa-trash"></i>   ' .  lang("Eliminar")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$value->id_receta,
				$value->id_visita,
				$value->nombre_mascota,
				$value->desc_receta,

				$ops				
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function postGetOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('id_receta');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->recetaModel->where('id_receta' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}	
		
	}	

	public function postAdd()
	{
        $response = array();

		$fields['id_receta'] = $this->request->getPost('id_receta');
		$fields['id_visita'] = $this->request->getPost('id_visita');
		$fields['id_mascota'] = $this->request->getPost('id_mascota');
		$fields['desc_receta'] = $this->request->getPost('desc_receta');


        $this->validation->setRules([
			'id_visita' => ['label' => 'Id visita', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'id_mascota' => ['label' => 'Id mascota', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
            'desc_receta' => ['label' => 'Desc receta', 'rules' => 'required|min_length[5]|max_length[50]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form
			
        } else {

            if ($this->recetaModel->insert($fields)) {
												
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
		
		$fields['id_receta'] = $this->request->getPost('id_receta');
		$fields['id_visita'] = $this->request->getPost('id_visita');
		$fields['id_mascota'] = $this->request->getPost('id_mascota');
		$fields['desc_receta'] = $this->request->getPost('desc_receta');


        $this->validation->setRules([
			'id_visita' => ['label' => 'Id visita', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'id_mascota' => ['label' => 'Id mascota', 'rules' => 'required|numeric|min_length[0]|max_length[11]'],
            'desc_receta' => ['label' => 'Desc receta', 'rules' => 'required|min_length[5]|max_length[50]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form

        } else {

            if ($this->recetaModel->update($fields['id_receta'], $fields)) {
				
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
		
		$id = $this->request->getPost('id_receta');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->recetaModel->where('id_receta', $id)->delete()) {
								
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
