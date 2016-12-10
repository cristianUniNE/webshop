@extends('frontend.matrimonial.layouts.app')
@section('content')

	<div id="content" class="inner inner-app">

		<div class="row">
			<div class="col-md-12 homepageBlock">

				@if(isset($page))
					<h3 class="line">{{ $page->title }}</h3>
					{!! $page->content !!}

					@if(!$page->contents->isEmpty())
						<?php $styles = $page->contents->groupBy('type'); ?>
						@foreach($styles as $style => $contents)
							@include('frontend.matrimonial.partials.'.$style, ['contents' => $contents])
						@endforeach
					@endif
				@endif

			</div>
		</div>

	</div>

@stop
