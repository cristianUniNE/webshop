<?php
namespace App\Http\Controllers\Backend\Shop;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Shop\Product\Repo\ProductInterface;
use App\Droit\Shop\Order\Repo\OrderInterface;
use App\Droit\Shop\Categorie\Repo\CategorieInterface;

class OrderController extends Controller {

	protected $product;
    protected $categorie;
    protected $order;
    protected $generator;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(ProductInterface $product, CategorieInterface $categorie, OrderInterface $order)
	{
        $this->product   = $product;
        $this->categorie = $categorie;
        $this->order     = $order;
        $this->generator = new \App\Droit\Generate\Excel\ExcelGenerator();

        setlocale(LC_ALL, 'fr_FR.UTF-8');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{

        $names   = config('columns.names');

        $period  = $request->all();
        $status  = $request->input('status',null);
        $columns = $request->input('columns',$this->generator->columns);
        $export  = $request->input('export',null);

        $period['start'] = (!isset($period['start']) ? \Carbon\Carbon::now()->startOfMonth() : \Carbon\Carbon::parse($period['start']) );
        $period['end']   = (!isset($period['end'])   ? \Carbon\Carbon::now()->endOfMonth()   : \Carbon\Carbon::parse($period['end']) );

        $orders = $this->order->getPeriod($period['start'],$period['end'], $status);

        if($export)
        {
            $this->generator->setColumns($columns);
            $this->export($orders);
        }

		return view('backend.orders.index')->with(['orders' => $orders, 'start' => $period['start'], 'end' => $period['end'], 'columns' => $columns, 'names' => $names]);
	}

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function export($orders)
    {
        \Excel::create('Export Commandes', function($excel) use ($orders)
        {
            $excel->sheet('Export_Commandes', function($sheet) use ($orders)
            {
                $names   = config('columns.names');

                $sheet->setOrientation('landscape');
                $sheet->loadView('backend.export.orders', ['orders' => $orders , 'generator' => $this->generator, 'names' => $names]);
            });
        })->export('xls');
    }

    /**
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->product->find($id);

        return view('backend.orders.show')->with(['product' => $product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = $this->product->getAll();

        return view('backend.orders.create')->with(['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        echo '<pre>';
        print_r($request->all());
        echo '</pre>';exit;

        $product  = $this->product->create($request->all());

        return redirect('admin/orders')->with(array('status' => 'success', 'message' => 'Le produit a été crée' ));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->product->delete($id);

        return redirect('admin/orders')->with(array('status' => 'success' , 'message' => 'Le produit a été supprimé' ));
    }

}
