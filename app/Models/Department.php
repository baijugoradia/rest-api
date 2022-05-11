<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $departments_id)
 */
class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    protected $primaryKey = 'departments_id';
    protected $hidden = ['created_at', 'updated_at'];
}
