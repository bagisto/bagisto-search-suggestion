<?php

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {

    Route::get('/suggestion', 'Webkul\suggestion\Http\Controllers\Shop\suggestionController@index')->defaults('_config', [
        'view' => 'suggestion::shop.index',
    ])->name('suggestion.shop.index');

    Route::get('/ajaxsearch', 'Webkul\suggestion\Http\Controllers\Shop\suggestionController@search')
            ->name('searchsuggestion.search.index');

});