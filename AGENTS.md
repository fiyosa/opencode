# AGENTS.md

This file provides guidance to AI coding agents working with code in this repository, using OpenCode.

## Repository Overview

This project uses skills from addyosmani/agent-skills to guide senior-engineer-grade development workflows.

## OpenCode Integration

OpenCode uses a **skill-driven execution model**. Skills live in `.opencode/skills/`, reference checklists live in `.opencode/references/`, and custom slash commands live in `.opencode/commands/`.

### Core Rules

- If a task matches a skill, you MUST invoke it
- Skills are located in `.opencode/skills/<skill-name>/SKILL.md`
- Never implement directly if a skill applies
- Always follow the skill instructions exactly (do not partially apply them)

### Path Resolution

All skill, agent, and reference paths mentioned inside SKILL.md or command files are relative to `.opencode/`. For example, a reference to `references/security-checklist.md` resolves to `.opencode/references/security-checklist.md`.

### Intent → Skill Mapping

The agent should automatically map user intent to skills, even without a slash command:

- Feature / new functionality → `spec-driven-development`, then `incremental-implementation`, `test-driven-development`
- Planning / breakdown → `planning-and-task-breakdown`
- Bug / failure / unexpected behavior → `debugging-and-error-recovery`
- Code review → `code-review-and-quality`
- Refactoring / simplification → `code-simplification`
- API or interface design → `api-and-interface-design`
- UI work → `frontend-ui-engineering`

### Slash Commands

This project has custom slash commands defined in `.opencode/commands/`: `/spec`, `/plan`, `/build`, `/test`, `/review`, `/webperf`, `/code-simplify`, `/ship`. These are optional shortcuts that invoke the matching skill directly.

Even without typing a command, the agent must still auto-detect intent from natural language and invoke the matching skill.

### Lifecycle Mapping

- DEFINE → `spec-driven-development` (or `/spec`)
- PLAN → `planning-and-task-breakdown` (or `/plan`)
- BUILD → `incremental-implementation` + `test-driven-development` (or `/build`)
- VERIFY → `debugging-and-error-recovery` (or `/test`)
- REVIEW → `code-review-and-quality` (or `/review`)
- SHIP → `shipping-and-launch` (or `/ship`)

### Execution Model

For every request:

1. Determine if any skill applies (even 1% chance)
2. Read the appropriate skill file from `.opencode/skills/`
3. Follow the skill workflow strictly
4. Only proceed to implementation after required steps (spec, plan, etc.) are complete

### Anti-Rationalization

The following thoughts are incorrect and must be ignored:

- "This is too small for a skill"
- "I can just quickly implement this"
- "I'll gather context first"

Correct behavior:

- Always check for and use skills first

## Orchestration: Personas, Skills, and Commands

This project has three composable layers. They have different jobs and should not be confused:

- **Skills** (`.opencode/skills/<name>/SKILL.md`) — workflows with steps and exit criteria. The _how_. Mandatory hops when an intent matches.
- **Slash commands** (`.opencode/commands/*.md`) — user-facing entry points. The _when_. The orchestration layer.

Composition rule: **the user (or a slash command) is the orchestrator. Personas do not invoke other personas.** A persona may invoke skills.

The only multi-persona pattern this project uses is **sequential fan-out with a merge step** — used by `/ship` to run `code-reviewer`, `security-auditor`, and `test-engineer` in sequence and synthesize their reports. Do not build a "router" persona that decides which other persona to call; that's the job of slash commands and intent mapping.

See `.opencode/references/orchestration-patterns.md` for the full pattern catalog.

## Reference Checklists

Supplementary checklists live in `.opencode/references/`: `security-checklist.md`, `performance-checklist.md`, `accessibility-checklist.md`, `testing-patterns.md`, `observability-checklist.md`, `definition-of-done.md`, `orchestration-patterns.md`. Load these when a skill needs detail beyond what's in its SKILL.md.
