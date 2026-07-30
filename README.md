# Agent Skills Setup — OpenCode

Configuration of engineering skills from [addyosmani/agent-skills](https://github.com/addyosmani/agent-skills), adapted to run on OpenCode.

## Structure

```
.opencode/
├── agents/          # Reviewer personas (code-reviewer, security-auditor, test-engineer, web-performance-auditor)
├── commands/        # Slash commands (/spec, /plan, /build, etc.)
├── references/       # Supplementary checklists (security, performance, accessibility, etc.)
└── skills/          # 24 skills, one SKILL.md per skill
AGENTS.md            # Main instruction file for the agent
```

## Why it was adapted

The original agent-skills repo is built with Claude Code as the primary target, using native slash commands under `.claude/commands/` and automatic subagent tools under `agents/`. OpenCode doesn't have either mechanism natively, so this setup makes the following adjustments.

- Skills, agents, and references were moved under `.opencode/` to keep everything in one consistent namespace
- The 8 command files were converted from `.toml` format to `.md` format with YAML frontmatter, matching OpenCode's custom command convention
- `/ship` and `/webperf`, which originally called subagents in parallel, now invoke each persona sequentially in the same context, since OpenCode has no subagent tool system like Claude Code
- `AGENTS.md` was rewritten so every referenced path matches the `.opencode/` structure

## Usage

### Via slash command

```
/spec add a CSV export feature
/plan add a CSV export feature
/build
/test
/code-review
/webperf
/code-simplify
/ship
```

### Via natural language

No command is required. `AGENTS.md` already instructs the agent to detect intent automatically and invoke the matching skill.

```
I want to build a feature to export report data to CSV
```

```
There's a 500 error on the login endpoint, can you check it
```

## Command reference

| Command          | Skill invoked                                       | Purpose                                       |
| ---------------- | --------------------------------------------------- | --------------------------------------------- |
| `/spec`          | spec-driven-development                             | Write a spec before writing code              |
| `/plan`          | planning-and-task-breakdown                         | Break work into small tasks                   |
| `/build`         | incremental-implementation, test-driven-development | Implement incrementally, one slice per commit |
| `/test`          | test-driven-development                             | Red-green-refactor cycle                      |
| `/code-review`   | code-review-and-quality                             | Five-axis review before merge                 |
| `/webperf`       | performance-optimization                            | Web performance audit                         |
| `/code-simplify` | code-simplification                                 | Simplify code without changing behavior       |
| `/ship`          | shipping-and-launch                                 | Pre-launch checklist, go/no-go decision       |

Note, `/code-review` here overrides OpenCode's built-in `/code-review` command for viewing git diffs. If you need the built-in command back, delete or rename `.opencode/commands/code-review.md`.

## Full skill catalog

24 skills are available under `.opencode/skills/`, organized across six lifecycle phases.

**Define** — using-agent-skills, interview-me, idea-refine, spec-driven-development

**Plan** — planning-and-task-breakdown

**Build** — incremental-implementation, test-driven-development, context-engineering, source-driven-development, doubt-driven-development, frontend-ui-engineering, api-and-interface-design

**Verify** — browser-testing-with-devtools, debugging-and-error-recovery

**Review** — code-review-and-quality, code-simplification, security-and-hardening, performance-optimization

**Ship** — git-workflow-and-versioning, ci-cd-and-automation, deprecation-and-migration, documentation-and-adrs, observability-and-instrumentation, shipping-and-launch

Skills also activate automatically based on context, without needing a slash command. See the Intent → Skill Mapping section in `AGENTS.md` for the full mapping.

## Source

- Repo: [addyosmani/agent-skills](https://github.com/addyosmani/agent-skills)
- License: MIT

```

```
