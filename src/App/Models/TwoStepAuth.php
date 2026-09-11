<?php

namespace jeremykenedy\laravel2step\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TwoStepAuth extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'userId',
        'authCode',
        'authCount',
        'authStatus',
        'requestDate',
        'authDate',
    ];

    protected $casts = [
        'userId'      => 'integer',
        'authCode'    => 'string',
        'authCount'   => 'integer',
        'authStatus'  => 'boolean',
        'requestDate' => 'datetime',
        'authDate'    => 'datetime',
    ];

    /**
     * Create a new instance to set the table and connection.
     *
     * @return void
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('laravel2step.laravel2stepDatabaseTable');
        $this->connection = config('laravel2step.laravel2stepDatabaseConnection');
    }

    /**
     * Get the database connection.
     */
    public function getConnectionName()
    {
        return $this->connection;
    }

    /**
     * Get the database table.
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * A two step auth entry belongs to a user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('laravel2step.defaultUserModel'), 'userId');
    }

    /**
     * Get a validator for an incoming Request.
     *
     * @param array $merge (rules to optionally merge)
     *
     * @return array
     */
    public static function rules($merge = [])
    {
        return array_merge(
            [
                'userId'     => 'required|integer',
                'authCode'   => 'required|string|max:4|min:4',
                'authCount'  => 'required|integer',
                'authStatus' => 'required|boolean',
            ],
            $merge
        );
    }
}
