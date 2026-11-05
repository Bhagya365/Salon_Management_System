<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCard extends Model
{
    protected $table = 'service_card';
    protected $primaryKey = 'idservice_card';
    protected $fillable = ['client_id', 'status'];

    
    const STATUS_PENDING     = 0; 
    const STATUS_COMPLETED   = 1; 
    const STATUS_IN_PROGRESS = 2; 


    public function client(){
        return $this->belongsTo(Client::class, 'client_id', 'idclient');
    }

    public function appointments(){
        return $this->hasMany(Appointment::class, 'service_card_idservice_card', 'idservice_card');
    }


    public function getStatusLabelAttribute(){
        $map = [
            self::STATUS_PENDING     => 'Pending',
            self::STATUS_COMPLETED   => 'Completed',
            self::STATUS_IN_PROGRESS => 'In Progress',
        ];
        return $map[$this->status] ?? 'Unknown';
    }
}