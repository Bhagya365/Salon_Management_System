<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table='product';
    protected $primaryKey='idproduct';


    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'product_idproduct', 'idproduct');
    }

}
