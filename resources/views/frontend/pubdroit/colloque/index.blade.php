@@extends('frontend.pubdroit.layouts.master')
@section('content')

    <section class="row">
        <div class="col-md-12">

            <p><a href="{{ url('/') }}"><span aria-hidden="true">&larr;</span> Retour à l'accueil</a></p>

            <div class="heading-bar">
                <h2>Colloque</h2>
                <span class="h-line"></span>
            </div>

            @if(!$colloques->isEmpty())
                <?php $chunks = $colloques->chunk(3); ?>
                @foreach($chunks as $chunk)
                    <section class="row">
                        @foreach($chunk as $colloque)

                            <div class="event-post col-md-4">
                                <div class="post-img">
                                    <a href="{{ url('colloque/'.$colloque->id) }}">
                                        <img src="{{ asset('files/colloques/illustration/'.$colloque->illustration->path) }}" alt=""/>
                                    </a>
                                    <span class="post-date"><span>{{ $colloque->start_at->format('d') }}</span> {{ $colloque->start_at->formatLocalized('%b') }}</span>
                                </div>
                                <div class="post-det">
                                    <h3><a href="{{ url('colloque/'.$colloque->id) }}"><strong>{{ $colloque->titre }}</strong></a></h3>
                                    <span class="comments-num">{{ $colloque->soustitre }}</span>
                                    <p><strong>Lieu: </strong>
                                        {{ $colloque->location ? $colloque->location->name : '' }}, {{ $colloque->location ? $colloque->location->adresse : '' }}</p>
                                    {!! $colloque->remarque !!}
                                    <p><a class="more-btn btn-sm" href="{{ url('colloque/'.$colloque->id) }}">Inscription</a></p>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        @endforeach
                    </section>
                @endforeach
            @endif

        </div>
    </section>

@stop
