<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    /**
     * @return HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id', 'id')->orderBy('created_at', 'desc');
    }
}
