<?php
/**
 * The OmniLog is an adapter class for invoking events and sending them to a log collector.
 * 
 * The underlying implementation may be using a CDP or CommonLog.
 * 
 * The objective of the class is to provide easy-to-use interface for developers to 
 * send events, while at the same time retaining and using stateful context to 
 * enrich the event with data, such as session id, session channel information, 
 * experience id, flow id, etc.
 *
 * @package com.houzz.omnilog
 **/

namespace package com.houzz.omnilog;

class OmniLog implements LoggerI
{
    
    /**@{
     * \name Experience Context 
     * The experience context properties are retained until a new Experience is loaded.
     */
    /**
     * Keeps track of the current experience Id.
     */
    private Id $experienceId;

    /**
     * The current experience name, as defined in the RouteDescriptor.
     */    
    private String $experienceName;

    /**
     * The current experience's argument, as defined in the RouteDescriptor. 
    */    
    private Map $experienceArguments;

    /**
     * The current experience's product, as defined in the RouteDescriptor (property name "namespace")
     */        
    private String $experienceProduct;

    /**
     * The current experience's product variant, as defined in the RouteDescriptor (property name "siteName")
     */        
    private String $experienceProductVariant;

    /**
     * The experience ID of the referrer experience, null for first experience in a session.
     */        
    private Id $referrerExperienceId;
    /**@}*/
   
    /**@{
     * \name Flow Context 
     * The flow context has a set of properties belonging to the current flow(s)
     */
    /**
     * Keeps track of the current flow Id. Gets set whenever a new Flow is started from an experience, but retains its value if a sub-flow is started.
     */
    private Id $flowId;

    /**
     * A Stack of flow names. New flow names are added to the end of the stack when a new flow is started. The stack is flushed whenever a new experience is loaded or the entire flow is dismissed.
     */    
    private List<String> $flowNames;

    /**
     * The step in the flow, auto-incremented.
     */    
    private int $flowStep;

    /** @}*/
    
    /**
     * Incorporate all the inputs along with the contextual data and construct the final event.
     * 
     * Specifically:
     * - Generate an Event ID and Timestamp
     * - invoker = EventSource == null ? `Application` : `User`
     * - location = `Client` on all client-based events
     * 
     * @param String $eventName From a list of enumerated and agreed-upon list of event names
     * @param Map $eventDetails An open-ended map of String to String values (the value may be a JSON blob)
     * @param EventSource $eventSource
     * @param Map $extraFields
     * 
     */
    private void function sendEvent(String $eventName, Map $eventDetails, EventSource $eventSource, Map $extraFields) {};

    /**
     * @param String $eventName From a list of enumerated and agreed-upon list of event names
     * @param Map $eventDetails An open-ended map of String to String values (the value may be a JSON blob)
     * @param EventSource $eventSource
     * 
     * 
     * Send a platform event.
     * 
     * Invokes `sendEvent ($eventName, $eventDetails, $eventSource, null)`
     */
    private void function sendPlatformEvent(String $eventName, Map $eventDetails, EventSource $eventSource) {};

    /**
     * @param String $eventName From a list of enumerated and agreed-upon list of event names
     * @param Map $eventDetails An open-ended map of String to String values (the value may be a JSON blob)
     * @param EventSource $eventSource
     * 
     * 
     * Send a Flow event.
     * 
     * Incorporate the following into the $additionalFields argument:
     * - $flowName
     * - $flowId
     * - $flowStep
     * 
     * Invokes `sendEvent ($eventName, $eventDetails, $eventSource, $additionalFields)`
     */
    private void function sendFlowEvent(String $eventName, Map $eventDetails, EventSource $eventSource) {};



///@{ \name Platform Events

    public void function experienceLoaded (com.houzz.common_router.RoutingDescriptor $rd, Id $experienceId, EventSource $eventSource) {}

    public void function experienceUnloaded (com.houzz.common_router.RoutingDescriptor $rd, Id $experienceId, EventSource $eventSource) {}

    public void function appStarted (EventSource $eventSource) {}

    public void function appStopped (EventSource $eventSource) {}
    
    public void function sessionStarted () {}

    public void function sessionEnded () {}
    
    public void function abRegistered (String $testName, String $testVariantId) {}

    public void function heartbeat () {}

///@}

///@{ \name Flow Events
    public void function resetFlows() {}

    public void function flowStarted (String $flowName, Map $eventDetails, EventSource $eventSource) {}
    
    public void function flowCompleted (String $flowName, Map $eventDetails, EventSource $eventSource) {}

    public void function flowStepLoaded (String $flowName, String $stepName, Map $eventDetails, EventSource $eventSource) {}

    public void function flowStepUnloaded (String $flowName, String $stepName, Map $eventDetails, EventSource $eventSource) {}

    public void function flowStepCompleted (String $flowName, String $stepName, Map $eventDetails, EventSource $eventSource) {}
    ///@}
    
///@{ \name UI Interaction Events

    public void function sendInteractionEvent(String $eventName, EventSource $eventSource) {};
///@}
//
///@{ \name Outcome Events

    public void function sendOutcomeEvent (String $eventName, Map $eventDetails, int $errorCode, String $errorMessage) {}
///@}

    }
    

    
