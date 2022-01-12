<?php

Route::group(['middleware' => ['web', 'admin']], function () {

    Route::get('/admin/suggestion', 'Webkul\suggestion\Http\Controllers\Admin\suggestionController@index')->defaults('_config', [
        'view' => 'suggestion::admin.index',
    ])->name('suggestion.admin.index');

});