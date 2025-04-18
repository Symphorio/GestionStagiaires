<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Application
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 */
	class Application extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Attestation
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\AttestationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Attestation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attestation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attestation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attestation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attestation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attestation whereUpdatedAt($value)
 */
	class Attestation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DemandeStage
 *
 * @property int $id
 * @property string $prenom
 * @property string $nom
 * @property string $email
 * @property string $telephone
 * @property string $formation
 * @property string|null $specialisation
 * @property string $lettre_motivation
 * @property string $date_debut
 * @property string $date_fin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\DemandeStageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage query()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereFormation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereLettreMotivation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereSpecialisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandeStage whereUpdatedAt($value)
 */
	class DemandeStage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Memoire
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\MemoireFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Memoire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Memoire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Memoire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Memoire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memoire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memoire whereUpdatedAt($value)
 */
	class Memoire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\NotificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Rapport
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RapportFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Rapport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rapport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rapport query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rapport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rapport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rapport whereUpdatedAt($value)
 */
	class Rapport extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Stagiaire> $stagiaires
 * @property-read int|null $stagiaires_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Stage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage query()
 */
	class Stage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stagiaire
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $email
 * @property string $intern_id
 * @property string $password
 * @property bool $is_validated
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $role_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role $role
 * @method static \Database\Factories\StagiaireFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereInternId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereIsValidated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stagiaire whereUpdatedAt($value)
 */
	class Stagiaire extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tache
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TacheFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tache newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tache newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tache query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tache whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tache whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tache whereUpdatedAt($value)
 */
	class Tache extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

