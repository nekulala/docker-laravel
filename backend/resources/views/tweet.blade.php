@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新しいつぶやき</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					<form action="{{ url('/create_tweet') }}" method="POST">
						@csrf
						<div class="form-group">
							<input type="text" class="form-control mb-2" name="tweet">
						<div>
						@error('tweet')
							<li>{{$message}}</li>
						@enderror
						<button type="submit" class="btn btn-primary">つぶやく</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
