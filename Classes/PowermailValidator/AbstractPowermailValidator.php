<?php

declare(strict_types=1);

namespace PowerCaptcha\Typo3\PowermailValidator;

use In2code\Powermail\Domain\Validator\AbstractValidator;

abstract class AbstractPowermailValidator extends AbstractValidator {
    /**
     * @param Mail $mail
     * @return bool
     */
    protected function skipPowerCaptchaValidation($mail) : bool {
        // skip validation if form has no POWER CAPTCHA field OR
        // OR if it is not the first action for validation (f.e. token was already verified on confirmationAction)
        return !$this->hasPowerCaptchaField($mail) || !$this->isFirstActionForValidation();
    }

    /**
     * @param Mail $mail
     * @return bool
     */
    private function hasPowerCaptchaField($mail) : bool {
        foreach ($mail->getForm()->getPages() as $page) {
            foreach ($page->getFields() as $field) {
            	if ($field->getType() === 'power_captcha') {
                    return true;
                }
            }
        }
        return false;
    }
}