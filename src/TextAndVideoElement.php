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
    private static $inline_editable = false;

    private static $db = [
        'Content' => 'HTMLText',
        'VideoLink' => 'Varchar',
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
            TextField::create('VideoLink', 'Video Link')
                ->setDescription('Enter the full link, eg: https://www.youtube.com/watch?v=YE7VzlLtp-4')
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

    /**
     * Get the video ID
     * @return bool|string|null
     */
    public function getVideoID()
    {
        $vID = null;
        switch ($this->VideoType) {
            case 'youtube':
                $vID = $this->getYouTubeVideoID();
                break;
            case 'vimeo':
                $vID = $this->getVimeoVideoID();
                break;
        }
        return $vID;
    }

    /**
     * @return bool|string
     */
    public function getYouTubeVideoID()
    {
        $link = $this->VideoLink;
        if ($link == '') {
            return false;
        }

        $parsedURL = parse_url($link, PHP_URL_QUERY);
        if ($parsedURL === false) {
            return false;
        }

        parse_str($parsedURL, $params);
        if (array_key_exists('v', $params)) {
            return $params['v'];
        }

        return false;
    }

    /**
     * @return bool|string
     */
    public function getVimeoVideoID()
    {
        $link = $this->VideoLink;
        if ($link == '') {
            return false;
        }

        $parsedURL = parse_url($link, PHP_URL_PATH);
        if ($parsedURL === false) {
            return false;
        }

        $result = preg_match_all('/\d+/', $parsedURL, $matches);

        if ($result !== false && $result !== 0) {
            $videoID = $matches[0][0];
            return $videoID;
        }

        return false;
    }
}
