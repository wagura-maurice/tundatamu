<?php

namespace App\Notifications\Messages;

class ShortMessage
{
    protected int $_identity;
    protected string $_recipient;
    protected string $_content;

    /**
     * > This function returns the value of the private property `_identity`
     * 
     * @return int The value of the private property .
     */
    public function getIdentity(): int
    {
        return $this->_identity;
    }

    /**
     * > Sets the identity of the message
     * 
     * @param int identity The identity of the message.
     * 
     * @return ShortMessage The object itself.
     */
    public function setIdentity(int $identity): ShortMessage
    {
        $this->_identity = $identity;
        return $this;
    }

    /**
     * > This function returns the recipient of the email
     * 
     * @return string The recipient of the email.
     */
    public function getRecipient(): string
    {
        return $this->_recipient;
    }

    /**
     * Set the recipient of the message.
     * 
     * @param string recipient The phone number of the recipient.
     * 
     * @return ShortMessage The object itself.
     */
    public function setRecipient(string $recipient): ShortMessage
    {
        $this->_recipient = $recipient;
        return $this;
    }

    /**
     * > This function returns the content of the page
     * 
     * @return string The content of the page.
     */
    public function getContent(): string
    {
        return $this->_content;
    }

    /**
     * > Sets the content of the message
     * 
     * @param string content The content of the message.
     * 
     * @return ShortMessage The object itself.
     */
    public function setContent(string $content): ShortMessage
    {
        $this->_content = $content;
        return $this;
    }
}