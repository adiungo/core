<?php

namespace Adiungo\Core\Interfaces;

use Adiungo\Core\Collections\Category_Collection;
use Adiungo\Core\Factories\Category;
use Underpin\Exceptions\Operation_Failed;

interface Has_Categories
{
    /**
     * Gets the category
     *
     * @return Category_Collection
     */
    public function get_categories(): Category_Collection;

    /**
     * Sets the category
     *
     * @param Category $category The category to set.
     * @param Category ...$categories
     * @return static
     * @throws Operation_Failed
     */
    public function add_categories(Category $category, Category ...$categories): static;

    /**
     * @param string $id
     * @param string ...$ids
     * @return static
     * @throws Operation_Failed
     */
    public function remove_categories(string $id, string ...$ids): static;

    /**
     * Returns true if there are any categories.
     *
     * @return bool
     */
    public function has_categories(): bool;
}
