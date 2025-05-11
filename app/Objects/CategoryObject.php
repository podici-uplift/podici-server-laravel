<?php

namespace App\Objects;

use App\Enums\CategoryStatus;
use App\Models\Category;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class CategoryObject
{

    public function __construct(
        public string $name,
        public string $description,
        public ?string $parentSlug = null,
        public CategoryStatus $status = CategoryStatus::ACTIVE,
        public bool $isAdult = false,
    ) {
        //
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
        $slug = $this->slug();

        $parentId = $this->getParentId($slugIdMap);

        $existing = $this->table()->where('slug', $slug)->first();

        if ($existing) {
            $slugIdMap[$slug] = $existing->id;

            return;
        }

        $id = Str::lower(Str::ulid()->toString());

        $this->table()->insert([
            'id' => $id,
            'name' => $this->name,
            'slug' => $slug,
            'description' => $this->description,
            'parent_id' => $parentId,
            'status' => $this->status->value,
            'is_adult' => $this->isAdult,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $slugIdMap[$slug] = $id;
    }

    private function getParentId(array &$slugIdMap): ?string
    {
        if (is_null($this->parentSlug)) {
            return null;
        }

        if ($existingId = data_get($slugIdMap, $this->parentSlug)) {
            return $existingId;
        }

        $parent = $this->table()->where('slug', $this->parentSlug)->first();

        throw_unless($parent, "Parent category '{$this->parentSlug}' was not found");

        $slugIdMap[$this->parentSlug] = $parent->id;

        return $parent->id;
    }

    private function slug(): string
    {
        return $this->parentSlug
            ? $this->parentSlug . '-' . Str::slug($this->name)
            : Str::slug($this->name);
    }

    private function table(): Builder
    {
        return DB::table('categories');
    }
}
