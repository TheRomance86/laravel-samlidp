<?php

namespace CodeGreenCreative\SamlIdp\Events;

use LightSaml\ClaimTypes;
use Illuminate\Queue\SerializesModels;
use LightSaml\Model\Assertion\Attribute;
use LightSaml\Model\Assertion\AttributeStatement;

class Assertion
{
    use SerializesModels;

    /**
     * The SAML assertion attribute statement
     *
     * @var object
     */
    public $attribute_statement;

    /**
     * Create a new event instance.
     *
     * @param  string $guard
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  bool  $remember
     * @return void
     */
    public function __construct(AttributeStatement &$attribute_statement, ?string $impersonationEmail = null)
    {
        $this->attribute_statement = &$attribute_statement;
        $this->attribute_statement
            ->addAttribute(
                new Attribute(
                    ClaimTypes::EMAIL_ADDRESS,
                    $impersonationEmail ?? auth()->user()->__get(config('samlidp.email_field', 'email'))
                )
            );
    }
}
