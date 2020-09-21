<?php

namespace App\Classes\DataClass;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterDataClass
{
    /**
     * @var string|null
     */
    private $username;

    /**
     * @Assert\NotBlank()
     *
     * @var string|null
     */
    private $email;

    /**
     * @Assert\NotBlank()
     *
     * @var string|null
     */
    private $password;

    public function mapFormToDataClass($requestData): void
    {
        $this->username = $requestData['username'];
        $this->email = $requestData['email'];
        $this->password = $requestData['password'];
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}