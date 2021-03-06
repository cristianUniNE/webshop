<?php namespace App\Droit\Shop\Product\Repo;

use App\Droit\Shop\Product\Repo\ProductInterface;
use App\Droit\Shop\Product\Entities\Product as M;

class ProductEloquent implements ProductInterface{

    protected $product;

    public function __construct(M $product)
    {
        $this->product = $product;
    }

    public function getAll($search = null, $nbr = null, $visible = false)
    {
        $products = $this->product->search($search)->visible($visible)->orderBy('created_at', 'DESC');

        if($nbr)
        {
            return $products->paginate($nbr);
        }

        return $products->get();
    }

    public function listForAdminOrder()
    {
        return $this->product->whereNull('url')->orderBy('title', 'ASC')->get();
    }

    // For shop only
    public function getNbr($nbr = null, $visible = true)
    {
        return $this->product->with(['categories'])->visible($visible)->orderBy('created_at', 'DESC')->paginate($nbr);
    }

    public function forAbos()
    {
        $product = $this->product->with(['attributs'])->where('hidden','=',0);

        foreach([3,4] as $attr){
            $product->whereHas('attributs', function($q) use ($attr){
                $q->where('attribute_id', $attr);
            });
        }

        return $product->get();
    }

    public function getAbos()
    {
        return $this->product->with(['abos'])->has('abos')->get();
    }

    public function getByCategorie($id)
    {
        return $this->product
            ->with(['authors','attributs','categories'])
            ->where('hidden','=',0)
            ->whereHas('categories', function($query) use ($id)
            {
                $query->where('shop_categories.id', '=' ,$id);
                $query->orWhere('shop_categories.title', 'LIKE' ,'%'.$id.'%');
            })
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function find($id)
    {
        return $this->product->with(['categories','authors','domains','attributs','abos','stocks'])->find($id);
    }

    public function sku($product_id, $qty, $operator)
    {
        $product = $this->product->find($product_id);

        if(!$product){
            return $product;
        }

        switch($operator)
        {
            case "+":
                $result = $product->sku + $qty;
                break;

            case "-";
                $result = $product->sku - $qty;
                break;
        }

        $product->sku = $result;
        $product->save();

        return $product;
    }

    public function getSome($ids){

        return $this->product->whereIn('id', $ids)->get();
    }

    public function search($term, $hidden = false)
    {
        $products = $this->product->leftJoin('shop_product_attributes', 'shop_products.id', '=', 'shop_product_attributes.product_id')
            ->where('shop_product_attributes.value', 'like', '%'.$term.'%')
            ->orWhere('shop_products.title', 'like', '%'.$term.'%')
            ->select('shop_products.*','shop_product_attributes.value');

        if(!$hidden)
        {
            $products->where('hidden','=',0);
        }

        return $products->groupBy('shop_products.id')->get();
    }

    public function create(array $data){

        $product = $this->product->create(array(
            'title'           => $data['title'],
            'teaser'          => $data['teaser'],
            'image'           => isset($data['image']) ? $data['image'] : '',
            'description'     => $data['description'],
            'weight'          => $data['weight'],
            'sku'             => $data['sku'],
            'hidden'          => 1,
            'price'           => $data['price'] * 100,
            'is_downloadable' => (isset($data['is_downloadable']) ? $data['is_downloadable'] : null),
            'url'             => (isset($data['url']) && !empty($data['url']) ? $data['url'] : null),
            'pages'           => (isset($data['pages']) && !empty($data['pages']) ? $data['pages'] : null),
            'reliure'         => (isset($data['reliure']) && !empty($data['reliure']) ? $data['reliure'] : null),
            'format'          => (isset($data['format']) && !empty($data['format']) ? $data['format'] : null),
            'edition_at'      => (isset($data['edition_at']) && !empty($data['edition_at']) ? $data['edition_at'] : null),
            'abo_id'          => (isset($data['abo_id']) ? $data['abo_id'] : null),
            'rang'            => (isset($data['rang']) && $data['rang'] > 0 ? $data['rang'] : 0),
            'created_at'      => date('Y-m-d G:i:s'),
            'updated_at'      => date('Y-m-d G:i:s')
        ));

        if( ! $product )
        {
            return false;
        }

        return $product;
    }

    public function update(array $data){

        $data['hidden']     = (isset($data['hidden']) && $data['hidden'] ? 1 : 0);
        $data['edition_at'] = (isset($data['edition_at']) && !empty($data['edition_at']) ? $data['edition_at'] : null);

        $product = $this->product->findOrFail($data['id']);

        if( ! $product )
        {
            return false;
        }

        $product->fill($data);
        $product->price = $data['price'] * 100;
        
        if(isset($data['url']))
        {
            $product->url = (!empty($data['url']) ? $data['url'] : null);
        }

        $product->save();

        if(isset($data['abo_id']))
        {
            $product->abos()->sync($data['abo_id']);
        }

        if(!isset($data['abo_id']) || (isset($data['abo_id']) && empty($data['abo_id'])))
        {
            $product->abos()->detach();
        }

        return $product;
    }

    public function delete($id)
    {
        return $this->product->find($id)->delete();
    }

}
