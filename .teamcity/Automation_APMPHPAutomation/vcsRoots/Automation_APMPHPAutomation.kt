package Automation_APMPHPAutomation.vcsRoots

import jetbrains.buildServer.configs.kotlin.v10.vcs.GitVcsRoot

object Automation_APMPHPAutomation : GitVcsRoot({
    uuid = "a7a9a3af-9978-4c78-8121-d3b6820df64f"
    extId = "Automation_APMPHPAutomation"
    name = "Automation_APMPHPAutomation"
    url = "ssh://git@bitbucket.corp.appdynamics.com:7999/ati/apm-php-automation.git"
    authMethod = uploadedKey {
        uploadedKey = "TeamCity BitBucket Key"
    }
    agentCleanPolicy = AgentCleanPolicy.ALWAYS
    branchSpec = """
        +:refs/heads/(master)
        +:refs/heads/(release/*)
        +:refs/(pull-requests/*)/from
    """.trimIndent()
})
