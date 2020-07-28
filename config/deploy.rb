lock '3.14.1'

set :app_user, 'rongo'
set :application, 'main'
set :repo_url, ENV['PWD']

set :ssh_options, user: fetch(:app_user)
set :deploy_to, "/data/#{fetch(:app_user)}/apps/#{fetch(:application)}"

set :laravel_roles, :all

set :laravel_artisan_flags, "--env=#{fetch(:stage)}"

set :laravel_migration_roles, :all

set :laravel_migration_artisan_flags, "--force --env=#{fetch(:stage)}"

set :laravel_upload_dotenv_file_on_deploy, true

set :laravel_dotenv_file, './.env'

set :scm, :bundle_rsync

set :laravel_version, 7.2

set :bundle_rsync_scm, 'local_git'

set :rsync_options, '-az --delete --delete-excluded --exclude=vendor_bundle'

set :bundle_rsync_max_parallels, ENV['PARA']

set :bundle_rsync_rsync_bwlimit, ENV['BWLIMIT']

set :laravel_server_user, 'rongo'

set :laravel_ensure_linked_dirs_exist, true

set :laravel_set_linked_dirs, true

set :laravel_4_linked_dirs, [
        'app/storage/public',
        'app/storage/cache',
        'app/storage/logs',
        'app/storage/meta',
        'app/storage/sessions',
        'app/storage/views'
]

set :laravel_5_linked_dirs, [
      'storage/app',
      'storage/framework/cache',
      'storage/framework/sessions',
      'storage/framework/views',
      'storage/logs'
    ]

set :laravel_ensure_acl_paths_exist, true
set :laravel_set_acl_paths, true

set :laravel_4_acl_paths, [
      'app/storage',
      'app/storage/public',
      'app/storage/cache',
      'app/storage/logs',
      'app/storage/meta',
      'app/storage/sessions',
    ]

set :laravel_5_acl_paths, [
      'bootstrap/cache',
      'storage',
      'storage/app',
      'storage/app/public',
      'storage/framework',
      'storage/framework/cache',
      'storage/framework/sessions',
      'storage/framework/views',
      'storage/logs',
      'storage/app/public/ProductPortfolio'
    ]

namespace :laravel do

        desc 'Delete Exist Shared Linked Folder'
        task :resolve_linked_dirs_error do
                on roles fetch(:laravel_roles) do
                        fetch(:linked_dirs).each do |path|
                                within shared_path do
                                        execute :rm, '-rf', path
                                end
                        end
                end
        end

        desc 'Determine which folders, if any, to use for linked directories.'
        task :resolve_linked_dirs do
                laravel_version = fetch(:laravel_version)
                laravel_linked_dirs = fetch(:laravel_5_linked_dirs)
                laravel_linked_dirs = fetch(:laravel_4_linked_dirs) if laravel_version < 5
                if fetch(:laravel_set_linked_dirs)
                        set :linked_dirs, fetch(:linked_dirs, []).push(*laravel_linked_dirs)
                end
        end

        desc 'Ensure that linked dirs exist.'
        task :ensure_linked_dirs_exist do
                next unless fetch(:laravel_ensure_linked_dirs_exist)

                on roles fetch(:laravel_roles) do
                        fetch(:linked_dirs).each do |path|
                                within shared_path do
                                        execute :mkdir, '-p', path
                                end
                        end
                end
        end

        desc 'Determine which paths, if any, to have ACL permissions set.'
        task :resolve_acl_paths do
                next unless fetch(:laravel_set_acl_paths)
                laravel_version = fetch(:laravel_version)
                laravel_acl_paths = fetch(:laravel_5_acl_paths)
                laravel_acl_paths = fetch(:laravel_4_acl_paths) if laravel_version < 5

                set :file_permissions_paths, fetch(:file_permissions_paths, [])
                        .push(*laravel_acl_paths)
                        .uniq
                set :file_permissions_users, fetch(:file_permissions_users, [])
                        .push(fetch(:laravel_server_user))
                        .uniq
        end

        desc 'Ensure that linked dirs exist.'
        task :ensure_linked_dirs_exist do
                next unless fetch(:laravel_ensure_linked_dirs_exist)

                on roles fetch(:laravel_roles) do
                        fetch(:linked_dirs).each do |path|
                                within shared_path do
                                        execute :mkdir, '-p', path
                                end
                        end
                end
        end

        desc 'Ensure that ACL paths exist.'
        task :ensure_acl_paths_exist do
                next unless fetch(:laravel_set_acl_paths) && fetch(:laravel_ensure_acl_paths_exist)

                on roles fetch(:laravel_roles) do
                        fetch(:file_permissions_paths).each do |path|
                                within release_path do
                                        execute :mkdir, '-p', path
                                end
                        end
                end
        end

        desc 'Upload dotenv file for release.'
        task :upload_dotenv_file do
                next unless fetch(:laravel_upload_dotenv_file_on_deploy)
                next if fetch(:laravel_version) < 5

                dotenv_file = fetch(:laravel_dotenv_file)

                run_locally do
                        if dotenv_file.empty? || test("[ ! -e #{dotenv_file} ]")
                                raise Capistrano::ValidationError,
                                        "Must prepare dotenv file [#{dotenv_file}] locally before deploy!"
                        end
                end

                on roles fetch(:laravel_roles) do
                        upload! dotenv_file, "#{release_path}/.env"
                end
        end

        desc 'Execute a provided artisan command.'
        task :artisan, [:command_name] do |_t, args|
                ask(:cmd, 'list') # Ask only runs if argument is not provided
                command = args[:command_name] || fetch(:cmd)

                on roles fetch(:laravel_roles) do
			within release_path do
                                execute :php, :artisan, command, *args.extras, fetch(:laravel_artisan_flags)
                        end
                end
                Rake::Task['laravel:artisan'].reenable
        end

        desc 'Create a cache file for faster configuration loading.'
        task :config_cache do
                next if fetch(:laravel_version) < 5

                Rake::Task['laravel:artisan'].invoke('config:cache')
        end

        desc 'Create a route cache file for faster route registration.'
        task :route_cache do
                next if fetch(:laravel_version) < 5
        next if fetch(:laravel_version) < 5

                Rake::Task['laravel:artisan'].invoke('route:cache')
        end

        desc 'Optimize the framework for better performance.'
        task :optimize do
                next if fetch(:laravel_version) >= 5.5

                Rake::Task['laravel:artisan'].invoke(:optimize)
        end

        desc 'Create a symbolic link from "public/storage" to "storage/app/public."'
        task :storage_link do
                next if fetch(:laravel_version) < 5.3

                Rake::Task['laravel:artisan'].invoke('storage:link')
        end

        desc 'Routes cache clear'
        task :routes_clear do
                next if fetch(:laravel_version) < 5.3
                Rake::Task['laravel:artisan'].invoke('route:clear')
        end

        desc 'Migrate Data'
        task :migrate_data do
                next if fetch(:laravel_version) < 5.3
                Rake::Task['laravel:artisan'].invoke('migrate')
        end

        before 'deploy:starting', 'laravel:resolve_linked_dirs'
        before 'deploy:starting', 'laravel:resolve_linked_dirs_error'
        before 'deploy:starting', 'laravel:resolve_acl_paths'
        after  'deploy:starting', 'laravel:ensure_linked_dirs_exist'
        after  'deploy:updating', 'laravel:ensure_acl_paths_exist'
        before 'deploy:updated',  'deploy:set_permissions:acl'
        before 'deploy:updated',  'laravel:upload_dotenv_file'
        before 'composer:run',      'laravel:config_cache'
        after  'composer:run',    'laravel:storage_link'
        after  'deploy:updated',    'laravel:config_cache'
        #after  'deploy:updated',    'laravel:route_cache'
        after  'deploy:updated',    'laravel:routes_clear'
        #after 'deploy:updated', 'laravel:migrate_data'
end

namespace :restart do
  task :php do
    on roles(:app), in: :sequence, wait: 3 do
      execute :sudo, :systemctl, :reload, 'php-fpm'
    end
  end
end

after 'deploy:finished', 'restart:php'
