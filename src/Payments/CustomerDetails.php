<?php

namespace Easypay\SDK\Payments;

class CustomerDetails
{
    /**
     * Your client name
     * @var string
     */
    protected $name;

    /**
     * Your client email
     * @var string
     */
    protected $email;

    /**
     * Your client mobile or phone number
     * @var string
     */
    protected $phoneNumber;

    /**
     * You can use this to store whatever you want..
     * @var string
     */
    protected $description;

    /**
     * Sets the name that will be automatically filled on the gateway
     * @param string $name Name
     * @return CustomerDetails
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Sets the email that will be automatically filled on the gateway
     * @param string $email Email
     * @return CustomerDetails
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Sets the phone number that will be automatically filled on the gateway
     * @param string $phoneNumber Phone Number
     * @return CustomerDetails
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Sets the description, can be anything you want
     * @param string $description Description
     * @return CustomerDetails
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Returns an array with the parameters to use in a API request
     * @return array
     */
    public function toArray()
    {
        return array(
            'o_name'        => $this->name,
            'o_email'       => $this->email,
            'o_mobile'      => $this->phoneNumber,
            'o_description' => $this->description,
        );
    }
}
