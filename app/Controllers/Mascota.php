<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\MascotaModel;

use App\Models\DuenoModel; //ADAN: USAR USE 


class Mascota extends BaseController
{
	
    protected $mascotaModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->mascotaModel = new MascotaModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function getIndex()
{
    // Obtener los registros de los dueños desde el modelo de dueños
    $duenosModel = new DuenoModel();
    $duenos = $duenosModel->findAll();

    // Crear los datos que se enviarán a la vista
    $data = [
        'controller' => 'mascota',
        'title' => 'mascota',
        'duenos' => $duenos  // Pasar la variable $duenos a la vista
    ];

    // Cargar la vista 'mascota' y pasar los datos a la vista
    return view('mascota', $data);
}


///////
public function postGetAll()
{
    $response = $data['data'] = array();  

    // Seleccionar todas las mascotas con los nombres de los dueños
    $result = $this->mascotaModel
                    ->select('mascota.id_mascota, dueno.nombre_completo as nombre_dueno, mascota.nombre, mascota.descripcion')
                    ->join('dueno', 'dueno.id_dueno = mascota.id_dueno')
                    ->findAll();
    
    // Recorrer los resultados
    foreach ($result as $key => $value) {
        // Generar los botones
        $ops = '<div class="btn-group">';
        $ops .= '<button type="button" class=" btn btn-sm dropdown-toggle btn-info" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $ops .= '<i class="fa-solid fa-pen-square"></i>  </button>';
        $ops .= '<div class="dropdown-menu">';
        $ops .= '<a class="dropdown-item text-info" onClick="save('. $value->id_mascota .')"><i class="fa-solid fa-pen-to-square"></i>   ' .  lang("Editar")  . '</a>';
        $ops .= '<a class="dropdown-item text-orange" ><i class="fa-solid fa-copy"></i>   ' .  lang("Copiar")  . '</a>';
        $ops .= '<div class="dropdown-divider"></div>';
        $ops .= '<a class="dropdown-item text-danger" onClick="remove('. $value->id_mascota .')"><i class="fa-solid fa-trash"></i>   ' .  lang("Eliminar")  . '</a>';
        $ops .= '</div></div>';

        // Añadir los datos de la mascota y el nombre del dueño al array de datos
        $data['data'][$key] = array(
            $value->id_mascota,
            $value->nombre_dueno, // Usar el nombre del dueño en lugar de su ID
            $value->nombre,
            $value->descripcion,
            $ops
        );
    } 

    return $this->response->setJSON($data);        
}



///////////
	
	public function postGetOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('id_mascota');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->mascotaModel->where('id_mascota' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			throw new \CodeIgniter\Exceptions\PageNotFoundException();
		}	
		
	}	

	public function postAdd()
	{
        $response = array();

		$fields['id_mascota'] = $this->request->getPost('id_mascota');
$fields['id_dueno'] = $this->request->getPost('id_dueno');
$fields['nombre'] = $this->request->getPost('nombre');
$fields['descripcion'] = $this->request->getPost('descripcion');


        $this->validation->setRules([
			            'id_dueno' => ['label' => 'Id dueno', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
            'nombre' => ['label' => 'Nombre', 'rules' => 'required|min_length[0]|max_length[30]'],
            'descripcion' => ['label' => 'Descripción', 'rules' => 'required|min_length[0]|max_length[50]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form
			
        } else {

            if ($this->mascotaModel->insert($fields)) {
												
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
		
		$fields['id_mascota'] = $this->request->getPost('id_mascota');
$fields['id_dueno'] = $this->request->getPost('id_dueno');
$fields['nombre'] = $this->request->getPost('nombre');
$fields['descripcion'] = $this->request->getPost('descripcion');


        $this->validation->setRules([
			            'id_dueno' => ['label' => 'Id dueno', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
            'nombre' => ['label' => 'Nombre', 'rules' => 'required|min_length[0]|max_length[30]'],
            'descripcion' => ['label' => 'Descripción', 'rules' => 'required|min_length[0]|max_length[50]'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
			$response['messages'] = $this->validation->getErrors();//Show Error in Input Form

        } else {

            if ($this->mascotaModel->update($fields['id_mascota'], $fields)) {
				
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
		
		$id = $this->request->getPost('id_mascota');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->mascotaModel->where('id_mascota', $id)->delete()) {
								
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
