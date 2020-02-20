<?php

namespace JoeDixon\Translation;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $guarded = [];

    protected $maps = [
        'language_pack_id' => 'language_id',
        'target'            => 'group'
    ];

    protected $append = ['language_id','group'];

    public function getLanguageIdAttribute()
    {
        return $this->attributes['language_pack_id'];
    }

    public function getGroupAttribute()
    {
        return $this->attributes['target'];
    }

    protected $hidden = ['language_pack_id','target'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('translation.database.connection');
        $this->table = config('translation.database.translations_table');
    }

    public function language()
    {
        return $this->belongsTo(Language::class,'language_pack_id');
    }

    public static function getGroupsForLanguage($language)
    {
        return static::whereHas('language', function ($q) use ($language) {
            $q->where('name', $language);
        })->whereNotNull('target')
            ->where('target', 'not like', '%single')
            ->select('target')
            ->distinct()
            ->get();
    }
}
