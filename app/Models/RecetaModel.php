<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Models;
use CodeIgniter\Model;

class RecetaModel extends Model {
    
	protected $table = 'receta';
	protected $primaryKey = 'id_receta';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['id_visita', 'id_mascota', 'desc_receta', 'archivo'];
	protected $useTimestamps = false;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    
	

	protected $with = ['mascota', 'visita'];

	public function mascota() {
        return $this->belongsTo(MascotaModel::class, 'id_mascota', 'id_mascota');
    } 

	public function visita() {
        return $this->belongsTo(VisitaModel::class, 'id_visita', 'id_visita');
    } 

	//Funcion agregada en el modelo para contador de recetas Geno

	public function getContadorRecetas()
{
    // Consulta para obtener el número de recetas en la base de datos
    return $this->countAllResults();
}


}