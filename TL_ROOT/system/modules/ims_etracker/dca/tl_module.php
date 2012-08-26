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
$GLOBALS['TL_DCA']['tl_module']['palettes']['etracker'] = "{title_legend},name,type;{etracker_legend},et_securecode;{template_legend:hide},et_template;{protected_legend:hide},protected;{expert_legend:hide},guests";

/**
 * definie new fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['et_securecode'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['et_securecode'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array
    (
        'rgxp' => 'alnum',
        'max_length' => 20,
        'tl_class' => 'w50'
    )
);

$GLOBALS['TL_DCA']['tl_module']['fields']['et_template'] = array
(
    'label' => &$GLOBALS['TL_LANG']['tl_module']['et_template'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => array('tl_module_etracker', 'getEtrackerTemplates')
);

class tl_module_etracker extends Backend
{
    /**
     * Return all navigation templates as array
     * @param DataContainer
     * @return array
     */
    public function getEtrackerTemplates(DataContainer $dc)
    {
        $intPid = $dc->activeRecord->pid;

        if ($this->Input->get('act') == 'overrideAll')
        {
            $intPid = $this->Input->get('id');
        }

        return $this->getTemplateGroup('etracker_', $intPid);
    }
}
