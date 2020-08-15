<?php

namespace App\Security\Voter;

use App\Entity\Operation\BaseOperation;
use App\Entity\Operation\BaseOperationCashFlow;
use App\Entity\Operation\BaseOperationDebt;
use App\Entity\Operation\BaseOperationLoan;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class OperationVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['OPERATION_EDIT', 'OPERATION_COPY', 'OPERATION_DELETE'])
            && $subject instanceof BaseOperation;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'OPERATION_EDIT':
            case 'OPERATION_COPY':
            case 'OPERATION_DELETE':
                if ($subject instanceof BaseOperationCashFlow && $subject->getUser() === $user) {
                    return true;
                }
                if ($subject instanceof BaseOperationDebt && $subject->getDebt()->getUser() === $user) {
                    return true;
                }
                if ($subject instanceof BaseOperationLoan && $subject->getLoan()->getUser() === $user) {
                    return true;
                }
                
                break;
        }

        return false;
    }
}
