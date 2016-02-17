@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-4">
        <h3>Rappels via email</h3>
    </div>
    <div class="col-md-8">
        <div class="options text-right" style="margin-bottom: 10px;">
            <div class="btn-toolbar">

                <?php $items = config('jobs'); ?>

                @if(!empty($items))
                    @foreach($items as $type => $title)
                        <a href="{{ url('admin/reminder/create/'.$type) }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp;Ajouter un rappel {{ $title['name'] }}</a>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xs-12">
        <?php
        echo '<pre>';
        print_r(config('jobs'));
        echo '</pre>';
        ?>
        @if(!$reminders->isEmpty())

            <div class="panel panel-primary">
                <div class="panel-body">

                    <table class="table">
                        <thead>
                        <tr>
                            <th class="col-sm-1">Action</th>
                            <th class="col-sm-3">Titre</th>
                            <th class="col-sm-2 no-sort"></th>
                        </tr>
                        </thead>
                        <tbody class="selects">
                       
                            @foreach($reminders as $reminder)
                                <tr>
                                    <td><a class="btn btn-sky btn-sm" href="{{ url('admin/reminder/'.$reminder->id) }}"><i class="fa fa-edit"></i></a></td>
                                    <td><strong>{{ $reminder->title }}</strong></td>
                                    <td class="text-right">
                                        <form action="{{ url('admin/reminder/'.$reminder->id) }}" method="POST" class="form-horizontal">
                                            <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                            <button data-what="Supprimer" data-action="{{ $reminder->title }}" class="btn btn-danger btn-sm deleteAction">x</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>

        @endif

    </div>
</div>


@stop