# Devstack

- Start devstack: `docker-compose up -d --remove-orphans devstack_app`
- Build and start devstack: `docker-compose up -d --build --remove-orphans devstack_app`
- Stop devstack: `docker-compose down --remove-orphans`
- Attach to devstack: `docker-compose run devstack_dev /bin/ash`
