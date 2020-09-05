@extends('main')

@section('title', 'Profile')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<h3 class="mt-4"> Profile List </h3>
<div class="text-right mb-2"> <a href="javascript:void(0)" id="add_new_profile"> Add New Profile </a> </div>

    <div class="new-profile">
        <form class="form-group">
            <label for="fname">Profile Title</label><br>
            <input type="text" name="profiletitle" placeholder="Profile title">
            <input type="hidden" name="profileid">
            <input type="hidden" name="submittype">
            <button type="button" class="btn btn-success btn-sm mb-1" id="submit_profile" onclick="submitProfile(event);"> Submit </button>
            <button type="button" class="btn btn-warning btn-sm mb-1" id="cancel_profile" > Cancel </button>
        </form>
    </div>



<table id="profile_table" class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Profile Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <!-- <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>
        <i class="fa fa-pencil text-success" aria-hidden="true"></i>
        <i class="fa fa-trash-o text-danger ml-3"></i>
      </td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>
        <i class="fa fa-pencil text-success" aria-hidden="true"></i>
        <i class="fa fa-trash-o text-danger ml-3"></i>
      </td>
    </tr> -->
  </tbody>
</table>

<input type="hidden" name="deleteprofile">
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="delete-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title" id="myModalLabel">Are you sure want to delete?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="submitDeleteProfile();">Yes</button>
        <button type="button" class="btn btn-primary" onclick="cancelDelete();">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alertModal" aria-hidden="true" id="alert-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content  alert alert-primary">
        <div class="modal-header modal-text"> This is modal content </div>
    </div>
  </div>
</div>

@endsection


@section('script')
    <script type="text/javascript" src="{{ URL::asset('js/profile.js') }}"></script> 
@endsection
