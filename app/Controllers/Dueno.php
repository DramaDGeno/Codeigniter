<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\DuenoModel;

class Dueno extends BaseController
{
	
    protected $duenoModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->duenoModel = new DuenoModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function getIndex()
	{

	    $data = [
                'controller'    	=> 'dueno',
                'title'     		=> 'cliente'				
			];
		
		return view('dueno', $data);
			
	}

	public function postGetAll()
	{
 		$response = $data['data'] = array();	

		$result = $this->duenoModel->select()->findAll();
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
			$ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
			$ops .= '<div class="dropdown-menu">';
			$ops .= '<a class="dropdown-item text-info" onClick="save('. $value->id_dueno .')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("App.edit")  . '</a>';
			$ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("App.copy")  . '</a>';
			$ops .= '<div class="dropdown-divider"></div>';
			$ops .= '<a class="dropdown-item text-danger" onClick="remove('. $value->id_dueno .')"><i class="fa-solid fa-trash"></i>   ' .  lang("App.delete")  . '</a>';
			$ops .= '</div></div>';

			$data['data'][$key] = array(
				$value->id_dueno,
$value->nombre_completo,
$value->direccion,
$value->fecha_nac,

				$ops				
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function postGetOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('id_dueno');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->duenoModel->where('id_dueno' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}	
		
	}	

	public function postAdd()
	{
        $response = array();

		$fields['id_dueno'] = $this->request->getPost('id_dueno');
$fields['nombre_completo'] = $this->request->getPost('nombre_completo');
$fields['direccion'] = $this->request->getPost('direccion');
$fields['fecha_nac'] = $this->request->getPost('fecha_nac');


        $this->validation->setRules([
			            'nombre_completo' => ['label' => 'Nombre completo', 'rules' => 'required|min_length[0]|max_length[30]'],
            'direccion' => ['label' => 'Direccion', 'rules' => 'required|min_length[0]|max_length[50]'],
            'fecha_nac' => ['label' => 'Fecha nac', 'rules' => 'required|valid_date|min_length[0]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form
			
        } else {

            if ($this->duenoModel->insert($fields)) {
												
                $response['success'] = true;
                $response['messages'] = lang("App.insert-success") ;	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = lang("App.insert-error") ;
				
            }
        }
		
        return $this->response->setJSON($response);
	}

	public function postEdit()
	{
        $response = array();
		
		$fields['id_dueno'] = $this->request->getPost('id_dueno');
$fields['nombre_completo'] = $this->request->getPost('nombre_completo');
$fields['direccion'] = $this->request->getPost('direccion');
$fields['fecha_nac'] = $this->request->getPost('fecha_nac');


        $this->validation->setRules([
			            'nombre_completo' => ['label' => 'Nombre completo', 'rules' => 'required|min_length[0]|max_length[30]'],
            'direccion' => ['label' => 'Direccion', 'rules' => 'required|min_length[0]|max_length[50]'],
            'fecha_nac' => ['label' => 'Fecha nac', 'rules' => 'required|valid_date|min_length[0]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form

        } else {

            if ($this->duenoModel->update($fields['id_dueno'], $fields)) {
				
                $response['success'] = true;
                $response['messages'] = lang("App.update-success");	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = lang("App.update-error");
				
            }
        }
		
        return $this->response->setJSON($response);	
	}
	
	public function postRemove()
	{
		$response = array();
		
		$id = $this->request->getPost('id_dueno');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->duenoModel->where('id_dueno', $id)->delete()) {
								
				$response['success'] = true;
				$response['messages'] = lang("App.delete-success");	
				
			} else {
				
				$response['success'] = false;
				$response['messages'] = lang("App.delete-error");
				
			}
		}	
	
        return $this->response->setJSON($response);		
	}	
		
}	