<?php

namespace App\Model;

//the library to create a model in lumen
use Illuminate\Database\Eloquent\Model;

class UserJob extends Model{
    protected $table = 'tbluserjob';
    // column sa table
    protected $fillable = [
        'jobId', 'jobName'
    ];
    public $timestamps = false;
    protected $primaryKey = 'jobId';//add to not explicitly ask for an id when adding data

}

?>
