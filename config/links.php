<?php

return [

    'linkable' => [
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

    'list_types' => [
        'small_arrow' => 'Маленькие стрелки',
        'big_arrow' => 'Большие стрелки',
    ],

];
