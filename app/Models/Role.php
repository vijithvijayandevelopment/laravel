<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model {

    use HasFactory;

    public const ID = 'id';
    public const NAME = 'name';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::NAME
    ];

    /**
     * Get the name of the table associated with the model.
     *
     * @return string
     */
    public static function getTableName(): string {
        return (new static)->getTable();
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }
}
