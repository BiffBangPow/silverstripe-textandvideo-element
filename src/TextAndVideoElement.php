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
        'VideoWidthClass' => 'Varchar'
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
            DropdownField::create('VideoWidthClass', 'Set video width on larger screens', [
                'quarter' => '1/4 width',
                'half' => '1/2 width',
                'threequarter' => '3/4 width',
                'full' => 'Full width'
            ]),
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
        return 'text-and-video-element';
    }
}
