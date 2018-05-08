pipeline {
  agent any
  stages {
    stage('Clone') {
      parallel {
        stage('Clone') {
          steps {
            sh 'composer install'
          }
        }
        stage('Npm') {
          steps {
            sh 'npm install'
          }
        }
      }
    }
    stage('Migrations') {
      steps {
        sh 'php artisan migrate:refresh --seed'
      }
    }
  }
}