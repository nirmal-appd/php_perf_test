package Automation_APMPHPAutomation.buildTypes

import jetbrains.buildServer.configs.kotlin.v10.BuildType
import jetbrains.buildServer.configs.kotlin.v10.buildSteps.exec
import Automation_APMPHPAutomation.buildTypes.BranchFilterSpec.allBranches

object Automation_APMPHPAutomation_Test : BuildType({
    uuid = "3e94304b-962f-4af0-a13a-ba723353372a"
    extId = "Automation_APMPHPAutomation_Test"
    name = "Test"

    withDefaults()
    triggerOnVcsChange(allBranches)

    steps {
        exec {
            path = "make"
            arguments = "test"
        }
    }

    runAfter(Automation_APMPHPAutomation_Build)

    publishCommitStatus()
})
