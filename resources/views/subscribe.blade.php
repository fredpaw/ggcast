@extends('layouts.app')

@section('head-scripts')
  <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('header')
<header class="header header-inverse" style="background-color: #1ac28d">
  <div class="container text-center">

    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">

        <h1>Subscribe to our awesome website</h1>
        <p class="fs-20 opacity-70"></p>
      </div>
    </div>

  </div>
</header>
@stop

@section('content')
<section class="section" id="section-vtab">
    <div class="container">
      <vue-stripe></vue-stripe>
    </div>
</section>
@endsection

