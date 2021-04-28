@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        	@if (session('ng'))
        	    <div class="alert alert-danger" role="alert">
        	        {{ session('ng') }}
        	    </div>
        	@endif
        	<div class="card">
        	    <div class="card-header">ユーザー一覧</div>
        	    <div class="card-body">
					<table class="table table-striped">
						<tbody>
							@foreach ($users as $user)
								<tr>
									<td>{{ $user->name }}</td>
									@if (Auth::id() === $user->id)
										<td>
										</td>
									@else
										<td>
											<div class="float-right">
												@if (Auth::user()->isFollowing($user->id))
													<a class="btn btn-danger btn-sm" href="{{ url('/unfollow/' .$user->id) }}" role="button">フォロー解除</a>
												@else
													<a class="btn btn-primary btn-sm" href="{{ url('/follow/' .$user->id) }}" role="button">フォローする</a>
												@endif
											</div>
										</td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			{{ $users->links() }}
        </div>
    </div>
</div>
@endsection
