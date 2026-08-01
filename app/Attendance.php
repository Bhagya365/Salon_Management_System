<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table='attendance';
    protected $primaryKey='idattendance';
    public $timestamps = true;


    protected $fillable = [
        'master_user_idmaster_user','marked_by','date','check_in','status'
    ];

    public function User(){
        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }

    public function MarkedBy()
{
        return $this->belongsTo(User::class, 'marked_by', 'idmaster_user');
}

}