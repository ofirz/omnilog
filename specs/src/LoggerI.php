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
     * Call experienceLoaded whenever an Experience is loaded (rendered) on the client device 
     * and the user can see it.
     * 
     * @param RoutingDescriptor $rd A Routing Descriptor
     * @param Id $experienceId The Experience Id, null by default. This function would generate
     * and Experience Id if one is not provided. It may be useful to pass an Experience
     * Id if one was previously determined and the behavior requires re-loading that same experience.
     * @param EventSource $eventSource
     */  
    public void function experienceLoaded (com.houzz.common_router.RoutingDescriptor $rd, Id $experienceId, EventSource $eventSource);

    /**
     * Call experienceLoaded whenever an Experience is removed from the client device to make way 
     * for the next experience. 
     * 
     * Calling this function is optional, and is meant to serve two purposes: recording the time 
     * spent on the experience, and which element on the page was engaged, thus unloading it.
     * 
     * @param RoutingDescriptor $rd A Routing Descriptor
     * @param Id $experienceId The Experience Id, could be null.
     * @param EventSource $eventSource
     */
    public void function experienceUnloaded (com.houzz.common_router.RoutingDescriptor $rd, Id $experienceId, EventSource $eventSource);

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
     * Invoked internally whenever a new experience is loaded, or when all flows are 
     * abandoned/completed.
     */
    public void function resetFlows();

    /**
     * Call this as soon as the user instantiates the flow, e.g. when they click the 
     * button to open a dialog/screen, or if they engage by focusing on a popup. 
     * 
     * This event is useful for sending extra flow-related data in the eventDetails.
     * 
     * @param String $flowName
     * @param Map $eventDetails
     * @param EventSource $eventSource
     */
    public void function flowStarted (String $flowName, Map $eventDetails, EventSource $eventSource) ;
    
    /**
     * Call this at the end of a Flow, when the flow is positively concluded and completed
     * and there are no more activities (either UI interactions, Ajax/Restful calls or other 
     * events) related to the flow.
     *
     * Aborting or bouncing back from a flow does not trigger this event. Use flowAbandoned instead.
     * 
     * @param String $flowName
     * @param Map $eventDetails
     * @param EventSource $eventSource
     */
    public void function flowCompleted (String $flowName, Map $eventDetails, EventSource $eventSource) ;

    /**
     * Call this whenever the most recent flow is abandoned. This call doesn't fire an actual 
     * event; it is only for internal bookkeeping of the nested flows.
     */
    function void flowAbandoned ($flowName);

    /**
     * Optional event. Call this whenever a new step is loaded (e.g. shows up), preferably 
     * without flow-related data in the eventDetails.
     * 
     * @param String $flowName
     * @param String $stepName
     * @param Map $eventDetails
     * @param EventSource $eventSource
     */
    public void function flowStepLoaded (String $flowName, String $stepName, Map $eventDetails, EventSource $eventSource) ;

    /**
     * Optional event. Call this whenever a new step is unloaded (e.g. hidden to be replaced
     * by the next step), preferably without flow-related data in the eventDetails.
     * 
     * @param String $flowName
     * @param String $stepName
     * @param Map $eventDetails
     * @param EventSource $eventSource
     */
    public void function flowStepUnloaded (String $flowName, String $stepName, Map $eventDetails, EventSource $eventSource) ;

    /**
     * Call this when the user positively completes filling up the inputs of the current step, 
     * and intentionally wishes to move forward.
     * 
     * Going back to a previous step or to dismiss the flow entirely is NOT a positive completion of the step.
     * 
     * This event is useful for sending extra flow-related data in the eventDetails.
     * 
     * @param String $flowName
     * @param String $stepName
     * @param Map $eventDetails
     * @param EventSource $eventSource
     */
    public void function flowStepCompleted (String $flowName, String $stepName, Map $eventDetails, EventSource $eventSource) ;
    ///@}
    
///@{ \name UI Interaction Events

    /**
     * Sends an Interaction event.
     * 
     * @param String $eventName From a list of Interaction Event Names
     * @param EventSource $eventSource
     */
    public void function sendInteractionEvent(String $eventName, EventSource $eventSource) ;
        
    /**
     * Sends an User Error event.
     * User errors occur on the client side and typically follow an on-screen warning, such as when
     * a password is not repeated correctly, a mandatory input field is missing, etc.
     * 
     * @param String $eventName From a list of User Error Event Names
     * @param Map $eventDetails An open-ended map of String to String values (the value may be a JSON blob)
     * @param EventSource $eventSource
     */
    public void function sendUserError(String $eventName, Map $eventDetails, EventSource $eventSource) ;
    
///@}
//
///@{ \name Outcome Events

    /**
     * Sends an Outcome event.
     * 
     * @param String $eventName From a list of Outcome Event Names
     * @param Map $eventDetails An open-ended map of String to String values (the value may be a JSON blob)
     * @param int $errorCode Send `0` on success, otherwise include a predefined error code number
     * @param String $errorMessage Error message, null when successful.
     */
    public void function sendOutcomeEvent (String $eventName, Map $eventDetails, int $errorCode, String $errorMessage) ;
///@}

    }
    

    
