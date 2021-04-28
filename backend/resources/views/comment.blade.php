@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">コメント</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
					<form action="{{ url('/create_comment/' .$tweet->id) }}" method="POST">
						@csrf
						<div class="form-group">
							<input id="comment" type="text" class="form-control @error('comment') is-invalid @enderror mb-2" name="comment" value="{{ old('comment') }}" required autocomplete="comment" autofocus>
  						<div>
						@error('comment')
							<div style="color:red">{{ $message }}</div>
						@enderror
						<button type="submit" class="btn btn-info">コメント</button>
					</form>
                </div>
            </div>
        </div>
    </div>
	<a class="btn btn-link mt-3 float-right" href="{{ url('/home') }}" role="button">トップページへ戻る</a>
</div>
@endsection
