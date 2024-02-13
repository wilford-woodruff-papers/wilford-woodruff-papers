<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Octopy\Impersonate\ImpersonateAuthorization;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

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
        'ww_relationship_distance',
        'ww_relationship_description',
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

    public function getFirstNameAttribute()
    {
        return str($this->name)
            ->explode(' ')
            ->first();
    }

    public function getLastNameAttribute()
    {
        return str($this->name)->explode(' ')->count() > 1
            ? str($this->name)->explode(' ')->last()
            : '';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole([
            'Super Admin',
            'Editor',
            'Bio Admin',
            'Bio Editor',
        ]);
    }

    public function relationships(): BelongsToMany
    {
        return $this->belongsToMany(Relationship::class);
    }
}
