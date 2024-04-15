<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR
//Comentario Adan   
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
			$ops .= '<a class="dropdown-item text-warning" onClick="viewPDF('. $value->id_visita .')"><i class="fa-solid fa-file-pdf"></i>   ' .  lang("Ver PDF")  . '</a>';
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
	
	public function viewPDF()
	{
		$id_visita = $this->request->getGet('id_visita');
	
		// Obtener la información de la receta desde la base de datos
		$visita = $this->visitaModel->find($id_visita);
	
		if ($visita) {
			// Obtener la ruta del archivo PDF asociado a la receta
			$rutaPDF = ROOTPATH . '/public/uploads/' . $visita['archivo'];
	
			// Verificar si el archivo existe
			if (file_exists($rutaPDF)) {
				// Configurar las cabeceras para visualizar el archivo PDF en línea
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="' . $visita['archivo'] . '"');
	
				// Leer el archivo y enviar su contenido al navegador para visualización
				readfile($rutaPDF);
	
				exit();
			} else {
				// Si el archivo no existe, mostrar un mensaje de error
				return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Archivo PDF no encontrado']);
			}
		} else {
			// Si no se encuentra la receta con el id proporcionado, mostrar un mensaje de error
			return $this->response->setStatusCode(404)->setJSON(['success' => false, 'message' => 'Visita no encontrada']);
		}
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

	public function generatePDFName()
{
    $lastVisita = $this->visitaModel->orderBy('id_visita', 'DESC')->first();
    if ($lastVisita) {
        $lastVisitaId = $lastVisita->id_visita;
        $newVisitaId = $lastVisitaId + 1;
    } else {
        $newVisitaId = 1;
    }
    return 'visita_' . $newVisitaId;
}

public function postAdd()
{
    $response = [];

    // Obtener los datos del formulario
    $fields['id_visita'] = $this->request->getPost('id_visita');
    $fields['id_mascota'] = $this->request->getPost('id_mascota');
    $fields['id_medico'] = $this->request->getPost('id_medico');
    $fields['fecha_visita'] = $this->request->getPost('fecha_visita');
    $fields['tipo_servicio'] = $this->request->getPost('tipo_servicio');
    $fields['descripcion_servicio'] = $this->request->getPost('descripcion_servicio');

    $archivo = $this->request->getFile('archivo');

// Verificar si se proporcionó un archivo y si es un PDF válido
if ($archivo && $archivo->isValid()) {
    if ($archivo->getClientMimeType() == 'application/pdf') {
        // Generar un nombre secuencial para el archivo PDF
        $nombreArchivo = $this->generatePDFName();

        // Mover el archivo a la carpeta deseada en tu servidor
        if ($archivo->move(ROOTPATH . '/public/uploads', $nombreArchivo . '.pdf')) {
            // Guardar la ruta del archivo en los datos de la visita
            $fields['archivo'] = '/uploads/' . $nombreArchivo . '.pdf';
        } else {
            // Error al mover el archivo
            $response['success'] = false;
            $response['messages'] = lang("Error al cargar el archivo");
            return $this->response->setJSON($response);
        }
    } else {
        // Archivo no es un PDF válido
        $response['success'] = false;
        $response['messages'] = lang("El archivo no es un PDF válido");
        return $this->response->setJSON($response);
    }
}

    // Validar otros campos del formulario
    $this->validation->setRules([
        'id_mascota' => ['label' => 'Id mascota', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
        'id_medico' => ['label' => 'Id medico', 'rules' => 'required|numeric|min_length[0]|max_length[20]'],
        'fecha_visita' => ['label' => 'Fecha visita', 'rules' => 'required|valid_date|min_length[0]'],
        'tipo_servicio' => ['label' => 'Tipo servicio', 'rules' => 'required|min_length[0]|max_length[50]'],
        'descripcion_servicio' => ['label' => 'Descripcion servicio', 'rules' => 'required|min_length[0]|max_length[50]'],
    ]);

    // Ejecutar la validación
    if ($this->validation->run($fields) == false) {
        $response['success'] = false;
        $response['messages'] = $this->validation->getErrors();
    } else {
        // Insertar los datos en la base de datos
        if ($this->visitaModel->insert($fields)) {
            $response['success'] = true;
            $response['messages'] = lang("Agregado correctamente");
        } else {
            $response['success'] = false;
            $response['messages'] = lang("Error al insertar");
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
