<?php declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 * @property $id
 * @property $name
 * @property $email
 * @property $created_at
 * @property $updated_at
 */
class User extends Model
{
  /**
   * @var string
   */
  public string $keyType = 'string';

  protected ?string $table = 'user';

  /**
   * @var bool
   */
  public bool $incrementing = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected array $fillable = ['id', 'name', 'email', 'password', 'created_at', 'updated_at'];


}