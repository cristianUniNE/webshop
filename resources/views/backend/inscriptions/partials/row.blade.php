<tr {!! ($inscription->group_id ? 'class="isGoupe"' : '') !!}>
    <td><a class="btn btn-sky btn-sm" href="{{ url('admin/inscription/'.$inscription->id) }}"><i class="fa fa-edit"></i></a></td>
    <td>
        <p><strong>{{ ($inscription->inscrit && $inscription->adresse_facturation ? $inscription->adresse_facturation->civilite_title : '') }}</strong></p>

        @if($inscription->inscrit)
            <p><a href="{{ url('admin/user/'.$inscription->inscrit->id) }}">{{ $inscription->inscrit->name }}</a></p>
        @else
            <p><span class="label label-warning">Duplicata</span></p>
        @endif

        @if($inscription->group_id)
            <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#editGroup_{{ $inscription->groupe->id }}">Changer le détenteur</a>
            @include('backend.inscriptions.modals.change', ['group' => $inscription->groupe]) <!-- Modal edit group -->
        @endif

    </td>
    <td>{!! ($inscription->inscrit ? $inscription->inscrit->email : '<span class="label label-warning">Duplicata</span>') !!}</td>
    <td>
        @if($inscription->group_id)

            @if($inscription->groupe->inscriptions)
                <dl>
                    @foreach($inscription->groupe->inscriptions as $inscription)
                        <dt>{!! $inscription->participant->name !!}</dt>
                        <dd>{{ $inscription->inscription_no }}</dd>
                    @endforeach
                </dl>
            @endif

            <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#addToGroup_{{ $inscription->groupe->id }}">Ajouter un participant</a>
            @include('backend.inscriptions.modals.add', ['group' => $inscription->groupe, 'colloque' => $inscription->colloque]) <!-- Modal add to group -->
        @else
            <strong>{{ $inscription->inscription_no }}</strong>
        @endif
    </td>
    <td>
        @if($inscription->group_id)
            {{ $inscription->groupe->price }} CHF
        @else
            {{ $inscription->price->price_cents }} CHF
        @endif
    </td>
    <td>
        <?php $group = ($inscription->group_id ? 'group' : 'inscription'); ?>
        <?php $item  = ($inscription->group_id ? $inscription->groupe : $inscription); ?>
        @include('backend.inscriptions.partials.payed',['model' => $group, 'item' => $item])
    </td>
    <td>{{ $inscription->created_at->formatLocalized('%d %B %Y') }}</td>
    <td class="text-right">
        <form action="{{ url('admin/inscription/'.$inscription->id) }}" method="POST" class="form-horizontal">{!! csrf_field() !!}
            <input type="hidden" name="_method" value="DELETE">
            <button data-what="Désinscrire" data-action="N°: {{ $inscription->inscription_no }}" class="btn btn-danger btn-sm deleteAction">X</button>
        </form>
    </td>
</tr>