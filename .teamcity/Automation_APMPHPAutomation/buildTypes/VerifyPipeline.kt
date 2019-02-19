package Automation_APMPHPAutomation.buildTypes

import jetbrains.buildServer.configs.kotlin.v10.BuildType

object VerifyPipeline : BuildType({
    template = "VerifyPipeline"
    uuid = "e01bdc78-bb77-424f-853c-00cd7717cbb6"
    extId = "Automation_APMPHPAutomation_VerifyPipeline"
    name = "TeamCity Pipeline"
    description = "Verify TeamCity Pipeline"

    withDefaults()

    publishCommitStatus()
})
