<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mindscms\Entrust\EntrustPermission;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Translatable\HasTranslations;

class Permission extends EntrustPermission
{

    use HasFactory, HasTranslations,  SearchableTrait;

    protected $guarded = [];
    public $translatable = ['display_name', 'description'];


    protected $searchable = [
        'columns' => [
            'permissions.display_name' => 10,
            'permissions.description' => 10,
        ]
    ];


    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }





    public function parent()
    {
        // hasOne syntax : hasOne(model::class , foreign_key , Local_key)
        return $this->hasOne(Permission::class, 'id', 'parent');
    }

    public function children()
    {
        // hasMany syntax : hasMany(model::class, foreign_key ,Local_key)
        return $this->hasMany(Permission::class, 'parent', 'id');
    }

    public function appearedChildren()
    {
        return $this->hasMany(Permission::class, 'parent', 'id')->where('appear', 1);
    }

    public static function tree($level = 1)
    {
        return static::with(implode('.', array_fill(0, $level, 'children')))
            ->whereParent(0)
            ->whereAppear(1)
            ->whereSidebarLink(1) // this is the option to let the sidebar link is happened in side link
            ->orderBy('ordering', 'asc')
            ->get();
    }

    public static function assigned_childern($level = 1)
    {
        return static::with(implode('.', array_fill(0, $level, 'assigned_childern')))
            ->whereParentOriginal(0)
            ->whereAppear(1)
            ->orderBy('ordering', 'asc')
            ->get();
    }
}
