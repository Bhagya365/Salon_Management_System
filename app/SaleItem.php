<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $table='sale_item';
    protected $primaryKey='idsale_item';
    protected $guarded = [];

    public function Sale(){

        return $this->belongsTo(Sale::class,'sale_idsale');
    }

    public function Product(){

        return $this->belongsTo(Product::class,'product_idproduct');
    }

    

}