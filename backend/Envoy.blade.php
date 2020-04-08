@setup
$repo = 'https://github.com/tolbertdesign/system';
$branch = 'develop';
$server = 'gentle-breeze';
$site = 'tolbert.design';
$release_dir = '/home/forge/releases/' . $site;
$app_dir = '/home/forge/' . $site;
$release = 'release_' . date('Y-md-Hi-s');
function logMessage($message) {
    return "echo '\033[32m" .$message. "\033[0m';\n";
}
@endsetup

@servers(['local' => 'localhost', 'remote' => $server])

@macro('deploy', ['on' => 'remote'])
fetch_repo
run_composer
update_permissions
update_symlinks
@endmacro

@task('fetch_repo')
{{ logMessage("🌀  Fetching repository…") }}
[ -d {{ $release_dir }} ] || mkdir -p {{ $release_dir }}
cd {{ $release_dir }}
git clone --branch {{ $branch }} {{ $repo }} {{ $release }}
@endtask

@task('run_composer')
{{ logMessage("🚚  Running Composer…") }}
cd {{ $release_dir }}/{{ $release }}
composer install --prefer-dist --no-scripts;
php artisan clear-compiled --env=production;
@endtask

@task('run_yarn', ['on' => 'remote'])
{{ logMessage("📦  Running Yarn…") }}
cd {{ $release_dir }}/{{ $release }}
yarn config set ignore-engines true
yarn
@endtask

@task('generate_assets', ['on' => 'remote'])
{{ logMessage("🌅  Generating assets…") }}
cd {{ $release_dir }}/{{ $release }}
yarn run production -- --progress false
@endtask

@task('update_permissions')
{{ logMessage("🔑  Updating permissions…") }}
cd {{ $release_dir }}
chgrp -R www-data {{ $release }}
chmod -R ug+rxw {{ $release }}
@endtask

@task('update_symlinks')
{{ logMessage("🔗  Updating symlinks…") }}
ln -nfs {{ $release_dir }}/{{ $release }} {{ $app_dir }}
chgrp -h www-data {{ $app_dir }}

cd {{ $release_dir }}/{{ $release }};
ln -nfs ../../.env .env;
chgrp -h www-data .env;

rm -r {{ $release_dir }}/{{ $release }}/storage/logs;
cd {{ $release_dir }}/{{ $release }}/storage;
ln -nfs ../../logs logs;
chgrp -h www-data logs;

sudo -S service php7.4-fpm reload;
@endtask
