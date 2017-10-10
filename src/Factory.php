<?php

namespace Fluent\Laravel;

use Fluent\Message;
use Fluent\Event;

class Factory
{
    protected $_defaults = [
        'key'       => null,
        'secret'    => null,
        'sender'    => null,
        'headers'   => null,
        'format'    => 'markup',
        'transport' => 'remote',
        'storage'   => 'sqlite'
    ];

    protected $_options = array();

    public function __construct(array $options = array())
    {
        $this->_options = array_merge(
            $this->_defaults, $options
        );
    }
    
    /**
     * @return \Fluent\Message
     */
    public function message()
    {
        return new Message($this->_options);
    }

    /**
     * @return \Fluent\Event
     */
    public function event()
    {
        return new Event($this->_options);
    }

    /**
     * Render a message locally.
     * @param \Fluent\Message\Create $message
     * @param array $options
     * @return \Fluent\Layout
     */
    public function layout($message, $options = array())
    {
        $content = $message->getContent();

        if ($content->getFormat() == 'raw') {
            return $content;
        }

        return Theme::factory('musimal', $content->toString())->getLayout($options);
    }
}