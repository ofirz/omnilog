<?php
/**
 * Interface for Logger implementations
 *
 * @package com.houzz.omnilog
 **/

namespace package com.houzz.omnilog;

interface LoggerI
{
///@{ \name Platform Events

    /**
     * @param RoutingDescriptor $rd A Routing Descriptor
     * @param Id $experienceId The Experience Id, could be null.
     * @param EventSource $eventSource
     */    
    public void function experienceLoaded (RoutingDescriptor $rd, Id $experienceId, EventSource $eventSource);

    /**
     * @param RoutingDescriptor $rd A Routing Descriptor
     * @param Id $experienceId The Experience Id, could be null.
     * @param EventSource $eventSource
     */
    public void function experienceUnloaded (RoutingDescriptor $rd, Id $experienceId, EventSource $eventSource);

    /**
     * @param EventSource $eventSource
     */
    public void function appStarted (EventSource $eventSource);

    /**
     * @param EventSource $eventSource
     */
    public void function appStopped (EventSource $eventSource);
    
    /**
     * Invoked automatically if a session is not previously active, or if a 
     * new experience comes from a new channel.
     */
    public void function sessionStarted ();

    /**
     * Invoked automatically after predefined (default = 30m) of inactivity.
     */
    public void function sessionEnded ();
    
    /**
     * @param String $testName
     * @param String $testVariantId
     * 
     * Invoked automatically after predefined (30 mins) of inactivity.
     */
    public void function abRegistered (String $testName, String $testVariantId);

    /**
     * Invoked periodically (default = 60s) as long as the user is interacting with the application.
     */
    public void function heartbeat ();

///@}

///@{ \name Flow Events
    /**
     * Invoked whenever a new experience is loaded, or explicitly by the developer when a flow is dismissed.
     */
    public void function resetFlows() {}

    /**
     * @param String $flowName
     * @param EventSource $eventSource
     * 
     * Invoked at the start of a flow, immediately after the user interacted with a UI element.
     */
    public void function flowStarted (String $flowName, EventSource $eventSource) {}
    
    /**
     * @param String $flowName
     * @param EventSource $eventSource
     */
    public void function flowEnded (String $flowName, EventSource $eventSource) {}

    /**
     * @param String $flowName
     * @param String $stepName
     * @param EventSource $eventSource
     * 
     * Invoked whenever a step was impressed.
     */
    public void function flowStepLoaded (String $flowName, String $stepName, EventSource $eventSource) {}

    /**
     * @param String $flowName
     * @param String $stepName
     * @param EventSource $eventSource
     * 
     * Invoked whenever a step was unloaded.
     */
    public void function flowStepUnloaded (String $flowName, String $stepName, EventSource $eventSource) {}

    /**
     * @param String $flowName
     * @param String $stepName
     * @param Map $eventData
     * @param EventSource $eventSource
     * 
     * Invoked whenever a step was completed, and sends extra data about the step, such as the information collected in the inputs.
     */
    public void function flowStepCompleted (String $flowName, String $stepName, Map $eventData, EventSource $eventSource) {}
    ///@}
    
///@{ \name UI Interaction Events

    /**
     * @param String $eventName From a list of Interaction Event Names
     * @param EventSource $eventSource
     * 
     * Sends an Interaction event.
     */
    public void function sendInteractionEvent(String $eventName, EventSource $eventSource) {};
///@}
//
///@{ \name Outcome Events

     /**
     * @param String $eventName From a list of Outcome Event Names
     * @param Map $eventData An open-ended map of String to String values (the value may be a JSON blob)
     * @param int $errorCode Send `0` on success, otherwise include a predefined error code number
     * @param String $errorMessage Error message, null when successful.
     * 
     * Sends an Outcome event.
     */  
    public void function sendOutcomeEvent (String $eventName, Map $eventData, int $errorCode, String $errorMessage) {}
///@}

    }
    

    