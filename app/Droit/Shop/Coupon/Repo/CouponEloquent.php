<?php namespace App\Droit\Shop\Coupon\Repo;

use App\Droit\Shop\Coupon\Repo\CouponInterface;
use App\Droit\Shop\Coupon\Entities\Coupon as M;

class CouponEloquent implements CouponInterface{

    protected $coupon;

    public function __construct(M $coupon)
    {
        $this->coupon = $coupon;
    }

    public function getAll(){

        return $this->coupon->all();
    }

    public function find($id){

        return $this->coupon->find($id);
    }

    public function findByTitle($title){

        $coupon = $this->coupon->where('title', '=' , $title)->get();

        if(!$coupon->isEmpty())
        {
            return $coupon->first();
        }

        return false;
    }



    public function create(array $data){

        $coupon = $this->coupon->create(array(
            'title'      => $data['title'],
            'value'      => $data['value'],
            'product_id' => (isset($data['product_id']) ? $data['product_id'] : null),
            'expire_at'  => $data['expire_at']
        ));

        if( ! $coupon )
        {
            return false;
        }

        return $coupon;

    }

    public function update(array $data){

        $coupon = $this->coupon->findOrFail($data['id']);

        if( ! $coupon )
        {
            return false;
        }

        $coupon->fill($data);

        $coupon->save();

        return $coupon;
    }

    public function delete($id){

        $coupon = $this->coupon->find($id);

        return $coupon->delete();

    }

}
