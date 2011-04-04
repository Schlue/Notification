<?php
/**
 * The Alarm Decorator notifies the alarm system to push its notifications on
 * the stack.
 *
 * Copyright 2001-2011 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author   Jan Schneider <jan@horde.org>
 * @category Horde
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @package  Notification
 */
class Horde_Notification_Handler_Decorator_Alarm
extends Horde_Notification_Handler_Decorator_Base
{
    /**
     * A Horde_Alarm instance.
     *
     * @var Horde_Core_Factory_Alarm
     */
    protected $_alarm;

    /**
     * The current user.
     *
     * @var string
     */
    protected $_user;

    /**
     * Initialize the notification system, set up any needed session
     * variables, etc.
     *
     * @param object $alarm  An alarm factory that implements create().
     * @param string $user   The current username.
     */
    public function __construct($alarm, $user)
    {
        $this->_alarm = $alarm;
        $this->_user = $user;
    }

    /**
     * Listeners are handling their messages.
     *
     * @param array $options  An array containing display options for the
     *                        listeners (see Horde_Notification_Handler for
     *                        details).
     *
     * @throws Horde_Notification_Exception
     */
    public function notify($options)
    {
        if (in_array('status', $options['listeners'])) {
            try {
                $this->_alarm->create()->notify($this->_user);
            } catch (Horde_Alarm_Exception $e) {
                throw new Horde_Notification_Exception($e);
            }
        }
    }

}
