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
							@if ($favorite_tweets->isEmpty())
								いいねしているつぶやきはありません。
							@else
								@foreach ($favorite_tweets as $favorite_tweet)
									<tr>
										<td>{{ $favorite_tweet->name }}</td>
										<td>{{ $favorite_tweet->tweet }}</td>
										<td>
											<div class="float-right">
												<a class="btn btn-secondary btn-sm" href="{{ url('/unfavorite/' .$favorite_tweet->id) }}" role="button">いいね取消</a>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
			{{ $favorite_tweets->links() }}
        </div>
    </div>
</div>
@endsection
