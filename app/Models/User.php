<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes;

    public const ID = 'id';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const REMEMBER_TOKEN = 'remember_token';
    public const MOBILE = 'mobile';
    public const USERNAME = 'username';
    public const IS_ACTIVE = 'is_active';
    public const EMAIL_VERIFIED_AT = 'email_verified_at';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::NAME,
        self::EMAIL,
        self::MOBILE,
        self::USERNAME,
        self::PASSWORD,
        self::IS_ACTIVE,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::PASSWORD,
        self::REMEMBER_TOKEN,
    ];

    /**
     * Get the name of the table associated with the model.
     *
     * @return string
     */
    public static function getTableName(): string {
        return (new static)->getTable();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            self::EMAIL_VERIFIED_AT => 'datetime',
            self::PASSWORD => 'hashed',
        ];
    }

    // Mutator for hashing the password before saving
    public function setPasswordAttribute($value): void {
        $this->attributes[self::PASSWORD] = Hash::make($value);
    }

    // Mutator for formatting the name
    public function setNameAttribute($value): void {
        $this->attributes[self::NAME] = Str::title(Str::lower($value));
    }

    // Mutator for ensuring the username is lowercase
    public function setUsernameAttribute($value): void {
        $this->attributes[self::USERNAME] = Str::lower($value);
    }

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class);
    }
}
