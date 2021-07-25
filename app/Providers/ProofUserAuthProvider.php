<?php

namespace App\Providers;

use App\Enums\RoleType;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class ProofUserAuthProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials)
    {
        $query = $this->createModel()->newQuery();
        $query = $query->where('email', $credentials['email']);
        // if ($credentials['role_id'] == RoleType::ADMIN || $credentials['role_id'] == RoleType::USER) {
        //     $query = $query->whereHas('company');
        // }
        return $query->first();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param Authenticatable $authenticatable
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $authenticatable, array $credentials)
    {
        return Hash::check($credentials['password'], $authenticatable->password);
    }
}
