@extends('layouts.app_home')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="text-center">My Resignation Progress</h1>
      <br>
      <br>
      <br>
      <ol class="progtrckr" data-progtrckr-steps="6">
        <li class="progtrckr-done">Resignation Applied</li>
        <li class="progtrckr-done">Lead Assigned</li>
        <li class="progtrckr-done">Lead Verified</li>
        <li class="progtrckr-todo">Head Verified</li>
        <li class="progtrckr-todo">Hr Verified</li>
        <li class="progtrckr-todo">Completed</li>
      </ol>
      <br>
      <br>
      <br>
      <div class="text-center">
        <button class="btn btn-primary">View Details</button>
      </div>
    </div>
  </div>
</div>


@endsection
