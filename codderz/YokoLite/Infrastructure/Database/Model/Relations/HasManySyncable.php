<?php

namespace Codderz\YokoLite\Infrastructure\Database\Model\Relations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasManySyncable extends HasMany
{
    public function sync(array $data, bool $deleting = true, bool $withDirty = true)
    {
        Model::unguard();

        $changes = ['created' => [], 'deleted' => [], 'updated' => [],];

        $relatedKeyName = $this->related->getKeyName();

        $current = $this->newQuery()->pluck($relatedKeyName)->all();

        $updateRows = [];
        $newRows = [];
        foreach ($data as $row) {
            if (isset($row[$relatedKeyName]) && !empty($row[$relatedKeyName]) && in_array($row[$relatedKeyName], $current)) {
                $id = $row[$relatedKeyName];
                $updateRows[$id] = $row;
            } else {
                $newRows[] = $row;
            }
        }

        $updateIds = array_keys($updateRows);
        $deleteIds = [];
        foreach ($current as $currentId) {
            if (!in_array($currentId, $updateIds)) {
                $deleteIds[] = $currentId;
            }
        }

        if ($deleting && count($deleteIds) > 0) {
            $this->getRelated()->destroy($deleteIds);
            $changes['deleted'] = $this->castKeys($deleteIds);
        }

        $items = $withDirty ? $this->getResults() : false;
        foreach ($updateRows as $id => $row) {
            if ($items) {
                $item = $items->firstWhere($relatedKeyName, $id);
                if (!$item->fill($row)->isDirty()) continue;
            }
            $this->getRelated()->where($relatedKeyName, $id)
                ->update($row);
        }

        $changes['updated'] = $this->castKeys($updateIds);

        $newIds = [];
        foreach ($newRows as $row) {
            $newModel = $this->create($row);
            $newIds[] = $newModel->$relatedKeyName;
        }

        $changes['created'][] = $this->castKeys($newIds);

        Model::reguard();

        return $changes;
    }

    protected function castKeys(array $keys)
    {
        return (array)array_map(fn($v) => $this->castKey($v), $keys);
    }

    protected function castKey($key)
    {
        return is_numeric($key) ? (int)$key : (string)$key;
    }
}
