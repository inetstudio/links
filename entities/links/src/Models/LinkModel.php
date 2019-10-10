<?php

namespace InetStudio\LinksPackage\Links\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use InetStudio\LinksPackage\Links\Contracts\Models\LinkModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class LinkModel.
 */
class LinkModel extends Model implements LinkModelContract
{
    use SoftDeletes;
    use HasJSONColumns;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'link';

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
        'link_type',
        'linkable_id',
        'linkable_type',
        'additional_info',
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
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id', 'link_type', 'linkable_type', 'linkable_id', 'additional_info',
        ];
    }

    /**
     * Сеттер атрибута link_type.
     *
     * @param $value
     */
    public function setLinkTypeAttribute($value)
    {
        $this->attributes['link_type'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута additional_info.
     *
     * @param $value
     */
    public function setAdditionalInfoAttribute($value): void
    {
        $this->attributes['additional_info'] = json_encode((array) $value);
    }

    /**
     * Сеттер атрибута linkable_type.
     *
     * @param $value
     */
    public function setLinkableTypeAttribute($value)
    {
        $this->attributes['linkable_type'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута linkable_id.
     *
     * @param $value
     */
    public function setLinkableIdAttribute($value)
    {
        $this->attributes['linkable_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Геттер атрибута type.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * Полиморфное отношение с остальными моделями.
     *
     * @return MorphTo
     */
    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
