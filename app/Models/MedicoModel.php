<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class MedicoModel extends Model {
    
	protected $table = 'medico';
	protected $primaryKey = 'id_medico';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nombre_completo', 'direccion', 'edad', 'estatus'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	
}