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
     * @param String $eventName From a list of enumerated and agreed-upon list of event names
     * @param Map $eventData An open-ended map of String to String values (the value may be a JSON blob)
     * @param EventSource $eventSource
     * @param Map $extraFields
     * 
     * 
     * Incorporate all the inputs along with the contextual data and construct the final event.
     * 
     * Specifically:
     * - Generate an Event ID and Timestamp
     * - invoker = EventSource == null ? `Application` : `User`
     * - location = `Client` on all client-based events
     */
    private void function sendEvent(String $eventName, Map $eventData, EventSource $eventSource, Map $extraFields) {};

    /**
     * @param String $eventName From a list of enumerated and agreed-upon list of event names
     * @param Map $eventData An open-ended map of String to String values (the value may be a JSON blob)
     * @param EventSource $eventSource
     * 
     * Send a platform event.
     * 
     * Invokes `sendEvent ($eventName, $eventData, $eventSource, null)`
     */
    private void function sendPlatformEvent(String $eventName, Map $eventData, EventSource $eventSource) {};

    /**
     * @param String $eventName From a list of enumerated and agreed-upon list of event names
     * @param Map $eventData An open-ended map of String to String values (the value may be a JSON blob)
     * @param EventSource $eventSource
     * 
     * Send a Flow event.
     * 
     * Incorporate the following into the $additionalFields argument:
     * - $flowName
     * - $flowId
     * - $flowStep
     * 
     * Invokes `sendEvent ($eventName, $eventData, $eventSource, $additionalFields)`
     */
    private void function sendFlowEvent(String $eventName, Map $eventData, EventSource $eventSource) {};



///@{ \name Platform Events

    /**
     * @param RoutingDescriptor $rd A Routing Descriptor
     * @param Id $experienceId The Experience Id, could be null.
     * @param EventSource $eventSource
     *
     * Populate the experience fields (experienceName, experienceArguments, product and productVariant) and the experienceId.
     * If the experience id = null, auto-generates one and populate the $experienceId.
     * If the $eventSource has an experienceId, use it to populate the $referrerExperienceId
     * Invokes `resetUserFlow()`
     * Invokes `sendPlatformEvent("Experience Loaded", null, eventSource)`
     */
    
    public void function experienceLoaded (RoutingDescriptor $rd, Id $experienceId, EventSource $eventSource) {}

    /**
     * @param RoutingDescriptor $rd A Routing Descriptor
     * @param Id $experienceId The Experience Id, could be null.
     * @param EventSource $eventSource
     *
     * Invokes `sendPlatformEvent("Experience Unloaded", null, eventSource)`
     */
    public void function experienceUnloaded (RoutingDescriptor $rd, Id $experienceId, EventSource $eventSource) {}

    /**
     * @param EventSource $eventSource
     *
     * Invoked whenever the app started or new Browser Window/tab launched.
     * 
     * Invokes `sendPlatformEvent("App Started", null, eventSource)`
     */
    public void function appStarted (EventSource $eventSource) {}

    /**
     * @param EventSource $eventSource
     *
     * Invoked whenever the app stopped (killed) or Browser Window/tab closed.
     * 
     * Invokes `sendPlatformEvent("App Stopped", null, eventSource)`
     */
    public void function appStopped (EventSource $eventSource) {}
    
    /**
     * Invoked automatically if a session is not previously active, or if a 
     * new experience comes from a new channel.
     * 
     * Invokes `sendPlatformEvent("Session Started")`
     */
    public void function sessionStarted () {}

    /**
     * Invoked automatically after predefined (default = 30m) of inactivity.
     * 
     * Invokes `sendPlatformEvent("Session Ended")`
     */
    public void function sessionEnded () {}
    
    /**
     * @param String $testName
     * @param String $testVariantId
     * 
     * Invoked automatically after predefined (30 mins) of inactivity.
     * 
     * Populate the eventData with $testName and $testVariantId.
     *
     * Invokes `sendPlatformEvent("AB Registered", eventData, eventSource)`
     */
    public void function abRegistered (String $testName, String $testVariantId) {}

    /**
     * Invoked periodically (default = 60s) as long as the user is interacting with the application.
     * 
     * Invokes `sendPlatformEvent("Heartbeat", eventData, eventSource)`
     */
    public void function heartbeat () {}

///@}

///@{ \name Flow Events
    /**
     * Reset the internal $flowNames list.
     * 
     * Invoked whenever a new experience is loaded, or explicitly by the developer when a flow is dismissed.
     */
    public void function resetFlows() {}

    /**
     * @param String $flowName
     * @param EventSource $eventSource
     * 
     * Generate a new userFlowId
     * If the flowNames stack is empty, set userFlowStep to 0
     * Adds the flowName to the $flowNames stack
     * Invokes `sendFlowEvent($flowName + " - Started", null, eventSource)`
     */
    public void function flowStarted (String $flowName, EventSource $eventSource) {}
    
    /**
     * @param String $flowName
     * @param EventSource $eventSource
     * 
     * Generate a new userFlowId.
     * 
     * If the flowNames stack is empty, set userFlowStep to 0.
     * 
     * Removes the flowName from the $flowNames stack.
     * 
     * Invokes `sendFlowEvent($flowName + " - Ended", null, eventSource)`
     */
    public void function flowEnded (String $flowName, EventSource $eventSource) {}

    /**
     * @param String $flowName
     * @param String $stepName
     * @param EventSource $eventSource
     * 
     * Invoked whenever a step was impressed.
     * 
     * Increases the internal flowStepId.
     * 
     * Invokes `sendFlowEvent($flowName + " - " $flowStep + " Loaded", null, eventSource)`
     */
    public void function flowStepLoaded (String $flowName, String $stepName, EventSource $eventSource) {}

    /**
     * @param String $flowName
     * @param String $stepName
     * @param EventSource $eventSource
     * 
     * Invoked whenever a step was impressed.
     * 
     * Increases the internal flowStepId.
     * 
     * Invokes `sendFlowEvent($flowName + " - " $flowStep + " Unloaded", null, eventSource)`
     */
    public void function flowStepUnloaded (String $flowName, String $stepName, EventSource $eventSource) {}

    /**
     * @param String $flowName
     * @param String $stepName
     * @param Map $eventData
     * @param EventSource $eventSource
     * 
     * Invoked whenever a step was completed, and sends extra data about the step.
     * 
     * Invokes `sendFlowEvent($flowName + " - " $flowStep + " Completed", $eventData, eventSource)`
     */
    public void function flowStepCompleted (String $flowName, String $stepName, Map $eventData, EventSource $eventSource) {}
    ///@}
    
///@{ \name UI Interaction Events

    /**
     * @param String $eventName From a list of Interaction Event Names
     * @param EventSource $eventSource
     * 
     * Send an Interaction event.
     * 
     * Incorporate the following into the $additionalFields argument:
     * - $flowName
     * - $flowId
     * - $flowStep
     * 
     * Invokes `sendEvent ($eventName, null, $eventSource, $additionalFields)`
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
     * Send an Outcome event.
     * 
     * Invokes `sendEvent ($eventName, null, $eventSource, $additionalFields)`
     */  
    public void function sendOutcomeEvent (String $eventName, Map $eventData, int $errorCode, String $errorMessage) {}
///@}

    }
    

    
