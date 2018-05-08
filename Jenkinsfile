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
    stage('Sitemap') {
      parallel {
        stage('Sitemap') {
          steps {
            sh '''sitemapContent=`curl -Is "http://nueva.preciosahomes.com/sitemap.xml" | head -1`
if [[ $sitemapContent != *"200"* ]]; then
    echo "No sitemap file found"
    exit 1
fi'''
          }
        }
        stage('Robots') {
          steps {
            sh '''sitemapContent=`curl -Is "http://nueva.preciosahomes.com/robots.txt" | head -1`
if [[ $sitemapContent != *"200"* ]]; then
    echo "No sitemap file found"
    exit 1
fi'''
          }
        }
      }
    }
    stage('Clean') {
      steps {
        sleep 5
        sleep 1
      }
    }
  }
}