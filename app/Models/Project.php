<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_no',
        'name',
        'version',
        'creator_id',
        'client_id',
        'team_id',
        'assigned_to_id',
        'demo_url',
        'start_date',
        'end_date',
        'description',
        'billing_type',
        'estimated_hours',
        'progress',
        'budget',
        'is_auto_progress',
        'image',
        'status'
    ];

    /*
    |---------------------------------------------------------------
    | Relations
    |---------------------------------------------------------------
    */
    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function teams()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function task()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function defect()
    {
        return $this->hasMany(Defect::class, 'project_id');
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'project_id');
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
    | Accessors
    |---------------------------------------------------------------
    */
    public function getImageAttribute($value)
    {
        if(isset($value)) {
            return $value;            
        } else {    
            return '../../admin-assets/images/users/user-vector.png';
        }
    }
}
