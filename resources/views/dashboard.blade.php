@extends('frontend.main_master')
@section('content')

<div class="body-content">
	<div class="container">
		<div class="row">
			
			@php

    $id = Auth::user()->id;
    $user = App\Models\User::find($id);

@endphp


	@include('frontend.profile.navbar')

			<div class="col-md-2">
				
			</div> <!-- // end col md 2 -->


			<div class="col-md-6">
  <div class="card">
  	<h3 class="text-center"><span class="text-danger">Hi....</span><strong>{{ Auth::user()->name }}</strong> Welcome To Easy Online Shop </h3>
  	
  </div>


				
			</div> <!-- // end col md 6 -->
			
		</div> <!-- // end row -->
		
	</div>
	
</div>
 

@endsection