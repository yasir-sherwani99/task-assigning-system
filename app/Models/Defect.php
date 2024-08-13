<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'project_id',
        'start_date',
        'end_date',
        'type',
        'priority',
        'team_id',
        'assigned_to_id',
        'estimated_hours',
        'status',
        'description'
    ];

    /*
    |---------------------------------------------------------------
    | Relations
    |---------------------------------------------------------------
    */
    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function teams()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /*
    |---------------------------------------------------------------
    | Mutators
    |---------------------------------------------------------------
    */
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords($value);
    }

    /*
    |---------------------------------------------------------------
    | Scopes
    |---------------------------------------------------------------
    */
    public function scopeSort($query, $value)
    {
        return $query->orderBy('created_at', $value);
    }
}
