<?php

namespace InetStudio\Links\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Links\Contracts\Models\LinkModelContract;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;

/**
 * Class LinkModel.
 */
class LinkModel extends Model implements LinkModelContract
{
    use SoftDeletes;
    use HasJSONColumns;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'links';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'linkable_id', 'linkable_type', 'additional_info',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы к базовым типам.
     *
     * @var array
     */
    protected $casts = [
        'additional_info' => 'array',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Полиморфное отношение с остальными моделями.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function linkable()
    {
        return $this->morphTo();
    }
}
