<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'due_date',
        'status'
    ];

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

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
