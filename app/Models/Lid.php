<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $validatedData)
 * @method static findorfail($id)
 */
class Lid extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'text', 'status_id'];

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
