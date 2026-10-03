<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_REQUESTER = 'requester';
    public const ROLE_STAFF_REVIEWER = 'staff_reviewer';
    public const ROLE_RECORD_KEEPER = 'record_keeper';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isRequester(): bool
    {
        return $this->role === self::ROLE_REQUESTER;
    }

    public function isStaffReviewer(): bool
    {
        return $this->role === self::ROLE_STAFF_REVIEWER;
    }

    public function isRecordKeeper(): bool
    {
        return $this->role === self::ROLE_RECORD_KEEPER;
    }

    public function canSubmitRequest(): bool
    {
        return $this->isRequester();
    }

    public function canReviewRequests(): bool
    {
        return $this->isStaffReviewer();
    }

    public function canViewAllRecords(): bool
    {
        return $this->isRecordKeeper();
    }
}
