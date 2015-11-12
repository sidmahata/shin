set :application, "shin"
set :domain,      "45.63.52.40"
set :deploy_to,   "/home/admin/web/deployshin"
set :user,        "root"
set :use_sudo,    false
set :app_path,    "app"

set :repository,  "https://github.com/sidmahata/#{application}.git"
set :deploy_via,  :copy
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :shared_files,     ["app/config/parameters.yml"]
set  :shared_children,  [app_path + "/logs", web_path + "/uploads"]

set  :use_composer,   true
set  :keep_releases,  3

task :upload_parameters do
  origin_file = "app/config/parameters.yml"
  destination_file = shared_path + "/app/config/parameters.yml" # Notice the
  shared_path

  try_sudo "mkdir -p #{File.dirname(destination_file)}"
  top.upload(origin_file, destination_file)
end

after "deploy:setup", "upload_parameters"

task :change_permissions do

  try_sudo "chmod -R 777 /home/admin/web/deployshin/current/app/logs"
  try_sudo "chmod -R 777 /home/admin/web/deployshin/current/app/cache"

end

after "deploy", "change_permissions"

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL