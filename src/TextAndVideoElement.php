<?php

namespace BiffBangPow\Element;

use BiffBangPow\Extension\CallToActionExtension;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;

class TextAndVideoElement extends BaseElement
{
    /**
     * @var string
     */
    private static $table_name = 'ElementTextAndVideo';
    private static $singular_name = 'text and video element';
    private static $plural_name = 'text and video elements';
    private static $description = 'Displays a video embed and optional text';

    private static $db = [
        'Content' => 'HTMLText',
        'VideoEmbed' => 'Varchar',
        'VideoType' => 'Varchar',
        'VideoWidthClass' => 'Varchar',
        'VideoFirst' => 'Boolean'
    ];

    private static $width_classes = [
        'col-lg-3' => '1/4 width',
        'col-lg-4' => '1/3 width',
        'col-lg-6' => '1/2 width',
        'col-lg-8' => '2/3 width',
        'col-lg-9' => '3/4 width',
        'col-lg-12' => 'Full width'
    ];

    private static $extensions = [
        CallToActionExtension::class
    ];


    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['VideoWidthClass']);
        $fields->addFieldsToTab('Root.Main', [
            HTMLEditorField::create('Content'),
            DropdownField::create('VideoWidthClass', 'Set video width on larger screens',
                $this->config()->get('width_classes')),
            DropdownField::create('VideoType', 'Video Type', [
                'youtube' => 'YouTube',
                'vimeo' => 'Vimeo'
            ]),
            TextField::create('VideoEmbed', 'Video Link')
        ]);
        return $fields;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'Text and Video';
    }

    public function getSimpleClassName()
    {
        return 'bbp-text-and-video-element';
    }
}
