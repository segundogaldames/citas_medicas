<?php
// example of using model with eloquent
namespace models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';
    protected $fillable = [];

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function profesion()
    {
        return $this->belongsTo(Profesion::class);
    }
}
