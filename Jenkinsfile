#!/usr/bin/env groovy

/* Comments */


//TODO: then build parallel array thingy, then unstash
// println(plugins[0].get("dest")) plugins.size()
def plugins = [
    [
        "name" : 'theme_saylor',
        "url" : 'https://github.com/saylordotorg/moodle-theme_saylor.git',
        "branch" : env.BRANCH_NAME,
        "dest" : 'theme/saylor'
    ],
    [
        "name" : 'mod_journal',
        "url" : 'https://github.com/dmonllao/moodle-mod_journal.git',
        "branch" : 'MOODLE_31_STABLE',
        "dest" : 'mod/journal'
    ]

]

def StashMoodle() {
    moodleJob = [
        "moodle" : (
            node {
                git([url: 'https://github.com/moodle/moodle.git', branch: 'MOODLE_31_STABLE'])
                stash([name: 'moodle'])
            }
            )
    ]

}

def StashPlugins(plugins) {
    for (int i = 0; i < plugins.size(); i++) {
        def integer = i
        node {
            git([url: (plugins[integer].get("url")), branch: (plugins[integer].get("branch"))])
            echo("Stashing: ${plugins[integer].get("name")}")
            stash([name: (plugins[integer].get("name"))])
        }
    }
}

def BuildPluginsJobs(plugins) {
    def pluginsJobs = ""
    for (int i = 0; i < plugins.size(); i++) {
        def integer = i
        pluginJobs = pluginJobs + """\"${plugins[integer].get("name")}\" : (
                node {
                    git([url: ${plugins[integer].get("url")}, branch: ${plugins[integer].get("branch")}])
                    echo(\"Stashing:${plugins[integer].get("name")}\")
                    stash([name: ${plugins[integer].get("name")}])
                    echo(\"Integer: ${integer}\")
                }
            )
        ],"""

    }

    pluginsJobs = pluginsJobs.substring(0, pluginsJobs.length() - 1)

    return pluginsJobs
}

try {
    stage('Stash Repos') {
        echo("Beginning stashing operations")

        StashMoodle()
        //StashPlugins(plugins)

        pluginJobs = BuildPluginsJobs(plugins)
        echo("${pluginJobs}")

        parallel ("${pluginJobs}")

        echo("Finished stashing operations")
    }
    stage('Build') {
        node {
            echo("Checking out SCM")
            checkout scm

            echo("Beginning unstash operations")
            unstash name: 'moodle'

            sh 'mkdir -p theme/saylor'
            dir("theme/saylor") {
                unstash name: 'theme_saylor'
            }

            sh 'mkdir -p mod/journal'
            dir("mod/journal") {
                unstash name: 'mod_journal'
            }

        }

    }  
}

catch (exc) {
    echo "Caught: ${exc}"
}