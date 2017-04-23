@if($user->id !== Auth::user()->id)
	<div id="follow_form">
		@if(Auth::user()->isFollowing($user->id))
			<form action="{{ route('followers.destroy', $user->id) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
				<button type="submit" class="btn btn-sm">Unfollow</button>
			</form>
		@else
			<form action="{{ route('followers.store', $user->id) }}" method="POST">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-sm">Follow</button>
			</form>
		@endif
	</div>
@endif