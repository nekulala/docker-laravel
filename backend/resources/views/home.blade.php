@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        	@if (session('ok'))
        	    <div class="alert alert-success" role="alert">
        	        {{ session('ok') }}
        	    </div>
        	@endif
        	@if (session('ng'))
        	    <div class="alert alert-danger" role="alert">
        	        {{ session('ng') }}
        	    </div>
        	@endif
		<a class="btn btn-primary" href="{{ url('/tweet') }}" role="button">つぶやく</a>
		<a class="btn btn-danger" href="{{ url('/users') }}" role="button">ユーザー一覧</a>
        	<div class="card">
        	    <div class="card-header">タイムライン</div>
        	    <div class="card-body">
					<table class="table table-striped">
						<tbody>
							@if ($tweets->isEmpty())
								表示するつぶやきがありません。<br>
								（つぶやいたり、他ユーザーをフォローすることでここにつぶやきが表示されます。）
							@else
								@foreach ($tweets as $tweet)
									<tr>
										<td>{{ $tweet->user->name }}</td>
										<td>{{ $tweet->tweet }}</td>
										<td>
											<div class="float-right">
												@if (Auth::id() === $tweet->user_id)
													<a class="btn btn-success btn-sm" href="{{ url('/edit/' .$tweet->id) }}" role="button">編集</a>
													<a class="btn btn-danger btn-sm" href="{{ url('/delete/' .$tweet->id) }}" role="button">削除</a>
												@endif
												@if (App\Models\Favorite::isFavorite(Auth::id(), $tweet->id))
													<a class="btn btn-secondary btn-sm" href="{{ url('/unfavorite/' .$tweet->id) }}" role="button">いいね取消</a>
												@else
													<a class="btn btn-warning btn-sm" href="{{ url('/favorite/' .$tweet->id) }}" role="button">いいね</a>
												@endif
												<a class="btn btn-info btn-sm" href="{{ url('/comment/' .$tweet->id) }}" role="button">コメント</a>
											</div>
										</td>
									</tr>
									@foreach ($tweet->comments as $comment)
										<tr>
											<td>コメント</td>
											<td>{{ $comment->user->name }}</td>
											<td>{{ $comment->comment }}</td>
										</tr>
									@endforeach
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
