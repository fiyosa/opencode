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

### Standard Workflow

The default sequence for building a new feature, end to end:

```
/spec → /plan → /build → /test → /review → /ship
```

For UI/UX work, ui-ux-pro-max runs before or during `/spec`, its design decisions (colors, layout, typography) should already be reflected in the spec before `/plan` breaks it into tasks.

```
ui-ux-pro-max → /spec → /plan → /build → /test → /review → (/webperf if UI-heavy) → /ship
```

Guidance for each step:

- **/spec** — always the starting point for a new feature or significant change. Do not skip straight to `/plan` or `/build` without a spec.
- **/plan** — run once the spec is confirmed. Breaks the spec into small, verifiable tasks.
- **/build** — implements one task at a time (or the whole plan with `/build auto`). Each task must pass its own test before moving to the next.
- **/test** — used standalone for the Prove-It pattern on bug fixes, or as part of `/build`'s RED-GREEN-REFACTOR loop for new features.
- **/code-simplify** — optional, run after `/build` and `/test` pass, when the working code needs cleanup without behavior changes. Not part of the mandatory path.
- **/review** — run before every merge, regardless of change size. Lighter weight than `/ship`, single-persona.
- **/webperf** — run when the change touches browser-facing UI with meaningful visual or data load (images, charts, large lists, real-time data). Skip for backend-only or CLI changes.
- **/ship** — the final gate before deploying to production. Mandatory fan-out review unless the change is trivial: 2 files or fewer, under 50 lines, and does not touch auth, payments, data access, or config/env. Otherwise `/ship` is required even for small-looking diffs.

Do not jump ahead in the sequence (e.g. `/build` before `/spec` exists, or `/ship` before `/test` has passed) unless the user explicitly asks to skip a step.

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
