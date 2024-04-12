<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class VisitaModel extends Model {
    
	protected $table = 'visita';
	protected $primaryKey = 'id_visita';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['id_mascota', 'id_medico', 'fecha_visita', 'tipo_servicio', 'descripcion_servicio'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	

	protected $with = ['mascota', 'medico'];

	public function mascota() {
        return $this->belongsTo(MascotaModel::class, 'id_mascota', 'id_mascota');
    } 

	public function medico() {
		return $this->belongsTo(MedicoModel::class, 'id_medico', 'id_medico');
	}
}