<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Presenters\RevisionDisplayers\Page;

use App\Presenters\RevisionDisplayers\AbstractRevisionDisplayer;

/**
 * This is the abstract displayer class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
abstract class AbstractDisplayer extends AbstractRevisionDisplayer
{
    /**
     * Get the change title.
     *
     * @return string
     */
    public function title()
    {
        return 'Updated Page';
    }

    /**
     * Get the page name.
     *
     * @param bool $final
     *
     * @return string
     */
    protected function name($final = true)
    {
        $page = $this->wrappedObject->revisionable()->withTrashed()->first();
        $title = $page['nav_title'];

        return $title;
    }
}
