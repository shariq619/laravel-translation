<?php

namespace JoeDixon\Translation;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = [];

    protected $maps = [
        'name' => 'language'
    ];

    protected $append = ['language'];

    public function getLanguageAttribute()
    {
        return $this->attributes['name'];
    }

    protected $hidden = ['name'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('translation.database.connection');
        $this->table = config('translation.database.languages_table');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class,'language_pack_id');
    }
}
