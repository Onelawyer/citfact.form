<?php

/*
 * This file is part of the Studio Fact package.
 *
 * (c) Kulichkin Denis (onEXHovia) <onexhovia@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Citfact\Form\View\Type\IBlock;

class DateType extends BaseIBlockType
{
    /**
     * @inheritdoc
     */
    public function detected()
    {
        // For default fields
        if (isset($this->field['FIELD_TYPE']) && $this->field['FIELD_TYPE'] == 'date') {
            return true;
        }

        if ($this->field['PROPERTY_TYPE'] == 'S' && $this->field['USER_TYPE'] == 'DateTime') {
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'date';
    }
}
