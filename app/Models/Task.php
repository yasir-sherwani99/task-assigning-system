<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
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
        'start_date',
        'end_date',
        'description',
        'project_id',
        'estimated_hours',
        'progress',
        'priority',
        'status'
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

    public function members()
    {
        return $this->belongsToMany(User::class, 'task_members');
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

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

}












