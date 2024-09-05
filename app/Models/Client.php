<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'photo',
        'address',
        'city',
        'country',
        'company_name',
        'company_email',
        'designation',
        'company_address',
        'company_city',
        'company_country',
        'company_website',
        'company_logo',
        'status'
    ];

    /*
    |---------------------------------------------------------------
    | Relations
    |---------------------------------------------------------------
    */
    public function project()
    {
        return $this->hasMany(Project::class, 'client_id');
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'client_id');
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'client_id');
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
    | Accessors
    |---------------------------------------------------------------
    */
    public function getCompanyLogoAttribute($value)
    {
        if(isset($value)) {
            return $value;            
        } else {    
            return '../../admin-assets/images/users/user-vector.png';
        }
    }
}
