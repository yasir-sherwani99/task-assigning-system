<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'organizer_id',
        'client_id',
        'start_date',
        'end_date',
        'location',
        'notes',
        'status'
    ];

    /*
    |---------------------------------------------------------------
    | Relations
    |---------------------------------------------------------------
    */
    public function users()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function clients()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /*
    |---------------------------------------------------------------
    | Mutators
    |---------------------------------------------------------------
    */
    public function setTitleAttribute($value)
    {
        return $this->attributes['title'] = ucwords($value);
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

    public function scopeReserved($query)
    {
        return $query->where('status', 'reserved');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', 'canceled');
    }
}
