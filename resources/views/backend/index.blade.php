@extends('backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-midnightblue">
                <div class="panel-body">

                    <form>
                        <div class="file-upload-wrapper" data-name="file">
                            <button type="button" class="btn btn-default" id="file" data-toggle="modal" data-target="#uploadModal">Chercher</button>
                            <div class="file-input"></div>
                            @include('manager.modal')
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="panel panel-info">
                <div class="panel-body">
                    <h4><i class="fa fa-table"></i> &nbsp;Dernières inscriptions</h4>
                    <table class="table normalTable" id="" style="margin-bottom: 0px;"><!-- Start inscriptions -->
                        <thead>
                        <tr>
                            <th class="col-sm-1">Action</th>
                            <th class="col-sm-3">Déteteur</th>
                            <th class="col-sm-2">No</th>
                            <th class="col-sm-2">Date</th>
                        </tr>
                        </thead>
                        <tbody class="selects">
                        @if(!empty($inscriptions))
                            @foreach($inscriptions as $inscription)
                                <tr {!! ($inscription->group_id > 0 ? 'class="isGoupe"' : '') !!}>
                                    <td><a class="btn btn-sky btn-sm" href="{{ url('admin/inscription/'.$inscription->id) }}"><i class="fa fa-edit"></i></a></td>
                                    <td>
                                        <?php
                                            echo ($inscription->group_id > 0 ? '<span class="label label-default">Groupe '.$inscription->group_id.'</span>' : '');
                                            if($inscription->inscrit)
                                            {
                                                echo ($inscription->inscrit->company != '' ? '<p><strong>'.$inscription->adresse_facturation->company.'</strong></p>' : '');
                                                echo '<p>'.($inscription->group_id > 0 ? $inscription->participant->name : $inscription->inscrit->name).'</p>';
                                            }
                                        ?>
                                    </td>
                                    <td><strong>{{ $inscription->inscription_no }}</strong></td>
                                    <td>{{ $inscription->created_at->formatLocalized('%d %B %Y') }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    {{--
                    <div class='examples'>
                        <div class='parent'>
                            <div class='wrapper'>
                                <div id='middle-defaults' class='wide'>
                                    <div>You can move these ele containers</div>
                                    <div>Moviossible</div>
                                </div>
                            </div>
                            <div class='wrapper'>
                                <div id='left-defaults' class='container_dd'>
                                    <div>You can move these elements between these two containers</div>
                                    <div>Anything can be moved around. That includes images, <a href='https://github.com/bevacqua/dragula'>links</a>, or any other nested elements.</div>
                                </div>
                                <div id='right-defaults' class='container_dd'>
                                    <div>There's also the possibility of moving elements around in the same container, changing their position</div>
                                    <div>Moving <code>&lt;input/&gt;</code> elements works just fine. You can still focus them, too. <input placeholder='See?' /></div>
                                    <div>Make sure to check out the <a href='https://github.com/bevacqua/dragula#readme'>documentation on GitHub!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                    <!-- TREEVIEW CODE -->

                    @inject('fileWorker', 'App\Droit\Service\FileWorkerInterface')

                    <?php $files = $fileWorker->listDirectoryFiles('files'); ?>

                    @if(!empty($files))
                        <?php
                            echo '<pre>';
                            print_r( $fileWorker->treeDirectories($files,'files'));
                            echo '</pre>';
                        ?>
                    @endif


                </div>
            </div>

        </div>
        <div class="col-md-6">

            <div class="panel panel-info">
                <div class="panel-body">
                    <h4><i class="fa fa-shopping-cart"></i> &nbsp;Dernières commandes</h4>
                    <table class="table normalTable" id="" style="margin-bottom: 0px;"><!-- Start inscriptions -->
                        <thead>
                        <tr>
                            <th class="col-sm-1">Action</th>
                            <th class="col-sm-3">Déteteur</th>
                            <th class="col-sm-3">No</th>
                            <th class="col-sm-2">Date</th>
                        </tr>
                        </thead>
                        <tbody class="selects">
                        @if(!$orders->isEmpty())
                            @foreach($orders as $order)
                                <tr>
                                    <td><a class="btn btn-sky btn-sm" href="{{ url('admin/order/'.$order->id) }}"><i class="fa fa-edit"></i></a></td>
                                    <td>{{ isset($order->order_adresse) ? $order->order_adresse->name : 'NA' }}</td>
                                    <td><strong>{{ $order->order_no }}</strong></td>
                                    <td>{{ $order->created_at->formatLocalized('%d %B %Y') }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

@stop