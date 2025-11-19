<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'parent_id'
    ];
    
    public function parent(){
        
        return $this->belongsTo(Customer::class, 'parent_id');
    }

}
