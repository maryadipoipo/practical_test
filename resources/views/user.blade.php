@extends('main')

@section('title', 'User')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
<h3 class="mt-4"> User List </h3>
<div class="text-right mb-2"> <a href="javascript:void(0);" id="add_new_user"> Add New User </a> </div>

<!-- Form to add or edit new user -->
<input type="hidden" name="userid">
<form class='new-user mb-4'>
<div class="form-group">
    <label for="exampleFormControlInput1">Name</label>
    <input type="text" class="form-control" name="input_name" placeholder="name">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" name="input_email" placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Password</label>
    <input type="password" class="form-control" name="input_password" placeholder="leave this empty if you don't wanna change password">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Profile</label>
    <select class="form-control" id="input_profile">
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Skills</label>
    <div id="skill_list">
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

<input type="hidden" name="deleteUser">
@endsection

@section('script')
    <script type="text/javascript" src="{{ URL::asset('js/user.js') }}"></script> 
@endsection
