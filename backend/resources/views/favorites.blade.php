@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        	<div class="card">
        	    <div class="card-header">いいねつぶやき一覧</div>
        	    <div class="card-body">
        	        @if (session('status'))
        	            <div class="alert alert-success" role="alert">
        	                {{ session('status') }}
        	            </div>
        	        @endif
					<table class="table table-striped">
						<tbody>
							@if ($favorites->isEmpty())
								いいねしているつぶやきはありません。
							@else
								@foreach ($favorites as $favorite)
									<tr>
										<td>{{ $favorite->name }}</td>
										<td>{{ $favorite->tweet }}</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
        	    </div>
        	</div>
        </div>
    </div>
</div>
@endsection
