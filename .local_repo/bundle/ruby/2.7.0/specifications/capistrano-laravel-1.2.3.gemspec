# -*- encoding: utf-8 -*-
# stub: capistrano-laravel 1.2.3 ruby lib

Gem::Specification.new do |s|
  s.name = "capistrano-laravel".freeze
  s.version = "1.2.3"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Peter Mitchell".freeze, "Andrew Miller".freeze]
  s.bindir = "exe".freeze
  s.date = "2020-01-28"
  s.description = "Laravel deployment for Capistrano 3.x".freeze
  s.email = ["peterjmit@gmail.com".freeze, "ikari7789@yahoo.com".freeze]
  s.homepage = "https://github.com/capistrano/laravel".freeze
  s.licenses = ["MIT".freeze]
  s.required_ruby_version = Gem::Requirement.new(">= 2.3.0".freeze)
  s.rubygems_version = "3.1.2".freeze
  s.summary = "Laravel specific deployment options for Capistrano 3.x".freeze

  s.installed_by_version = "3.1.2" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4
  end

  if s.respond_to? :add_runtime_dependency then
    s.add_runtime_dependency(%q<capistrano>.freeze, [">= 3.0.0"])
    s.add_runtime_dependency(%q<capistrano-composer>.freeze, [">= 0.0.6"])
    s.add_runtime_dependency(%q<capistrano-file-permissions>.freeze, [">= 1.0.0"])
    s.add_development_dependency(%q<bundler>.freeze, [">= 0"])
    s.add_development_dependency(%q<rake>.freeze, [">= 10.0.0"])
    s.add_development_dependency(%q<rspec>.freeze, [">= 0"])
    s.add_development_dependency(%q<rubocop>.freeze, [">= 0"])
  else
    s.add_dependency(%q<capistrano>.freeze, [">= 3.0.0"])
    s.add_dependency(%q<capistrano-composer>.freeze, [">= 0.0.6"])
    s.add_dependency(%q<capistrano-file-permissions>.freeze, [">= 1.0.0"])
    s.add_dependency(%q<bundler>.freeze, [">= 0"])
    s.add_dependency(%q<rake>.freeze, [">= 10.0.0"])
    s.add_dependency(%q<rspec>.freeze, [">= 0"])
    s.add_dependency(%q<rubocop>.freeze, [">= 0"])
  end
end
