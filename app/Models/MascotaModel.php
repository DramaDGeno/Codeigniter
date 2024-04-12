<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class MascotaModel extends Model {
    
	protected $table = 'mascota';
	protected $primaryKey = 'id_mascota';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['id_dueno', 'nombre', 'descripcion'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    

	// Define la relación con el modelo DuenoModel
    protected $with = ['dueno'];

    // Define la relación inversa (opcional)
    public function dueno() {
        return $this->belongsTo(DuenoModel::class, 'id_dueno', 'id_dueno');
    }   
	
}