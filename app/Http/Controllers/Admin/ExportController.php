<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Inscription\Repo\InscriptionInterface;
use App\Droit\Colloque\Repo\ColloqueInterface;
use App\Droit\Inscription\Worker\InscriptionWorker;

class ExportController extends Controller
{
    protected $inscription;
    protected $colloque;
    protected $worker;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ColloqueInterface $colloque, InscriptionInterface $inscription, InscriptionWorker $worker )
    {
        $this->inscription = $inscription;
        $this->colloque    = $colloque;
        $this->worker      = $worker;
        $this->helper      = new \App\Droit\Helper\Helper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function inscription($id)
    {
        //$format = $request->input('format');

        $order = 'choix';

        $colloque = $this->colloque->find($id);
        $colloque->options->load('groupe');

        $allgroupes = [];
        $alloptions = [];

        if(!$colloque->options->isEmpty())
        {
            foreach($colloque->options as $option)
            {
                $alloptions[$option->id] = $option->title;

                if(isset($option->groupe) && !$option->groupe->isEmpty())
                {
                    foreach($option->groupe as $groupe)
                    {
                        $allgroupes[$groupe->id] = $groupe->text;
                    }
                }

            }
        }

        $inscriptions = $this->inscription->getByColloque($id);
        $inscriptions = $this->worker->dispatch($inscriptions);

        return view('export.inscription')->with(['inscriptions' => $inscriptions[$order], 'colloque' => $colloque, 'type' => $order, 'alloptions' => $alloptions, 'allgroupes' => $allgroupes]);

        ////////////////////////////////////////////////////////////////////////////////////////

        \Excel::create('Export inscriptions', function($excel) use ($id) {

            $inscriptions = $this->inscription->getByColloque($id);
            $inscriptions = $this->worker->dispatch($inscriptions);
            $colloque     = $this->colloque->find($id);

            $excel->sheet('Export', function($sheet) use ($inscriptions,$colloque) {

                $sheet->setOrientation('landscape');
                $sheet->loadView('export.inscription', ['inscriptions' => $inscriptions, 'colloque' => $colloque]);

            });

        })->export('xls');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
