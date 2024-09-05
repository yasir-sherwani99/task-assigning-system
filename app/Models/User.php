<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasPermissionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPermissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'photo',
        'phone',
        'address',
        'city',
        'country',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |---------------------------------------------------------------
    | Relations
    |---------------------------------------------------------------
    */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function team()
    {
        return $this->hasOne(Team::class, 'leader_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'assigned_to_id');
    }
    
    public function task()
    {
        return $this->hasOne(Task::class, 'creator_id');
    }

    public function defect2()
    {
        return $this->hasOne(Defect::class, 'creator_id');
    }

    public function defect()
    {
        return $this->hasOne(Defect::class, 'assigned_to_id');
    }

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meetings_members');
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'organizer_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_members');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_members');
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

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /*
    |---------------------------------------------------------------
    | Mutators
    |---------------------------------------------------------------
    */
    public function setFirstNameAttribute($value)
    {
        return $this->attributes['first_name'] = ucfirst($value);
    }

    public function setLastNameAttribute($value)
    {
        return $this->attributes['last_name'] = ucfirst($value);
    }

    /*
    |---------------------------------------------------------------
    | Accessors
    |---------------------------------------------------------------
    */
    public function getPhotoAttribute($value)
    {
        if(isset($value)) {
            return $value;            
        } else {    
            return '../../admin-assets/images/users/user-vector.png';
        }
    }
}
