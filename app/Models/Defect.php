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
        'creator_id',
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
    public function createdby()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
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

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeSolved($query)
    {
        return $query->where('status', 'solved');
    }
}





















