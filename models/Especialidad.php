<?php
// example of using model with eloquent
namespace models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades';
    protected $fillable = [];

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}
