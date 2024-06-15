<?php
// example of using model with eloquent
namespace models;

use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    protected $table = 'profesiones';
    protected $fillable = [];
}
