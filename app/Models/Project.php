<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        'user_id'
    ];

    public function task()
    {
        return $this->hasMany(Task::class);
    }
    public function collaborators()
    {
        return $this->hasMany(Collaborator::class,'collab_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
