<?php

namespace App\Http\Controllers\Backend\Content;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Droit\Seminaire\Repo\SeminaireInterface;
use App\Droit\Seminaire\Repo\SubjectInterface;
use App\Droit\Service\UploadInterface;

class SubjectController extends Controller
{
    protected $seminaire;
    protected $subject;
    protected $upload;

    public function __construct(SubjectInterface $subject, SeminaireInterface $seminaire, UploadInterface $upload)
    {
        $this->seminaire = $seminaire;
        $this->subject   = $subject;
        $this->upload    = $upload;

        view()->share('current_site', 2);
    }

    /**
     * Store a newly created resource in storage.
     * POST /subject
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->except('file','appendixes');

        if($request->file('file')){
            $file  = $this->upload->upload( $request->file('file') , 'files/subjects');
            $data['file'] = $file['name'];
        }

        if($request->file('appendixes')){
            $appendixes = $this->upload->upload( $request->file('appendixes') , 'files/subjects');
            $data['appendixes'] = $appendixes['name'];
        }

        $seminaire = $this->seminaire->find($request->input('seminaire_id'));

        $subject = $this->subject->create($data);
        
        $seminaire->subjects()->save($subject);

        alert()->success('Sujet crée');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * PUT /subject/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        $data  = $request->except('file','appendixes');

        if($request->file('file')){
            $file  = $this->upload->upload( $request->file('file') , 'files/subjects');
            $data['file'] = $file['name'];
        }

        if($request->file('appendixes')){
            $appendixes = $this->upload->upload( $request->file('appendixes') , 'files/subjects');
            $data['appendixes'] = $appendixes['name'];
        }

        $this->subject->update( $data );

        alert()->success('Sujet mise à jour');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /subject/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->subject->delete($id);

        alert()->success('Sujet supprimé');

        return redirect()->back();
    }

}
