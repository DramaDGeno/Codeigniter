<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class DuenoModel extends Model {
    
	protected $table = 'dueno';
	protected $primaryKey = 'id_dueno';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nombre_completo', 'direccion', 'fecha_nac'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}


