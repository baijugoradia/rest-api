<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\Address;

/**
 * @method static where(string $string, int $id)
 */
class Employee extends Model
{
    use HasFactory;

    public $table = 'employee';
    protected $primaryKey = 'employee_id';

    protected $hidden = ['created_at','updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contact()
    {
        return $this->hasMany(Contact::class, 'employee_id');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'employee_id');
    }


}
