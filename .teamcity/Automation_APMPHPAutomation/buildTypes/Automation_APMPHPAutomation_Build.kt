package Automation_APMPHPAutomation.buildTypes

import jetbrains.buildServer.configs.kotlin.v10.BuildType
import jetbrains.buildServer.configs.kotlin.v10.buildSteps.exec
import jetbrains.buildServer.configs.kotlin.v10.triggers.vcs

object Automation_APMPHPAutomation_Build : BuildType({
    uuid = "c84748fc-69a8-4d7c-84d8-34db8c3fba31"
    extId = "Automation_APMPHPAutomation_Build"
    name = "Build"

    withDefaults()

    steps {
        exec {
            path = "make"
            arguments = "set-build-version"
        }
        exec {
            path = "make"
            arguments = "build"
        }
    }

    publishCommitStatus()

})
