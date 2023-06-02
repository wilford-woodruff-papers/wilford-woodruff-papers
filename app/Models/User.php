<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Octopy\Impersonate\ImpersonateAuthorization;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'accepted_terms',
        'provider',
        'provider_id',
        'organization_name',
        'proposed_use',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function tasks()
    {
        return $this->hasMany(User::class, 'assigned_to');
    }

    public function pending_actions()
    {
        return $this->hasMany(Action::class, 'assigned_to')
                    ->where(
                        'actionable_type',
                        \App\Models\Item::class
                    )
                    ->whereNull('completed_at');
    }

    public function impersonatable(ImpersonateAuthorization $authorization): void
    {
        $authorization->impersonator(function (User $user) {
            return $user->hasRole('Super Admin');
        });

        $authorization->impersonated(function (User $user) {
            return ! $user->id !== 1;
        });
    }

    public function hasAcceptedApiTerms()
    {
        return $this->accepted_api_terms;
    }

    public function hasProvidedApiUseFields()
    {
        return $this->provided_api_fields;
    }
}
