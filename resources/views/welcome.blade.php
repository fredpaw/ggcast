@extends('layouts.app')

@section('header')

<header class="header header-inverse h-fullscreen pb-80" data-parallax="{{ asset('img/bg-gift.jpg') }}" data-overlay="8">
    <div class="container text-center">

        <div class="row h-full">
            <div class="col-12 col-lg-8 offset-lg-2 align-self-center">
                <h1 class="display-4 hidden-sm-down">SGCASTS</h1>
                <h1 class="hidden-md-up">THE BEST WEB DEVELOPMENT SCREENCASTS ON THE INTERNET</h1>
                <br>
                <p class="lead text-white fs-20 hidden-sm-down"><span class="fw-400">SGcasts</span> is an awesome web development learning<br>subscription based SaaS application powered with Vuejs and <span class="mark-border">Laravel 5.7  </span>.</p>

                <br><br><br>

                <a class="btn btn-lg btn-round w-200 btn-primary mr-16" href="/series">View more</a>
            </div>

            <div class="col-12 align-self-end text-center">
                <a class="scroll-down-2 scroll-down-inverse" href="#" data-scrollto="section-intro"><span></span></a>
            </div>
        </div>

    </div>
</header>

@endsection

@section('content')

    <section class="section bg-gray">
        <div class="container">
          <header class="section-header">
            <small>lessons</small>
            <h2>Featured Screencasts</h2>
            <hr>
            <p class="lead"></p>
          </header>
          @forelse($series as $s)
            <div class="card mb-30">
              <div class="row">
                <div class="col-12 col-md-4 align-self-center">
                  <a href=""><img src="{{ $s->image_path }}" alt="..."></a>
                </div>

                <div class="col-12 col-md-8">
                  <div class="card-block">
                    <h4 class="card-title">{{ $s->title }}</h4>
                   {{$s->image_url}}
                    <p class="card-text">{{ $s->description }}</p>
                    <a class="fw-600 fs-12" href="{{ route('series', $s->slug) }}">Read more <i class="fa fa-chevron-right fs-9 pl-8"></i></a>
                  </div>
                </div>
              </div>
            </div>
          @empty
          @endforelse

        </div>
      </section>

@endsection
