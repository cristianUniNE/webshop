@extends('backend.layouts.master')
@section('content')

<?php $site = $sites->find($current); ?>

<div class="row">
    <div class="col-md-6">
        <h3>Blocs de contenus</h3>
    </div>
    <div class="col-md-6">
        <div class="options text-right" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
                <a href="{{ url('admin/bloc/create/'.$site->id) }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp;Ajouter</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <h4><img height="100%" style="width: 150px;" src="{{ asset('logos/'.$site->logo) }}" alt="{{ $site->nom }}" /></h4>

        <div class="panel panel-primary">
            <div class="panel-body">

                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-sm-1">Action</th>
                        <th class="col-sm-1">Type</th>
                        <th class="col-sm-2">Titre</th>
                        <th class="col-sm-1">Image</th>
                        <th class="col-sm-1">Position</th>
                        <th class="col-sm-1"></th>
                    </tr>
                    </thead>
                    <tbody class="selects">
                    @if(!$blocs->isEmpty())
                        @foreach($blocs as $bloc)
                            <tr>
                                <td><a class="btn btn-sky btn-sm" href="{{ url('admin/bloc/'.$bloc->id) }}">&Eacute;diter</a></td>
                                <td>{{ ucfirst($bloc->type) }}</td>
                                <td><strong>{!! $bloc->title !!}</strong></td>
                                <td>
                                    @if(!empty($bloc->image))
                                        <img height="50" src="{{ asset('files/uploads/'.$bloc->image) }}" alt="{{ $bloc->title or '' }}" />
                                    @endif
                                </td>
                                <td>{{ $positions[$bloc->position] }}</td>
                                <td class="text-right">
                                    <form action="{{ url('admin/bloc/'.$bloc->id) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                        <button data-what="supprimer" data-action="bloc: {{ $bloc->title }}" class="btn btn-danger btn-sm deleteAction">x</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td>Aucun contenus</td></tr>
                    @endif
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

@stop