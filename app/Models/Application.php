<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Application extends Model {

    use HasFactory,
        SoftDeletes;

    public const ID = 'id';
    public const APPLICATION_ID = 'application_id';
    public const APPLICATION_NAME = 'application_name';
    public const APPLICATION_API_KEY = 'application_api_key';
    public const USER_ID = 'user_id';
    public const IS_ACTIVE = 'is_active';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::APPLICATION_ID,
        self::APPLICATION_NAME,
        self::APPLICATION_API_KEY,
        self::USER_ID,
        self::IS_ACTIVE,
    ];

    /**
     * Get the name of the table associated with the model.
     *
     * @return string
     */
    public static function getTableName(): string {
        return (new static)->getTable();
    }

    // Mutator for formatting the application name
    public function setApplicationNameAttribute($value): void {
        $this->attributes[self::APPLICATION_NAME] = Str::title(Str::lower($value));
    }
}
