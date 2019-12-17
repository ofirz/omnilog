<?php

/**
 * A container class to describe an experience and its arguments,
 * running on a platform, product and environment.
 * @package com.houzz.common_router
 */

namespace com.houzz.common_router;

class RoutingDescriptor {
    /**
     * Namespace, a logical grouping of sites
     *
     * Any of:
     * - HOUZZ
     * - HOUZZ_PRO
     * - IVY
     * - SITEDESIGNER
     */
    public String $ns;

    /**
     * Site name, a variation on the site under the current namespace
     *
     * For the HOUZZ namespace, it is any of -
     * - HOUZZ_US
     * - HOUZZ_UK
     * - HOUZZ_AU
     * - HOUZZ_DE
     * - HOUZZ_FR
     * etc.
     *
     * For HOUZZ_PRO namesapce, it is any of -
     * - HOUZZ_PRO_US
     * - HOUZZ_PRO_UK
     * - HOUZZ_PRO_AU
     * - HOUZZ_PRO_DE
     * - HOUZZ_PRO_FR
     * etc.
     */
    public String $sitename;

    /**
     * Environment indicates a variation of the current experience in terms of servers responding to the request.
     *
     * For the HOUZZ environment, it is any of -
     * - PRODUCTION
     * - STGHOUZZ
     * - HOUZZ1
     * - HOUZZ2
     * - HOUZZ3
     * - STGHOUZZ
     * - DEV
     */
    public String $environment;

    /**
     * Experiment name
     *
     * For the HOUZZ environment, see - https://docs.google.com/spreadsheets/d/1lssiYLNMrnN0BB4jpLZLBD3c7FRlI18XgAIUcyjiTQ4/edit#gid=0
     */
    public String $experience;

    /**
     * Experience arguments in JSON string.
     */
    public String $experienceArgumentsJSON;

    /**
     * Global directives in JSON string.
     */
    public String $globalDirectivesJSON;
}