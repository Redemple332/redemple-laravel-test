<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\Base\BaseRepository;
use Illuminate\Validation\ValidationException;
use App\Repository\User\UserRepositoryInterface;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUserByEmailUsername(string $login): User
    {
        $user = User::where('username', $login)
            ->orWhere('email', $login)
            ->first();
        if ($user) {
            return $user;
        } else {
            throw ValidationException::withMessages([
                'user_not_found' => 'User not found'
            ]);
        }
    }
}
