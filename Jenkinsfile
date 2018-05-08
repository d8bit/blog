pipeline {
  agent any
  stages {
    stage('Clone') {
      steps {
        sh 'composer install'
      }
    }
    stage('Migrations') {
      steps {
        sh 'php artisan migrate:refresh --seed'
      }
    }
  }
}