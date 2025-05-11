<?php

namespace App\Objects;

use App\Enums\CategoryStatus;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryObject
{
    public string $slug;

    public function __construct(
        public string $name,
        public string $description,
        public ?string $parentSlug = null,
        public CategoryStatus $status = CategoryStatus::ACTIVE,
        public bool $isAdult = false,
    ) {
        $this->slug = Str::slug("{$this->parentSlug}-{$this->name}");
    }

    public static function make(
        string $name,
        string $description,
        ?string $parentSlug = null,
        CategoryStatus $status = CategoryStatus::ACTIVE,
        bool $isAdult = false,
    ): self {
        return new self($name, $description, $parentSlug, $status, $isAdult);
    }

    public function save(array &$slugIdMap): void
    {
        $parentId = $this->getParentId($slugIdMap);

        $this->table()->upsert([
            'id' => Str::lower(Str::ulid()->toString()),
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'parent_id' => $parentId,
            'status' => $this->status->value,
            'is_adult' => $this->isAdult,
            'created_at' => now(),
            'updated_at' => now(),
        ], ['slug'], ['name', 'description', 'parent_id', 'status', 'is_adult', 'updated_at']);
    }

    private function getParentId(array &$slugIdMap): ?string
    {
        if (is_null($this->parentSlug)) {
            return null;
        }

        if ($cachedID = data_get($slugIdMap, $this->parentSlug)) {
            return $cachedID;
        }

        $parent = $this->table()->where('slug', $this->parentSlug)->first();

        throw_unless($parent, "Parent category '{$this->parentSlug}' was not found");

        $slugIdMap[$this->parentSlug] = $parent->id;

        return $parent->id;
    }

    private function table(): Builder
    {
        return DB::table('categories');
    }
}
