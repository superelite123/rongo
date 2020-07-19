# -*- encoding: utf-8 -*-
# stub: capistrano-bundle_rsync 0.5.2 ruby lib

Gem::Specification.new do |s|
  s.name = "capistrano-bundle_rsync".freeze
  s.version = "0.5.2"

  s.required_rubygems_version = Gem::Requirement.new(">= 0".freeze) if s.respond_to? :required_rubygems_version=
  s.require_paths = ["lib".freeze]
  s.authors = ["Naotoshi Seo".freeze, "tohae".freeze]
  s.date = "2019-02-14"
  s.description = "Deploy an application and bundled gems via rsync".freeze
  s.email = ["sonots@gmail.com".freeze, "tohaechan@gmail.com".freeze]
  s.homepage = "https://github.com/sonots/capistrano-bundle_rsync".freeze
  s.licenses = ["MIT".freeze]
  s.rubygems_version = "3.1.2".freeze
  s.summary = "Deploy an application and bundled gems via rsync.".freeze

  s.installed_by_version = "3.1.2" if s.respond_to? :installed_by_version

  if s.respond_to? :specification_version then
    s.specification_version = 4
  end

  if s.respond_to? :add_runtime_dependency then
    s.add_runtime_dependency(%q<capistrano>.freeze, [">= 3.3.3"])
    s.add_runtime_dependency(%q<parallel>.freeze, [">= 0"])
    s.add_development_dependency(%q<bundler>.freeze, ["~> 1.3"])
    s.add_development_dependency(%q<rake>.freeze, [">= 0"])
    s.add_development_dependency(%q<rspec>.freeze, ["~> 3"])
  else
    s.add_dependency(%q<capistrano>.freeze, [">= 3.3.3"])
    s.add_dependency(%q<parallel>.freeze, [">= 0"])
    s.add_dependency(%q<bundler>.freeze, ["~> 1.3"])
    s.add_dependency(%q<rake>.freeze, [">= 0"])
    s.add_dependency(%q<rspec>.freeze, ["~> 3"])
  end
end
