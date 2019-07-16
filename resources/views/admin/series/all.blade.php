@extends('layouts.app')

@section('header')
  <header class="header header-inverse" style="background-color: #c2b2cd;">
    <div class="container text-center">

      <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2">
          <h1>All series</h1>
          <p class="fs-20 opacity-70">Let's make the world a better place for coders</p>
        </div>
      </div>

    </div>
  </header>
@stop

@section('content')
  <div class="section bg-grey">
    <div class="container">

      <div class="row gap-y">
        <div class="col-12">
          <table class="table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              @forelse($series as $serie)
                <tr>
                  <td><a href="{{ route('series.show', $serie->slug) }}">{{ $serie->title }}</a></td>
                  <td>
                    <a href="{{ route('series.edit', $serie->slug) }}" class="btn btn-info">Edit</a>
                  </td>
                  <td>
                    <a href="" class="btn btn-danger">Delete</a>
                  </td>
                </tr>
              @empty
                <p class="text-center">No series yet</p>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection