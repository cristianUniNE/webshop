<?php

namespace App\Http\Controllers\Backend\User;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Droit\Pays\Repo\PaysInterface;
use App\Droit\Canton\Repo\CantonInterface;
use App\Droit\Profession\Repo\ProfessionInterface;

use App\Droit\User\Repo\UserInterface;
use App\Http\Requests\CreateUser;
use App\Http\Requests\UpdateUser;

class UserController extends Controller {

    protected $user;
    protected $pays;
    protected $canton;
    protected $profession;

    public function __construct(UserInterface $user, CantonInterface $canton, PaysInterface $pays, ProfessionInterface $profession)
    {
        $this->user       = $user;
        $this->pays       = $pays;
        $this->canton     = $canton;
        $this->profession = $profession;

        setlocale(LC_ALL, 'fr_FR.UTF-8');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->user->getAll();

        return view('backend.users.index')->with([ 'users' => $users ]);
    }

    public function users(Request $request)
    {
        $order  = $request->input('order');
        $search = $request->input('search',null);
        $search = ($search ? $search['value'] : null);

        return $this->user->get_ajax(
            $request->input('draw'), $request->input('start'), $request->input('length'), $order[0]['column'], $order[0]['dir'], $search
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cantons     = $this->canton->getAll();
        $professions = $this->profession->getAll();
        $pays        = $this->pays->getAll();

        return view('backend.users.create')->with(compact('pays','cantons','professions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateUser $request)
    {
        $user = $this->user->create($request->all());

        return redirect('user/'.$user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user        = $this->user->find($id);
        $cantons     = $this->canton->getAll();
        $professions = $this->profession->getAll();
        $pays        = $this->pays->getAll();

        return view('backend.users.show')->with(compact('pays','cantons','professions','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,UpdateUser $request)
    {
        $user = $this->user->update($request->all());

        $request->ajax();

        return redirect('user/'.$user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->user->delete($id);

        return redirect('/')->with(array('status' => 'success', 'message' => 'Utilisateur supprimé' ));
    }

}
