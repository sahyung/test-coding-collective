<?php

namespace App\Models;

use App\Traits\UuidsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;

class Candidate extends Model
{
    use UuidsTrait;
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
    ];

    public $incrementing = false;

    public function __construct()
    {
        $this->id = Uuid::generate(4)->string;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'education',
        'date_of_birth',
        'experience',
        'last_position',
        'applied_position',
        'top_skills',
        'email',
        'phone_number',
        'resume',
    ];
}
