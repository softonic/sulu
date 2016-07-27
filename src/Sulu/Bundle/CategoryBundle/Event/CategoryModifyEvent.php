<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\CategoryBundle\Event;

use Sulu\Bundle\CategoryBundle\Entity\Category;
use Symfony\Component\EventDispatcher\Event;

/**
 * An object of this class is thrown along with the category.modify event.
 */
class CategoryModifyEvent extends Event
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @param Category $category The modified category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Returns the modified category.
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
