 /*2014_10_10_223327_create_permission_tables */
   create table `permissions` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `guard_name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';  
   alter table `permissions` add unique `permissions_name_guard_name_unique`(`name`, `guard_name`)  ;
   create table `roles` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `guard_name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';  
   alter table `roles` add unique `roles_name_guard_name_unique`(`name`, `guard_name`)  ;
   create table `model_has_permissions` (`permission_id` bigint unsigned not null, `model_type` varchar(255) not null, `model_id` bigint unsigned not null, primary key (`permission_id`, `model_id`, `model_type`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';  
   alter table `model_has_permissions` add index `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`)  ;
   alter table `model_has_permissions` add constraint `model_has_permissions_permission_id_foreign` foreign key (`permission_id`) references `permissions` (`id`) on delete cascade ;
   create table `model_has_roles` (`role_id` bigint unsigned not null, `model_type` varchar(255) not null, `model_id` bigint unsigned not null, primary key (`role_id`, `model_id`, `model_type`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci' ;
   alter table `model_has_roles` add index `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`)  ;
   alter table `model_has_roles` add constraint `model_has_roles_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade ;
   create table `role_has_permissions` (`permission_id` bigint unsigned not null, `role_id` bigint unsigned not null, primary key (`permission_id`, `role_id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci' ;
   alter table `role_has_permissions` add constraint `role_has_permissions_permission_id_foreign` foreign key (`permission_id`) references `permissions` (`id`) on delete cascade  ;
   alter table `role_has_permissions` add constraint `role_has_permissions_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade  ;
  /*2014_10_12_000000_create_users_table */
   create table `users` (`id` bigint not null, `name` varchar(255) not null, `tipo_doc` varchar(10) not null, `tel` varchar(11) not null, `fecha_naci` date not null, `genero` varchar(50) not null, `direccion` varchar(50) not null, `email` varchar(255) not null, `email_verified_at` timestamp null, `password` varchar(255) not null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci' ;
   alter table `users` add unique `users_id_unique`(`id`)  ;
   alter table `users` add unique `users_email_unique`(`email`) ;
  /*2014_10_12_100000_create_password_reset_tokens_table */
   create table `password_reset_tokens` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null, primary key (`email`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
  /*2016_06_01_000001_create_oauth_auth_codes_table */
   create table `oauth_auth_codes` (`id` varchar(100) not null, `user_id` bigint unsigned not null, `client_id` char(36) not null, `scopes` text null, `revoked` tinyint(1) not null, `expires_at` datetime null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';  
   alter table `oauth_auth_codes` add index `oauth_auth_codes_user_id_index`(`user_id`);  
  /*2016_06_01_000002_create_oauth_access_tokens_table */
   create table `oauth_access_tokens` (`id` varchar(100) not null, `user_id` bigint unsigned null, `client_id` char(36) not null, `name` varchar(255) null, `scopes` text null, `revoked` tinyint(1) not null, `created_at` timestamp null, `updated_at` timestamp null, `expires_at` datetime null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';  
   alter table `oauth_access_tokens` add index `oauth_access_tokens_user_id_index`(`user_id`) ;
  /*2016_06_01_000003_create_oauth_refresh_tokens_table */
   create table `oauth_refresh_tokens` (`id` varchar(100) not null, `access_token_id` varchar(100) not null, `revoked` tinyint(1) not null, `expires_at` datetime null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `oauth_refresh_tokens` add index `oauth_refresh_tokens_access_token_id_index`(`access_token_id`)  ;
  /*2016_06_01_000004_create_oauth_clients_table */
   create table `oauth_clients` (`id` char(36) not null, `user_id` bigint unsigned null, `name` varchar(255) not null, `secret` varchar(100) null, `provider` varchar(255) null, `redirect` text not null, `personal_access_client` tinyint(1) not null, `password_client` tinyint(1) not null, `revoked` tinyint(1) not null, `created_at` timestamp null, `updated_at` timestamp null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci' ; 
   alter table `oauth_clients` add index `oauth_clients_user_id_index`(`user_id`)  ;
  /*2016_06_01_000005_create_oauth_personal_access_clients_table */
   create table `oauth_personal_access_clients` (`id` bigint unsigned not null auto_increment primary key, `client_id` char(36) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci' ;
  /*2019_08_19_000000_create_failed_jobs_table */
   create table `failed_jobs` (`id` bigint unsigned not null auto_increment primary key, `uuid` varchar(255) not null, `connection` text not null, `queue` text not null, `payload` longtext not null, `exception` longtext not null, `failed_at` timestamp not null default CURRENT_TIMESTAMP) default character set utf8mb4 collate 'utf8mb4_unicode_ci' ;
   alter table `failed_jobs` add unique `failed_jobs_uuid_unique`(`uuid`);  
  /*2019_12_14_000001_create_personal_access_tokens_table */
   create table `personal_access_tokens` (`id` bigint unsigned not null auto_increment primary key, `tokenable_type` varchar(255) not null, `tokenable_id` bigint unsigned not null, `name` varchar(255) not null, `token` varchar(64) not null, `abilities` text null, `last_used_at` timestamp null, `expires_at` timestamp null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `personal_access_tokens` add index `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`)  ;
   alter table `personal_access_tokens` add unique `personal_access_tokens_token_unique`(`token`) ;
  /*2024_05_17_161558_create_images_table */
   create table `images` (`id` bigint unsigned not null auto_increment primary key, `imageable_type` varchar(255) not null, `imageable_id` bigint unsigned not null, `path` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `images` add index `images_imageable_type_imageable_id_index`(`imageable_type`, `imageable_id`)  ;
  /*2024_05_17_161559_create_categorias_table */
   create table `categorias` (`id` bigint unsigned not null auto_increment primary key, `nombre_cat` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
  /*2024_05_17_161560_create_productos_table */
   create table `productos` (`id` bigint unsigned not null auto_increment primary key, `nom_producto` varchar(50) not null, `precio_producto` int not null, `detalle` varchar(255) not null, `codigo` varchar(10) not null, `created_at` timestamp null, `updated_at` timestamp null, `categoria_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `productos` add constraint `productos_categoria_id_foreign` foreign key (`categoria_id`) references `categorias` (`id`) on delete restrict  ;
  /*2024_05_17_161561_create_promociones_table */
   create table `promociones` (`id` bigint unsigned not null auto_increment primary key, `nom_promo` varchar(50) not null, `total_promo` int not null, `created_at` timestamp null, `updated_at` timestamp null, `categoria_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `promociones` add constraint `promociones_categoria_id_foreign` foreign key (`categoria_id`) references `categorias` (`id`) on delete set null  ;
  /*2024_05_17_161820_create_detpromociones_table */
   create table `detpromociones` (`id` bigint unsigned not null auto_increment primary key, `cantidad` int not null, `descuento` int not null, `subtotal` int not null, `created_at` timestamp null, `updated_at` timestamp null, `promocione_id` bigint unsigned null, `producto_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `detpromociones` add constraint `detpromociones_promocione_id_foreign` foreign key (`promocione_id`) references `promociones` (`id`) on delete cascade ;
   alter table `detpromociones` add constraint `detpromociones_producto_id_foreign` foreign key (`producto_id`) references `productos` (`id`) on delete cascade  ;
  /*2024_05_17_161929_create_ventas_table */
   create table `ventas` (`id` bigint unsigned not null auto_increment primary key, `metodo_pago` varchar(20) not null, `estado` tinyint(1) not null default '0', `total` int null, `created_at` timestamp null, `updated_at` timestamp null, `user_id` bigint not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `ventas` add constraint `ventas_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete restrict  ;
  /*2024_05_17_161930_create_detventas_table */
   create table `detventas` (`id` bigint unsigned not null auto_increment primary key, `nom_producto` varchar(50) not null, `pre_producto` int not null, `cantidad` int not null, `subtotal` int not null, `created_at` timestamp null, `updated_at` timestamp null, `venta_id` bigint unsigned null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';  
   alter table `detventas` add constraint `detventas_venta_id_foreign` foreign key (`venta_id`) references `ventas` (`id`) on delete restrict  ;
  /*2024_05_17_162051_create_matprimas_table */
   create table `matprimas` (`id` bigint unsigned not null auto_increment primary key, `referencia` varchar(50) not null, `descripcion` varchar(255) not null, `existencia` int not null, `entrada` int not null, `salida` int not null, `stock` int not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
  /*2024_05_17_162303_create_pqrs_table */
   create table `pqrs` (`id` bigint unsigned not null auto_increment primary key, `sugerencia` text not null, `tipo_suge` varchar(20) not null, `estado` varchar(20) not null, `created_at` timestamp null, `updated_at` timestamp null, `user_id` bigint not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `pqrs` add constraint `pqrs_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete restrict  ;
  /*2024_05_17_162452_create_proveedores_table */
   create table `proveedores` (`id` bigint unsigned not null auto_increment primary key, `codigo` int not null, `nombre` varchar(50) not null, `telefono` varchar(50) not null, `direccion` varchar(50) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  ;
   alter table `proveedores` add unique `proveedores_codigo_unique`(`codigo`)  ;

