<?php

declare(strict_types=1);

namespace PowerCaptcha\Typo3\PowermailValidator;

use PowerCaptcha\Typo3\Service\TokenVerification;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use In2code\Powermail\Utility\FrontendUtility;

class PowermailV12Validator extends AbstractPowermailValidator {
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

    /**
     * Overwriting the orignal isFirstActionForValidation method, because since Powermail 12.0.3 the actions 
     * were renamed to 'checkConfirmation' and 'checkCreate' (instead of 'confirimation' and 'create').
     * However, the isFirstActionForValidation method has not been adpated to the new action names.
     * 
     * @link https://github.com/in2code-de/powermail/commit/afdaa34712756429a9e6514ac964de1ad6495648#diff-6ef7cf948e4f7df7ba3197d1fb2cda4ee608e102859ff588e6c2cb36cda1b5df commit where the actions where renamed
     * @see \In2code\Powermail\Domain\Validator\AbstractValidator::isFirstActionForValidation original method
     * 
     * @return bool
     */
    public function isFirstActionForValidation() : bool {
        $arguments = FrontendUtility::getArguments();
        if ($this->isConfirmationActivated()) {
            return $arguments['action'] === 'checkConfirmation';
        }
        return $arguments['action'] === 'checkCreate';
    }
}