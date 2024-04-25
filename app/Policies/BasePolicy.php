<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class BasePolicy
{
  use HandlesAuthorization;

  public static $name = "";

  public function before(Model $user, string $ability): bool|null
  {
    if ($user instanceof User && $user->isAdmin()) {
      return true;
    }

    return null;
  }

  public function viewAny(Model $user)
  {
    return $user->hasPermission(static::prefix("viewAny"));
  }

  public function view(?Model $user)
  {
    return $user->hasPermission(static::prefix("view"));
  }

  public function create(Model $user)
  {
    return $user->hasPermission(static::prefix("create"));
  }

  public function update(Model $user)
  {
    return $user->hasPermission(static::prefix("update"));
  }

  public function delete(Model $user)
  {
    return $user->hasPermission(static::prefix("delete"));
  }

  public function deleteAny(Model $user)
  {
    return $user->hasPermission(static::prefix("deleteAny"));
  }

  public function restore(Model $user)
  {
    return $user->hasPermission(static::prefix("restore"));
  }

  public function forceDelete(Model $user)
  {
    return $user->hasPermission(static::prefix("destroy"));
  }

  public function toggleflagActive(Model $user)
  {
    return $user->hasPermission(static::prefix("toggleflagActive"));
  }

  public function toggleflagsActive(Model $user)
  {
    return $user->hasPermission(static::prefix("toggleflagsActive"));
  }

  public static function prefix($name)
  {
    return ucfirst(static::$name) . ".{$name}";
  }
}
