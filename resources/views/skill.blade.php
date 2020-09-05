@extends('main')

@section('title', 'Page Title')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/skill.css') }}">
@endsection

@section('content')
<h3 class="mt-4"> Skill List </h3>
<div class="text-right mb-2"> <a href="javascript:void(0);" id="add_new_skill"> Add New Skill </a> </div>

<div class="new-skill">
  <form class="form-group">
      <label for="fname">Skill Name</label><br>
      <input type="text" name="skilltitle" placeholder="Skill Name">
      <input type="hidden" name="skillid">
      <input type="hidden" name="submittype">
      <button type="button" class="btn btn-success btn-sm mb-1" id="submit_skill" onclick="submitSkill(event);"> Submit </button>
      <button type="button" class="btn btn-warning btn-sm mb-1" id="cancel_skill"> Cancel </button>
  </form>
</div>

<table id="skill_table" class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Skill Name</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<input type="hidden" name="deleteskill">
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="delete-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Are you sure want to delete?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="submitDeleteSkill();">Yes</button>
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
    <script type="text/javascript" src="{{ URL::asset('js/skill.js') }}"></script> 
@endsection
