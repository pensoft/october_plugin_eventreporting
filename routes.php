<?php

/**
 * Created by PhpStorm.
 * User: Christoph Heich
 * Date: 02.06.2018
 * Time: 22:28
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Pensoft\Eventreporting\Models\EventsreportingData;

Route::prefix('api/pensoft/eventreporting/')->group(function () {

	/**
	 * Route for the feed.
	 *
	 * @return json_array
	 */

	Route::get('feed/{count?}/{category?}', function (Request $request) {
		return EventsreportingData::formatted();
	})->middleware('web');

});
