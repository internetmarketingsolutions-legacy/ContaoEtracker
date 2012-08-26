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

class ModuleEtracker extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'tracking_etracker';

    /**
     * @var object
     */
    protected $objPage;

    /**
     * @var array
     */
    protected $arrPageTree = array();

    /**
     * Generate Module
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
                $objTemplate = new BackendTemplate('be_wildcard');
                $objTemplate->wildcard = '### TRACKING ETRACKER ###';
                $objTemplate->title = $this->headline;
                $objTemplate->id = $this->id;
                $objTemplate->link = $this->name;
                $objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;
                return $objTemplate->parse();
        }
        return(parent::generate());
    }

    /**
     * Compile module
     */
    protected function compile()
    {
        // get the page
        global $objPage;

        // assign page property
        $this->objPage = $objPage;

        // build page tree
        $this->arrPageTree =  $this->buildPageTree($this->objPage->id);

        // template
        $objTemplate = new FrontendTemplate($this->et_template);

        // assign data
        $objTemplate->et_securecode = $this->et_securecode;
        $objTemplate->et_pagename = $this->getETPagename();
        $objTemplate->et_areas = $this->getETAreas();
        $objTemplate->et_url = $this->getETUrl();
        $objTemplate->et_level = $this->getETLevel();
        $objTemplate->et_target = $this->getETtarget();

        // assign rendered template to parent template
        $this->Template->content = $objTemplate->parse();
    }

    /**
     * @return string
     */
    public function getETPagename()
    {
        // get last page in page tree
        $arrPage = $this->getPage();

        // return the title
        return $arrPage['title'];
    }

    /**
     * @return string
     */
    public function getETAreas()
    {
        // prepare area string
        $strArea = "";

        // set counter 0
        $intCounter = 0;

        // go through all pages
        foreach($this->arrPageTree as $arrPage)
        {
            if($intCounter >=1)
            {
                // add the page title
                $strArea .= $arrPage['title'] . "/";
            }

            // add one to counter
            $intCounter++;
        }

        // remove last slash
        $strArea = substr($strArea, 0 , -1);

        // return the area string
        return $strArea;
    }

    /**
     * @return string
     */
    public function getETUrl()
    {
        return rawurlencode($this->Environment->base . $this->Environment->request);
    }

    /**
     * @return string
     */
    public function getETTarget()
    {
        // get all referers
        $arrReferers = $this->Session->get('referer');

        // get page
        $arrPage = $this->getPage();

        // check if a referer exists
        if(count($arrReferers) > 0 && $arrPage['et_target'])
        {
            // return the last referer
            return rawurlencode($this->Environment->base . array_shift($arrReferers));
        }

        // fallback return an empty string
        return '';
    }

    /**
     * @return int
     */
    public function getETLevel()
    {
        // return level
        return count($this->arrPageTree) -1 ;
    }

    /**
     * @return array
     */
    public function getPage()
    {
        return end($this->arrPageTree);
    }

    /**
     * @param int $id
     * @param array $arrPageTree
     * @return array
     */
    protected function buildPageTree($id, $arrPageTree = array())
    {
        // get page
        $objPage = $this->Database->prepare("
            SELECT
                id,
                pid,
                title,
                alias,
                type,
                pageTitle,
                et_target
            FROM
                tl_page
            WHERE
                id = ?
        ")->execute($id);

        // add to array
        $arrPageTree[] = array
        (
            'id' => $objPage->id,
            'pid' => $objPage->pid,
            'title' => !empty($objPage->pageTitle) ? $objPage->pageTitle : $objPage->title,
            'alias' => $objPage->alias,
            'type' => $objPage->type,
            'et_target' => $objPage->et_target,
        );

        // not root page
        if($objPage->type != 'root' && $objPage->pid != 0)
        {
            $arrPageTree = $this->buildPageTree($objPage->pid, $arrPageTree);
        }

        // reverse key order
        krsort($arrPageTree);

        // return the array
        return $arrPageTree;
    }
}
