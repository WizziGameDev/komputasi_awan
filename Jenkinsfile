pipeline {
    agent any  
    environment {
        DOCKER_IMAGE = "tubes_komputasi"  
        DOCKER_REGISTRY = 'docker.io' 
        DOCKER_REPO = 'risqifirdianzah/tubes_komputasi' 
        DOCKER_CREDENTIALS = 'risqifirdianzah' 
    }

    stages {
        stage('Git Checkout') {
            steps {
                git branch: 'main', changelog: false, poll: false, url: 'https://github.com/enzz3e/Tubes_Komputasi'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    docker.build("${DOCKER_IMAGE}", ".")
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                   docker.withRegistry('', 'risqifirdianzah') {
                        docker.image("${DOCKER_REPO}:latest").push()
                    }

                }
            }
        }
    }
}
