<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    protected $table = 'report';
    protected $primaryKey = 'idreport';

    public $timestamps = false; // manually setting 'date'
    protected $fillable = ['report_title', 'report_type', 'date', 'master_user_idmaster_user'];

    public function User(){
        
        return $this->belongsTo(User::class,'master_user_idmaster_user');
    }


}