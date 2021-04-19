@foreach($test as $t)
{{ App\Models\Favorite::favoriteTweet($t->tweet_id)->tweet }}
@endforeach

{{-- $test --}}