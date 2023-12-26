<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;
    //use SoftDeletes;
    protected $table = 'email_templates';
    protected $fillable = ['email_template_type_id','subject_name','email_template_title_id','message','status'];
}
