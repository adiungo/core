<?php

namespace Adiungo\Core\Traits;


namespace Adiungo\Core\Traits;

use Adiungo\Core\Collections\Category_Collection;
use Adiungo\Core\Factories\Category;
use Underpin\Exceptions\Operation_Failed;

trait With_Categories
{

    protected Category_Collection $categories;

    /**
     * Sets the categories
     *
     * @param Category $category
     * @param Category ...$categories The categories to set.
     * @return $this
     * @throws Operation_Failed
     */
    public function add_categories(Category $category, Category ...$categories): static
    {
        $categories = func_get_args();

        /** @var Category $category_item */
        foreach ($categories as $category_item) {
            $this->get_categories()->add((string)$category_item->get_id(), $category_item);
        }

        return $this;
    }

    /**
     * Gets the categories
     *
     * @return Category_Collection
     */
    public function get_categories(): Category_Collection
    {
        if (!isset($this->categories)) {
            $this->categories = new Category_Collection();
        }

        return $this->categories;
    }

    /**
     * @param string $id
     * @param string ...$ids
     * @return static
     * @throws Operation_Failed
     */
    public function remove_categories(string $id, string ...$ids): static
    {
        $all_ids = func_get_args();

        /** @var Category_Collection $result */
        $result = $this->get_categories()->query()->not_in('id', ...$all_ids)->get_results();

        $this->categories = $result;
        return $this;
    }

    /**
     * Returns true if this class has any categories.
     *
     * @return bool
     */
    public function has_categories(): bool
    {
        return !empty($this->get_categories()->to_array());
    }

}