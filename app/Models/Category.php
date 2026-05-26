<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Campos que permitimos llenar masivamente
    protected $fillable = ['name', 'color'];

    // Relación: Una categoría tiene muchas tareas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
