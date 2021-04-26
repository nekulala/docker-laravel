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
