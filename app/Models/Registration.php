<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $reference
 * @property string $participation_type
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $university
 * @property string $major
 * @property string|null $study_year
 * @property string $skills
 * @property string $track
 * @property string|null $experience
 * @property string|null $portfolio
 * @property string|null $source
 * @property string|null $team_name
 * @property int|null $team_size
 * @property array<int, array<string, string>>|null $team_members
 * @property string|null $idea
 */
#[Fillable([
    'reference',
    'participation_type',
    'full_name',
    'email',
    'phone',
    'university',
    'major',
    'study_year',
    'skills',
    'track',
    'experience',
    'portfolio',
    'source',
    'team_name',
    'team_size',
    'team_members',
    'idea',
    'ip_address',
    'user_agent',
])]
class Registration extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'team_members' => 'array',
            'team_size' => 'integer',
        ];
    }

    /**
     * هل هذا التسجيل لفريق؟
     */
    public function isTeam(): bool
    {
        return $this->participation_type === 'فريق';
    }
}
