<?php namespace App\Droit\Seminaire\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model{

    use SoftDeletes;
    
    protected $table = 'subjects';

    protected $fillable = ['title','file','appendixes','rang'];

    public function seminaire()
    {
        return $this->belongsTo('App\Droit\Seminaire\Entities\Seminaire');
    }

    public function authors()
    {
        return $this->belongsToMany('App\Droit\Author\Entities\Author' , 'subject_authors', 'subject_id', 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Droit\Categorie\Entities\Categorie' , 'subject_categories', 'subject_id', 'categorie_id');
    }
}