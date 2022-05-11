<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

/**
 * @method static where(string $string, int $id)
 */
class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    protected $primaryKey = 'addresses_id';

    protected $hidden = ['created_at', 'updated_at', 'employee_id'];

    public function employee()
    {
        $this->belongsTo(Employee::class, 'employee_id');
    }

}
