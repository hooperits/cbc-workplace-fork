<?php

return [
  ["id" => "adm", "parent" => "#", "text" => "Administración"],
  ["id" => "app", "parent" => "#", "text" => "Aplicación"],

  ["id" => "Role", "parent" => "adm", "text" => "Roles"],
  ["id" => "Role.viewAny", "parent" => "Role", "text" => "Listar"],
  ["id" => "Role.create", "parent" => "Role", "text" => "Agregar"],
  ["id" => "Role.view", "parent" => "Role", "text" => "Ver"],
  ["id" => "Role.update", "parent" => "Role", "text" => "Editar"],
  ["id" => "Role.delete", "parent" => "Role", "text" => "Eliminar"],
  ["id" => "Role.toggleflag-active", "parent" => "Role", "text" => "Alternar Activo"],
  ["id" => "Role.toggleflag-blocked", "parent" => "Role", "text" => "Alternar Admin"],

  ["id" => "User", "parent" => "adm", "text" => "Usuarios"],
  ["id" => "User.viewAny", "parent" => "User", "text" => "Listar"],
  ["id" => "User.create", "parent" => "User", "text" => "Agregar"],
  ["id" => "User.view", "parent" => "User", "text" => "Ver"],
  ["id" => "User.update", "parent" => "User", "text" => "Editar"],
  ["id" => "User.delete", "parent" => "User", "text" => "Eliminar"],
  ["id" => "User.toggleflag-active", "parent" => "User", "text" => "Alternar Activo"],
  ["id" => "User.toggleflag-blocked", "parent" => "User", "text" => "Alternar Bloqueado"],
  ["id" => "User.set-password", "parent" => "User", "text" => "Fijar Contraseña"],

  ["id" => "Config", "parent" => "adm", "text" => "Configuración"],
  ["id" => "Config.viewAny", "parent" => "Config", "text" => "Listar"],
  ["id" => "Config.view", "parent" => "Config", "text" => "Ver"],
  ["id" => "Config.update", "parent" => "Config", "text" => "Editar"],

  ["id" => "Member", "parent" => "app", "text" => "Miembros"],
  ["id" => "Member.viewAny", "parent" => "Member", "text" => "Listar"],
  ["id" => "Member.view", "parent" => "Member", "text" => "Ver"],
  ["id" => "Member.delete", "parent" => "Member", "text" => "Eliminar"],
  ["id" => "Member.approve-membership", "parent" => "Member", "text" => "Aprobar Membresia"],

  ["id" => "Venture", "parent" => "app", "text" => "Emprendimientos"],
  ["id" => "Venture.viewAny", "parent" => "Venture", "text" => "Listar"],
  ["id" => "Venture.view", "parent" => "Venture", "text" => "Ver"],
  ["id" => "Venture.delete", "parent" => "Venture", "text" => "Eliminar"],
  ["id" => "Venture.approve-venture", "parent" => "Venture", "text" => "Aprobar Emprendimiento"],
  ["id" => "Venture.force-reject-venture", "parent" => "Venture", "text" => "Desaprobar Emprendimiento"],
];
