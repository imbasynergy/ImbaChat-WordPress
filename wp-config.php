<?php
define('WP_CACHE', true);
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'imbademo_wordpress_db' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'imbademo_wordpress' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '8MCsLC4vSCHJY5YT' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ' 6CPj=>UyY(w`0:@%L1_]PO+/jVyo`p~1SmL|TWRUM+^Q{cg@_O9l_W_3KXo^b%m' );
define( 'SECURE_AUTH_KEY',  'uCJz+gI${Fq{_/lVzRA(TPgR>ziiMN3MXg}Rm~av]gn5(=](6/i%81TSZlg.R:Wk' );
define( 'LOGGED_IN_KEY',    '~Zw16HNf @p.)kJ4ZZTKKq?YF`F8=&T+`|^ou-In:In}@:-?1y<t<,]w_h?y:r*1' );
define( 'NONCE_KEY',        'pNk!wK%I8en79oN}9kN9Ps]Y.hb lTE2x-u2AK:<++A3RU0C$%=GG;?kiQ5Ef;=I' );
define( 'AUTH_SALT',        '-N:hWU/lVm?`~dlJNYUY/S-pZG!&e443M7*JlB9l5<E>/3!U<jA3 p}h<LW; }@6' );
define( 'SECURE_AUTH_SALT', '%d]WZ7fPGC1K-+Cbce&Up#YZ8qHimIrnlUunHd5E=qf}5/!Vf,|XGe@@%TGPbQ[ ' );
define( 'LOGGED_IN_SALT',   '_a5y|[B<IqwBmn$btLa%!pb btdTFgiE.%8|LRZPNx UEms&K;p.sR/p>Q(`)y.v' );
define( 'NONCE_SALT',       '9J&OlMJ7q#Z]vW]S]*sV3<Y99t1C*l4Zd#]B<GhW2}+1*e;q8i`KD,WL5?k3X{#k' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'imbademo_wordpress_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
