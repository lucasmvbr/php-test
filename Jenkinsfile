node {
    def app
    def db
    stage('Initialize'){
        def dockerHome = tool 'myDocker'
        env.PATH = "${dockerHome}/bin:${env.PATH}"
    
    }
    
    stage('Clone repository') {
        /* Let's make sure we have the repository cloned to our workspace */

        checkout scm
    }

    stage('Build image') {
        /* This builds the actual image; synonymous to
         * docker build on the command line */

        app = docker.build("repository.lab.local:5000/php:latest", "./php")
        db = docker.build("repository.lab.local:5000/db:latest", "./db")
    }

    stage('Push image') {
        /* Finally, we'll push the image with two tags:
         * First, the incremental build number from Jenkins
         * Second, the 'latest' tag.
         * Pushing multiple tags is cheap, as all the layers are reused. */
        docker.withRegistry('https://repository.lab.local:5000') {
            db.push("${env.BUILD_NUMBER}")
            db.push("latest")
            app.push("${env.BUILD_NUMBER}")
            app.push("latest")
        }
    }

    stage('update pod') {
          sh "sed -i  's/repository.lab.local:5000\\/php/repository.lab.local:5000\\/php:${env.BUILD_NUMBER}/g' php.yaml"
          sh "sed -i  's/repository.lab.local:5000\\/db/repository.lab.local:5000\\/db:${env.BUILD_NUMBER}/g' mariadb.yaml"
          withKubeConfig([credentialsId: 'k8s-cred',
                    clusterName: 'kubernates',
                    serverUrl: 'https://192.168.40.10:6443',
                    namespace: 'default'
                    ]) {
          sh 'kubectl apply -f mariadb.yaml'
          sh 'kubectl apply -f php.yaml'
    }
  }

}
