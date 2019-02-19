package Automation_APMPHPAutomation.buildTypes

import Automation_APMPHPAutomation.buildTypes.BranchFilterSpec.releaseBranches
import Automation_APMPHPAutomation.vcsRoots.Automation_APMPHPAutomation
import jetbrains.buildServer.configs.kotlin.v10.BuildType
import jetbrains.buildServer.configs.kotlin.v10.buildFeatures.vcsLabeling
import jetbrains.buildServer.configs.kotlin.v10.buildSteps.exec

object Automation_APMPHPAutomation_Publish : BuildType({
    uuid = "cc21306c-957f-43c5-905a-ea6e375a6807"
    extId = "Automation_APMPHPAutomation_Publish"
    name = "Publish"

    enablePersonalBuilds = false

    withDefaults()

    triggerOnVcsChange(releaseBranches)

    steps {
        exec {
            path = "make"
            arguments = "publish"
        }
    }

    runAfter(Automation_APMPHPAutomation_Test)

    features {
        vcsLabeling {
            vcsRootExtId = Automation_APMPHPAutomation.extId
            labelingPattern = "%system.build.number%"
            successfulOnly = true
            branchFilter = releaseBranches
        }
    }
})
