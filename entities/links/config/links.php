<?php

return [

    'links_types' => [
        [
            'text' => 'Категория',
            'value' => 'category',
            'attributes' => [
                'data-suggestions' => 'back.categories.getSuggestions',
            ],
        ],
        [
            'text' => 'Тег',
            'value' => 'tag',
            'attributes' => [
                'data-suggestions' => 'back.tags.getSuggestions',
            ],
        ],
        [
            'text' => 'Статья',
            'value' => 'article',
            'attributes' => [
                'data-suggestions' => 'back.articles.getSuggestions',
            ],
        ],
        [
            'text' => 'Ингредиент',
            'value' => 'ingredient',
            'attributes' => [
                'data-suggestions' => 'back.ingredients.getSuggestions',
            ],
        ],
        [
            'text' => 'Страница',
            'value' => 'page',
            'attributes' => [
                'data-suggestions' => 'back.pages.getSuggestions',
            ],
        ],
        [
            'text' => 'Ссылка',
            'value' => 'link',
            'attributes' => [],
        ],
    ],

    'links_types_new' => [
        [
            'text' => 'Категория',
            'value' => 'categories',
            'attributes' => [
                'data-suggestions' => 'back.categories.getSuggestions',
            ],
        ],
        [
            'text' => 'Тег',
            'value' => 'tags',
            'attributes' => [
                'data-suggestions' => 'back.tags.getSuggestions',
            ],
        ],
        [
            'text' => 'Статья',
            'value' => 'articles',
            'attributes' => [
                'data-suggestions' => 'back.articles.getSuggestions',
            ],
        ],
        [
            'text' => 'Страница',
            'value' => 'pages',
            'attributes' => [
                'data-suggestions' => 'back.pages.getSuggestions',
            ],
        ],
        [
            'text' => 'Ссылка',
            'value' => 'links',
            'attributes' => [],
        ],
    ],

    'list_styles' => [
        [
            'text' => 'Маленькие стрелки',
            'value' => 'small_arrow',
        ],
        [
            'text' => 'Большие стрелки',
            'value' => 'big_arrow',
        ],
    ],

];
