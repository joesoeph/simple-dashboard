<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Menu extends Model
{
    use HasRecursiveRelationships;

    protected $fillable = [
        'name',
        'label',
        'route',
        'icon',
        'parent_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parentKeyName()
    {
        return 'parent_id';
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->orderBy('order')
            ->with('children');
    }

    public function isActive(): bool
    {
        if ($this->route && request()->routeIs($this->route)) {
            return true;
        }

        foreach ($this->children as $child) {
            if ($child->isActive()) {
                return true;
            }
        }

        return false;
    }

    public function isParentActive(): bool
    {
        foreach ($this->children as $child) {
            if ($child->isActive() || $child->isParentActive()) {
                return true;
            }
        }
        return false;
    }
}
