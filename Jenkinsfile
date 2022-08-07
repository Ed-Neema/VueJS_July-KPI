pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        script {
          dockerImage = docker.build (imagename, '--build-arg BUILD_ENV="PRD" .')
        }

      }
    }

    stage('Test') {
      steps {
        script {
          dockerImage.inside('-u root:root -v ${WORKSPACE}:/home/www') {
            sh '(cd /home/www/ && ls && composer install)'
            sh '(cd /home/www/project/laravel && ls && composer install)'
            sh '(cd /home/www && vendor/bin/phing build)'
          }
        }

      }
    }

    stage('Push') {
      when {
        anyOf {
          branch 'develop'
          branch 'master'
        }

      }
      steps {
        script {
          docker.withRegistry(registryUrl, registryCredential ) {
            dockerImage.push("${env.BRANCH_NAME}")
          }
        }

      }
    }

    stage('Deploy UAT') {
      when {
        anyOf {
          branch 'develop'
          branch 'master'
        }
      }
      steps {
        script {
          final String url = deployNotificationUrl
          final String response = sh(script: "curl -X POST -s $url", returnStdout: true).trim()
          echo response
        }

      }
    }

    stage('Clean Up') {
      steps {
        sh "docker rmi $imagename"
      }
    }

  }
  environment {
    imagename = "enqmanager/web:${env.BRANCH_NAME.replace("/", "-")}"
    registryUrl = 'https://docker-registry.teamup.lk'
    registryCredential = '89aeb4fc-9319-46e0-8c51-fc733e076ffe'
    deployNotificationUrl = 'http://teamup.lk:9000/api/webhooks/09e11bb6-0925-421e-b9fb-bf82a4dddb00'
    discordWebhook = 'https://discord.com/api/webhooks/980934580435570728/VO7nLBSi0H1fQjYNf-gz1H_9Ft_N_Nd7OnZWNj-vsu77YqsWMTwOLPH73vV43s3FXxyy'
    dockerImage = ''
  }
  post {
    always {
      discordSend description: "Build was a ${currentBuild.currentResult}", link: env.BUILD_URL, result: currentBuild.currentResult, title: JOB_NAME, webhookURL: discordWebhook
      cleanWs()
    }

  }
}