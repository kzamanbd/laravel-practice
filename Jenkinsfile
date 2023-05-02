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
                sshagent(credentials: ['github']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ec2-user@13.40.116.143 whoami
                    '''
                }
            }
        }
    }
}
