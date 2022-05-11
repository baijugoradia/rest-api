<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @method static where(string $string, int $id)
 */
class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $primaryKey = 'contacts_id';
    protected $hidden = ['created_at', 'updated_at'];

    public function employee()
    {
        $this->belongsTo(Employee::class, 'employee_id');
    }

}
