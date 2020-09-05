@extends('main')

@section('title', 'Page Title')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
<h3 class="mt-4"> User List </h3>
<div class="text-right mb-2"> <a href="#"> Add New User </a> </div>
<!-- Form to add or edit new user -->
<form class='new-user mb-4'>
<div class="form-group">
    <label for="exampleFormControlInput1">Name</label>
    <input type="text" class="form-control" id="input_name" placeholder="name">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" id="input_email" placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Password</label>
    <input type="password" class="form-control" id="input_password" placeholder="leave this empty if you don't wanna change password">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Profile</label>
    <select class="form-control" id="input_profile">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Skills</label>
    <div class="skill">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
        <label class="form-check-label" for="inlineCheckbox1">Skill 1</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
        <label class="form-check-label" for="inlineCheckbox2">Skill 2</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
        <label class="form-check-label" for="inlineCheckbox3">Skill 3</label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <button type="button" class="btn btn-success btn-sm mb-1" id="submit_user" onclick="submitUser(event);"> Submit </button>
    <button type="button" class="btn btn-warning btn-sm mb-1" id="cancel_user"> Cancel </button>
  </div>
</form>
<!-- ################################# -->

<table id="user_table" class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Profile</th>
      <th scope="col">Skills</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>
        <i class="fa fa-pencil" aria-hidden="true"></i>
        <i class="fa fa-trash-o"></i>
      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>
        <i class="fa fa-pencil" aria-hidden="true"></i>
        <i class="fa fa-trash-o"></i>
      </td>
    </tr>
  </tbody>
</table>
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('js/user.js') }}"></script> 
@endsection
