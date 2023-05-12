pipeline {
    agent any
    stages {
        stage('Deploy') {
            steps {
                sshagent(['dev_api']) {
                    sh '''
                        ssh root@203.188.245.58 "cd /var/www/laravel-project && git pull && composer install"
                    '''
                }
            }
        }
    }
}
