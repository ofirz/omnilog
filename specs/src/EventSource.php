<?php
/**
 * The EventSource encapsulates the data associate with the element that triggered the event.
 * 
 * @package com.houzz.omnilog
 **/

namespace package com.houzz.omnilog;

class EventSource
{
    /**
     * The source element type. 
     * 
     * Any of: 
     * - button
     * - link
     * - image     
     * - paragraph     
     * - select_box     
     * - checkbox     
     * - input     
     * - card     
     * - menu     
     * - menu_item
     * - video
     * - video_control
     */
    public String $elementType;


    /**
     * The text label associated with the element.
     */    
    public String $elementLabel;

    /**
     * The input device that acted upon the element. 
     * 
     * Any of: 
     * - touch
     * - click
     * - keyboard 
     */
    public String $inputType;

    /**
     * The Houzz entity type associated with the element.
     * 
     * Any of -
     * - photo
     * - product
     * - story
     * - user
     * - pro
     * - pro_plus
     * - comment
     * - question
     * - answer
     * - universal_ideabook
     * - project
     * - photo_topic     
     * - product_topic
     * - pro_topic   
     * - discussion_topic     
     * - ideabook_topic     
     * - sale_gallery     
     * - newsletter     
     * - pro_review     
     * - product_review     
     * - product_tag     
     * - product_variation_selector     
     * - ad     
     * - video
     */    
    public String $entityType;
    
    /**
     * The entity's object id
     */    
    public Id $entityId;

    /**
     * The name of the section containing the element, such as header, products list, recommendations, related photos, question, answers, related questions, header menu, search bar, hamburger menu
     */
    public String $section;

    /**
     * The name of the component containing the element, such as "pro card", "pro quick view", "photo card"
     */
    public String $component;

    /**
     * The position of the element in a list, e.g. 1,2,3 etc. Applicable only to list of items.
     */
    public int $positionId;

    /**
     * The logical placement of an element, typically an ad, within the experience. Typically top, bottom, left rail, embedded ad, popup. 
     */
    public string $placement;

    /**
     * The ID of an element associated with an Ad campaign.
     */
    public Id $campaignId;

    /**
     * The ID of an element associated with an Ad campaign.
     */
    public Id $creativeId;

    /**
     * The ID the experience on which the Element is rendered.
     */
    public Id $experienceId;
            
    /**
     * The ID the flow on which the Element is rendered.
     */
    public Id $flowId;
}
