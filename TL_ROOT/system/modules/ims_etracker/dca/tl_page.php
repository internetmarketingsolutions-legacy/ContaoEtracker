<?php if(!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  IMS Internet Makreting Solutions Ltd. 2012
 * @author     Dominik Zogg <dz@erfolgreiche-internetseiten.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

/**
 * modify palette
 */
$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace('{publish_legend}', '{etracker_legend},et_target;{publish_legend}', $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']);

/**
 * definie new fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['et_target'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_page']['et_target'],
    'inputType' => 'checkbox',
    'eval' => array
    (
        'mandatory' => false,
        'isBoolean' => true,
        'tl_class' => 'clr w50'
    ),
);
