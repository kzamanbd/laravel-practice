pipeline {
    agent any
    stages {
        stage('Verify tooling') {
            steps {
                sh '''
                    docker info
                    docker version
                    docker compose version
                '''
            }
        }
        stage('Verify SSH connection to server') {
            steps {
                sshagent(credentials: ['dev_api']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no root@203.188.245.58 whoami
                    '''
                }
            }
        }
        stage('Clear all running docker containers') {
            steps {
                script {
                    try {
                        sh 'docker rm -f $(docker ps -a -q)'
                    } catch (Exception e) {
                        echo 'No running container to clear up...'
                    }
                }
            }
        }
        stage('Start Docker') {
            steps {
                sh 'make up'
                sh 'docker compose ps'
            }
        }
        stage('Run Composer Install') {
            steps {
                sh 'docker compose run --rm composer install'
            }
        }
        stage('Populate .env file') {
            steps {
                dir('/var/lib/jenkins/workspace/envs/laravel-test') {
                    fileOperations([fileCopyOperation(excludes: '', flattenFiles: true, includes: '.env', targetLocation: "${WORKSPACE}")])
                }
            }
        }
        stage('Run Tests') {
            steps {
                sh 'docker compose run --rm artisan test'
            }
        }
    }
}
