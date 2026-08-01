<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table='sale';
    protected $primaryKey='idsale';


    public function User(){

        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }

    public function Client(){

        return $this->belongsTo(Client::class,'client_idclient');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_idsale', 'idsale');
    }
}
