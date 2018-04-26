<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Monitor\V1;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * @property string accountSid
 * @property string alertText
 * @property string apiVersion
 * @property \DateTime dateCreated
 * @property \DateTime dateGenerated
 * @property \DateTime dateUpdated
 * @property string errorCode
 * @property string logLevel
 * @property string moreInfo
 * @property string requestMethod
 * @property string requestUrl
 * @property string requestVariables
 * @property string resourceSid
 * @property string responseBody
 * @property string responseHeaders
 * @property string sid
 * @property string url
 */
class AlertInstance extends InstanceResource {
    /**
     * Initialize the AlertInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $sid The sid
     * @return \Twilio\Rest\Monitor\V1\AlertInstance 
     */
    public function __construct(Version $version, array $payload, $sid = null) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = array(
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'alertText' => Values::array_get($payload, 'alert_text'),
            'apiVersion' => Values::array_get($payload, 'api_version'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'dateGenerated' => Deserialize::dateTime(Values::array_get($payload, 'date_generated')),
            'dateUpdated' => Deserialize::dateTime(Values::array_get($payload, 'date_updated')),
            'errorCode' => Values::array_get($payload, 'error_code'),
            'logLevel' => Values::array_get($payload, 'log_level'),
            'moreInfo' => Values::array_get($payload, 'more_info'),
            'requestMethod' => Values::array_get($payload, 'request_method'),
            'requestUrl' => Values::array_get($payload, 'request_url'),
            'resourceSid' => Values::array_get($payload, 'resource_sid'),
            'sid' => Values::array_get($payload, 'sid'),
            'url' => Values::array_get($payload, 'url'),
            'requestVariables' => Values::array_get($payload, 'request_variables'),
            'responseBody' => Values::array_get($payload, 'response_body'),
            'responseHeaders' => Values::array_get($payload, 'response_headers'),
        );

        $this->solution = array(
            'sid' => $sid ?: $this->properties['sid'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Monitor\V1\AlertContext Context for this AlertInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new AlertContext(
                $this->version,
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Fetch a AlertInstance
     * 
     * @return AlertInstance Fetched AlertInstance
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Deletes the AlertInstance
     * 
     * @return boolean True if delete succeeds, false otherwise
     */
    public function delete() {
        return $this->proxy()->delete();
    }

    /**
     * Magic getter to access properties
     * 
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get($name) {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Monitor.V1.AlertInstance ' . implode(' ', $context) . ']';
    }
}