<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;
    protected $fillable = [
        "project_id",
        "user_id",
        "collab_id"
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function collaborators()
    {
        return $this->hasMany(User::class,'id','collab_id');
    }
}