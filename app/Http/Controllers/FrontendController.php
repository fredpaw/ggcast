<?php

namespace App\Http\Controllers;

use SEO;
use App\Series;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
	public function welcome() {
		$this->setSeo('GGCast', 'The Best Developer Training Website.');

		return view('welcome')->withSeries(Series::all());
	}

	public function series(Series $series) {
		$this->setSeo($series->title, $series->description);
		
		return view('series')->withSeries($series);
	}

	public function showAllseries() {
		return view('all-series')->withSeries(Series::all());
	}
}
