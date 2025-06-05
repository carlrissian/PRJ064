pipeline {
     agent any

     environment {
         PRE_PROD_URL = "/var/www/${env.JOB_NAME}"
     }

    stages {
        stage('Build') {
            steps{
                sh 'composer install'
                sh 'yarn install'
                sh 'yarn js-routing'
                sh 'yarn dev'
            }
        }

        stage('Deploy on Pre') {
            steps{
                sh "sudo rsync -a --delete  ${env.WORKSPACE}/ ${PRE_PROD_URL}"
                sh "sudo chmod -R 775 ${PRE_PROD_URL}"
                sh "sudo chown -R www-data:www-data ${PRE_PROD_URL}"
                //sh "sudo php bin/console cache:clear"
                //sh "sudo chown -R www-data:www-data ${PRE_PROD_URL}/var/log"
                //sh "sudo chown -R www-data:www-data ${PRE_PROD_URL}/var/cache"
                //sh 'sudo rm -fr ${PRE_PROD_URL}/var/cache/*'
                //sh 'sudo rm -fr ${PRE_PROD_URL}/var/log/*'
                //sh 'sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx ${PRE_PROD_URL}/var/cache ${PRE_PROD_URL}/var/log'
                //sh 'sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx ${PRE_PROD_URL}/var/cache ${PRE_PROD_URL}/var/log'
            }
        }
    }
}
