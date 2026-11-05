<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table='client';
    protected $primaryKey='idclient';


    public function Sale(){

        return $this->hasMany(Sale::class,'client_idclient');
    }

}