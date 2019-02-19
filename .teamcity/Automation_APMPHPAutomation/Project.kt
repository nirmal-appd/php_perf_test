package Automation_APMPHPAutomation

import Automation_APMPHPAutomation.buildTypes.VerifyPipeline
import Automation_APMPHPAutomation.buildTypes.Automation_APMPHPAutomation_Build
import Automation_APMPHPAutomation.buildTypes.Automation_APMPHPAutomation_Publish
import Automation_APMPHPAutomation.buildTypes.Automation_APMPHPAutomation_Test
import Automation_APMPHPAutomation.vcsRoots.Automation_APMPHPAutomation
import jetbrains.buildServer.configs.kotlin.v10.Project
import jetbrains.buildServer.configs.kotlin.v10.projectFeatures.VersionedSettings.BuildSettingsMode.PREFER_SETTINGS_FROM_VCS
import jetbrains.buildServer.configs.kotlin.v10.projectFeatures.VersionedSettings.Format.KOTLIN
import jetbrains.buildServer.configs.kotlin.v10.projectFeatures.VersionedSettings.Mode.ENABLED
import jetbrains.buildServer.configs.kotlin.v10.projectFeatures.versionedSettings

object Project : Project({
    uuid = "88eefb5e-b37d-46d9-85dc-92cfdb562484"
    extId = "Automation_APMPHPAutomation"
    parentId = "Automation"
    name = "APMPHPAutomation"

    vcsRoot(Automation_APMPHPAutomation)

    buildType(VerifyPipeline)
    buildType(Automation_APMPHPAutomation_Build)
    buildType(Automation_APMPHPAutomation_Test)
    buildType(Automation_APMPHPAutomation_Publish)

    params {
        param("env.BUILD_REF_NAME", "%teamcity.build.branch%")
        param("env.BUILD_SHA", "%build.vcs.number%")
        param("env.BUILD_NUMBER", "%build.number%")
    }

    features {
        versionedSettings {
            mode = ENABLED
            buildSettingsMode = PREFER_SETTINGS_FROM_VCS
            rootExtId = Automation_APMPHPAutomation.extId
            showChanges = true
            settingsFormat = KOTLIN
            param("credentialsStorageType", "credentialsJSON")
        }
    }

    buildTypesOrder = arrayListOf(
        VerifyPipeline,
        Automation_APMPHPAutomation_Build,
        Automation_APMPHPAutomation_Test,
        Automation_APMPHPAutomation_Publish
    )
})
