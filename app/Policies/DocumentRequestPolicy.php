<?php

namespace App\Policies;

use App\Models\DocumentRequest;
use App\Models\User;

class DocumentRequestPolicy
{
    /**
     * Any signed-in user may open the request list page.
     * The list contents are scoped by ownership in the controller.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Only the owner of a request or an administrator may view it.
     * Anyone else receives 403 Forbidden.
     */
    public function view(User $user, DocumentRequest $documentRequest): bool
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return $documentRequest->user_id === $user->id;
    }

    /**
     * Only authenticated students may create requests.
     */
    public function create(User $user): bool
    {
        return $user->isStudent();
    }

    /**
     * Only an administrator may change the status of a request.
     */
    public function updateStatus(User $user, DocumentRequest $documentRequest): bool
    {
        return $user->isAdministrator();
    }
}
