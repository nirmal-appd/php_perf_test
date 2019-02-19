package Automation_APMPHPAutomation.buildTypes

import Automation_APMPHPAutomation.vcsRoots.Automation_APMPHPAutomation
import jetbrains.buildServer.configs.kotlin.v10.BuildType
import jetbrains.buildServer.configs.kotlin.v10.FailureAction
import jetbrains.buildServer.configs.kotlin.v10.buildFeatures.commitStatusPublisher
import jetbrains.buildServer.configs.kotlin.v10.triggers.vcs

fun BuildType.publishCommitStatus() {
    features {
        commitStatusPublisher {
            vcsRootExtId = Automation_APMPHPAutomation.extId
            publisher = bitbucketServer {
                url = "%env.BITBUCKET_SERVER%"
                userName = "%env.BITBUCKET_USERNAME%"
                password = "%env.BITBUCKET_PASSWORD%"
            }
        }
    }
}

fun BuildType.triggerOnVcsChange(branchFilterSpec : String) {
    triggers {
        vcs {
            branchFilter = branchFilterSpec
        }
    }
}

fun BuildType.withDefaults() {
    vcs {
        root(Automation_APMPHPAutomation)
        cleanCheckout = true
    }

    requirements {
        matches("env.AGENT_OS", "Linux")
    }
}

fun BuildType.runAfter(buildTypes: List<BuildType>) {
    buildTypes.forEach {
        this.dependencies.dependency(it) {
            snapshot {
                onDependencyFailure = FailureAction.FAIL_TO_START
            }
        }
    }
}

fun BuildType.runAfter(buildType: BuildType) {
    runAfter(listOf(buildType))
}

object BranchFilterSpec {
    val allBranches = """
    +:*
    """.trimIndent()

    val masterBranch = """
    +:master
    """.trimIndent()

    val releaseBranches = """
    +:master
    +:release/*
    """.trimIndent()
}
