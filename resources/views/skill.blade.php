@extends('main')

@section('title', 'Page Title')

@section('content')
<h3 class="mt-4"> Skill List </h3>
<div class="text-right"> <a href="#"> Add New Skill </a> </div>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Title</th>
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
