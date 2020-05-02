<?php

namespace Common\Structure;

use Common\Interfaces\EqualityComparable;

class WatchableList
{
    /** @var EqualityComparable[] */
    protected array $added_items = [];
    /** @var EqualityComparable */
    protected array $current_items = [];
    /** @var EqualityComparable[] */
    protected array $removed_items = [];

    protected string $watched_class;

    public function __construct(string $watched_class)
    {
        $interfaces = class_implements($watched_class, true);
        assert(($interfaces && in_array(EqualityComparable::class, $interfaces)), new \TypeError("Class must be equality comparable"));

        $this->watched_class = $watched_class;
    }

    public function add($item)
    {
        assert(($item instanceof $this->watched_class), new \TypeError("Item must be a type of " . $this->watched_class));

        $i = 0;
        foreach ($this->removed_items as $r) {
            if ($r->equals($item)) {
                unset($this->removed_items[$i]);
            }
            $i++;
        }

        $this->added_items[] = $item;
    }

    public function remove($item)
    {
        assert(($item instanceof $this->watched_class), new \TypeError("Item must be a type of " . $this->watched_class));

        $i = 0;
        foreach ($this->added_items as $a) {
            if ($a->equals($item)) {
                unset($this->added_items[$i]);
            }
            $i++;
        }

        $this->removed_items[] = $item;
    }

    public function getAddedItems(): array
    {
        return $this->added_items;
    }

    public function getCurrentItems(): array
    {
        return $this->current_items;
    }

    public function getRemovedItems(): array
    {
        return $this->removed_items;
    }
}
