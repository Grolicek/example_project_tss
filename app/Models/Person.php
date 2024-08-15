<?php

namespace App\Models;

use App\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'age',
        'gender',
    ];

    protected $casts = [
        'age' => 'integer',
        'gender' => 'integer',
    ];

    /**
     * Returns localized gender label.
     *
     * @return string
     */
    public function getGenderLabel(): string
    {
        return GenderEnum::from($this->gender)->getLabel();
    }
}
