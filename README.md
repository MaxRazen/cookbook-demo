# Cookbook Demo App

This project is built for education purposes and to prove skills of testing.
You may find some tests are redundant, but it was required by the task

## Local Deployment
1. Clone the repo using command:
```shell
git clone https://github.com/MaxRazen/cookbook-demo.git
```
2. Run next command to prepare environment files:
```shell
make docker-env
```
3. (optional) Change .env files configurations `./app/.env` or `./docker-environment/.env`
4. Start containers: `make up`
5. Stop containers: `make down`
