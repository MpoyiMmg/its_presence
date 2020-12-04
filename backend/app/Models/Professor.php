<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname', 'matricule', 'gender', 'account_id'
    ];

    public function account()
    {
        return $this->hasOne('App\Models\Account');
    }
}
