<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{

    protected $table='feedback';
    protected $primaryKey='idfeedback';



    public function Appointment(){

        return $this->belongsTo(Appointment::class,'appointment_idappointment');
    }


}