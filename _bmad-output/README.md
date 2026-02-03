# BMAD Output Directory

This directory contains artifacts, documentation, and retrospective materials generated through the BMAD (Business Model Architecture Development) workflow for the MCOP Quest project.

## Directory Structure

```
_bmad-output/
├── implementation-artifacts/
│   ├── epics/                   # Planned work organized by Epic
│   ├── operations/              # Hotfixes and routine work by Month (YYYY-MM)
│   └── archive/                 # Legacy artifacts and retired documents
├── planning-artifacts/
│   ├── wireframes/              # UX wireframes and design mockups
│   └── prototypes/              # Interactive prototypes
├── quality/                     # Quality assurance and code review reports
├── templates/                   # Process templates and checklists
└── retrospectives/             # Epic retrospective analyses
```

## Directory Guidelines

### implementation-artifacts/epics/
- Create one folder per Epic: `epic-XX-name/`
- Each Epic folder contains:
  - `epic-summary.md` - Epic overview and status
  - `story-XX-YY/` - Individual story folders with implementation details

### planning-artifacts/
- **wireframes/** - Store static wireframes and UI mockups
- **prototypes/** - Interactive HTML/Figma prototypes

### quality/
- Code review reports
- Test coverage analysis
- Security audit results

### retrospectives/
- Post-epic retrospective analysis
- Lessons learned
- Action items for improvement

## Documentation Purpose

These artifacts serve as:
1. **Historical Record** - Track decisions, implementations, and outcomes
2. **Process Reference** - Templates and checklists for future work
3. **Quality Evidence** - Code reviews, audits, and test coverage
4. **Learning Resource** - Retrospectives and lessons learned

## Accessing Epic Information

For each completed epic, you will find:
- **Epic Summary:** Complete overview of deliverables and metrics
- **Story Workspaces:** Individual story implementations
- **Quality Reports:** Code reviews and audit results
- **Retrospective:** Analysis of what went well and improvements

See the `implementation-artifacts/epics/` directory for complete epic histories.

---

**Project:** MCOP Quest - Web-based RPG Game
**Tech Stack:** Laravel 12.x, Livewire 3.7+, Flux UI 2.x
**Status:** Active Development
**Last Updated:** 2026-02-01
