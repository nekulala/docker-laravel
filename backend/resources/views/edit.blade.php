@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ツイートの編集</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					<form action="{{ url('/edit_tweet/' .$tweet->id)}}" method="POST">
						@csrf
						<div class="form-group">
							<input id="tweet" type="text" class="form-control @error('tweet') is-invalid @enderror mb-2" name="tweet" value="{{ old('tweet') }}" required autocomplete="tweet" autofocus>
  						<div>
						@error('tweet')
							<div style="color:red">{{ $message }}</div>
						@enderror
						<button type="submit" class="btn btn-success">編集</button>
					</form>
                </div>
            </div>
        </div>
    </div>
	<a class="btn btn-link mt-3 float-right" href="{{ url('/home') }}" role="button">トップページへ戻る</a>
</div>
@endsection