<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Compte\Repo\CompteInterface;

class CompteController extends Controller
{
    protected $compte;

    public function __construct( CompteInterface $compte )
    {
        $this->compte = $compte;
    }

    /**
     * Show the form for creating a new resource.
     * GET /admin/compte/create
     *
     * @return Response
     */
    public function index()
    {
        $comptes  = $this->compte->getAll();

        return view('backend.comptes.index')->with(['comptes' => $comptes]);
    }

    /**
     * Show the form for creating a new resource.
     * GET /compte/create
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.comptes.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /compte
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $compte = $this->compte->create( $request->all() );

        return redirect('admin/compte/'.$compte->id)->with(['status' => 'success' , 'message' => 'Compte crée']);
    }

    /**
     * Display the specified resource.
     * GET /compte/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $compte = $this->compte->find($id);

        return view('backend.comptes.show')->with(['compte' => $compte]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /compte/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        $this->compte->update( $request->all() );

        return redirect('admin/compte/'.$id)->with(['status' => 'success' , 'message' => 'Compte mise à jour']);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /compte/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->compte->delete($id);

        return redirect()->back()->with(['status' => 'success', 'message' => 'Compte supprimé']);
    }
}
