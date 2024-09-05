<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'leader_id',
        'description'
    ];

    /*
    |---------------------------------------------------------------
    | Relations
    |---------------------------------------------------------------
    */
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function project()
    {
        return $this->hasMany(Project::class, 'team_id');
    }

    public function defect()
    {
        return $this->hasMany(Project::class, 'team_id');
    }

    /*
    |---------------------------------------------------------------
    | Scopes
    |---------------------------------------------------------------
    */
    public function scopeSort($query, $value)
    {
        return $query->orderBy('name', $value);
    }
}
