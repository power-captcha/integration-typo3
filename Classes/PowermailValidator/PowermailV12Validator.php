<?php

declare(strict_types=1);

namespace PowerCaptcha\Typo3\PowermailValidator;

use PowerCaptcha\Typo3\Service\TokenVerification;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PowermailV12Validator extends AbstractPowermailValidator
{
    /**
     * @param Mail $mail
     */
    public function isValid($mail) : void {
        if ($this->skipPowerCaptchaValidation($mail)) {
            return;
        }

        $tokenVerificationService = GeneralUtility::makeInstance(TokenVerification::class);
        $verificationResult = $tokenVerificationService->verify();
        
        if($verificationResult->isSuccess() === false) {
            $this->addError($this->translateErrorMessage('message.blocked', 'power_captcha'), 1713193899);
            
            if(!is_null($verificationResult->getErrorCode())) {
                $errorCodeMsgKey = $verificationResult->getErrorCode()->value;
                $this->addError($this->translateErrorMessage($errorCodeMsgKey, 'power_captcha'), 1713194073);
            }
        }
    }
}