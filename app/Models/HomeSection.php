<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['section', 'content'])]
class HomeSection extends Model
{
    protected function casts(): array
    {
        return ['content' => 'array'];
    }
}
