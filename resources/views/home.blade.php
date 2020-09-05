@extends('main')
@section('title', 'Home')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
<h3 class="mt-4"> Training Activity List</h3>
<div class="text-right mb-2"> <a href="javascript:void(0);" id="add_new_activity"> Add New Activity </a> </div>


<!-- Form to add or edit new activity -->
<input type="hidden" name="activityid">
<form class='new-activity mb-4'>
<div class="form-group">
    <label for="exampleFormControlInput1">Title</label>
    <input type="text" class="form-control" name="input_title" placeholder="name">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Start Date</label>
    <input type="date" class="form-control" name="input_start_date" placeholder="start date">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">End Date</label>
    <input type="date" class="form-control" name="input_end_date" placeholder="end date">
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Description</label>
    <textarea class="form-control" name="input_description" rows="3"></textarea>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Skills</label>
    <div id="activity_skills">
    </div>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Participants</label>
    <div id="input_participants">
    </div>
  </div>
  <div class="form-group">
    <button type="button" class="btn btn-success btn-sm mb-1" id="submit_activity" onclick="submitActivity(event);"> Submit </button>
    <button type="button" class="btn btn-warning btn-sm mb-1" id="cancel_activity"> Cancel </button>
  </div>
</form>
<!-- ################################# -->



<input type="hidden" name="deleteActivity">
@endsection


@section('script')
    <script type="text/javascript" src="{{ URL::asset('js/home.js') }}"></script> 
@endsection