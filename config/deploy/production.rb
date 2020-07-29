require 'aws-sdk'

ec2 = Aws::EC2::Client.new(
  region: 'ap-northeast-1'
)

app_instances = []
ec2.describe_instances({
  filters: [
    { name: 'tag:Environment', values: ['prd'] },
    { name: 'tag:System',      values: ['live'] },
    { name: 'tag:Roles',       values: ['app'] },
  ]
}).reservations.each do |ec2|
  ec2.instances.each do |m|
    app_instances << m.private_ip_address if m.state.name.include?('running')
  end
end

role :app, app_instances
