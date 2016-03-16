<?php namespace App\Droit\Newsletter\Repo;

use App\Droit\Newsletter\Entities\Newsletter_lists as M;
use App\Droit\Newsletter\Repo\NewsletterListInterface;

class NewsletterListEloquent implements NewsletterListInterface{

	protected $list;

	public function __construct(M $list)
	{
		$this->list = $list;
	}
	
	public function getAll(){
		
		return $this->list->all();
	}
	
	public function find($id){

		return $this->list->with(['emails'])->find($id);
	}

    public function create(array $data){

        $list = $this->list->create(array(
            'title'        => $data['title'],
            'created_at'   => date('Y-m-d G:i:s'),
            'updated_at'   => date('Y-m-d G:i:s')
        ));

        if( ! $list )
        {
            return false;
        }

        return $list;
    }

    public function update(array $data){

        $list = $this->list->findOrFail($data['id']);

        if( !$list )
        {
            return false;
        }

        $list->fill($data);

        $list->save();

        return $list;
    }

	public function delete($id){

        $list = $this->list->find($id);

        return $list->delete();
    }
}
