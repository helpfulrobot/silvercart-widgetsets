<?php
/**
 * Copyright 2011 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * SilverCart is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SilverCart is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with SilverCart.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Silvercart
 * @subpackage Widgets
 */

/**
 * Provides a free text widget.
 *
 * @package Widgetsets
 * @subpackage Widgets
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @since 09.06.2011
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2011 pixeltricks GmbH
 */
class WidgetSetTextWidget extends WidgetSetTextWidget {

    public static $db = array(
        'isContentView'     => 'Boolean',
    );

    public static $casting = array(
        'Headline'          => 'Text',
        'FreeText'          => 'Text',
    );

/*
    /**
     * 1:n relationships.
     *
     * @var array
     *
    public static $has_many = array(
        'SilvercartTextWidgetLanguages' => 'SilvercartTextWidgetLanguage'
    );

    */

    /**
     * retirieves the attribute FreeText from related language class depending
     * on the set locale
     *
     * @return string
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 22.01.2012
     */
    public function getFreeText() {
        return $this->FreeText;
        return $this->getLanguageFieldValue('FreeText');
    }

    /**
     * retirieves the attribute Headline from related language class depending
     * on the current locale
     *
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2012
     */
    public function getHeadline() {
        return $this->Headline;
        return $this->getLanguageFieldValue('Headline');
    }

    /**
     * Returns the title of this widget.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 26.05.2011
     */
    public function Title() {
        return $this->fieldLabel('Title');
    }

    /**
     * Field labels for display in tables.
     *
     * @param boolean $includerelations A boolean value to indicate if the labels returned include relation fields
     *
     * @return array
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @copyright 2012 pixeltricks GmbH
     * @since 26.01.2012
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
            parent::fieldLabels($includerelations),
            array(
                'ExtraCssClasses'               => _t('WidgetSetTextWidget.CSSFIELD_LABEL'),
                'SilvercartTextWidgetLanguages' => _t('SilvercartTextWidgetLanguage.PLURALNAME'),
                'Headline'                      => _t('WidgetSetTextWidget.HEADLINEFIELD_LABEL'),
                'FreeText'                      => _t('WidgetSetTextWidget.FREETEXTFIELD_LABEL'),
                'isContentView'                 => _t('WidgetSetTextWidget.IS_CONTENT_VIEW'),
                'Title'                         => _t('WidgetSetTextWidget.TITLE'),
                'Description'                   => _t('WidgetSetTextWidget.DESCRIPTION'),
                'Content'                       => _t('WidgetSetWidget.CONTENT'),
                'Translations'                  => _t('WidgetSetTextWidget.TRANSLATIONS'),

            )
        );

        $this->extend('updateFieldLabels', $fieldLabels);
        return $fieldLabels;
    }

    /**
     * Returns the title of this widget for display in the WidgetArea GUI.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 26.05.2011
     */
    public function CMSTitle() {
         return $this->fieldLabel('Title');
    }

    /**
     * Returns the description of what this template does for display in the
     * WidgetArea GUI.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 26.05.2011
     */
    public function Description() {
        return $this->fieldLabel('Description');
    }

    /**
     * Returns the input fields for this widget.
     *
     * @return FieldSet
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 20.06.2012
     */
    public function getCMSFields() {
        $fields             = new FieldList();
        $rootTabSet         = new TabSet('RootTabSet');
        $mainTab            = new Tab('Root', 'Haupttab');
        # $translationsTab    = new Tab('TranslationsTab', $this->fieldLabel('Translations'));
        $cssField           = new TextField('ExtraCssClasses', $this->fieldLabel('ExtraCssClasses'));
        # $languageTableField = new ComplexTableField($this, 'SilvercartTextWidgetLanguages', 'SilvercartTextWidgetLanguage');
        $isContentView      = new CheckboxField('isContentView', $this->fieldLabel('isContentView'));

        $mainTab->push($cssField);
        $rootTabSet->setTabs($mainTab);
        # $rootTabSet->push($translationsTab);

        # $mainTab->push($isContentView);
        # $translationsTab->push($languageTableField);
        //multilingual fields, in fact just the title
        /* $languageFields = SilvercartLanguageHelper::prepareCMSFields($this->getLanguage(true));
        foreach ($languageFields as $languageField) {
            $mainTab->push($languageField);
        } */
        $fields->push($cssField);
        $fields->push($isContentView);
        return $fields;
    }
}

/**
 * Provides a free text widget.
 *
 * @package Widgetset
 * @subpackage Widgets
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @since 04.01.2013
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2013 pixeltricks GmbH
 */
class WidgetSetTextWidget_Controller extends WidgetSetWidget_Controller {

    /**
     * Overloaded from {@link Widget->Content()}
     * to allow for controller/form linking.
     *
     * @return string HTML
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 03.04.2012
     */
    public function Content() {
        $renderData = array(
            'Controller' => $this
        );
        $template = new SSViewer_FromString($this->getField('FreeText'));
        $freeText = HTTP::absoluteURLs($template->process(new ArrayData($renderData)));

        $data = new ArrayData(
            array(
                'FreeText' => $freeText
            )
        );

        return $this->customise($data)->renderWith(array_reverse(ClassInfo::ancestry($this->widget->class)));
    }
}
