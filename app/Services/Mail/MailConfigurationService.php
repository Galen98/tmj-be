<?php

namespace App\Services\Mail;

use App\Services\ParameterGlobals\ParameterGlobalService;

class MailConfigurationService
{
    public function __construct(
        private ParameterGlobalService $parameterService
    ) {
    }


    public function apply(): void
    {
        $username =
            $this->parameterService
                ->getValue(
                    'MAIL_USERNAME'
                );


        $password =
            $this->parameterService
                ->getValue(
                    'MAIL_PASSWORD'
                );


        $fromAddress =
            $this->parameterService
                ->getValue(
                    'MAIL_FROM_ADDRESS'
                );


        /*
         * Override config Laravel
         * untuk request/job saat ini.
         */

        config([
            'mail.mailers.smtp.username' =>
                $username,

            'mail.mailers.smtp.password' =>
                $password,

            'mail.from.address' =>
                $fromAddress,
        ]);
    }
}
