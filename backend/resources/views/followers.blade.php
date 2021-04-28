@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        	<div class="card">
        	    <div class="card-header">フォローユーザー一覧</div>
        	    <div class="card-body">
        	        @if (session('status'))
        	            <div class="alert alert-success" role="alert">
        	                {{ session('status') }}
        	            </div>
        	        @endif
					<table class="table table-striped">
						<tbody>
							@if ($following_users->isEmpty())
								フォローしているユーザーはいません。
							@else
								@foreach ($following_users as $following_user)
									<tr>
										<td>{{ $following_user->name }}</td>
										<td>
											<div class="float-right">
												<a class="btn btn-danger btn-sm" href="{{ url('/unfollow/' .$following_user->id) }}" role="button">フォロー解除</a>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
			{{ $following_users->links() }}
			<a class="btn btn-link mt-3 float-right" href="{{ url('/home') }}" role="button">トップページへ戻る</a>
        </div>
    </div>
</div>
@endsection
