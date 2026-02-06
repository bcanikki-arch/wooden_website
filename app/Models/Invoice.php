<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    public function sale(){
        return $this->hasMany('App\Models\Sales');
    }

     public function customer()
    {
        return $this->belongsTo(Customer::class);
    }






}
