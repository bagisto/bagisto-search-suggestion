<?php

return [
    [
        'key'=>'suggestion',
        'name'=>'Search Suggestion',
        'sort'=>1,
    ],[
        'key'=>'suggestion.suggestion',
        'name'=>'Search Suggestion Settings',
        'sort'=>1,
    ],[
        'key'    => 'suggestion.suggestion.options',
        'name'   => 'Options',
        'sort'   => 1,
        'fields' => [
            ['name'          => 'show_terms',
            'title'         => 'Show Categories',
            'type'          => 'text',
            'validation'    => 'required|numeric',
            'channel_based' => true,
            ],['name'          => 'show_products',
            'title'         => 'Show Products ',
            'type'          => 'text',
            'validation'    => 'required|numeric',
            'channel_based' => true,
            ],[
                'name'          => 'display_terms_toggle',
                'title'         => 'Display Terms',
                'type'          => 'boolean',
                'locale_based'  => true,
                'channel_based' => true,
            ],[
                'name'          => 'display_product_toggle',
                'title'         => 'Display Product',
                'type'          => 'boolean',
                'locale_based'  => true,
                'channel_based' => true,
            ],[
                'name'          => 'display_categories_toggle',
                'title'         => 'Display Categories',
                'type'          => 'boolean',
                'locale_based'  => true,
                'channel_based' => true,
            ],
        ],
    ],

        ];